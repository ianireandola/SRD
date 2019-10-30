<template>
<div>
    <h2> Historial de horas registradas </h2>

     <form @submit.prevent="registrarHoras()" class="mb-3">
        <table class="table table-hover table-reponsive overflow-auto">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col"> FECHA </th>
                    <th class="text-center" scope="col"> PROYECTO/LETRA </th>
                    <th class="text-center" scope="col"> CANTIDAD HORAS </th>
                    <th class="text-center" scope="col"> SERVICIO OFICIAL </th>
                    <th class="text-center" scope="col"> ELIMINAR </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(srd_letra, index) in srd_letras" v-bind:key="index">
                    <td class="text-center">{{srd_letra.fecha}}</td>
                    <td>{{srd_letra.nombre}}</td>
                    <td class="text-center">{{srd_letra.cantidadHoras}}</td>
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" v-model="srd_letra.viaje" disabled>
                    </td>
                    <td class="text-center"><b-button block variant="secondary" type="submit" @click="eliminarSRDLetra(srd_letra, index)">Eliminar</b-button></td>
                </tr>
                <tr v-for="(srd_proyecto, index) in srd_proyectos" v-bind:key="`A-${index}`">
                    <td class="text-center">{{srd_proyecto.fecha}}</td>
                    <td>{{srd_proyecto.nombre}}</td>
                    <td class="text-center">{{srd_proyecto.cantidadHoras}}</td>
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" v-model="srd_proyecto.viaje" disabled>
                    </td>
                    <td class="text-center"><b-button block variant="secondary" type="submit" @click="eliminarSRDProyecto(srd_proyecto, index)">Eliminar</b-button></td>
                </tr>
            </tbody>
        </table>
     </form>
</div>
</template>

<script>
    export default 
    {
        name: "HistorialComponent",
        data()
        {
            return{
                srd_letras: [],
                srd_letra:
                {
                    id: '',
                    letra_id: '',
                    fecha: '', 
                    nombre: '',
                    cantidadHoras: '',
                    viaje: ''
                },
                srd_proyectos: [],
                srd_proyecto:
                {
                    id: '',
                    fecha: '',
                    nombre: '',
                    cantidadHoras: '',
                    viaje: ''
                }
            }
        },
        created()
        {
            axios.get('/srd_letras')
                .then(res=>{
                    this.srd_letras = res.data;
                });
            axios.get('/srd_proyectos/create')
                .then(res=>{
                    this.srd_proyectos = res.data;
                });        
        },
        methods:
        {
            registrarHoras()
            {

            },
            eliminarSRDLetra(item, index)
            {
                axios.delete(`/srd_letras/${item.id}`)
                    .then(()=>{
                        this.srd_letras.splice(index, 1);
                    });
            }, 
            eliminarSRDProyecto(item, index)
            {
                axios.delete(`/srd_proyectos/${item.id}`)
                    .then(()=>{
                        this.srd_proyectos.splice(index, 1);
                    });
            }
        }
    }
</script>
