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
            <div class="row">
                <div class="col">
                    <b-form-input class="mb-4" type="number" v-model="trabajan.horasEstimadas" placeholder="Horas estimadas"/>
                </div>
                <div class="col">
                    <b-form-input class="mb-4" type="number" v-model="trabajan.presupuesto" placeholder="Presupuesto"/>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-block">Guardar</button>
            <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
        </form>

        <!--Cuando "editarActivo=false" AGREGAR -->
        <form @submit.prevent="agregar()" v-else class="mb-5">
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
            <div class="row">
                <div class="col">
                    <b-form-input class="mb-4" type="number" v-model="trabajan.horasEstimadas" placeholder="Horas estimadas"/>
                </div>
                <div class="col">
                    <b-form-input class="mb-4" type="number" v-model="trabajan.presupuesto" placeholder="Presupuesto"/>
                </div>
            </div>
            <button type="submit" class="btn btn-success btn-block mb-7 md-2">Agregar</button>
        </form>

        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th scope="col" width="30%">PROYECTO</th>
                    <th scope="col" width="37,5%">SECCIÓN</th>
                    <th class="text-center" scope="col" width="5%">HORAS ESTIMADAS</th>
                    <th class="text-center" scope="col" width="5%">PRESUPUESTO</th>
                    <th class="text-center" scope="col" width="20%">OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(trabajan, index) in trabajans" v-bind:key="index">
                    <template v-for="proyecto in proyectos">
                        <td v-if="proyecto.id === trabajan.proyecto_id" v-bind:key="`A-${proyecto.id}`">
                            {{proyecto.nombre}}
                        </td>
                    </template>
                    <template v-for="seccion in secciones">
                        <td v-if="seccion.id === trabajan.seccion_id" v-bind:key="`B-${seccion.id}`">
                            {{seccion.nombre}}
                        </td>
                    </template>
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
                proyectos: [],
                proyecto:
                {
                    id: '', 
                    proyectoPadre: '',
                    nombre: '',
                    descripcion: '',
                    estado: '',
                    cantidadActual: '',
                    cantidadTotal: '',
                    Ed_PF: '',
                    ultimaRevision: '',
                    fabricacion: ''
                },
                secciones: [],
                seccion:
                {
                    id: '',
                    nombre: '',
                    nivel2: '',
                    area_id: '',
                    planta_id: ''
                },
                editarActivo: false
            }
        },
        created()
        {
            axios.get('/admin/trabajan/create')
                .then(res=>{
                    this.trabajans = res.data;
                });
            axios.get('/admin/proyectos/create')
                .then(res=>{
                    this.proyectos = res.data;
                });
            axios.get('/admin/secciones/create')
                .then(res=>{
                    this.secciones = res.data;
                })           
        },
        methods:
        {
            agregar()
            {
                if(this.trabajan.proyecto_id === '' || this.trabajan.seccion_id === '' || this.trabajan.horasEstimadas === '' || this.trabajan.presupuesto === '')
                {
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                }
                const params = {
                    proyecto_id: this.trabajan.proyecto_id, 
                    seccion_id: this.trabajan.seccion_id, 
                    horasEstimadas: this.trabajan.horasEstimadas, 
                    presupuesto: this.trabajan.presupuesto}

                this.trabajan.proyecto_id = '',
                this.trabajan.seccion_id = '',
                this.trabajan.horasEstimadas = '',
                this.trabajan.presupuesto = '',
                this.trabajan.id = '',
                this.proyecto = '',
                this.seccion = ''
                
                axios.post('/admin/trabajan', params)
                    .then(res=>{
                        this.trabajans.push(res.data);
                    });
                this.$swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Registro realizado',
                    showConfirmButton: false,
                    timer: 1300})
            },
            editarFormulario(trabajan)
            {
                this.editarActivo = true;
                this.trabajan.proyecto_id = trabajan.proyecto_id;
                this.trabajan.seccion_id = trabajan.seccion_id;
                this.trabajan.horasEstimadas = trabajan.horasEstimadas;
                this.trabajan.presupuesto = trabajan.presupuesto;
                this.trabajan.id = trabajan.id;

                for(var i=0; i<this.proyectos.length; i++)
                {
                    if(this.proyectos[i].id === trabajan.proyecto_id)
                    {
                        this.proyecto = this.proyectos[i];
                        this.trabajan.proyecto_id = this.proyectos[i].id;
                    }
                }
                for(var i=0; i<this.secciones.length; i++)
                {
                    if(this.secciones[i].id === trabajan.seccion_id)
                    {
                        this.seccion = this.secciones[i];
                        this.trabajan.seccion_id = this.secciones[i].id;
                    }
                }
            },
            editarTrabajan()
            {
                const params={
                    id: this.seccion.id,
                    proyecto_id: this.trabajan.proyecto_id, 
                    seccion_id: this.trabajan.seccion_id, 
                    horasEstimadas: this.trabajan.horasEstimadas, 
                    presupuesto: this.trabajan.presupuesto}

                axios.put(`/admin/trabajan/${this.trabajan.id}`, params)
                    .then(res =>{
                        this.editarActivo = false;
                        const index = this.trabajans.findIndex(trabajanBuscar => trabajanBuscar.id === res.data.id)
                        this.trabajans[index] = res.data;

                        this.trabajan = { id: '', proyecto_id: '', seccion_id: '', horasEstimadas: '', presupuesto: ''}
                        this.proyecto = '',
                        this.seccion = ''
                    });
                this.$swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Modificación realizada',
                    showConfirmButton: false,
                    timer: 1300})
            },
            cancelarEdicion()
            {
                this.editarActivo = false;
                this.trabajan = { id: '', proyecto_id: '', seccion_id: '', horasEstimadas: '', presupuesto: ''}
                this.proyecto = '',
                this.seccion = ''
            },
            asignarProyecto(proyecto)
            {
                this.trabajan.proyecto_id = proyecto.id;
            },
            asignarSeccion(seccion)
            {
                this.trabajan.seccion_id = seccion.id;
            },
            eliminarTrabajan(trabajan, index)
            {
                this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",
                {
                    okVariant: 'danger',
                    okTitle: 'Eliminar',
                    cancelTitle: 'Cancelar'
                }).then(value=>
                {
                    if(value === true)
                    {
                        axios.delete(`/admin/trabajan/${trabajan.id}`)
                            .then(()=>
                            {
                                this.trabajans.splice(index, 1);
                            });
                        this.$swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Eliminado',
                            showConfirmButton: false,
                            timer: 1300})
                    }
                })
            }
        }
    }
</script>