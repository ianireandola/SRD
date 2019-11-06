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
                                    <img src="images/accion2.png" width="70" height="70" alt="Acción de nivel 2" title="Acción de nivel 2">
                                    <a href="/admin/accion2s"><h3 class="h4 mb-2">Acción nivel 2 </h3>
                                </td>
                                <td class="text-center">
                                    <img src="images/administrador.png" width="70" height="70" alt="Administrador" title="Administrador">
                                    <a href="/admin/admins"><h3 class="h4 mb-2">Administrador </h3>
                                </td>
                                <td class="text-center">
                                    <img src="images/administrador.png" width="70" height="70" alt="Área" title="Área">
                                    <a href="/admin/areas"><h3 class="h4 mb-2">Área </h3>
                                </td>
                                <td class="text-center">
                                    <img src="images/categoria.png" width="70" height="70" alt="Categoría" title="Categoría">
                                    <a href="/admin/categorias"><h3 class="h4 mb-2">Categoría</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/elemento.png" width="70" height="70" alt="Elemento" title="Elemento">
                                    <a href="#"><h3 class="h4 mb-2">X-Elemento</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img src="images/fase.png" width="70" height="70" alt="Fase" title="Fase">
                                    <a href="/admin/fases"><h3 class="h4 mb-2">Fase</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/fijo_eventual.png" width="70" height="70" alt="Fijo/Eventual" title="Fijo/Eventual">
                                    <a href="/admin/fijos_eventuales"><h3 class="h4 mb-2">Fijo/Eventual</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/avance_proyecto.png" width="70" height="70" alt="Avance de Proyecto" title="Avance de Proyecto">
                                    <a href="#"><h3 class="h4 mb-2">X-Avance de Proyecto</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/hito.png" width="70" height="70" alt="Hito" title="Hito">
                                    <a href="#"><h3 class="h4 mb-2">X-Hito</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/user_letra.png" width="70" height="70" alt="Usuario/Letra" title="Usuario/Letra">
                                    <a href="#"><h3 class="h4 mb-2">X-Usuario/Letra</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img src="images/letra.png" width="70" height="70" alt="Letra" title="Letra">
                                    <a href="/admin/letras"><h3 class="h4 mb-2">Letra</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/nacion.png" width="70" height="70" alt="Nación" title="Nación">
                                    <a href="/admin/naciones"><h3 class="h4 mb-2">Nación</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/planta.png" width="70" height="70" alt="Tipo de Elemento" title="Planta">
                                    <a href="/admin/plantas"><h3 class="h4 mb-2">Planta</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/trabajan.png" width="70" height="70" alt="Proyecto/Sección" title="Proyecto/Sección">
                                    <a href="#"><h3 class="h4 mb-2">X-Proyecto/Sección</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/composicion.png" width="70" height="70" alt="Proyecto/Tipo de Elemento" title="Proyecto/Tipo de Elemento">
                                    <a href="#"><h3 class="h4 mb-2">X-Proyecto/Tipo de Elemento</a>
                                </td>
                            </tr>
                            <tr>
                                <td class="text-center">
                                    <img src="images/proyecto.png" width="70" height="70" alt="Proyecto" title="Proyecto">
                                    <a href="#"><h3 class="h4 mb-2">X-Proyecto</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/proyecto_padre.png" width="70" height="70" alt="Proyecto Padre" title="Proyecto Padre">
                                    <a href="#"><h3 class="h4 mb-2">X-Proyecto padre</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/seccion.png" width="70" height="70" alt="Sección" title="Sección">
                                    <a href="/admin/secciones"><h3 class="h4 mb-2">Sección</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/srd_letra.png" width="70" height="70" alt="SRD Letra" title="SRD Letra">
                                    <a href="#"><h3 class="h4 mb-2">X-SRD Letra</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/srd_proyecto.png" width="70" height="70" alt="SRD Proyecto" title="SRD Proyecto">
                                    <a href="#"><h3 class="h4 mb-2">X-SRD Proyecto</a>
                                </td> 
                            </tr>
                            <tr>
                                <td></td>
                                <td class="text-center">
                                    <img src="images/tipo_elemento.png" width="70" height="70" alt="Tipo de Elemento" title="Tipo de Elemento">
                                    <a href="#"><h3 class="h4 mb-2">X-Tipo de Elemento</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/tipo_proyecto.png" width="70" height="70" alt="Tipo de Proyecto" title="Tipo de Proyecto">
                                    <a href="/admin/tipos_proyecto"><h3 class="h4 mb-2">Tipo de Proyecto</a>
                                </td>
                                <td class="text-center">
                                    <img src="images/usuario.png" width="70" height="70" alt="Usuario" title="Usuario">
                                    <a href="/admin/usuarios"><h3 class="h4 mb-2">Usuario</a>
                                </td>
                                <td></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                <div class="card-body">
                    <h3 class="text-center mb-3">Esquema de la Base de Datos</h3>
                    <img src="images/SRD.png" width="1147" height="521" alt="Esquema de la Base de Datos" title="Esquema de la Base de Datos">
                </div>
            </div>
        </div>
    </div>
</div>



@endsection
