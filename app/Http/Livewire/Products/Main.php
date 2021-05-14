<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;

class Main extends Component
{
    public function render()
    {
        return view('livewire.products.main', [
            'name' => 'Jelly',
        ]);
    }
}
