<template>
<div>
    <template v-for="user in users">
        <td v-bind:key="`B-${user.id}`">
            {{user.id}} - {{user.nivel2}}
        </td>
    </template>
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
                <tr v-for="(srd_proyecto, index) in srd_proyectos" v-bind:key="`A-${index}`">
                    <td class="text-center">{{srd_proyecto.fecha}}</td>
                    <td>{{srd_proyecto.user_nombre}}</td>
                    <td>{{srd_proyecto.proyecto_nombre}}</td>
                    <td>{{srd_proyecto.accion2_nombre}}</td>
                    <td>{{srd_proyecto.elemento_nombre}}</td>
                    <td class="text-center">{{srd_proyecto.cantidadHoras}}</td>
                    <td class="text-center">{{srd_proyecto.viaje}}</td>
                </tr>
                <tr v-for="(srd_proyecto2, index) in srd_proyectos2" v-bind:key="`B-${index}`">
                    <td class="text-center">{{srd_proyecto2.fecha}}</td>
                    <td>{{srd_proyecto2.user_nombre}}</td>
                    <td>{{srd_proyecto2.proyecto_nombre}}</td>
                    <td></td>
                    <td></td>
                    <td class="text-center">{{srd_letra.cantidadHoras}}</td>
                    <td class="text-center">{{srd_letra.viaje}}</td>                
                </tr>
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
            users: [],
            user:
            {
                id: '',
                nivel2: ''
            },
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
            srd_proyectos: [],
            srd_proyecto:
            {
                id: '',
                us_id: '',
                user_nombre: '',
                proy_id: '',
                proyecto_nombre: '',
                acc_id: '',
                accion2_nombre: '',
                el_id: '',
                elemento_nombre: '',
                fecha: '',
                cantidadHoras: '',
                viaje: ''
            },
            srd_proyectos2: [],
            srd_proyecto2:
            {
                id: '',
                us_id: '',
                user_nombre: '',
                proy_id: '',
                proyecto_nombre: '',
                fecha: '',
                cantidadHoras: '',
                viaje: ''
            }
        }
    },
    created()
    {
        axios.get('/admin/srd/createNivel2')
            .then(res=>{
                this.users = res.data;
            });

        axios.get('/admin/srd/createLetras')
            .then(res=>{
                this.srd_letras = res.data;
            });
        console.log(this.users.length); 

        for(var i=0; i<this.users.length; i++)
        {
            console.log("Entro");
            if(this.users[i].nivel2 === 0)
            {
                axios.get('/admin/srd/createProyectos2')
                    .then(res=>{
                        this.srd_proyectos2[i] = res.data;
                    });
            }else{
                axios.get('/admin/srd/createProyectos')
                    .then(res=>{
                        this.srd_proyectos[i] = res.data;
                    });
            }
        }
     

    }
}
</script>