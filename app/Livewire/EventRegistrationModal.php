<?php

namespace App\Livewire;

use App\Models\EventAndUmkmCategory;
use App\Models\EventCategory;
use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\EventRegistration;

class EventRegistrationModal extends Component
{
    use WithFileUploads;

    public $event;
    public $showModal = false;

    // Form fields
    public $umkm_brand_name;
    public $partner_address;
    public $event_category_id;
    public $owner_name;
    public $whatsapp_number;
    public $instagram_name;
    public $brand_photo;
    public $product_photo;
    public $ktp_photo;
    public $business_license_number;
    public $categories = [];

    protected $rules = [
        'umkm_brand_name' => 'required|string|max:255',
        'partner_address' => 'required|string',
        'event_category_id' => 'required|exists:event_categories,id',
        'owner_name' => 'required|string|max:255',
        'whatsapp_number' => 'required|string|max:20',
        'instagram_name' => 'nullable|string|max:255',
        'business_license_number' => 'nullable|string|max:255',
        'brand_photo'  => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'product_photo' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',
        'ktp_photo'    => 'required|image|mimes:jpg,jpeg,png,webp|max:2048',

    ];

    public function mount($event)
    {
        $this->event = $event;
        $this->categories = EventAndUmkmCategory::orderBy('name')->get();
    }

    public function openModal()
    {
        $this->showModal = true;
    }

    public function closeModal()
    {
        $this->showModal = false;
        $this->reset([
            'umkm_brand_name',
            'partner_address',
            'event_category_id',
            'owner_name',
            'whatsapp_number',
            'instagram_name',
            'brand_photo',
            'product_photo',
            'ktp_photo',
            'business_license_number'
        ]);
        $this->resetValidation();
    }

    public function submit()
    {
        $this->validate();

        $registration = EventRegistration::create([
            'event_id' => $this->event->id,
            'umkm_brand_name' => $this->umkm_brand_name,
            'partner_address' => $this->partner_address,
            'event_category_id' => $this->event_category_id,
            'owner_name' => $this->owner_name,
            'whatsapp_number' => $this->whatsapp_number,
            'instagram_name' => $this->instagram_name,
            'business_license_number' => $this->business_license_number,
        ]);

        // Upload photos using Spatie Media Library
        // === Upload photos ke collection 'event_registration' ===
        if ($this->brand_photo) {
            $registration->addMedia($this->brand_photo->getRealPath())
                ->usingFileName($this->brand_photo->getClientOriginalName())
                ->withCustomProperties(['kind' => 'brand'])
                ->toMediaCollection('event_registration');
        }

        if ($this->product_photo) {
            $registration->addMedia($this->product_photo->getRealPath())
                ->usingFileName($this->product_photo->getClientOriginalName())
                ->withCustomProperties(['kind' => 'product'])
                ->toMediaCollection('event_registration');
        }

        if ($this->ktp_photo) {
            $registration->addMedia($this->ktp_photo->getRealPath())
                ->usingFileName($this->ktp_photo->getClientOriginalName())
                ->withCustomProperties(['kind' => 'ktp'])
                ->toMediaCollection('event_registration');
        }

        session()->flash('success', 'Pendaftaran berhasil! Kami akan menghubungi Anda segera.');

        $this->closeModal();
    }

    public function render()
    {
        return view('livewire.event-registration-modal');
    }
}
