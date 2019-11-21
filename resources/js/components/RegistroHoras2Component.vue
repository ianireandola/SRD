<template>
    <div>
        <b-row>
            <b-col>
                <h2> Registro de Horas Nivel 2 </h2>
            </b-col>
            <b-col class="text-right" md="auto">
                <date-picker 
                    class="mb-4 inline p-2"
                    ref="datepicker"
                    format="YYYY-MM-DD" 
                    :value-type="valueType"
                    dateFormat="YYYY-MM-DD"
                    :first-day-of-week= "1"
                    v-model="date" 
                    v-on:change="comprobarFecha()"
                    @panel-change="handlePanelChange"
                    lang="es"/>
            </b-col>
        </b-row>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <br/>
        <b-row>
            <b-col class="text-center">
                <b-dropdown id="dropdown-1" dropright variant="info" text="Añadir Letra" class="m-md-2">
                    <div v-for="(todoLetra, index) in todoLetras" v-bind:key="index">
                        <b-dropdown-item @click="añadirLetra(todoLetra)">{{todoLetra.nombre}}</b-dropdown-item>
                    </div>
                </b-dropdown>
            </b-col>
            <b-col class="text-center">
                <b-dropdown id="dropdown-2" dropleft variant="info" text="Añadir Proyecto" class="m-md-2">
                    <div v-for="(todoProyecto, index) in todoProyectos" v-bind:key="index">
                        <b-dropdown-item @click="añadirProyecto(todoProyecto)">{{todoProyecto.nombre}}</b-dropdown-item>
                    </div>
                </b-dropdown>
            </b-col>
        </b-row>

        <form @submit.prevent="registrarHoras()" class="mb-3">
            <table class="table table-hover table-reponsive overflow-auto">
                <thead>
                    <tr>
                        <th id="popover-target-3" class="text-center" scope="col" width="3%"> ELIMINAR </th>
                            <b-popover target="popover-target-3" triggers="hover" placement="top">
                                Elimina letra/proyecto de tu panel de habituales
                            </b-popover>
                        <th scope="col" width="32%"> HABITUALES </th>
                        <th id="popover-target-4" class="text-center" scope="col" width="29,5%"> ACCIÓN NIVEL 1 </th>
                            <b-popover target="popover-target-4" triggers="hover" placement="top">
                                Acción que se ha llevado a cabo
                            </b-popover>
                        <th id="popover-target-5" class="text-center" scope="col" width="29,5%"> ACCIÓN NIVEL 2 </th>
                            <b-popover target="popover-target-5" triggers="hover" placement="top">
                                Elemento en el que se ha trabajado
                            </b-popover>
                        <th id="popover-target-6" class="text-center" scope="col" width="3%"> INTRODUCIR HORAS </th>
                            <b-popover target="popover-target-6" triggers="hover" placement="top">
                                Cantidad de horas necesitadas
                            </b-popover>
                        <th id="popover-target-7" class="text-center" scope="col" width="3%"> SERVICIO OFICIAL </th> 
                            <b-popover target="popover-target-7" triggers="hover" placement="top">
                                Horas fuera de la empresa
                            </b-popover>
                    </tr>
                </thead>
                <tbody>
                    <tr v-for="(letra, index) in letras" v-bind:key="index">
                        <td class="text-center"><font-awesome-icon :icon="['fas', 'times-circle']"  @click="eliminarLetra(letra, index)"/></td>
                        <td>{{letra.nombre}}</td>
                        <td></td>
                        <td></td>
                        <td class="text-center"><b-form-input type="number" min="0" max="12" step="0.25" v-model="srd_letra.cantidadHoras[index]" v-on:change="guardarSRDLetra(letra, index)"/></td>
                        <td class="text-center"> <b-form-checkbox class="mb-3" v-model="srd_letra.viaje[index]" v-on:change="guardarSRDLetra(letra, index)"/> </td>
                    </tr>
                    <tr v-for="(proyecto, index) in proyectos" v-bind:key="`A-${index}`">
                        <td class="text-center">
                            <font-awesome-icon :icon="['fas', 'times-circle']"  @click="eliminarProyecto(proyecto, index)"/>
                            <font-awesome-icon :icon="['fas', 'plus-circle']"  @click="añadirMismoProyecto(proyecto, index)"/>
                        </td>
                        <td>{{proyecto.nombre}}</td>
                        <td>
                            <b-form-select v-model="srd_proyecto.accion2_id[index]" v-on:change="guardarSRDProyecto(proyecto, index)">
                                <template v-for="accion2 in acciones2">
                                        <option v-if="accion2.proyecto_id === proyecto.id" v-bind:key="accion2.id" :value="accion2.id">
                                            {{accion2.id}} - {{accion2.nombre}}
                                        </option>
                                </template>
                            </b-form-select>
                        
                        </td>
                        <td>
                            <b-form-select v-model="srd_proyecto.elemento_id[index]" v-on:change="guardarSRDProyecto(proyecto, index)">
                                <template v-for="elemento in elementos">
                                        <option v-if="elemento.proyecto_id === proyecto.id" v-bind:key="elemento.id" :value="elemento.id">
                                            {{elemento.id}} - {{elemento.nombre}}
                                        </option>
                                </template>
                            </b-form-select>
                        </td>
                        <td class="text-center"> <b-form-input type="number" min="0" max="12" step="0.25" v-model="srd_proyecto.cantidadHoras[index]" v-on:change="guardarSRDProyecto(proyecto, index)"/></td>
                        <td class="text-center"> <b-form-checkbox class="mb-3" v-model="srd_proyecto.viaje[index]" v-on:change="guardarSRDProyecto(proyecto, index)"/> </td>
                    </tr>
                </tbody>
            </table>

            <b-row>
                <b-col class="col-sm-3">
                    <b-button id="popover-target-8" block variant="warning" @click="cancelar()">Cancelar</b-button>
                        <b-popover target="popover-target-8" triggers="hover" placement="top">
                            Limpiar pantalla
                        </b-popover>
                </b-col>
                <b-col class="col-sm-9">
                    <b-button block variant="success" type="submit">Introducir Horas</b-button>     
                </b-col>
            </b-row>
        </form>

        <b-modal id="modal-tabla" hide-footer size="lg">
            <template v-slot:modal-title>
                Horas registradas en día: <b>{{date}} </b>
            </template>
            <b-alert show>Para más información sobre las horas registradas en proyectos en el historial</b-alert>
            <table class="table table-hover">
                <thead class="thead-light">
                    <th scope="col">HABITUALES</th>
                    <th class="text-center" scope="col">CANTIDAD HORAS</th>
                    <th class="text-center" scop e="col">SERVICIO OFICIAL</th>
                    <th class="text-center" scop e="col">ELIMINAR</th>
                </thead>
                <tbody>
                    <tr v-for="(srd_letra_coincidente, index) in srd_letra_coincidentes" v-bind:key="index">
                        <td>{{srd_letra_coincidente.nombre}}</td>
                        <td class="text-center">{{srd_letra_coincidente.cantidadHoras}}</td>
                        <td class="text-center">
                            <input class="form-check-input" type="checkbox" v-model="srd_letra_coincidente.viaje" disabled>
                        </td>
                        <td class="text-center"><b-button block variant="secondary" type="submit" @click="eliminarSRDLetra(srd_letra_coincidente, index)">Eliminar</b-button></td>
                    </tr>
                    <tr v-for="(srd_proyecto_coincidente, index) in srd_proyecto_coincidentes" v-bind:key="`A-${index}`">
                        <td>{{srd_proyecto_coincidente.nombre}}</td>
                        <td class="text-center">{{srd_proyecto_coincidente.cantidadHoras}}</td>
                        <td class="text-center">
                            <input class="form-check-input" type="checkbox" v-model="srd_proyecto_coincidente.viaje" disabled>
                        </td>
                        <td class="text-center"><b-button block variant="secondary" type="submit" @click="eliminarSRDProyecto(srd_proyecto_coincidente, index)">Eliminar</b-button></td>
                    </tr>
                </tbody>
            </table>
        </b-modal>
    </div>
