<?php

namespace App\Http\Livewire\Products;

use Livewire\Component;

class Test extends Component
{
    public function render()
    {
        return view('livewire.products.test', [
            'name' => 'Jelly',
        ]);
    }
}
