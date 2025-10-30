<?php

namespace App\Livewire\Pages\Auth;

use App\Models\Product;
use App\Models\Umkm;
use App\Models\User;
use App\Models\Category;
use App\Models\EventAndUmkmCategory;
use App\Models\ProductCategory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\Features\SupportFileUploads\WithFileUploads;

class MultiStepRegistration extends Component
{
    use WithFileUploads;

    // Step tracker
    public $currentStep = 1;
    public $totalSteps = 3;

    // Step 1: User data
    public $first_name = '';
    public $last_name = '';
    public $email = '';
    public $phone_number = '';
    public $password = '';
    public $password_confirmation = '';
    public $agree_terms = false;

    // Step 2: UMKM data
    public $business_name = '';
    public $umkm_category_id  = '';
    public $city = '';
    public $latitude;
    public $longitude;
    public $business_description = '';
    public $umkmCategories = [];

    // Step 3: Product data
    public $product_name = '';
    public $product_category_id  = '';
    public $product_photo;
    public $product_description = '';
    public $productCategories = [];

    // Track if user came from Google
    public $fromGoogle = false;

    protected $messages = [
        'first_name.required' => 'Nama depan wajib diisi',
        'email.required' => 'Email wajib diisi',
        'email.email' => 'Format email tidak valid',
        'email.unique' => 'Email sudah terdaftar',
        'phone_number.required' => 'Nomor telepon wajib diisi',
        'phone_number.regex' => 'Nomor telepon harus angka dan diawali +62 atau 08 (contoh: +628123456789 atau 08123456789)',
        'password.required' => 'Password wajib diisi',
        'password.min' => 'Password minimal 8 karakter',
        'password.confirmed' => 'Konfirmasi password tidak cocok',
        'agree_terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
        'business_name.required' => 'Nama usaha wajib diisi',
        'umkm_category_id.required' => 'Kategori usaha wajib dipilih',
        'umkm_category_id.exists'   => 'Kategori usaha tidak valid',
        'city.required' => 'Kota wajib diisi',
        'product_name.required' => 'Nama produk wajib diisi',
        'product_photo.image' => 'File harus berupa gambar',
        'product_photo.max' => 'Ukuran gambar maksimal 2MB',
        'product_category_id.required' => 'Kategori produk wajib dipilih',
        'product_category_id.exists'   => 'Kategori produk tidak valid',
    ];

    public function mount()
    {
        // Check if there's a step parameter in the URL
        $requestedStep = request()->query('step');

        // Check if user came from Google OAuth
        if (session('google_signup_step')) {
            $this->currentStep = session('google_signup_step');
            $this->fromGoogle = true;

            // Load authenticated user data
            if (Auth::check()) {
                $user = Auth::user();
                $this->first_name = $user->first_name;
                $this->last_name = $user->last_name;
                $this->email = $user->email;
                $this->phone_number = $user->phone_number;
            }

            session()->forget('google_signup_step');
        } elseif ($requestedStep && in_array($requestedStep, [1, 2, 3])) {
            // If step is provided in URL, use it
            $this->currentStep = (int) $requestedStep;
        } else {
            // Default to step 1
            $this->currentStep = 1;
        }

        // daftar kategori produk
        $this->productCategories = ProductCategory::select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();

        // daftar kategori UMKM (diambil dari EventAndUmkmCategory)
        $this->umkmCategories = EventAndUmkmCategory::select('id', 'name')
            ->orderBy('name')
            ->get()
            ->toArray();
    }

    // Step 1 validation rules
    protected function step1Rules()
    {
        $rules = [
            'first_name' => 'required|string|max:255',
            'last_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => [
                'required',
                'string',
                'max:20',
                'regex:/^(\+62|0)8[0-9]{7,12}$/'
            ],
            'agree_terms' => 'accepted',
        ];

        // Only require password if not from Google
        if (!$this->fromGoogle) {
            $rules['password'] = 'required|string|min:8|confirmed';
        }

        return $rules;
    }

    // Step 2 validation rules
    protected function step2Rules()
    {
        return [
            'business_name' => 'required|string|max:255',
            'umkm_category_id'   => 'required|exists:event_and_umkm_categories,id',
            'city' => 'required|string|max:255',
            'latitude' => 'nullable|numeric',
            'longitude' => 'nullable|numeric',
        ];
    }

    // Step 3 validation rules
    protected function step3Rules()
    {
        return [
            'product_name' => 'required|string|max:255',
            'product_category_id' => 'required|integer|exists:product_categories,id',
            'product_photo' => 'nullable|image|max:2048',
        ];
    }

    public function nextStep()
    {
        if ($this->currentStep == 1) {
            $this->validate($this->step1Rules());
        } elseif ($this->currentStep == 2) {
            $this->validate($this->step2Rules());
        }

        $this->currentStep++;
    }

    public function previousStep()
    {
        $this->currentStep--;
    }

    public function setLocation($lat, $lng)
    {
        $this->latitude = $lat;
        $this->longitude = $lng;
    }

    public function submit()
    {
        // Validate step 3
        $this->validate($this->step3Rules());

        $user = null;

        // Check if user already authenticated (from Google)
        if (Auth::check()) {
            /** @var \App\Models\User $user */
            $user = Auth::user();

            // Update phone number if provided
            if ($this->phone_number) {
                $user->update([
                    'phone_number' => $this->phone_number,
                ]);
            }
        } else {
            // Create new user (regular registration)
            $last = trim((string) $this->last_name);
            $user = User::create([
                'first_name' => $this->first_name,
                'last_name'    => $last === '' ? null : $last,
                'role_id' => 2,
                'email' => $this->email,
                'phone_number' => $this->phone_number,
                'password' => Hash::make($this->password),
            ]);

            // Log in the user
            Auth::login($user);
        }

        // Create UMKM
        $umkm = Umkm::create([
            'user_id' => $user->id,
            'name' => $this->business_name,
            'category_id' => $this->umkm_category_id,
            'city' => $this->city,
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
            'description' => $this->business_description,
        ]);

        // Create Product
        $product = Product::create([
            'umkm_id' => $umkm->id,
            'user_id' => $user->id,
            'name' => $this->product_name,
            'description' => $this->product_description,
            'category_id' => $this->product_category_id,
        ]);

        // Upload product photo using Spatie Media Library
        if ($this->product_photo) {
            $product->addMedia($this->product_photo->getRealPath())
                ->usingFileName($this->product_photo->getClientOriginalName())
                ->toMediaCollection('product_photos');
        }

        // Redirect to dashboard with success message
        session()->flash('success', 'Registrasi berhasil! Selamat datang di platform UMKM.');

        return redirect()->route('home');
    }

    #[Layout('layouts.guest')]
    public function render()
    {
        // return view('livewire.pages.auth.user-registration');
        return view('livewire.pages.auth.multi-step-registration');
    }
}
