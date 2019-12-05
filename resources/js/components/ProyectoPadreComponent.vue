<template>
<div>
    <h3 class="text-center mb-3">Gestión de Proyectos Padre</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarProyectoPadre(proyecto_padre)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="proyecto_padre.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="proyecto_padre.descripcion"/>
        <div class="row">
            <div class="col">
                <b-form-group label="Tipo de Proyecto relacionado:">
                    <b-form-select v-model="tipo_proyecto" v-on:change="asignarTipoProyecto(tipo_proyecto)">
                        <option v-for="tipo_proyecto in tipo_proyectos" v-bind:key="tipo_proyecto.id" :value="tipo_proyecto">{{tipo_proyecto.id}} - {{tipo_proyecto.nombre}}</option>
                    </b-form-select>
                </b-form-group>
            </div>
            <div class="col">
                <b-form-group label="Nación relacionada:">
                    <b-form-select v-model="nacion" v-on:change="asignarNacion(nacion)">
                        <option v-for="nacion in naciones" v-bind:key="nacion.id" :value="nacion">{{nacion.id}} - {{nacion.nombre}}</option>
                    </b-form-select>
                </b-form-group>
            </div>
            <div class="col">
                <b-form-group label="Estado:">
                    <b-form-select v-model="estado" v-on:change="asignarEstado(estado)" :value="estado">
                        <option>Activo</option>
                        <option>Cerrado</option>
                        <option>Bloqueado</option>
                    </b-form-select>
                </b-form-group>
            </div>
        </div>          
        <div class="row">
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Q_Proyecto" v-model="proyecto_padre.Q_Proyecto">
            </div>
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Planificación" v-model="proyecto_padre.planificacion">
            </div>
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Safety" v-model="proyecto_padre.safety">
            </div>
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Homologaciones" v-model="proyecto_padre.homologaciones">
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="proyecto_padre.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="proyecto_padre.descripcion"/>
        <div class="row">
            <div class="col">
                <b-form-group label="Tipo de Proyecto relacionado:">
                    <b-form-select v-model="tipo_proyecto" v-on:change="asignarTipoProyecto(tipo_proyecto)">
                        <option v-for="tipo_proyecto in tipo_proyectos" v-bind:key="tipo_proyecto.id" :value="tipo_proyecto">{{tipo_proyecto.id}} - {{tipo_proyecto.nombre}}</option>
                    </b-form-select>
                </b-form-group>
            </div>
            <div class="col">
                <b-form-group label="Nación relacionada:">
                    <b-form-select v-model="nacion" v-on:change="asignarNacion(nacion)">
                        <option v-for="nacion in naciones" v-bind:key="nacion.id" :value="nacion">{{nacion.id}} - {{nacion.nombre}}</option>
                    </b-form-select>
                </b-form-group>
            </div>
            <div class="col">
                <b-form-group label="Estado:">
                    <b-form-select v-model="estado" v-on:change="asignarEstado(estado)" :value="estado">
                        <option>Activo</option>
                        <option>Cerrado</option>
                        <option>Bloqueado</option>
                    </b-form-select>
                </b-form-group>
            </div>
        </div>          
        <div class="row">
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Q_Proyecto" v-model="proyecto_padre.Q_Proyecto">
            </div>
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Planificación" v-model="proyecto_padre.planificacion">
            </div>
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Safety" v-model="proyecto_padre.safety">
            </div>
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Homologaciones" v-model="proyecto_padre.homologaciones">
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-block">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col" width="3%">ID</th>
                <th class="text-center" scope="col" width="20%">NOMBRE</th>
                <th class="text-center" scope="col" width="25%">DESCRIPCIÓN</th>
                <th class="text-center" scope="col" width="20%">TIPO DE PROYECTO</th>
                <th class="text-center" scope="col" width="32%">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(proyecto_padre, index) in proyecto_padres" v-bind:key="proyecto_padre.id">
                <td class="text-center">{{proyecto_padre.id}}</td>
                <td >{{proyecto_padre.nombre}}</td>
                <td>{{proyecto_padre.descripcion}}</td>
                <template v-for="tipo_proyecto in tipo_proyectos">
                    <td v-if="tipo_proyecto.id === proyecto_padre.tipoProyecto_id" v-bind:key="`A-${tipo_proyecto.id}`">
                        {{tipo_proyecto.nombre}}
                    </td>
                </template>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(proyecto_padre)" class="btn btn-primary">Modificar</button>
                    <b-button variant="info" v-b-modal.center @click="mostrarDetalle(proyecto_padre, $bvModal.show('modal-center'))">Detalle</b-button>
                    <button type="button" @click="relacionProyectos(proyecto_padre)" class="btn btn-info">Proyectos</button>
                    <button type="button" @click="eliminarProyectoPadre(proyecto_padre, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal id="modal-center" hide-footer>
        <template v-slot:modal-title>
            Detalle del Proyecto Padre: <b> {{proyecto_padre.id}} - {{proyecto_padre.nombre}} </b>
        </template>
        <div class="d-block text-left">
            <p><b>ID:</b> {{proyecto_padre.id}}</p>
            <p><b>Nombre:</b> {{proyecto_padre.nombre}}</p>
            <p><b>Descripción:</b> {{proyecto_padre.descripcion}}</p>
            <p><b>Estado:</b> {{proyecto_padre.estado}}</p>
            <p><b>Q Proyecto:</b> {{proyecto_padre.Q_Proyecto}}</p>
            <p><b>Planificación:</b> {{proyecto_padre.planificacion}}</p>
            <p><b>Safety:</b> {{proyecto_padre.safety}}</p>
            <p><b>Homologaciones:</b> {{proyecto_padre.homologaciones}}</p>
            <p><b>Tipo de Proyecto:</b>
                <template v-for="tipo_proyecto in tipo_proyectos">
                    <p v-if="tipo_proyecto.id === proyecto_padre.tipoProyecto_id" v-bind:key="`A-${tipo_proyecto.id}`">
                        {{tipo_proyecto.nombre}}
                    </p>
                </template>
            </p>
            <p><b>Nación:</b> 
                <template v-for="nacion in naciones">
                    <p v-if="nacion.id === proyecto_padre.nacion_id" v-bind:key="`B-${nacion.id}`">
                        {{nacion.nombre}}
                    </p>
                </template>
            </p>
        </div>
        <b-button class="mt-3" block @click="$bvModal.hide('modal-center')">Cerrar</b-button>
    </b-modal>

    <b-modal size="xl" id="modal-proyecto" ref="btnproyecto" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Proyecto Padre a eliminar: <b> {{proyecto_padre.nombre}} </b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionado con los siguientes proyectos: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">PROYECTO</th>
                    <th class="text-center" scope="col">ELEGIR OTRO PROYECTO PADRE: </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(proyecto_coincidente, index) in proyectos_coincidentes" v-bind:key="index">
                    <td>{{proyecto_coincidente.id}} - {{proyecto_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="proyecto_coincidente.proyectoPadre_id" v-on:change="guardarCambios(proyecto_coincidente, index)">
                            <option v-for="proyecto_padre in proyecto_padres" v-bind:key="proyecto_padre.id" :value="proyecto_padre.id">{{proyecto_padre.id}} - {{proyecto_padre.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal($bvModal.hide('modal-proyecto'))"> Cerrar </b-button>
            </b-col>
        </b-row>        
    </b-modal>
</div>
</template>

<script>
export default {
    name: "ProyectoPadreComponent",
    data(){
        return{
            proyecto_padres: [],
            proyecto_padre:
            {
                id: '',
                nombre: '',
                descripcion: '',
                estado: '',
                Q_Proyecto: '',
                planificacion: '',
                safety: '',
                homologaciones: '',
                tipoProyecto_id: '',
                nacion_id: '',
                dedicacion_id: '1'
            },
            tipo_proyectos: [],
            tipo_proyecto: 
            {
                id: '',
                nombre: ''
            },
            naciones: [],
            nacion: 
            {
                id: '',
                nombre: ''
            },
            proyectos: [],
            proyecto:
            {
                id: '',
                proyectoPadre_id: '',
                nombre: '',
                descripcion: ''
            }, 
            proyectos_coincidentes: [],
            proyecto_coincidente:
            {
                id: '',
                proyectoPadre_id: '',
                nombre: '',
                descripcion: ''
            }, 
            estado: '',
            total: 0,
            editarActivo: false
        }
    },
    created()
    {
        axios.get('/admin/proyectospadre/create')
            .then(res=>{
                this.proyecto_padres = res.data;
            });
        
        axios.get('/admin/tipos_proyecto/create')
            .then(res =>{
                this.tipo_proyectos = res.data;
            });

        axios.get('/admin/proyectos/create')
            .then(res=>{
                this.proyectos = res.data;
            });

        axios.get('/admin/naciones/create')
            .then(res =>{
                this.naciones = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.proyecto_padre.nombre.trim() === '' || this.proyecto_padre.estado === '' || this.proyecto_padre.Q_Proyecto === '' || this.proyecto_padre.tipoProyecto_id === '' || this.proyecto_padre.nacion_id === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {
                nombre: this.proyecto_padre.nombre, 
                descripcion: this.proyecto_padre.descripcion, 
                estado: this.proyecto_padre.estado, 
                Q_Proyecto: this.proyecto_padre.Q_Proyecto,
                planificaicon: this.proyecto_padre.planificacion,
                safety: this.proyecto_padre.safety,
                homologaciones: this.proyecto_padre.homologaciones,
                tipoProyecto_id: this.proyecto_padre.tipoProyecto_id,
                nacion_id: this.proyecto_padre.nacion_id,
                dedicacion: '1'}

            this.proyecto_padre.nombre = '',
            this.proyecto_padre.descripcion = '',
            this.proyecto_padre.estado = '',
            this.proyecto_padre.Q_Proyecto = '',
            this.proyecto_padre.planificacion = '',
            this.proyecto_padre.safety = '',
            this.proyecto_padre.homologaciones = '',
            this.proyecto_padre.tipoProyecto_id = '',
            this.proyecto_padre.nacion_id = '',
            this.tipo_proyecto = '',
            this.nacion = ''
            
            axios.post('/admin/proyectospadre', params)
                .then(res=>{
                    this.proyecto_padres.push(res.data);
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarProyectoPadre(proyecto_padre)
        {
            const params = {
                nombre: this.proyecto_padre.nombre, 
                descripcion: this.proyecto_padre.descripcion, 
                estado: this.proyecto_padre.estado, 
                Q_Proyecto: this.proyecto_padre.Q_Proyecto,
                planificacion: this.proyecto_padre.planificacion,
                safety: this.proyecto_padre.safety,
                homologaciones: this.proyecto_padre.homologaciones,
                tipoProyecto_id: this.proyecto_padre.tipoProyecto_id,
                nacion_id: this.proyecto_padre.nacion_id,
                dedicacion_id: this.proyecto_padre.dedicacion_id}

            axios.put(`/admin/proyectospadre/${proyecto_padre.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.proyecto_padres.findIndex(proyectoPadreBuscar => proyectoPadreBuscar.id === res.data.id)
                    this.proyecto_padres[index] = res.data;

                    this.proyecto_padre.id = '',
                    this.proyecto_padre.nombre = '',
                    this.proyecto_padre.descripcion = '',
                    this.proyecto_padre.estado = '',
                    this.proyecto_padre.Q_Proyecto = '',
                    this.proyecto_padre.planificacion = '',
                    this.proyecto_padre.safety = '',
                    this.proyecto_padre.homologaciones = '',
                    this.proyecto_padre.tipoProyecto_id = '',
                    this.proyecto_padre.nacion_id = '',
                    this.nacion = '',
                    this.tipo_proyecto = '',
                    this.estado = ''
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
            this.proyecto_padre = {
                id: '',
                nombre: '',
                descripcion: '',
                estado: '',
                Q_Proyecto: '',
                planificacion: '',
                safety: '',
                homologaciones: '',
                tipoProyecto_id: '',
                nacion_id: '',
                dedicacion_id: '1'
            },
            this.proyecto = '',
            this.tipo_proyecto = ''
        },
        editarFormulario(proyecto_padre)
        {
            this.editarActivo = true;
            this.proyecto_padre.nombre = proyecto_padre.nombre;
            this.proyecto_padre.descripcion = proyecto_padre.descripcion;
            this.proyecto_padre.id = proyecto_padre.id;
            this.proyecto_padre.estado = proyecto_padre.estado;
            this.proyecto_padre.Q_Proyecto = proyecto_padre.Q_Proyecto;
            this.proyecto_padre.planificacion = proyecto_padre.planificacion;
            this.proyecto_padre.safety = proyecto_padre.safety;
            this.proyecto_padre.homologaciones = proyecto_padre.homologaciones;
            this.estado = proyecto_padre.estado;

            for(var i=0; i<this.tipo_proyectos.length; i++)
            {
                if(this.tipo_proyectos[i].id === proyecto_padre.tipoProyecto_id)
                {
                    this.tipo_proyecto = this.tipo_proyectos[i];
                    this.proyecto_padre.tipoProyecto_id = this.tipo_proyectos[i].id;
                }
            }
            for(var i=0; i<this.naciones.length; i++)
            {
                if(this.naciones[i].id === proyecto_padre.nacion_id)
                {
                    this.nacion = this.naciones[i];
                    this.proyecto_padre.nacion_id = this.naciones[i].id;
                }
            }
        },
        eliminarProyectoPadre(proyecto_padre, index)
        {
            axios.get(`/admin/proyectos/showProyectoPadre/${proyecto_padre.id}`)
                .then(res=>{
                    this.total = res.data;
                })
            axios.get(`/admin/proyectospadre/showAvance/${proyecto_padre.id}`)
                .then(res=>{
                    this.total = this.total + res.data;
                    if(this.total === 0)
                    {
                        this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                            okVariant: 'danger',
                            okTitle: 'Eliminar',
                            cancelTitle: 'Cancelar'
                    }).then(value=>{
                        if(value === true)
                        {
                            axios.delete(`/admin/proyectospadre/${proyecto_padre.id}`)
                                .then(()=>{
                                    this.proyecto_padres.splice(index, 1);
                                });
                            this.$swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: 'Eliminado',
                                showConfirmButton: false,
                                timer: 1300})
                        }
                    })
                }else
                {
                    alert("El proyecto tiene avances o proyectos asignados, no se puede eliminar")
                }
            })
        },
        asignarEstado(estado)
        {
            this.proyecto_padre.estado = estado;
        },
        asignarNacion(nacion)
        {
            this.proyecto_padre.nacion_id = nacion.id;
        },
        asignarTipoProyecto(tipo_proyecto)
        {
            this.proyecto_padre.tipoProyecto_id = tipo_proyecto.id;
        },
        mostrarDetalle(proyecto_padre, $event)
        {
            this.proyecto_padre = proyecto_padre;
        },
        relacionProyectos(proyecto_padre)
        {
            this.proyecto_padre.nombre = proyecto_padre.nombre;
            this.proyecto_padre.descripcion = proyecto_padre.descripcion;
            this.proyecto_padre.estado = proyecto_padre.estado;
            this.proyecto_padre.Q_Proyecto = proyecto_padre.Q_Proyecto;
            this.proyecto_padre.planificacion = proyecto_padre.planificacion;
            this.proyecto_padre.safety = proyecto_padre.safety;
            this.proyecto_padre.homologaciones = proyecto_padre.homologaciones;
            this.proyecto_padre.tipoProyecto_id = proyecto_padre.tipoProyecto_id;
            this.proyecto_padre.nacion_id = proyecto_padre.nacion_id;
            this.proyecto_padre.dedicacion_id = '1';

            for(var i=0; i<this.proyectos.length; i++)
            {
                if(this.proyectos[i].proyectoPadre_id === proyecto_padre.id)
                {
                    this.proyectos_coincidentes.push(this.proyectos[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-proyecto', '#btnShow')
        },
        guardarCambios(proyecto, index)
        {
            const params = {
                proyectoPadre_id: proyecto.proyectoPadre_id,
                nombre: proyecto.nombre,
                descripcion: proyecto.descripcion}

            axios.put(`/admin//proyectos/proyectoPadreUpdate/${proyecto.id}`, params)
                .then(res=>{
                    const index = this.proyectos.findIndex(proyectoBuscar => proyectoBuscar.id === res.data.id)
                    this.proyectos[index] = res.data;
                })

            this.$root.$emit('bv::hide::modal', 'modal-proyecto', '#btnShow');
            this.proyecto_padre = {
                nombre: '',
                descripcion: '',
                estado: '',
                Q_Proyecto: '', 
                planificacion: '',
                safety: '',
                homologaciones: '',
                tipoProyecto_id: '',
                nacion_id: '',
                dedicacion_id: ''
            }
            this.proyectos_coincidentes = [];
        },
        cancelarEdicionModal($event)
        {
            this.proyecto_padre = {
                nombre: '',
                descripcion: '',
                estado: '',
                Q_Proyecto: '', 
                planificacion: '',
                safety: '',
                homologaciones: '',
                tipoProyecto_id: '',
                nacion_id: '',
                dedicacion_id: ''}
            this.proyectos_coincidentes = [];
        }
    }
}
</script>