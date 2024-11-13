<?php

namespace App\Livewire;
use Livewire\Component;

class FormularioCompra extends Component
{
    public $metodo;
    public function render()
    {
        return view('livewire.formulario-compra');
    }
}
