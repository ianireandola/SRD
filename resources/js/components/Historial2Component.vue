<template>
<div>
    <h2> Historial de horas registradas </h2>

     <form @submit.prevent="registrarHoras()" class="mb-3">
        <table class="table table-hover table-reponsive overflow-auto">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col" width="15%"> FECHA </th>
                    <th class="text-center" scope="col" width="30%"> PROYECTO/LETRA </th>
                    <th class="text-center" scope="col" width="15%"> DEDICACIÓN </th>
                    <th class="text-center" scope="col" width="10%"> ACCIÓN NIVEL 1 </th>
                    <th class="text-center" scope="col" width="20%"> ACCIÓN NIVEL 2 </th>
                    <th class="text-center" scope="col" width="3%"> CANTIDAD HORAS </th>
                    <th class="text-center" scope="col" width="3%"> SERVICIO OFICIAL </th>
                    <th class="text-center" scope="col" width="4%"> ELIMINAR </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(srd_letra, index) in srd_letras" v-bind:key="index">
                    <td class="text-center">{{srd_letra.fecha}}</td>
                    <td>{{srd_letra.nombre}}</td>
                        <td v-if="srd_letra.dedicacion_id == 2">
                            Gasto General
                        </td>
                        <td v-if="srd_letra.dedicacion_id == 3">
                            No Presencia
                        </td>
                        <td v-if="srd_letra.dedicacion_id == 4">
                            SAT
                        </td>
                    <td class="text-center"></td>
                    <td class="text-center"></td>
                    <td class="text-center">{{srd_letra.cantidadHoras}}</td>
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" v-model="srd_letra.viaje" disabled>
                    </td>
                    <td class="text-center"><b-button block variant="secondary" type="submit" @click="eliminarSRDLetra(srd_letra, index)">Eliminar</b-button></td>
                </tr>
                <tr v-for="(srd_proyecto, index) in srd_proyectos" v-bind:key="`A-${index}`">
                    <td class="text-center">{{srd_proyecto.fecha}}</td>
                    <td>{{srd_proyecto.nombre}}</td>
                    <td>Proyecto</td>
                    <td>
                    <template v-for="accion2 in acciones2">
                        <td v-if="accion2.id === srd_proyecto.acc_id" v-bind:key="`B-${accion2.id}`">
                            {{accion2.nombre}}
                        </td>
                    </template>
                    </td>
                    <td>
                    <template v-for="elemento in elementos">
                        <td v-if="elemento.id === srd_proyecto.el_id"  v-bind:key="`C-${elemento.id}`">
                            {{elemento.nombre}}
                        </td>
                    </template>
                    </td>
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
        name: "Historial2Component",
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
                    dedicacion_id: '',
                    cantidadHoras: '',
                    viaje: ''
                },
                srd_proyectos: [],
                srd_proyecto:
                {
                    id: '',
                    fecha: '',
                    nombre: '',
                    acc_id: '',
                    el_id: '',
                    cantidadHoras: '',
                    viaje: ''
                },
                acciones2: [],
                accion2:
                {
                    id: '',
                    nombre: '',
                },
                elementos: [],
                elemento:
                {
                    id:'',
                    nombre: ''
                }
            }
        },
        created()
        {
            axios.get('http://localhost/laravel/prueba4/public/index.php/srd_letras')
                .then(res=>{
                    this.srd_letras = res.data;
                });
            axios.get('http://localhost/laravel/prueba4/public/index.php/srd_proyectos/create')
                .then(res=>{
                    this.srd_proyectos = res.data;
                });
            axios.get('http://localhost/laravel/prueba4/public/index.php/acciones2')
                .then(res=>{
                    this.acciones2 = res.data;
                });   
            axios.get('http://localhost/laravel/prueba4/public/index.php/elementos')
                .then(res=>{
                    this.elementos = res.data;
                });
        },
        methods:
        {
            registrarHoras()
            {

            },
            eliminarSRDLetra(item, index)
            {
                axios.delete(`http://localhost/laravel/prueba4/public/index.php/srd_letras/${item.id}`)
                    .then(()=>{
                        this.srd_letras.splice(index, 1);
                    });
            }, 
            eliminarSRDProyecto(item, index)
            {
                axios.delete(`http://localhost/laravel/prueba4/public/index.php/srd_proyectos/${item.id}`)
                    .then(()=>{
                        this.srd_proyectos.splice(index, 1);
                    });
            }
        }
    }
</script>