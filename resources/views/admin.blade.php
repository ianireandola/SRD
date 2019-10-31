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
                                <td class="text-center"><a href="/admin/accion2s"><img src="images/accion2.png" width="70" height="70" alt="Acción de nivel 2" title="Acción de nivel 2">Acción nivel 2</a>
                                <td class="text-center"><a href="/admin/admins"><img src="images/administrador.png" width="70" height="70" alt="Administrador" title="Administrador">Administrador</a>
                                <td class="text-center"><a href="/admin/areas"><img src="images/area.png" width="70" height="70" alt="Área" title="Área">Área</a></td>
                            </tr>
                            <tr>
                                <td class="text-center"><a href="/admin/categorias"><img src="images/categoria.png" width="70" height="70" alt="Categoría" title="Categoría">Categoría</a></td>
                                <td class="text-center"><a href="#"><img src="images/elemento.png" width="70" height="70" alt="Elemento" title="Elemento">X-Elemento</a></td>
                                <td class="text-center"><a href="/admin/fases"><img src="images/fase.png" width="70" height="70" alt="Fase" title="Fase">Fase</a></td>
                            </tr>
                            <tr>
                                <td class="text-center"><a href="/admin/fijos_eventuales"><img src="images/fijo_eventual.png" width="70" height="70" alt="Fijo/Eventual" title="Fijo/Eventual">Fijo/Eventual</a></td>
                                <td class="text-center"><a href="#"><img src="images/avance_proyecto.png" width="70" height="70" alt="Avance de Proyecto" title="Avance de Proyecto">X-Avance de Proyecto</a></td>
                                <td class="text-center"><a href="#"><img src="images/hito.png" width="70" height="70" alt="Hito" title="Hito">X-Hito</a></td>
                            </tr>
                            <tr>
                                <td class="text-center"><a href="#"><img src="images/user_letra.png" width="70" height="70" alt="Usuario/Letra" title="Usuario/Letra">X-Usuario/Letra</a></td>
                                <td class="text-center"><a href="#"><img src="images/letra.png" width="70" height="70" alt="Letra" title="Letra">X-Letra</a></td>
                                <td class="text-center"><a href="/admin/naciones"><img src="images/nacion.png" width="70" height="70" alt="Nación" title="Nación">Nación</a></td>
                            </tr>
                            <tr>
                                <td class="text-center"><a href="/admin/plantas"><img src="images/planta.png" width="70" height="70" alt="Tipo de Elemento" title="Planta">Planta</a></td>
                                <td class="text-center"><a href="#"><img src="images/trabajan.png" width="70" height="70" alt="Proyecto/Sección" title="Proyecto/Sección">X-Proyecto/Sección</a></td>
                                <td class="text-center"><a href="#"><img src="images/composicion.png" width="70" height="70" alt="Proyecto/Tipo de Elemento" title="Proyecto/Tipo de Elemento">X-Proyecto/Tipo de Elemento</a></td>
                            </tr>
                            <tr>
                                <td class="text-center"><a href="#"><img src="images/proyecto.png" width="70" height="70" alt="Proyecto" title="Proyecto">X-Proyecto</a></td>
                                <td class="text-center"><a href="#"><img src="images/proyecto_padre.png" width="70" height="70" alt="Proyecto Padre" title="Proyecto Padre">X-Proyecto padre</a></td>
                                <td class="text-center"><a href="/admin/secciones"><img src="images/seccion.png" width="70" height="70" alt="Sección" title="Sección">Sección</a></td>
                            </tr>
                            <tr>
                                <td class="text-center"><a href="#"><img src="images/srd_letra.png" width="70" height="70" alt="SRD Letra" title="SRD Letra">X-SRD Letra</a></td>
                                <td class="text-center"><a href="#"><img src="images/srd_proyecto.png" width="70" height="70" alt="SRD Proyecto" title="SRD Proyecto">X-SRD Proyecto</a></td>  
                                <td class="text-center"><a href="#"><img src="images/tipo_elemento.png" width="70" height="70" alt="Tipo de Elemento" title="Tipo de Elemento">X-Tipo de Elemento</a></td>
                            </tr>
                            <tr>
                                <td class="text-center"><a href="/admin/tipos_proyecto"><img src="images/tipo_proyecto.png" width="70" height="70" alt="Tipo de Proyecto" title="Tipo de Proyecto">Tipo de Proyecto</a></td>
                                <td class="text-center"><a href="/admin/usuarios"><img src="images/usuario.png" width="70" height="70" alt="Usuario" title="Usuario">Usuario</a></td>
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
