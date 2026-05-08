<?php

namespace App\Livewire;

use App\Models\CartModel;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Navbar extends Component
{
    public int $cartCount = 0;

    protected $listeners = [
        'cartUpdated' => 'updateCartCount',
    ];

    public function mount(): void
    {
        $this->updateCartCount();
    }

    public function updateCartCount(): void
    {
        if (! Auth::check()) {
            $this->cartCount = 0;

            return;
        }

        $cart = CartModel::where('user_id', Auth::id())->first();

        $this->cartCount = $cart
            ? (int) $cart->items()->sum('quantity')
            : 0;
    }

    public function logout()
    {
        Auth::logout();

        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('home');
    }

    public function render()
    {
        return view('livewire.navbar');
    }
}
