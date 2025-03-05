<?php

namespace App\Livewire;

use Livewire\Component;

class Alert extends Component
{
    public $mensaje = '';
    public $tipo = 'info';
    public $mostrar = false;
    public $code = '';

    protected $listeners = ['mostrarAlerta' => 'mostrar'];

    public function mostrar($mensaje, $tipo = 'info', $code = '')
    {
        $this->mensaje = $mensaje;
        $this->tipo = $tipo;
        $this->mostrar = true;
        $this->code = $code;

        // Ocultar la alerta después de 3 segundos
        $this->dispatch('ocultarAlerta')->self();
    }

    public function ocultar()
    {
        $this->mostrar = false;
    }

    public function render()
    {
        return view('livewire.alert');
    }
}
