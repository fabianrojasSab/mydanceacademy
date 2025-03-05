<div class="grid lg:grid-cols-2 dm:grid-cols-2 sm:grid-cols-2 p-6 bg-white border-b border-gray-200 items-center justify-center">
    @if(auth()->user()->state_id == '1')
        @role('Profesor')
            <!-- Contenido para profesores -->
            <x-card tittle="Ver clases" description="Visualiza las clases que tienes asignadas como profesor de baile." ruta="lsn.r"/>
        @endrole
        @role('Estudiante')
            <!-- Contenido para estudiantes -->
            <x-card tittle="Inscripcion de clase" description="Mira las clases disponibles para incribirte a alguna de ellas." ruta="ncp.r"/>
            <x-card tittle="Ver mis clases" description="Me muestra el listado de las clases a las que estoy inscrito" ruta="lsn.r"/>
        @endrole
        @role('Administrador')
            <!-- Contenido para administradores -->
            <x-card tittle="Estudiantes" description="Realizar el registro de estudiantes y editar su informacion al igual que la eliminacion de los mismos." ruta="std.r"/>
            <x-card tittle="Pagos" description="Realizar registro de pagos" ruta="pym.r"/>
            <x-card tittle="Clases" description="Realizar registro de clases, eliminar o editarlas" ruta="lsn.r"/>
            <x-card tittle="Horarios" description="Ver el listado de horarios de clases" ruta="sch.r"/>
            <x-card tittle="Inscripcion de clase" description="Realiza la inscripcion de los estudiantes a las clases disponibles" ruta="ncp.r"/>
            <x-card tittle="Profesores" description="Ver el listado de profesores, realizar el cambio de estado, ingresar informacion ó eliminar profesores." ruta="tch.r"/>
            <x-card tittle="Liquidacion de pagos" description="Realizar la liquidacion de los pagos de los estudiantes" ruta="lqd.r"/>
        @endrole
        @role('SuperAdmin')
            <!-- Contenido para administradores -->
            <x-card tittle="Usuarios" description="Puedes visualizar el listado de todos los usuario del sistema, realizar nuevos registros, editar la informacion del usuario ó eliminar." ruta="usr.r"/>
            <x-card tittle="Profesores" description="Ver el listado de profesores, realizar el cambio de estado, ingresar informacion ó eliminar profesores." ruta="tch.r"/>
            <x-card tittle="Estudiantes" description="Realizar el registro de estudiantes y editar su informacion al igual que la eliminacion de los mismos." ruta="std.r"/>
            <x-card tittle="Pagos" description="Realizar registro de pagos" ruta="pym.r"/>
            <x-card tittle="Clases" description="Realizar registro de clases, eliminar o editarlas" ruta="lsn.r"/>
            <x-card tittle="Inscripcciones" description="Ver el listado de incripciones que se han realizado e inscribir a algun estudiante a una clase que ya se encuentre creada" ruta="ncp.r"/> 
            <x-card tittle="Panel administador" description="" ruta="dsh.r"/> 
        @endrole
    @else
    <div>Usted se encuentra en estado PRE-REGISTRO, por favor comuniquese con su administrador</div>
    @endif

</div>
