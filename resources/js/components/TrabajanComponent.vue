<template>
    <div>
        <h3 class="text-center mb-3">Gestión de relación Proyectos con Secciones</h3>

        <!--Cuando "editarActivo=true" EDITAR-->
        <form @submit.prevent="editarTrabajan()" v-if="editarActivo" class="mb-5">
            <b-form-group label="Proyecto:">
                <b-form-select v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                    <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.id}} - {{proyecto.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <b-form-group label="Sección:">
                <b-form-select class="form-control" v-model="seccion" v-on:change="asignarSeccion(seccion)">
                    <option v-for="seccion in secciones" v-bind:key="seccion.id" :value="seccion">{{seccion.id}} - {{seccion.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <button type="submit" class="btn btn-success btn-block">Guardar</button>
            <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
        </form>

        <!--Cuando "editarActivo=false" AGREGAR -->
        <form @submit.prevent="editarTrabajan()" v-if="editarActivo" class="mb-5">
            <b-form-group label="Proyecto:">
                <b-form-select v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                    <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.id}} - {{proyecto.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <b-form-group label="Sección:">
                <b-form-select class="form-control" v-model="seccion" v-on:change="asignarSeccion(seccion)">
                    <option v-for="seccion in secciones" v-bind:key="seccion.id" :value="seccion">{{seccion.id}} - {{seccion.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <button type="submit" class="btn btn-success btn-block mb-7 md-2">Agregar</button>
        </form>

        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col" width="37,5%">PROYECTO</th>
                    <th class="text-center" scope="col" width="37,5%">SECCIÓN</th>
                    <th class="text-center" scope="col" width="5%">HORAS ESTIMADAS</th>
                    <th class="text-center" scope="col" width="5%">PRESUPUESTO</th>
                    <th class="text-center" scope="col" width="20%">OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(trabajan, index) in trabajans" v-bind:key="index">
                    <td>{{trabajan.proyecto_id}}</td>
                    <td>{{trabajan.seccion_id}}</td>
                    <td>{{trabajan.horasEstimadas}}</td>
                    <td>{{trabajan.presupuesto}}</td>
                    <td class="text-center">
                        <button type="button" @click="editarFormulario(trabajan)" class="btn btn-primary">Modificar</button>
                        <button type="button" @click="eliminarTrabajan(trabajan, index)" class="btn btn-secondary">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default  {
        name: "TrabajanComponent",
        data()
        {
            return{
                trabajans: [],
                trabajan:
                {
                    id: '',
                    proyecto_id: '',
                    seccion_id: '', 
                    horasEstimadas: '',
                    presupuesto: ''
                },
                editarActivo: false
            }
        },
        created()
        {
            axios.get('/admin/trabajan/create')
                .then(res=>{
                    this.trabajans = res.data;
                })        
        },
        methods:
        {
            agregar()
            {
                
            },
            editarFormulario(avance)
            {
                this.editarActivo = true;
            },
            editarTrabajan()
            {

            },
            cancelarEdicion()
            {
                this.editarActivo = false;
            }
        }
    }
</script>