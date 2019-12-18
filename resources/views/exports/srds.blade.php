<table>
<thead>
    <tr>
        <th class="text-center" scope="col"> FECHA </th>
        <th class="text-center" scope="col"> CATEGORÍA </th>
        <th class="text-center" scope="col"> USUARIO </th>
        <th class="text-center" scope="col"> ID SECCIÓN </th>
        <th class="text-center" scope="col"> SECCIÓN </th>
        <th class="text-center" scope="col"> ID PROYECTO/LETRA </th>
        <th class="text-center" scope="col"> PROYECTO/LETRA </th>
        <th class="text-center" scope="col"> DEDICACIÓN </th>
        <th class="text-center" scope="col"> ID ACCIÓN NIVEL 1 </th>
        <th class="text-center" scope="col"> ACCIÓN NIVEL 1 </th>
        <th class="text-center" scope="col"> ID ACCIÓN NIVEL 2 </th>
        <th class="text-center" scope="col"> ACCIÓN NIVEL 2 </th>
        <th class="text-center" scope="col"> CANTIDAD HORAS </th>
        <th class="text-center" scope="col"> VIAJE </th>
    </tr>
</thead>
<tbody>
    @foreach($srd_letras as $srd_letra)
    <tr>
        <td>{{ $srd_letra->fecha }}</td>
        @foreach($users as $user)
            @if( $user->id === $srd_letra->user_id)
                @foreach($categorias as $categoria)
                    @if( $user->categoria_id === $categoria->id)
                        <td>{{$categoria->nombre}}
                    @endif
                @endforeach
                <td>{{ $user->chapa }}</td>
            @endif
        @endforeach
        @foreach($users as $user)
            @if( $user->id === $srd_letra->user_id)
                @foreach($secciones as $seccion)
                    @if($user->seccion_id === $seccion->id)
                        <td>{{ $seccion->identificador }}</td>
                        <td>{{ $seccion->nombre }}</td>
                    @endif
                @endforeach
            @endif
        @endforeach
        @foreach($letras as $letra)
            @if( $letra->id === $srd_letra->letra_id)
                <td>{{ $letra->identificador }}</td>
                <td>{{ $letra->nombre }}</td>
                @foreach($dedicaciones as $dedicacion)
                    @if($letra->dedicacion_id === $dedicacion->id)
                        <td>{{ $dedicacion->nombre }}</td>
                    @endif
                @endforeach
            @endif
        @endforeach
        <td></td>
        <td></td>
        <td></td>
        <td></td>
        <td>{{ $srd_letra->cantidadHoras }}</td>
        <td>{{ $srd_letra->viaje }}</td>
    </tr>
    @endforeach
    @foreach($srd_proyectos as $srd_proyecto)
        @if($srd_proyecto->nivel2  === 1)
            <tr>
                <td>{{ $srd_proyecto->fecha }}</td>
                @foreach($users as $user)
                    @if( $user->id === $srd_proyecto->us_id)
                        @foreach($categorias as $categoria)
                            @if( $user->categoria_id === $categoria->id)
                                <td>{{$categoria->nombre}}
                            @endif
                        @endforeach
                        <td>{{ $user->chapa }}</td>
                    @endif
                @endforeach
                @foreach($users as $user)
                    @if( $user->id === $srd_proyecto->us_id)
                        @foreach($secciones as $seccion)
                            @if($user->seccion_id === $seccion->id)
                                <td>{{ $seccion->identificador }}</td>
                                <td>{{ $seccion->nombre }}</td>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @foreach($proyectos as $proyecto)
                    @if( $proyecto->id === $srd_proyecto->proy_id)
                        <td>{{ $proyecto->identificador }}</td>
                        <td>{{ $proyecto->nombre }}</td>
                        <td> Proyecto </td>
                    @endif
                @endforeach
                @foreach($acciones as $accion)
                    @if( $accion->id === $srd_proyecto->acc_id)
                        <td>{{ $accion->identificador }}</td>
                        <td>{{ $accion->nombre }}</td>
                    @endif
                @endforeach
                @foreach($elementos as $elemento)
                    @if( $elemento->id === $srd_proyecto->el_id)
                        <td>{{ $elemento->identificador }}</td>
                        <td>{{ $elemento->nombre }}</td>
                    @endif
                @endforeach
                <td>{{ $srd_proyecto->cantidadHoras }}</td>
                <td>{{ $srd_proyecto->viaje }}</td>
            </tr>
        @endif
        @if($srd_proyecto->nivel2 === 0)
            <tr>
                <td>{{ $srd_proyecto->fecha }}</td>
                @foreach($users as $user)
                    @if( $user->id === $srd_proyecto->us_id)
                        @foreach($categorias as $categoria)
                            @if( $user->categoria_id === $categoria->id)
                                <td>{{$categoria->nombre}}
                            @endif
                        @endforeach
                        <td>{{ $user->chapa }}</td>
                    @endif
                @endforeach
                @foreach($users as $user)
                    @if( $user->id === $srd_proyecto->us_id)
                        @foreach($secciones as $seccion)
                            @if($user->seccion_id === $seccion->id)
                                <td>{{ $seccion->identificador }}</td>
                                <td>{{ $seccion->nombre }}</td>
                            @endif
                        @endforeach
                    @endif
                @endforeach
                @foreach($proyectos as $proyecto)
                    @if( $proyecto->id === $srd_proyecto->proy_id)
                        <td>{{ $proyecto->identificador }}</td>
                        <td>{{ $proyecto->nombre }}</td>
                        <td> Proyecto </td>
                    @endif
                @endforeach
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td>{{ $srd_proyecto->cantidadHoras }}</td>
                <td>{{ $srd_proyecto->viaje }}</td>
            </tr>
        @endif
    @endforeach
</tbody>
</table>