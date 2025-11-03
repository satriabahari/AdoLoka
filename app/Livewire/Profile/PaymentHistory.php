<?php

namespace App\Livewire\Profile;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class PaymentHistory extends Component
{
    use WithPagination;

    public $statusFilter = 'all';
    public $typeFilter = 'all';

    protected $queryString = [
        'statusFilter' => ['except' => 'all'],
        'typeFilter' => ['except' => 'all'],
    ];

    public function updatingStatusFilter()
    {
        $this->resetPage();
    }

    public function updatingTypeFilter()
    {
        $this->resetPage();
    }

    public function render()
    {
        $query = Order::with('purchasable')
            ->where('user_id', Auth::id())
            ->orderBy('created_at', 'desc');

        // Filter by status
        if ($this->statusFilter !== 'all') {
            $query->where('status', $this->statusFilter);
        }

        // Filter by type
        if ($this->typeFilter === 'product') {
            $query->where('purchasable_type', 'App\Models\Product');
        } elseif ($this->typeFilter === 'service') {
            $query->where('purchasable_type', 'App\Models\Service');
        }

        $orders = $query->paginate(6);

        return view('livewire.profile.payment-history', [
            'orders' => $orders,
        ]);
    }
}
