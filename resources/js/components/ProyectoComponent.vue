<template>
<div>
    <h3 class="text-center mb-3">Gestión de Proyectos</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarProyecto(proyecto)" v-if="editarActivo" class="mb-5">
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
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Fabricación en " v-model="proyecto.fabricacion">
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
                <b-form-group label="Proyecto Padre relacionado:">
                    <b-form-select v-model="proyecto_padre" v-on:change="asignarProyectoPadre(proyecto_padre)">
                        <option v-for="proyecto_padre in proyecto_padres" v-bind:key="proyecto_padre.id" :value="proyecto_padre">{{proyecto_padre.id}} - {{proyecto_padre.nombre}}</option>
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
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Fabricación en " v-model="proyecto.fabricacion">
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
                <b-form-group label="Proyecto Padre relacionado:">
                    <b-form-select v-model="proyecto_padre" v-on:change="asignarProyectoPadre(proyecto_padre)">
                        <option v-for="proyecto_padre in proyecto_padres" v-bind:key="proyecto_padre.id" :value="proyecto_padre">{{proyecto_padre.id}} - {{proyecto_padre.nombre}}</option>
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
                <th class="text-center" scope="col" width="30%">NOMBRE</th>
                <th class="text-center" scope="col" width="20%">DESCRIPCIÓN</th>
                <th class="text-center" scope="col" width="47%">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(proyecto, index) in proyectos" v-bind:key="proyecto.id">
                <td class="text-center">{{proyecto.id}}</td>
                <td >{{proyecto.nombre}}</td>
                <td>{{proyecto.descripcion}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(proyecto)" class="btn btn-primary">Modificar</button>
                    <b-button variant="info" v-b-modal.center @click="mostrarDetalle(proyecto, $bvModal.show('modal-center'))">Detalle</b-button>
                    <button type="button" @click="relacionNivel2(proyecto)" class="btn btn-info">Niveles 2</button>
                    <button type="button" @click="relacionElementos(proyecto)" class="btn btn-info">Elementos</button>
                    <button type="button" @click="eliminarProyecto(proyecto, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal id="modal-center" hide-footer>
        <template v-slot:modal-title>
            Detalle del Proyecto Padre: <b> {{proyecto.nombre}} </b>
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
            <p><b>Fabricación en :</b> {{proyecto.fabricacion}}</p>
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

    <b-modal size="xl" id="modal-nivel2" ref="btnproyecto" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Proyecto a eliminar: <b> {{proyecto.id}} - {{proyecto.nombre}} </b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionada con las siguientes acciones de nivel 2: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">ACCIÓN DE NIVEL 2 </th>
                    <th class="text-center" scope="col">ELEGIR OTRO PROYECTO: </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(nivel2_coincidente, index) in niveles2_coincidentes" v-bind:key="index">
                    <td>{{nivel2_coincidente.id}} - {{nivel2_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="nivel2_coincidente.proyecto_id" v-on:change="guardarCambiosNivel2(nivel2_coincidente, index)">
                            <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto.id">{{proyecto.id}} - {{proyecto.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal1($bvModal.hide('modal-nivel2'))"> Cerrar </b-button>
            </b-col>
        </b-row>        
    </b-modal>

    <b-modal size="xl" id="modal-elemento" ref="btnproyecto" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Proyecto a eliminar: <b> {{proyecto.nombre}} </b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionada con los siguientes elementos: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">ELEMENTO</th>
                    <th class="text-center" scope="col">ELEGIR OTRO PROYECTO: </th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(elemento_coincidente, index) in elementos_coincidentes" v-bind:key="index">
                    <td>{{elemento_coincidente.id}} - {{elemento_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="elemento_coincidente.proyecto_id" v-on:change="guardarCambiosElementos(elemento_coincidente, index)">
                            <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto.id">{{proyecto.id}} - {{proyecto.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal2($bvModal.hide('modal-elemento'))"> Cerrar </b-button>
            </b-col>
        </b-row>        
    </b-modal>
</div>
</template>

<script>
import Datepicker from 'vue2-datepicker'
import moment from "moment";

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
                fabricacion: '', 
                proyectoPadre_id: ''
            },
            niveles2: [],
            nivel2: 
            {
                id: '',
                nombre: '',
                descripcion: '',
                proyecto_id: ''
            },
            niveles2_coincidentes: [],
            nivel2_coincidente:
            {
                id: '',
                nombre: '',
                descripcion: '',
                proyecto_id: ''
            },
            elementos: [],
            elemento:
            {
                id: '',
                nombre: '',
                descripcion: '',
                tipoElemento_id: '',
                proyecto_id: '',
                estado: ''
            },
            elementos_coincidentes: [],
            elementos:
            {
                id: '',
                nombre: '',
                descripcion: '',
                tipoElemento_id: '',
                proyecto_id: '',
                estado: ''
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
            });

        axios.get('/admin/accion2s/create')
            .then(res=>{
                this.niveles2 = res.data;
            });

        axios.get('/admin/elementos/create')
            .then(res=>{
                this.elementos = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.proyecto.cantidadActual > this.proyecto.cantidadTotal)
            {
                alert('La cantidad actual no puede ser mayor a la total');
                return;
            }
            this.proyecto.ultimaRevision = this.date;
            if(this.proyecto.nombre.trim() === '' || this.proyecto.estado === '' || this.proyecto.cantidadActual === '' || this.proyecto.cantidadTotal === ''
                 || this.proyecto.ultimaRevision === '' || this.proyecto.fabricacion === '' || this.proyecto.proyectoPadre_id === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {
                nombre: this.proyecto.nombre,
                descripcion: this.proyecto.descripcion,
                estado: this.proyecto.estado,
                cantidadActual: this.proyecto.cantidadActual,
                cantidadTotal: this.proyecto.cantidadTotal,
                Ed_PF: this.proyecto.Ed_PF,
                ultimaRevision: this.proyecto.ultimaRevision,
                fabricacion: this.proyecto.fabricacion,
                proyectoPadre_id: this.proyecto.proyectoPadre_id}

            this.proyecto.nombre = '',
            this.proyecto.descripcion = '',
            this.proyecto.estado = '',
            this.proyecto.cantidadActual = '',
            this.proyecto.cantidadTotal = '',
            this.proyecto.Ed_PF = '',
            this.proyecto.ultimaRevision = '',
            this.proyecto.fabricacion = '',
            this.proyecto.id = '',
            this.proyecto_padre = '',
            this.estado = '',
            this.date = ''
            
            axios.post('/admin/proyectos', params)
                .then(res=>{
                    this.proyectos.push(res.data);
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarProyecto(proyecto)
        {
            this.proyecto.ultimaRevision = this.date;
            const params = {
                nombre: this.proyecto.nombre, 
                descripcion: this.proyecto.descripcion, 
                estado: this.proyecto.estado, 
                cantidadActual: this.proyecto.cantidadActual,
                cantidadTotal: this.proyecto.cantidadTotal,
                Ed_PF: this.proyecto.Ed_PF,
                ultimaRevision: this.proyecto.ultimaRevision,
                fabricacion: this.proyecto.fabricacion,
                proyectoPadre_id: this.proyecto.proyectoPadre_id}

            axios.put(`/admin/proyectos/${proyecto.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.proyectos.findIndex(proyectoBuscar => proyectoBuscar.id === res.data.id)
                    this.proyectos[index] = res.data;

                    this.proyecto.id = '',
                    this.proyecto.nombre = '',
                    this.proyecto.descripcion = '',
                    this.proyecto.estado = '',
                    this.proyecto.cantidadActual = '',
                    this.proyecto.cantidadTotal = '',
                    this.proyecto.Ed_PF = '',
                    this.proyecto.ultimaRevision = '',
                    this.proyecto.fabricacion = '',
                    this.proyecto.proyectoPadre_id = '',
                    this.proyecto_padre = '',
                    this.date = '',
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
            this.proyecto = {
                id: '',
                nombre: '',
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: ''
            },
            this.proyecto_padre = '',
            this.date = ''
        },
        cancelarEdicionModal1($event)
        {
            this.proyecto = {
                nombre: '',
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: ''
            }
            this.niveles2_coincidentes = [];
        },
        cancelarEdicionModal2($event)
        {
            this.proyecto = {
                nombre: '',
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: ''
            }
            this.elementos_coincidentes = [];
        },
        editarFormulario(proyecto)
        {
            this.editarActivo = true;
            this.proyecto.nombre = proyecto.nombre;
            this.proyecto.descripcion = proyecto.descripcion;
            this.proyecto.id = proyecto.id;
            this.proyecto.estado = proyecto.estado;
            this.proyecto.cantidadActual = proyecto.cantidadActual;
            this.proyecto.cantidadTotal = proyecto.cantidadTotal;
            this.proyecto.Ed_PF = proyecto.Ed_PF;
            this.proyecto.ultimaRevision = proyecto.ultimaRevision;
            this.proyecto.fabricacion = proyecto.fabricacion;
            this.estado = proyecto.estado;
            this.date = proyecto.ultimaRevision;

            for(var i=0; i<this.proyecto_padres.length; i++)
            {
                if(this.proyecto_padres[i].id === proyecto.proyectoPadre_id)
                {
                    this.proyecto_padre = this.proyecto_padres[i];
                    this.proyecto.proyectoPadre_id = this.proyecto_padres[i].id;
                }
            }
        },
        eliminarProyecto(proyecto, index)
        {
            axios.get(`/srd_proyectos/showProyecto/${proyecto.id}`)
                .then(res=>{
                    this.total = res.data;
                });

            axios.get(`/admin/trabajan/${proyecto.id}`)
                .then(res=>{
                    this.total = this.total + res.data;
                });

            axios.get(`/admin/composicion/${proyecto.id}`)
                .then(res=>{
                    this.total = this.total + res.data;
                });

            axios.get(`/admin/accions2/showProyecto/${proyecto.id}`)
                .then(res=>{
                    this.total = this.total + res.data;
                });

            axios.get(`/admin/elementos/showProyecto/${proyecto.id}`)
                .then(res=>{
                    this.total = this.total + res.data;
                    if(this.total === 0)
                    {
                        this.$bvModal.msgBoxConfirm("¿Quiere eliminar?", {
                            okVariant: 'danger',
                            okTitle: 'Eliminar',
                            cancelTitle: 'Cancelar'
                        }).then(value=>{
                            if(value === true)
                            {
                                axios.delete(`/admin/proyectos/${proyecto.id}`)
                                    .then(()=>{
                                        this.proyectos.splice(index, 1);
                                    });
                                this.$swal.fire({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Eliminado',
                                    showConfirmButton: false,
                                    timer: 1300})
                            }
                        })
                    }else{
                        alert("El proyecto puede tener: horas de trabajadores asignadas, secciones asignadas, tipos de elementos asignados, acciones de nivel2/elementos asignados. No se puede eliminar")
                    }
                })
            
        },
        asignarEstado(estado)
        {
            this.proyecto.estado = estado;
        },
        asignarProyectoPadre(proyecto_padre)
        {
            this.proyecto.proyectoPadre_id = proyecto_padre.id;
        },
        mostrarDetalle(proyecto, $event)
        {
            this.proyecto = proyecto;
        },
        relacionNivel2(proyecto)
        {
            this.proyecto.nombre = proyecto.nombre;
            this.proyecto.descripcion = proyecto.descripcion;
            this.proyecto.estado = proyecto.estado;
            this.proyecto.cantidadActual = proyecto.cantidadActual;
            this.proyecto.cantidadTotal = proyecto.cantidadTotal;
            this.proyecto.Ed_PF = proyecto.Ed_PF;
            this.proyecto.ultimaRevision = this.date;
            this.proyecto.fabricacion = proyecto.fabricacion;
            this.proyecto.proyectoPadre_id = proyecto.proyectoPadre_id;

            for(var i=0; i<this.niveles2.length; i++)
            {
                if(this.niveles2[i].proyecto_id === proyecto.id)
                {
                    this.niveles2_coincidentes.push(this.niveles2[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-nivel2', '#btnShow')
        },
        relacionElementos(proyecto)
        {
            this.proyecto.nombre = proyecto.nombre;
            this.proyecto.descripcion = proyecto.descripcion;
            this.proyecto.estado = proyecto.estado;
            this.proyecto.cantidadActual = proyecto.cantidadActual;
            this.proyecto.cantidadTotal = proyecto.cantidadTotal;
            this.proyecto.Ed_PF = proyecto.Ed_PF;
            this.proyecto.ultimaRevision = this.date;
            this.proyecto.fabricacion = proyecto.fabricacion;
            this.proyecto.proyectoPadre_id = proyecto.proyectoPadre_id;

            for(var i=0; i<this.elementos.length; i++)
            {
                if(this.elementos[i].proyecto_id === proyecto.id)
                {
                    this.elementos_coincidentes.push(this.elementos[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-elemento', '#btnShow')
        },
        guardarCambiosNivel2(nivel2, index)
        {
            const params = {nombre: nivel2.nombre, descripcion: nivel2.descripcion, proyecto_id: nivel2.proyecto_id, nombre_proyecto: this.proyecto.nombre}
            
            axios.put(`/admin/accions2/updateProyecto/${nivel2.id}`, params)
                .then(res=>{
                    const index = this.niveles2.findIndex(nivel2Buscar => nivel2Buscar.id === res.data.id)
                    this.niveles2[index] = res.data;
                });

            this.$root.$emit('bv::hide::modal', 'modal-nivel2', '#btnShow');
            this.proyecto = {
                nombre: '',
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: ''
            }
            this.niveles2_coincidentes = [];
        },
        guardarCambiosElementos(elemento, index)
        {
            const params = {nombre: elemento.nombre, descripcion: elemento.descripcion, tipoElemento_id: elemento.tipoElemento_id, proyecto_id: elemento.proyecto_id, estado: elemento.estado}

            axios.put(`/admin/elementos/proyectoUpdate/${elemento.id}`, params)
                .then(res=>{
                    const index = this.elementos.findIndex(elementoBuscar => elementoBuscar.id === res.data.id)
                    this.elementos[index] = res.data;
                });

            this.$root.$emit('bv::hide::modal', 'modal-elemento', '#btnShow');
            this.proyecto = {
                nombre: '',
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: ''
            }
            this.elementos_coincidentes = [];
        }
    }
}
</script>