<div class="grid lg:grid-cols-3 grid-cols-1 md:container md:mx-auto">
    <section class="lg:col-span-3 col-1 p-4">
        <div class="flex justify-end">
            <a href="{{ route('dashboard') }}" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                Volver
            </a>
        </div>
    </section>

    @hasanyrole('Administrador|SuperAdmin')
        <!-- Contenido para administradores -->
        <section class="lg:col-auto col-1 p-4">
            <form class="pt-6 px-9 pb-6 rounded-lg bg-white">
                <div class="mb-7">
                    <h1 class="text-2xl text-center font-semibold text-gray-900 dark:text-white">Liquidacion de profesores</h1>
                </div>
                @csrf

                <div class="relative z-0 w-full mb-5 group">
                    <label for="user_id" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Selecciona un profesor</label>
                    <select id="user_id" name="user_id" wire:model="teacherId" wire:change="getLessonIds" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>...</option>
                        @foreach ($teachers as $teacher)
                            <tr>
                                <option value="{{$teacher->id}}">{{$teacher->name}}</option>
                            </tr>
                        @endforeach
                    </select>
                </div>

                @if ($lessonsteacher)
                <div class="relative z-0 w-full mb-5 group">
                    <label for="claseId" class="block py-2.5 px-0 w-full text-sm text-gray-500 bg-transparent">Selecciona la clase</label>
                    <select id="claseId" name="claseId" wire:model="lessonId" wire:change="getPreview" class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:bg-gray-700 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-blue-500 dark:focus:border-blue-500">
                        <option>...</option>
                        @foreach ($lessonsteacher as $lessonteacher)
                            <tr>
                                <option value="{{$lessonteacher->id}}">{{$lessonteacher->name}}</option>
                            </tr>
                        @endforeach
                    </select>
                </div>
                @else
                    
                @endif
                <x-button class="ms-4" wire:click.prevent="{{ $teacherId ? 'update' : 'save' }}">
                    {{ $teacherId ? __('Update') : __('Register') }}
                </x-button>
            </form>
        </section>
        
        <section class="lg:col-span-2 col-1 h-auto p-4">
            <div class="grid lg:grid-cols-2 grid-cols-1 md:container md:mx-auto">
                <section class="lg:col-auto col-1 p-4 bg-white shadow-md p-4 rounded-lg border">
                        <h3 class="text-lg font-semibold mb-2">Informacion de pago</h3>
                        <!-- informacion de los parametros de pago -->
                        @if($teacherSetting)
                            <div class="text-gray-600 text-sm">
                                Tipo de Liquidación:
                                <span class="text-green">
                                @foreach ($teacherSetting as $setting)
                                    @if ($setting->param_name === 'Porcentaje')
                                        <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-sm font-medium">
                                            Valor en porcentaje
                                        </span>
                                    @elseif ($setting->param_name === 'Sueldo fijo')
                                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-sm font-medium">
                                            Sueldo fijo mensual
                                        </span>
                                    @else
                                        <span class="bg-gray-100 text-gray-600 px-3 py-1 rounded-full text-sm font-medium">
                                            No definido
                                        </span>
                                    @endif
                                @endforeach
                                </span>
                            </div>
                            <div class="mb-4">
                                    {{ $setting->param_name === 'Porcentaje' ? 'Porcentaje de pago:' : 'Monto base:' }}
                                    {{ $setting->param_name === 'Porcentaje' ? ($setting->param_value . '(%)') : ('$' . number_format($setting->param_value, 2)) }}
                            </div>
                        @else
                            <div class="text-gray-600 text-sm">
                                Tipo liquidacion:
                            </div>
                        @endif

                        <!-- Informacion de la clase -->
                        <div class="mt-4 text-lg font-semibold">
                            Clase: 
                            <span class="text-green-600">
                                @if($infoLesson)
                                    @foreach ( $infoLesson as $info)
                                        <!-- Clase seleccionada con badge verde -->
                                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded-md">
                                            {{ $info->name }}
                                        </span>
                                    @endforeach
                                @else
                                    <!-- Mensaje de advertencia si no hay clase -->
                                    <span class="text-red-500 font-medium flex items-center">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-1 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                                            <path fill-rule="evenodd" d="M18 10A8 8 0 112 10a8 8 0 0116 0zm-9-3a1 1 0 012 0v3a1 1 0 01-2 0V7zm1 5a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"/>
                                        </svg>
                                        No hay clase seleccionada
                                    </span>
                                @endif
                            </span>
                        </div>

                        <!-- Campo para profesores -->
                        <div class="mt-4 text-lg font-semibold">
                            Profesores:
                            @if ($teachersLesson)
                                @foreach ($teachersLesson as $teacher)
                                    <span class="bg-gray-200 text-gray-800 px-2 py-1 rounded-md text-sm">
                                        {{ $teacher ? $teacher['name'] : 'Profesor no encontrado' }}
                                    </span>
                                @endforeach
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" wire:change="toggleIsPayShared" wire:model="isPayShared" class="toggle-checkbox">
                                    <label for="shared" class="ml-2 text-sm text-gray-700">Clase compartida</label>
                                </label>
                            @endif
                        </div>

                        <!-- Cantidad de clases dictadas -->
                        <div class="mt-4 text-lg font-semibold flex items-center">
                            Días trabajados: 
                            <span class="text-xl font-bold text-blue-600"> 
                                @if($infoLesson)
                                    @foreach ( $infoLesson as $info)
                                        {{ $info->lesson_count }}
                                    @endforeach
                                    /
                                    @foreach ( $infoShedule as $info)
                                        {{ $info->schedule_count }}
                                    @endforeach
                                @else
                                    0
                                @endif
                            </span>
                            <div x-data="{ open: false }" class="relative ml-2">
                                <span @mouseover="open = true" @mouseleave="open = false" class="cursor-pointer text-gray-500">
                                    ℹ️
                                </span>
                                <div x-show="open" class="absolute left-0 mt-2 w-64 bg-white text-sm text-gray-700 p-2 rounded shadow-lg">
                                    Indica los días en los que se impartieron clases frente al total de días programados.
                                </div>
                            </div>
                        </div>

                        <!-- Campos para ingresar valor adicional -->
                        <div class="mt-4 text-lg font-semibold">
                            <input type="text" wire:model="adittionalValue" wire:change="updateTotal" name="valorAdicional" id="valorAdicional" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                            <p class="mt-2 text-sm text-gray-600">Valor Adicional</p>
                        </div>

                        <!-- Total a Pagar -->
                        <div class="mt-4 text-lg font-semibold">
                            Total a Pagar: <span class="text-green-600">$
                                @if($totalPagar)
                                    {{ number_format($totalPagar, 2) }}
                                @else
                                    0.00
                                @endif
                            </span>
                        </div>
                </section>

                <section class="lg:col-auto col-1 p-4">
                    <div class="h-full pt-6 px-2 rounded-lg bg-white">
                        <div class="rounded-t mb-0 px-4 py-3 border-0">
                            <div class="flex flex-wrap items-center">
                                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                    <h3 class="font-semibold text-base text-blueGray-700">Estudiantes inscritos a la clase</h3>
                                </div>
                            </div>
                        </div>
            
                        <div class="relative overflow-x-auto">
                            <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                                <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                                    <tr>
                                        <th scope="col" class="px-6 py-3">
                                            Estudiante
                                        </th>
                                        <th scope="col" class="px-6 py-3">
                                            Valor matricula
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @if($lessons)
                                        @foreach ($lessons as $lesson)
                                            <tr>
                                                <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                                    {{ $lesson['name'] }}
                                                </th>
                                                <th  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                                    ${{ number_format($lesson['price'], 2) }}
                                                </th>
                                            </tr>
                                        @endforeach
                                    @else
                                        <tr>
                                            <td class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 " colspan="7">No hay clases registradas</td>
                                        </tr>
                                    @endif
                                </tbody>
                            </table>
                            <!-- Total a Pagar -->
                            <div class="mt-4 text-lg font-semibold">
                                💰Total Pagos de estudiantes: <span class="bg-green-100 text-green-700 px-4 py-2 rounded-md font-bold text-lg flex items-center">$
                                    @if($totalByStudents)
                                        {{ number_format($totalByStudents, 2) }}
                                    @else
                                        0.00
                                    @endif
                                </span>
                            </div>
                        </div>
                    </div>
                </section>
            </div>
        </section> 
    @endhasanyrole

    @hasanyrole('Profesor|Estudiante')
        <!-- Contenido para profesores -->
        <section class="col-span-3 h-auto p-4">   
            <div class="h-full pt-6 px-2 rounded-lg bg-white">
                <div class="rounded-t mb-0 px-4 py-3 border-0">
                    <div class="flex flex-wrap items-center">
                        <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                            <h3 class="font-semibold text-base text-blueGray-700">Listado de clases programadas</h3>
                        </div>
                    </div>
                </div>
    
                <div class="relative overflow-x-auto">
                    <table id="search-table" class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3">
                                    NOMBRE
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    DESCRIPCION
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    CAPACIDAD
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    DURACION
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    HORARIO   
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    PROFESOR
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    ACCIONES
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lessons as $lesson)
                                <tr>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->name}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->description}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->capacity}}
                                    </th>
                                    <th  class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->duration}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->horario}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{$lesson->nombre}}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 "> 
                                        {{ $lesson->teacher ? $lesson->teacher->name : 'Profesor no encontrado' }}
                                    </th>
                                    <th class="border-t-0 px-6 align-middle border-l-0 border-r-0 text-xs whitespace-nowrap p-4 text-left text-blueGray-700 ">
                                        <x-danger-button wire:click="delete({{ $lesson->id }})"  wire:confirm="Esta seguro que desea eliminar?" class="bg-indigo-500 text-white active:bg-indigo-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150"
                                            type="submit">Eliminar</x-danger-button>
                                        <button wire:click="edit({{ $lesson->id }})" 
                                            class="bg-yellow-500 text-white active:bg-yellow-600 text-xs font-bold uppercase px-3 py-1 rounded outline-none focus:outline-none mr-1 mb-1 ease-linear transition-all duration-150">
                                            Editar
                                        </button>
                                    </th>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </section> 
    @endhasanyrole

    <!-- Modal de Carga -->
    <div x-data="{ loading: false }" x-show="loading" class="fixed inset-0 z-50 flex items-center justify-center bg-gray-900 bg-opacity-75">
        <div class="bg-white p-5 rounded-lg shadow-lg text-center">
            <svg class="animate-spin h-5 w-5 text-blue-500 mx-auto" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 01-8 8 8 8 0 01-8-8z"></path>
            </svg>
            <p class="mt-4 text-gray-700">Cargando...</p>
        </div>
    </div>
</div>