<template>
<div>
    <form class="mb-3">

        <table class="table table-hover table-responsive overflow-auto">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col"> FECHA </th>
                    <th class="text-center" scope="col"> USUARIO </th>
                    <th class="text-center" scope="col"> PROYECTO/LETRA </th>
                    <th class="text-center" scope="col"> ACCIÓN NIVEL 1 </th>
                    <th class="text-center" scope="col"> ACCIÓN NIVEL 2 </th>
                    <th class="text-center" scope="col"> CANTIDAD HORAS </th>
                    <th class="text-center" scope="col"> VIAJE </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(srd_letra, index) in srd_letras" v-bind:key="index">
                    <td class="text-center">{{srd_letra.fecha}}</td>
                    <td>{{srd_letra.user_nombre}}</td>
                    <td>{{srd_letra.letra_nombre}}</td>
                    <td></td>
                    <td></td>
                    <td class="text-center">{{srd_letra.cantidadHoras}}</td>
                    <td class="text-center">{{srd_letra.viaje}}</td>                
                </tr>
                <tr v-for="(srd_todoproyecto, index) in srd_todoproyectos" v-bind:key="`A-${index}`">
                    <td class="text-center">{{srd_todoproyecto.fecha}}</td>
                    <td>{{srd_todoproyecto.us_id}}</td>
                    <td>{{srd_todoproyecto.proy_id}}</td>
                    <td>{{srd_todoproyecto.acc_id}}</td>
                    <td>{{srd_todoproyecto.el_id}}</td>
                    <td class="text-center">{{srd_todoproyecto.cantidadHoras}}</td>
                    <td class="text-center">{{srd_todoproyecto.viaje}}</td>                
                </tr>
                <!--<tr v-for="(srd_proyecto, index) in srd_proyectos" v-bind:key="`A-${index}`">
                    <td class="text-center">{{srd_proyecto.fecha}}</td>
                    <td>{{srd_proyecto.user_nombre}}</td>
                    <td>{{srd_proyecto.proyecto_nombre}}</td>
                    <td></td>
                    <td></td>
                    <td class="text-center">{{srd_proyecto.cantidadHoras}}</td>
                    <td class="text-center">{{srd_proyecto.viaje}}</td>
                </tr>
                <tr v-for="(srd_proyecto2, index) in srd_proyectos2" v-bind:key="`B-${index}`">
                    <td class="text-center">{{srd_proyecto2.fecha}}</td>
                    <td>{{srd_proyecto2.user_nombre}}</td>
                    <td>{{srd_proyecto2.proyecto_nombre}}</td>
                    <td>{{srd_proyecto2.accion2_nombre}}</td>
                    <td>{{srd_proyecto2.elemento_nombre}}</td>
                    <td class="text-center">{{srd_proyectos2.cantidadHoras}}</td>
                    <td class="text-center">{{srd_proyectos2.viaje}}</td>                
                </tr>-->
            </tbody>
        </table>
    </form>
</div>
</template>

<script>
export default {
    name: 'SRDComponent',
    data()
    {
        return{
            srd_letras: [],
            srd_letra:
            {
                id: '',
                user_id: '',
                user_nombre: '',
                letra_id: '',
                letra_nombre: '',
                fecha: '',
                cantidadHoras: '',
                viaje: ''
            },
            srd_todoproyectos: [],
            srd_todoproyecto: 
            {
                id: '',
                proy_id: '',
                us_id: '',
                acc_id: '',
                el_id: '',
                fecha: '',
                cantidadHoras: '',
                viaje: '',
                nivel2: ''
            },
            srd_proyectos: [],
            srd_proyecto:
            {
                id: '',
                fecha: '',
                us_id: '',
                user_nombre: '',
                proy_id: '',
                proyecto_nombre: '',
                cantidadHoras: '',
                viaje: ''
            },
            srd_proyectos2: [],
            srd_proyecto2:
            {
                id: '',
                proy_id: '',
                proyecto_nombre: '',
                us_id: '',
                user_nombre: '',
                acc_id: '',
                accion2_nombre: '',
                el_id: '',
                elemento_nombre: '',
                fecha: '',
                cantidadHoras: '',
                viaje: ''
            }
        }
    },
    created()
    {
        axios.get('/admin/srd/createLetras')
            .then(res=>{
                this.srd_letras = res.data;
            });

        axios.get('/admin/srd/proyectos')
            .then(res=>{
                this.srd_todoproyectos = res.data;
            })

        axios.get('/admin/srd/createProyectos')
            .then(res=>{
                console.log(res.data.length);
                for(var i=0; i<res.data.length; i++)
                {
                    console.log("Item  " + i + ": ID - " + res.data[i].id + ", Nivel2 - " + res.data[i].nivel2);
                    for(var j=0; j<this.srd_todoproyectos.length; j++)
                    {
                        if(res.data[i].id === this.srd_todoproyectos[j].id && res.data[i].nivel2 === 1)
                        {
                            console.log("Entro en nivel 2, id: " + res.data[i].id);
                        }
                        if(res.data[i].id === this.srd_todoproyectos[j].id && res.data[i].nivel2 === 0)
                        {
                            console.log("Entro en nivel 1, id: " + res.data[i].id);
                        }
                    }
                }
            });

        
    }
}
</script>