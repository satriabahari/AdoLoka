<?php

namespace App\Livewire\Profile;

use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Validate;
use Livewire\Component;
use Livewire\Attributes\Layout;

class UpdateProfileInformation extends Component
{
    #[Validate('required|string|max:255')]
    public string $name = '';

    #[Validate('required|email')]
    public string $email = '';

    #[Validate('nullable|string|max:30')]
    public string $phone = '';

    #[Validate('nullable|string|max:1000')]
    public string $about = '';

    public array $editing = [
        'name'  => false,
        'email' => false,
        'phone' => false,
        'about' => false,
    ];

    public function mount(): void
    {
        $user = Auth::user();
        $this->name  = $user->name ?? 'Sid';
        $this->email = $user->email ?? 'sidxxd@growthx.com';
        $this->phone = $user->phone ?? '+62 49652845732';
        $this->about = $user->about ?? 'Lorem ipsum dolor sit amet consectetur. Erat auctor a aliquam vel congue luctus. Leo diam cras neque mauris ac arcu...';
    }

    public function toggle(string $field): void
    {
        $this->editing[$field] = ! $this->editing[$field];
    }

    public function save(string $field): void
    {
        $this->validateOnly($field);
        // Simpan ke database jika perlu:
        // Auth::user()->update([$field === 'phone' ? 'phone' : $field => $this->{$field}]);
        $this->editing[$field] = false;
        $this->dispatch('saved');
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information');
    }
}
