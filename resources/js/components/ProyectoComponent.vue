<template>
<div>
    <h3 class="text-center mb-3">Gestión de Proyectos</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarProyectoPadre(proyecto_padre)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="proyecto.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="proyecto.descripcion"/>
        <div class="row">
            <div class="col">
                <b-form-input class="mb-4" type="number" v-model="proyecto.cantidadActual" placeholder="Cantidad Actual"/>
            </div>
            <div class="col">
                <b-form-input class="mb-4" type="number" v-model="proyecto.cantidadTotal" placeholder="Cantidad Total"/>
            </div>
            <div class="col">
                <b-form-input class="mb-4" type="number" v-model="proyecto.Ed_PF" placeholder="Ed PF"/>
            </div>
        </div> 
        <div class="row">
            <div class="col">
                <b-form-group label="Estado:">
                    <b-form-select v-model="estado" v-on:change="asignarEstado(estado)" :value="estado">
                        <option>Activo</option>
                        <option>Cerrado</option>
                        <option>Bloqueado</option>
                    </b-form-select>
                </b-form-group>
            </div>
            <div class="col">
                <b-form-group label="Fabricación en planta de:">
                    <b-form-select v-model="planta" v-on:change="asignarFabrican(planta)">
                        <option v-for="planta in plantas" v-bind:key="planta.id" :value="planta">{{planta.id}} - {{planta.nombre}}</option>
                    </b-form-select>
                </b-form-group>
            </div>
            <div class="col">
                <b-form-group label="Última revisión:">
                    <date-picker 
                        class="mb-4 inline p-2"
                        ref="datepicker"
                        format="YYYY-MM-DD" 
                        :value-type="valueType"
                        dateFormat="YYYY-MM-DD"
                        :first-day-of-week= "1"
                        v-model="date"
                        lang="es"/>  
                </b-form-group>
            </div>
        </div> 
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="proyecto.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="proyecto.descripcion"/>
        <div class="row">
            <div class="col">
                <b-form-input class="mb-4" type="number" v-model="proyecto.cantidadActual" placeholder="Cantidad Actual"/>
            </div>
            <div class="col">
                <b-form-input class="mb-4" type="number" v-model="proyecto.cantidadTotal" placeholder="Cantidad Total"/>
            </div>
            <div class="col">
                <b-form-input class="mb-4" type="number" v-model="proyecto.Ed_PF" placeholder="Ed PF"/>
            </div>
        </div> 
        <div class="row">
            <div class="col">
                <b-form-group label="Estado:">
                    <b-form-select v-model="estado" v-on:change="asignarEstado(estado)" :value="estado">
                        <option>Activo</option>
                        <option>Cerrado</option>
                        <option>Bloqueado</option>
                    </b-form-select>
                </b-form-group>
            </div>
            <div class="col">
                <b-form-group label="Fabricación en planta de:">
                    <b-form-select v-model="planta" v-on:change="asignarFabrican(planta)">
                        <option v-for="planta in plantas" v-bind:key="planta.id" :value="planta">{{planta.id}} - {{planta.nombre}}</option>
                    </b-form-select>
                </b-form-group>
            </div>
            <div class="col">
                <b-form-group label="Última revisión:">
                    <date-picker 
                        class="mb-4 inline p-2"
                        ref="datepicker"
                        format="YYYY-MM-DD" 
                        :value-type="valueType"
                        dateFormat="YYYY-MM-DD"
                        :first-day-of-week= "1"
                        v-model="date"
                        lang="es"/>  
                </b-form-group>
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
                <th class="text-center" scope="col" width="10%">ESTADO</th>
                <th class="text-center" scope="col" width="20%">FAMILIA DE PROYECTO</th>
                <th class="text-center" scope="col" width="22%">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(proyecto, index) in proyecto" v-bind:key="proyecto.id">
                <td class="text-center">{{proyecto.id}}</td>
                <td >{{proyecto.nombre}}</td>
                <td>{{proyecto.descripcion}}</td>
                <td>{{proyecto.estado}}</td>
                <template v-for="proyecto_padre in proyecto_padres">
                    <td v-if="proyecto_padre.id === proyecto.proyectoPadre_id" v-bind:key="`A-${proyecto_padre.id}`">
                        {{proyecto_padre.nombre}}
                    </td>
                </template>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(proyecto)" class="btn btn-primary">Modificar</button>
                    <b-button variant="info" v-b-modal.center @click="mostrarDetalle(proyecto, $bvModal.show('modal-center'))">Detalle</b-button>
                    <button type="button" @click="eliminarProyectoPadre(proyecto, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal id="modal-center" hide-footer>
        <template v-slot:modal-title>
            Detalle del Proyecto Padre: <b> {{proyecto.id}} - {{proyecto.nombre}} </b>
        </template>
        <div class="d-block text-left">
            <p><b>ID:</b> {{proyecto.id}}</p>
            <p><b>Nombre:</b> {{proyecto.nombre}}</p>
            <p><b>Descripción:</b> {{proyecto.descripcion}}</p>
            <p><b>Estado:</b> {{proyecto.estado}}</p>
            <p><b>Cantidad Actual:</b> {{proyecto.cantidadActual}}</p>
            <p><b>Cantidad Total:</b> {{proyecto.cantidadTotal}}</p>
            <p><b>Ed PF:</b> {{proyecto.Ed_PF}}</p>
            <p><b>Última revisión:</b> {{proyecto.ultimaRevision}}</p>
            <p><b>Fabricación en planta de:</b>
                <template v-for="planta in plantas">
                    <p v-if="planta.id === proyecto.fabricacion" v-bind:key="`A-${planta.id}`">
                        {{planta.nombre}}
                    </p>
                </template>
            </p>
            <p><b>Proyecto Padre:</b> 
                <template v-for="proyecto_padre in proyecto_padres">
                    <p v-if="proyecto_padre.id === proyecto.proyectoPadre_id" v-bind:key="`B-${proyecto_padre.id}`">
                        {{proyecto_padre.nombre}}
                    </p>
                </template>
            </p>
        </div>
        <b-button class="mt-3" block @click="$bvModal.hide('modal-center')">Cerrar</b-button>
    </b-modal>