</template>

<script>
import Datepicker from 'vue2-datepicker'
import moment from "moment";
import { library } from '@fortawesome/fontawesome-svg-core'
import { faTimesCircle } from '@fortawesome/free-solid-svg-icons'
import { faPlusCircle } from '@fortawesome/free-solid-svg-icons'

library.add(faTimesCircle)
library.add(faPlusCircle)

export default {
    name: "RegistroHoras2",
    components: {Datepicker},
    props: ['currentUser', 'seccionId'],
    data()
    {
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
            numCoincidentes: 0,
            finalindexletra: 0,
            finalindexproyecto: 0,
            letras: [],
            letra:
            {
                id: '',
                nombre: '',
                descripcion: ''
            },
            proyectos: [],
            proyecto:
            {
                id: '',
                nombre: '',
                descripcion: '',
                estado: ''
            },
            todoLetras: [],
            todoLetra:
            {
                id: '',
                nombre: '',
                descripcion: ''
            },
            todoProyectos: [],
            todoProyecto: 
            {
                id: '', 
                nombre: '',
                descripcion: '',
                estado: ''
            },
            srd_letras: [],
            srd_letra:
            {
                id: [],
                letra_id: [],
                user_id: '',
                fecha: '',
                cantidadHoras: [],
                viaje: []
            },
            srd_proyectos: [],
            srd_proyecto:
            {
                id: [],
                proyecto_id: [],
                user_id: '',
                accion2_id: [],
                elemento_id: [],
                fecha: '',
                cantidadHoras: [],
                viaje: [], 
            },
            acciones2: [],
            accion2:
            {
                id: '',
                nombre: '',
                proyecto_id: ''
            },
            elementos: [],
            elemento:
            {
                id: '',
                nombre: '',
                proyecto_id: ''
            },
            srd_letra_coincidentes: [],
            srd_letra_coincidente:
            {
                id: '',
                letra_id: '',
                fecha: '',
                nombre: '',
                cantidadHoras: '',
                viaje: ''
            },
            srd_proyecto_coincidentes: [],
            srd_proyecto_coincidente:
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
        axios.get(`/letras_todo`)
            .then(res=>{
                this.todoLetras = res.data;
            });
        axios.get(`/proyectos/${this.seccionId}`)
            .then(res=>{
                this.todoProyectos = res.data;
            });
        axios.get(`/letras`)
            .then(res=>{
                this.letras = res.data;
            });
        axios.get(`/proyecto_user`)
            .then(res=>{
                this.proyectos = res.data;
            });

        axios.get(`/acciones2`)
            .then(res=>{
                this.acciones2 = res.data;
            });

        axios.get(`/elementos`)
            .then(res =>{
                this.elementos = res.data;
            })
    },
    mounted()
    {
        this.$refs.datepicker.showPopup()
        $("[data-toggle=popover-target-3]").popover();
        $("[data-toggle=popover-target-4]").popover();
        $("[data-toggle=popover-target-5]").popover();
        $("[data-toggle=popover-target-6]").popover();
        $("[data-toggle=popover-target-7]").popover();
        $("[data-toggle=popover-target-8]").popover();
    },
    methods:
    {
        registrarHoras()
        { 
            if(this.date === null)
            {
                alert("Debes añadir una fecha");
                return;
            }else
            {
                for(var i=0; i<=this.finalindexletra; i++)
                {
                    if(this.srd_letra.cantidadHoras[i] !== undefined)
                    {
                        if(this.srd_letra.viaje[i] === undefined)
                        {
                            this.srd_letra.viaje[i] = 0;
                        }
                        const params ={
                            letra_id: this.srd_letra.letra_id[i],
                            user_id: this.currentUser,
                            fecha: this.date,
                            cantidadHoras: this.srd_letra.cantidadHoras[i],
                            viaje: this.srd_letra.viaje[i]
                        }
                        axios.post(`/srd_letras`, params)
                    }
                }
                for(var i=0; i<=this.finalindexproyecto; i++)
                {
                    if(this.srd_proyecto.cantidadHoras[i] !== undefined)
                    {
                        if(this.srd_proyecto.accion2_id[i] === undefined || this.srd_proyecto.elemento_id[i] === undefined)
                        {
                            alert("Debes completar la acción nivel 1 y acción nivel 2");
                            return;
                        }else{
                            if(this.srd_proyecto.viaje[i] === undefined)
                            {
                                this.srd_proyecto.viaje[i] = 0;
                            }
                            const params={
                                seccion_user_nivel2: 1,
                                proyecto_id: this.srd_proyecto.proyecto_id[i],
                                user_id: this.currentUser,
                                fecha: this.date,
                                cantidadHoras: this.srd_proyecto.cantidadHoras[i],
                                viaje: this.srd_proyecto.viaje[i],
                                accion2_id: this.srd_proyecto.accion2_id[i],
                                elemento_id: this.srd_proyecto.elemento_id[i]                  
                            }
                            axios.post(`/srd_proyectos`, params)
                        }
                    }
                }
            }

            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Horas registradas!',
                showConfirmButton: false,
                timer: 1500
            })
            for(var i=0; i<=this.finalindexletra; i++)
            {
                this.srd_letra.letra_id[i] = '';
                this.srd_letra.cantidadHoras[i] = '',
                this.srd_letra.viaje[i] = ''
            }
            for(var i=0; i<=this.finalindexproyecto; i++)
            {
                this.srd_proyecto.proyecto_id[i] = '',
                this.srd_proyecto.cantidadHoras[i] = '',
                this.srd_proyecto.viaje[i] = '',
                this.srd_proyecto.accion2_id[i] = '',
                this.srd_proyecto.elemento_id[i] = ''
            }
            this.finalindexletra = 0;
            this.finalindexproyecto = 0;
            this.date = null;
        },
        guardarSRDLetra(item, index)
        {
            this.srd_letra.letra_id[index] = item.id;
            this.srd_letra.user_id = this.currentUser;

            if(index > this.finalindexletra)
            {
                this.finalindexletra = index;
            }            
        },
        guardarSRDProyecto(item, index)
        {
            this.srd_proyecto.proyecto_id[index] = item.id;
            this.srd_proyecto.user_id = this.currentUser;

            if(index > this.finalindexproyecto)
            {
                this.finalindexproyecto = index;
            }
        },
        eliminarLetra(item, index)
        {
            axios.delete(`/letras/${item.id}/${this.currentUser}`)
                .then(()=>{
                    this.letras.splice(index, 1);
                });
            
        },
        eliminarProyecto(item, index)
        {
            axios.delete(`/proyecto_user/${item.id}/${this.currentUser}`)
                .then(()=>{
                    this.proyectos.splice(index, 1);
                });
        },
        eliminarSRDLetra(item, index)
        {
            this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                okVariant: 'danger',
                okTitle: 'Eliminar',
                cancelTitle: 'Cancelar'
            }).then(value=> {
                if( value === true )
                {
                    axios.delete(`/srd_letras/${item.id}`)
                        .then(()=>{
                            this.$root.$emit('bv::hide::modal', 'modal-tabla', '#focusThisOnClose');
                        });
                }
            })  
        },
        eliminarSRDProyecto(item, index)
        {
            this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                okVariant: 'danger',
                okTitle: 'Eliminar',
                cancelTitle: 'Cancelar'
            }).then(value=> {
                if( value === true )
                {
                    axios.delete(`/srd_proyectos/${item.id}`)
                        .then(()=>{
                            this.$root.$emit('bv::hide::modal', 'modal-tabla', '#focusThisOnClose');
                        }); 
                }
            })  
        },
        añadirLetra(item)
        {
            this.todoLetra = item;
            for(var i=0; i<this.letras.length; i++)
            {
                if(this.letras[i].id === this.todoLetra.id)
                {
                    alert("Ya esta en la lista");
                    return;
                }
            }
            const params = {letra_id: item.id, user_id: this.currentUser}
            axios.post(`/letras`, params)
            axios.get(`/letras`)
                .then(res=>{
                    this.letras = null;
                    this.letras = res.data;
                });
        },
        añadirProyecto(item)
        {
            this.todoProyecto = item;
            for(var i=0; i<this.proyectos.length; i++)
            {
                if(this.proyectos[i].id === this.todoProyecto.id)
                {
                    alert("Ya esta en la lista");
                    return;
                }
            }
            const params = {proyecto_id: item.id, user_id: this.currentUser}
            axios.post(`/proyecto_user`, params)
            axios.get(`/proyecto_user`)
                .then(res=>{
                    this.proyectos = null;
                    this.proyectos = res.data;
                })
        },
        añadirMismoProyecto(item)
        {
            this.proyectos.push(item);
        },
        cancelar()
        {
            this.date = '';
            for(var i=0; i<=this.finalindexletra; i++)
            {
                this.srd_letra.letra_id[i] = '';
                this.srd_letra.cantidadHoras[i] = '',
                this.srd_letra.viaje[i] = ''
            }
            for(var i=0; i<=this.finalindexletra; i++)
            {
                this.srd_proyecto.proyecto_id[i] = '',
                this.srd_proyecto.cantidadHoras[i] = '',
                this.srd_proyecto.accion2_id[i] = '',
                this.srd_proyecto.elemento_id[i] = '',
                this.srd_proyecto.viaje[i] = ''
            }
        },
        handlePanelChange(panel)
        {
            if(panel === 'NONE')
            {
                this.$refs.datepicker.showPopup()
            }
        },
        comprobarFecha()
        {
            axios.get(`srd_proyectos/${this.date}/edit`)
                .then(res =>{

                    this.numCoincidentes = res.data;
                    if(this.numCoincidentes === 0)
                    {
                        this.$swal.fire({
                            position: 'top-end',
                            type: 'warning',
                            title: 'No hay horas registradas!',
                            showConfirmButton: false,
                            timer: 500
                        })
                    }else{
                        this.$root.$emit('bv::show::modal', 'modal-tabla', '#focusThisOnClose');
                    }
                });

            axios.get(`/srd_letras/${this.date}`)
                .then(res =>{
                    this.srd_letra_coincidentes = res.data;
                });

            axios.get(`/srd_proyectos/${this.date}`)
                .then(res=>{
                    this.srd_proyecto_coincidentes = res.data;
                });
        }
    }
}
</script>