<template>
<div>
    <b-row>
        <b-col>
            <date-picker 
                class="mb-4 "
                v-model="date" 
                type="month"
                format="YYYYMMDD"
                value-type="format"
                v-on:change="gestionarFecha()" 
                placeholder="Elegir mes"
                lang="es">
            </date-picker>
        </b-col>
        <b-col>
            <b-button class="mb-4" @click="llevarA()" variant="info">Descargar horas a Hoja Excel</b-button>
        </b-col>
        <b-col>
            <b-button class="mb-4" @click="usersSinHoras()" variant="info">Trabajadores SIN registrar horas en mes {{this.date}} </b-button>
        </b-col>
        <b-col>
            <b-button class="mb-4" @click="usersConHoras()" variant="info">Trabajadores CON horas registradas en mes {{this.date}} </b-button>
        </b-col>
    </b-row>
    
    <form class="mb-5">
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
                    <th class="text-center" scope="col"></th>
                </tr>
            </thead>
            <tbody>
                <tr class="warning">
                    <td class="text-center" colspan="7"><b>LETRAS</b></td>
                </tr>

                <tr v-for="(srd_letra, index) in srd_letras" v-bind:key="index">
                    <td class="text-center">{{srd_letra.fecha}}</td>
                    <td>{{srd_letra.user_nombre}}</td>
                    <td>{{srd_letra.letra_nombre}}</td>
                    <td></td>
                    <td></td>
                    <td class="text-center">{{srd_letra.cantidadHoras}}</td>  
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" v-model="srd_letra.viaje" disabled>
                    </td> 
                    <td class="text-center"><b-button block variant="secondary" @click="eliminarSRDLetra(srd_letra, index)">Eliminar</b-button></td>          
                </tr>

                <tr class="warning">
                    <td class="text-center" colspan="7"><b>PROYECTOS</b></td>
                </tr>
                
                <tr v-for="(srd_todoproyecto, index) in srd_todoproyectos" v-bind:key="`A-${index}`">
                    <td class="text-center">{{srd_todoproyecto.fecha}}</td>
                    <td>{{srd_todoproyecto.user_nombre}}</td>
                    <td>{{srd_todoproyecto.proyecto_nombre}}</td>
                    <td>
                        <template v-for="accion2 in acciones2">
                            <td v-if="accion2.id === srd_todoproyecto.acc_id" v-bind:key="`B-${accion2.id}`">
                                {{accion2.nombre}}
                            </td>
                        </template>
                    </td>
                    <td>
                        <template v-for="elemento in elementos">
                            <td v-if="elemento.id === srd_todoproyecto.el_id"  v-bind:key="`C-${elemento.id}`">
                                {{elemento.nombre}}
                            </td>
                        </template>
                    </td>
                    <td class="text-center">{{srd_todoproyecto.cantidadHoras}}</td>  
                    <td class="text-center">
                        <input class="form-check-input" type="checkbox" v-model="srd_todoproyecto.viaje" disabled>
                    </td> 
                    <td class="text-center"><b-button block variant="secondary" @click="eliminarSRDProyecto(srd_todoproyecto, index)">Eliminar</b-button></td>            
                </tr>
            </tbody>
        </table>
    </form>

    <b-modal id="modal-users-SIN" hide-footer>
        <template v-slot:modal-title>
            Trabajadores sin horas registradas en mes: <b> {{date}} </b>
        </template>
        <div class="d-block text-left">
            <template v-for="srd_user_sin in srd_users_sin">
                <p><b>Chapa:</b> {{srd_user_sin.chapa}} - <b>Nombre: </b> {{srd_user_sin.nombre}} </p>
            </template>
        </div>
        <b-button class="mt-3" block @click="cerrarModal()">Cerrar</b-button>
    </b-modal>

    <b-modal id="modal-users-CON" hide-footer>
        <template v-slot:modal-title>
            Trabajadores con horas registradas en mes: <b>{{date}}</b>
        </template>
        <div class="d-block text-left">
            <p class="text-center"> <b>HORAS REGISTRADAS A LETRAS</b> </p>
            <template v-for="srd_letrauser in srd_letrausers">
                <p><b>Chapa:</b> {{srd_letrauser.usuario_chapa}} - <b>Nombre:</b> {{srd_letrauser.nombre}} 
                <b>     Fecha:</b> {{srd_letrauser.fecha}}</p>
            </template>
            <p class="text-center"> <b>HORAS REGISTRADAS A PROYECTOS</b> </p>
            <template v-for="srd_proyectouser in srd_proyectousers">
                <p><b>Chapa:</b> {{srd_proyectouser.usuario_chapa}} - <b>Nombre:</b> {{srd_proyectouser.nombre}} 
                <b>     Fecha:</b> {{srd_proyectouser.fecha}}</p>
            </template>            
        </div>
        <b-button class="mt-3" block @click="cerrarModal2()"> Cerrar </b-button>
    </b-modal>

</div>
</template>

