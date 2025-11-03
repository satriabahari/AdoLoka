<?php

namespace App\Livewire\Profile;

use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithFileUploads;

class UpdateServiceInformation extends Component
{
    use WithFileUploads;

    public $showModal = false;
    public $editingServiceId;

    public $name;
    public $description;
    public $price;
    public $unit;
    public $category_id;
    public $consultation_link;
    public $has_brand_identity = false;
    public $revision_max;
    public $delivery_days_min;
    public $delivery_days_max;
    public $is_active = true;
    public $service_image;
    public $currentImageUrl;


    protected $rules = [
        'name' => 'required|string|max:255',
        'description' => 'nullable|string',
        'price' => 'required|numeric|min:0',
        'unit' => 'nullable|string|max:50',
        'category_id' => 'required|exists:service_categories,id',
        'consultation_link' => 'nullable|url',
        'revision_max' => 'nullable|integer|min:0',
        'delivery_days_min' => 'nullable|integer|min:1',
        'delivery_days_max' => 'nullable|integer|min:1',
        'service_image' => 'nullable|image|max:2048',
    ];

    public function mount(): void
    {
        // No need to load services here, we'll do it in render()
    }

    public function openModal($serviceId = null): void
    {
        $this->resetForm();

        if ($serviceId) {
            $service = Service::findOrFail($serviceId);

            if ($service->user_id !== Auth::id()) {
                session()->flash('error', 'Unauthorized access.');
                return;
            }

            $this->editingServiceId   = $serviceId;
            $this->name               = $service->name;
            $this->description        = $service->description;
            $this->price              = $service->price;
            $this->unit               = $service->unit;
            $this->category_id        = $service->category_id;
            $this->consultation_link  = $service->consultation_link;
            $this->has_brand_identity = $service->has_brand_identity;
            $this->revision_max       = $service->revision_max;
            $this->delivery_days_min  = $service->delivery_days_min;
            $this->delivery_days_max  = $service->delivery_days_max;
            $this->is_active          = $service->is_active;

            // ⬅️ simpan URL gambar untuk dipakai di Blade
            $this->currentImageUrl    = $service->image_url;
        }

        $this->showModal = true;
    }

    public function closeModal(): void
    {
        $this->showModal = false;
        $this->resetForm();
    }

    public function save(): void
    {
        $this->validate();

        $data = [
            'name' => $this->name,
            'description' => $this->description,
            'price' => $this->price,
            'unit' => $this->unit,
            'category_id' => $this->category_id,
            'consultation_link' => $this->consultation_link,
            'has_brand_identity' => $this->has_brand_identity,
            'revision_max' => $this->revision_max,
            'delivery_days_min' => $this->delivery_days_min,
            'delivery_days_max' => $this->delivery_days_max,
            'is_active' => $this->is_active,
            'user_id' => Auth::id(),
            'umkm_id' => Auth::user()->umkm?->id,
        ];

        if ($this->editingServiceId) {
            $service = Service::findOrFail($this->editingServiceId);
            $service->update($data);
            $message = 'Service berhasil diupdate!';
        } else {
            $service = Service::create($data);
            $message = 'Service berhasil ditambahkan!';
        }

        if ($this->service_image) {
            $service->clearMediaCollection('service');
            $service->addMedia($this->service_image->getRealPath())
                ->toMediaCollection('service');
        }

        session()->flash('message', $message);
        $this->closeModal();
    }

    public function deleteService($serviceId): void
    {
        $service = Service::findOrFail($serviceId);

        if ($service->user_id !== Auth::id()) {
            session()->flash('error', 'Unauthorized access.');
            return;
        }

        $service->delete();
        session()->flash('message', 'Service berhasil dihapus!');
        $this->closeModal();
    }

    private function resetForm(): void
    {
        $this->editingServiceId = null;
        $this->name = '';
        $this->description = '';
        $this->price = '';
        $this->unit = '';
        $this->category_id = '';
        $this->consultation_link = '';
        $this->has_brand_identity = false;
        $this->revision_max = '';
        $this->delivery_days_min = '';
        $this->delivery_days_max = '';
        $this->is_active = true;
        $this->service_image = null;
        $this->currentImageUrl = null; // ⬅️ reset
        $this->resetValidation();
    }


    public function render()
    {
        // Load services fresh on each render
        $services = Service::where('user_id', Auth::id())
            ->with('category')
            ->orderBy('created_at', 'desc')
            ->get();

        // Load categories
        $categories = ServiceCategory::all();

        return view('livewire.profile.update-service-information', [
            'services' => $services,
            'categories' => $categories,
        ]);
    }
}