</div>
</template>

<script>
import Datepicker from 'vue2-datepicker'

export default {
    name: "ProyectoPadreComponent",
    components: {Datepicker},
    data(){
        const valueType = {
            value2date: value => {
                return value ? moment(new Date(value), "YYYY-MM-DD").toDate() : null;
            },
            date2value: date => {
                return date ? moment(date).format("YYYY-MM-DD") : null;
            }
        };
        return{
            valueType,
            date: null,
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
            proyectos: [],
            proyecto:
            {
                id: '',
                nombre: '',
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: '', //Es la planta
                proyectoPadre_id: ''
            },
            plantas: [],
            planta: 
            {
                id: '',
                nombre: ''
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

        axios.get('/admin/proyectos/create')
            .then(res=>{
                this.proyectos = res.data;
            })
            
        axios.get('/admin/plantas/create')
            .then(res=>{
                this.plantas = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.proyecto.nombre.trim() === '' || this.proyecto.estado === '' || this.proyecto.cantidadActual === '' || this.proyecto.cantidadTotal === '' || 
                this.proyecto.Ed_PF === '' || this.proyecto.ultimaRevision === '' || this.proyecto.fabricacion === '' || this.proyecto.proyectoPadre_id === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {
                nombre: this.proyecto.nombre,
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: '',
                proyectoPadre_id: ''}

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
                })
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
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
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
                                })
                        }
                    })
                }else
                {
                    alert("La sección tiene usuarios o proyectos asignados, no se puede eliminar")
                }
            })
        },
        asignarEstado(estado)
        {
            this.proyecto_padre.estado = estado;
        },
        mostrarDetalle(proyecto_padre, $event)
        {
            this.proyecto_padre = proyecto_padre;
        },
        asignarFabrican(planta)
        {
            this.proyecto.fabricacion = planta.id;
        }
    }
}
</script>