<script>
import Datepicker from 'vue2-datepicker'
export default {
    name: 'SRDComponent',
    components: {Datepicker},
    data()
    {
        const valueType = {
            value2date: value => {
                return value ? moment(new Date(value), "MM").toDate() : null;
            },
            date2value: date => {
                return date ? moment(date).format("MM") : null;
            }
        };
        return{
            date: null,
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
                fecha: '',
                us_id: '',
                user_nombre: '',
                proy_id: '',
                proyecto_nombre: '',
                acc_id: '',
                el_id: '',
                cantidadHoras: '',
                viaje: '',
                nivel2: ''
            },
            srd_users_psin: [],
            srd_user_psin:
            {
                chapa: '',
                nombre: ''
            },
            srd_users_lsin: [],
            srd_user_lsin:
            {
                chapa: '',
                nombre: ''
            },
            srd_users_sin: [],
            srd_user_sin:
            {
                chapa: '',
                nombre: ''
            },
            srd_proyectousers: [],
            srd_proyectouser:
            {
                fecha: '',
                usuario_chapa: '',
                nombre: ''
            },
            srd_letrausers: [],
            srd_letrauser:
            {
                fecha: '',
                usuario_chapa: '',
                nombre: ''
            },
            acciones2: [],
            accion2: 
            {
                id: '',
                nombre: ''
            },
            elementos: [],
            elemento: 
            {
                id: '',
                nombre: ''
            }
        }
    },
    created()
    {
        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/srd/createLetras')
            .then(res=>{
                this.srd_letras = res.data;
            });

        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/srd/createProyectos')
            .then(res=>{
                this.srd_todoproyectos = res.data;
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
        gestionarFecha()
        {
            this.srd_letras = [];
            this.srd_todoproyectos = [];
            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/srd/${this.date}`)
                .then(res=>{
                    this.srd_todoproyectos = res.data;
                });

            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/srd/showLetras/${this.date}`)
                .then(res=>{
                    this.srd_letras = res.data;
                })
        },
        llevarA()
        {
            window.location.href = 'http://localhost/laravel/prueba4/public/index.php/admin/srd/descarga';
        },
        usersSinHoras()
        {
            if(this.date === null)
            {
                alert('Debe elegir un mes');
                return;
            }else
            {
                axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/srd/showUserProyectos/${this.date}`)
                .then(res=>{
                    this.srd_users_psin = res.data;
                });

                axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/srd/showUserLetras/${this.date}`)
                .then(res=>{
                    this.srd_users_lsin = res.data;
                });

                //En srd_users_sin estan aquellos trabajadores que no han insertado ninguna hora en mes X
                for(var i=0; i<this.srd_users_psin.length; i++)
                {
                    for(var j=0; j<this.srd_users_lsin.length; j++)
                    {
                        if(this.srd_users_psin[i].chapa === this.srd_users_lsin[j].chapa)
                        {
                            this.srd_users_sin.push(this.srd_users_psin[i]);
                        }
                    }
                }

                this.$root.$emit('bv::show::modal', 'modal-users-SIN', '#btnShow');
            }
            
        },
        cerrarModal()
        {
            if(this.srd_users_sin.length !== 0)
            {
                this.srd_users_psin = [],
                this.srd_users_lsin = [],
                this.srd_users_sin = []
            }
            this.$root.$emit('bv::hide::modal', 'modal-users-SIN');
        },
        usersConHoras()
        {
            if(this.date === null)
            {
                alert('Debe elegir un mes');
                return;
            }else{
                axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/srd/showDistinctProyectos/${this.date}`)
                .then(res=>{
                    this.srd_proyectousers = res.data;
                });

                axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/srd/showDistinctLetras/${this.date}`)
                .then(res=>{
                    this.srd_letrausers = res.data;
                });

                this.$root.$emit('bv::show::modal', 'modal-users-CON', '#btnShow');
            }
        },
        cerrarModal2()
        {
            if(this.srd_proyectosusers !== 0)
            {
                this.srd_proyectosusers = [],
                this.srd_letrasusers = []
            }
            this.$root.$emit('bv::hide::modal', 'modal-users-CON');
        },
        eliminarSRDProyecto(srd_todoproyecto, index)
        {
            this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                    okVariant: 'danger',
                    okTitle: 'Eliminar',
                    cancelTitle: 'Cancelar'
                }).then(value=> {
                    if( value === true )
                    {
                        axios.delete(`http://localhost/laravel/prueba4/public/index.php/srd_proyectos/${srd_todoproyecto.id}`)
                            .then(()=>{
                                this.srd_todoproyectos.splice(index, 1);
                            }); 
                    }
                })
        },
        eliminarSRDLetra(srd_letra, index)
        {
            this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                    okVariant: 'danger',
                    okTitle: 'Eliminar',
                    cancelTitle: 'Cancelar'
                }).then(value=> {
                    if( value === true )
                    {
                        axios.delete(`http://localhost/laravel/prueba4/public/index.php/srd_letras/${srd_letra.id}`)
                            .then(()=>{
                                this.srd_letras.splice(index, 1);
                            });
                    }
                })
        }
    }
}
</script>