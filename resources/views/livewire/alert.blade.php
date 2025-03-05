<div x-data="{ mostrar: @entangle('mostrar'), mensaje: @entangle('mensaje'), tipo: @entangle('tipo') }"
     x-init="$wire.on('ocultarAlerta', () => { 
         setTimeout(() => { mostrar = false }, 3000);
     })">

    <div x-show="mostrar"
         class="p-3 rounded shadow transition-all duration-500"
         :class="{
            'bg-green-500 text-white': tipo === 'success',
            'bg-red-500 text-white': tipo === 'error',
            'bg-yellow-300 text-black': tipo === 'warning',
            'bg-blue-500 text-white': tipo === 'info'
         }">
        <p x-text="mensaje"></p>
    </div>
</div>