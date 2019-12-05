@extends('layouts.app')

@section('content')
<div class="w-screen mt-4">
    <div class="row justify-content-center">
        <div class="col-md-10">
            <div class="card">
                <div class="card-header">
                    <b>Administrador</b>
                </div>
                <div class="card-body">
                    <table class="table table-sm mb-3">
                        <tbody>
                            <tr>
                                <td class="text-center">
                                    <img src={{URL::asset("images/accion2.png")}} width="70" height="70" alt="Acción de nivel 2" title="Acción de nivel 2">
                                    <a href="{{url('/admin/accion2s')}}"><h3 class="h4 mb-2">Acción nivel 2 </h3>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/administrador.png")}} width="70" height="70" alt="Administrador" title="Administrador">
                                    <a href="{{url('/admin/admins')}}"><h3 class="h4 mb-2">Administrador </h3>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/area.png")}} width="70" height="70" alt="Área" title="Área">
                                    <a href="{{url('/admin/areas')}}"><h3 class="h4 mb-2">Área </h3>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/categoria.png")}} width="70" height="70" alt="Categoría" title="Categoría">
                                    <a href="{{url('/admin/categorias')}}"><h3 class="h4 mb-2">Categoría</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/elemento.png")}} width="70" height="70" alt="Elemento" title="Elemento">
                                    <a href="{{url('/admin/elementos')}}"><h3 class="h4 mb-2">Elemento</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/fase.png")}} width="70" height="70" alt="Fase" title="Fase">
                                    <a href="{{url('/admin/fases')}}"><h3 class="h4 mb-2">Fase</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/fijo_eventual.png")}} width="70" height="70" alt="Fijo/Eventual" title="Fijo/Eventual">
                                    <a href="{{url('/admin/fijos_eventuales')}}"><h3 class="h4 mb-2">Fijo/Eventual</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img src={{URL::asset("images/avance_proyecto.png")}} width="70" height="70" alt="Avance de Proyecto" title="Avance de Proyecto">
                                    <a href="{{url('/admin/avance_proyectos')}}"><h3 class="h4 mb-2">Avance de Proyecto</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/hito.png")}} width="70" height="70" alt="Hito" title="Hito">
                                    <a href="{{url('/admin/hitos')}}"><h3 class="h4 mb-2">Hito</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/letra.png")}} width="70" height="70" alt="Letra" title="Letra">
                                    <a href="{{url('/admin/letras')}}"><h3 class="h4 mb-2">Letra</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/nacion.png")}} width="70" height="70" alt="Nación" title="Nación">
                                    <a href="{{url('/admin/naciones')}}"><h3 class="h4 mb-2">Nación</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/planta.png")}} width="70" height="70" alt="Tipo de Elemento" title="Planta">
                                    <a href="{{url('/admin/plantas')}}"><h3 class="h4 mb-2">Planta</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/trabajan.png")}} width="70" height="70" alt="Proyecto/Sección" title="Proyecto/Sección">
                                    <a href="{{url('/admin/trabajan')}}"><h3 class="h4 mb-2">Proyecto/Sección</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/composicion.png")}} width="70" height="70" alt="Proyecto/Tipo de Elemento" title="Proyecto/Tipo de Elemento">
                                    <a href="{{url('/admin/composicion')}}"><h3 class="h4 mb-2">Proyecto/Tipo de Elemento</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img src={{URL::asset("images/proyecto.png")}} width="70" height="70" alt="Proyecto" title="Proyecto">
                                    <a href="{{url('/admin/proyectos')}}"><h3 class="h4 mb-2">Proyecto</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/proyecto_padre.png")}} width="70" height="70" alt="Proyecto Padre" title="Proyecto Padre">
                                    <a href="{{url('/admin/proyectospadre')}}"><h3 class="h4 mb-2">Proyecto padre</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/seccion.png")}} width="70" height="70" alt="Sección" title="Sección">
                                    <a href="{{url('/admin/secciones')}}"><h3 class="h4 mb-2">Sección</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/srd_letra.png")}} width="70" height="70" alt="SRD Letra" title="SRD Letra">
                                    <a href="{{url('/admin/srd')}}"><h3 class="h4 mb-2">Horas Registradas</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/tipo_elemento.png")}} width="70" height="70" alt="Tipo de Elemento" title="Tipo de Elemento">
                                    <a href="{{url('/admin/tipo_elementos')}}"><h3 class="h4 mb-2">Tipo de Elemento</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/tipo_proyecto.png")}} width="70" height="70" alt="Tipo de Proyecto" title="Tipo de Proyecto">
                                    <a href="{{url('/admin/tipos_proyecto')}}"><h3 class="h4 mb-2">Tipo de Proyecto</a>
                                </td>
                                <td class="text-center">
                                    <img src={{URL::asset("images/usuario.png")}} width="70" height="70" alt="Usuario" title="Usuario">
                                    <a href="{{url('/admin/usuarios')}}"><h3 class="h4 mb-2">Usuario</a>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <h3 class="text-center mb-3">Esquema de la Base de Datos</h3>
                    <img src={{URL::asset("images/SRD.png")}} width="1147" height="521" alt="Esquema de la Base de Datos">
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
