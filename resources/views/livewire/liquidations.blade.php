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
                <section class="lg:col-auto col-1 p-4">
                    <div class="h-full pt-6 px-2 rounded-lg bg-white">
                        <div class="rounded-t mb-0 px-4 py-3 border-0">
                            <div class="flex flex-wrap items-center">
                                <div class="relative w-full px-4 max-w-full flex-grow flex-1">
                                    <h3 class="font-semibold text-base text-blueGray-700">Informacion de pago</h3>
                                </div>
                            </div>
                        </div>
            
                        <div class="relative overflow-x-auto">
                            <!-- informacion de los parametros de pago -->
                            @if($teacherSetting)
                                <div class="mt-4 text-lg font-semibold">
                                    Tipo liquidacion: <span class="text-green">
                                    @foreach ($teacherSetting as $setting)
                                        {{ $setting->param_name }}
                                    @endforeach
                                    </span>
                                </div>
                                <div class="mt-4 text-lg font-semibold">
                                    Valor: <span class="text-green">
                                    @foreach ($teacherSetting as $setting)
                                    {{ $setting->param_value }}
                                    @endforeach
                                    </span>
                                </div>
                            @else
                                <div class="mt-4 text-lg font-semibold">
                                    Tipo liquidacion:
                                </div>
                                <div class="mt-4 text-lg font-semibold">
                                    Valor:
                                </div>
                            @endif
                            <!-- Informacion de la clase -->
                            <div class="mt-4 text-lg font-semibold">
                                Clase: <span class="text-green-600">
                                    @if($infoLesson)
                                        @foreach ( $infoLesson as $info)
                                            {{ $info->name }}
                                        @endforeach
                                    @else
                                        No hay clase seleccionada
                                    @endif
                                </span>
                            </div>
                            <!-- Campo para profesores -->
                            <div class="mt-4 text-lg font-semibold">
                                Profesores:
                                @if ($teachersLesson)
                                    @foreach ($teachersLesson as $teacher)
                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded-sm dark:bg-red-900 dark:text-red-300">
                                            {{ $teacher ? $teacher['name'] : 'Profesor no encontrado' }}
                                        </span>
                                    @endforeach
                                    <label class="inline-flex items-center cursor-pointer">
                                        <input type="checkbox" wire:change="toggleIsPayShared" wire:model="isPayShared" class="sr-only peer">
                                        <div class="relative w-11 h-6 bg-gray-200 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 dark:peer-focus:ring-blue-800 rounded-full peer dark:bg-gray-700 peer-checked:after:translate-x-full rtl:peer-checked:after:-translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:start-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-gray-600 peer-checked:bg-blue-600 dark:peer-checked:bg-blue-600"></div>
                                        <span class="ms-3 text-sm font-medium text-gray-900 dark:text-gray-300">Clase compartida</span>
                                    </label>
                                @endif
                            </div>
                            <!-- Cantidad de clases dictadas -->
                            <div class="mt-4 text-lg font-semibold">
                                Cantidad de dias: <span class="text-green-600">
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
                            </div>
                            <!-- Campos para ingresar valor adicional -->
                            <div class="relative z-0 w-full mb-5 group">
                                <input type="text" wire:model="adittionalValue" wire:change="updateTotal" name="valorAdicional" id="valorAdicional" class="block py-2.5 px-0 w-full text-sm text-gray-900 bg-transparent border-0 border-b-2 border-gray-300 appearance-none dark:text-white dark:border-gray-600 dark:focus:border-blue-500 focus:outline-none focus:ring-0 focus:border-blue-600 peer" placeholder=" " required />
                                <label for="valorAdicional" class="peer-focus:font-medium absolute text-sm text-gray-500 dark:text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:start-0 rtl:peer-focus:translate-x-1/4 rtl:peer-focus:left-auto peer-focus:text-blue-600 peer-focus:dark:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Valor Adicional</label>
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
                        </div>
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
                                Total Pagos de estudiantes: <span class="text-green-600">$
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