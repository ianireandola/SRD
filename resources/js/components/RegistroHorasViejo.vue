<template>
    <div>
        <div class="form-group">
            <label>Elige sección: </label>
            <select class="form-control" v-model="seccion_user" v-on:change="seccionElegida(seccion_user)">
                <option v-for="seccion_user in seccions_user" v-bind:key="seccion_user.id" :value="seccion_user">{{seccion_user.id}} - {{seccion_user.nombre}}</option>
            </select>
        </div>
        

        <h2 class="text-center mb-3">Registro de Horas</h2>
        
        <form @submit.prevent="registrarHoras" class="mb-3">
            <div class="form-group"> 
                <label for="fecha">Fecha:</label>
                <date-picker 
                    class="mb-4"
                    format="YYYY-MM-DD" 
                    dateFormat="YYYY-MM-DD"
                    :first-day-of-week= "1"
                    v-model="date" 
                    lang="es"/> 

                <div v-if="this.proyectos">
                    <!--Cuando el usuario sea de nivel 2 y haya elegido proyecto-->
                    <div v-if="this.seccion_user.nivel2 && this.letra_proyecto">
                        <div class="row mb-1">
                            <div class="col">
                                <input class="form-control mb-2" id="seleccionado" type="text" disabled v-model="seleccionado">
                            </div>
                            <div>
                                <input class="form-control" type="number" placeholder="Introducir horas" id="srd" v-model.number="cantidadHoras">
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col" >
                                <select class="form-control" v-model="accion2" v-on:change="accion2Elegida(accion2)">
                                    <option v-for="accion2 in acciones2" v-bind:key="accion2.id" :value="accion2">{{accion2.nombre}}</option>
                                </select>
                            </div>
                            <div class="col">
                                <select class="form-control" v-model="elemento" v-on:change="elementoElegido(elemento)">
                                    <option v-for="elemento in elementos" v-bind:key="elemento.id" :value="elemento">{{elemento.nombre}}</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <!-- Cuando el usuario no tenga nivel 2-->
                    <div class="row mb-3" v-else>
                        <div class="col">
                            <input class="form-control" id="seleccionado" type="text" disabled v-model="seleccionado">
                        </div>
                        <div>
                            <input class="form-control" type="number" placeholder="Introducir horas" id="srd" v-model.number="cantidadHoras">
                        </div>
                    </div>
                </div>
                
                <div v-else>
                    <b-alert show variant="info">Elija sección para que se muestren los proyectos</b-alert>
                </div>
                    
                <input type="checkbox" id="viaje" v-model="srd_proyecto.viaje">
                <label for="checkbox"> Viaje </label>
                <b-button class="btn btn-success btn-block" type="submit">Añadir</b-button>
                <button class="btn btn-secondary btn-block" v-on:click="cancelar()">Cancelar</button>
            </div>
        </form>


        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="letra"><b>Letras:</b></label>
                    <div class="card card-body mb-2 form-group" v-for="(letra, index) in letras" v-bind:key="index" >
                        <p>{{letra.nombre}}</p>  
                        <div class="row">
                            <div class="col">
                                <button class="btn btn-primary btn-block btn-sm mb-2" v-on:click="guardarActual(letra, false)">Registrar Horas</button>
                            </div>
                            <div class="col">
                                <button type="button" class="btn btn-secondary btn-block btn-sm" v-on:click="eliminar(letra)">Eliminar letra</button>
                            </div>
                        </div>
                    </div>
                </div>

                <b-button v-b-toggle.collapse-1 variant="primary">Añadir nueva letra</b-button>
                <b-collapse id="collapse-1" class="mt-2">
                    <div class="card card-body mb-2 form-group" v-for="(todoLetra, index) in todoLetras" v-bind:key="index"> 
                        <p>{{todoLetra.nombre}}</p>
                        <button class="btn btn-third" v-on:click="añadirLetra(todoLetra)">Elegir</button>
                    </div>
                </b-collapse>
            </div>

            <div class="col">
                <div class="form-group mb-2">
                    <label for="proyecto"><b>Proyectos:</b> </label>
                    <div class="card card-body mb-2 form-group" v-for="(proyecto, index) in proyectos" v-bind:key="index" >
                        <p>{{proyecto.nombre}}</p>
                        <button class="btn btn-secondary btn-block btn-sm mb-2" v-on:click="guardarActual(proyecto, true)">Registrar Horas</button>
                    </div>
                </div>
            </div>
        </div>
        

    </div>
</template>



<script>
import Datepicker from 'vue2-datepicker'
 
export default {
    name: "srd",
    components: {Datepicker},
    props: ['currentUser'],
    data(){
        return{
            date: null,
            seleccionado: '',
            cantidadHoras: '',
            letra_proyecto: false,
            letras: [],
            letra:
            {
                id:'', 
                nombre:'', 
                descripcion:''
            },
            seccions_user: [],
            seccion_user:
            {
                id: '',
                nombre:'', 
                nivel2:''
            },
            seccions_project: [],
            seccion_project:
            {
                id: '',

            },
            todoLetras: [],
            todoLetra:
            {
                id:'',
                nombre:'',
                descipcion:''
            },
            proyectos: null,
            proyecto: 
            {
                id:'', 
                nombre:'', 
                descripcion:'', 
                estado:'', 
                cantidadActual:'', 
                cantidadTotal:'', 
                ultimaRevision:''
            },
            srd_letra: 
            {
                id:'', 
                letra_id:'', 
                user_id:'', 
                fecha:'', 
                cantidadHoras:'' 
            },
            srd_proyecto: 
            {
                id:'', 
                proyecto_id:'', 
                user_id:'', 
                accion2_id:'', 
                elemento_id:'', 
                fecha:'', 
                cantidadHoras:'', 
                viaje:''
            },
            accciones2: [],
            accion2:
            {
                id: '',
                nombre: '',
                descripcion: ''
            },
            elementos: null,
            elemento:
            {
                id: '',
                nombre: '',
                descripcion: ''
            }
        }
    },
    created()
    {
        console.log('Component created') 
        axios.get('/letras')
            .then(res=>{
                this.letras = res.data;
            });
        axios.get(`/letras_todo`)
            .then(res =>{
                this.todoLetras = res.data;
            });
        axios.get(`/secciones`)
            .then(res=>{
                this.seccions_user = res.data;
            });
        axios.get(`/acciones2`)
            .then(res=>{
                this.acciones2 = res.data;
            });
    },
    methods:
    {
        registrarHoras()
        {
            if(this.cantidadHoras>12)
            {
                alert("No debes registrar más de 12 horas en 1 día");
                return;
            }
            if(this.srd_letra.letra_id === '' && this.srd_proyecto.proyecto_id === '' || this.seccion_user.id === '' || this.date === null )
            {
                alert("Debes elegir al menos un proyecto/letra/seccion/fecha para registro de horas");
                return;
            }else if(this.srd_letra.letra_id === '')
            {
                console.log('Soy un proyecto, voy a guardarme')
                //Cuando estamos en nivel2
                if(this.seccion_user.nivel2===1)
                {
                    console.log("Registrar Horas SI nivel2")
                    const params = {
                        seccion_user_nivel2: this.seccion_user.nivel2, 
                        proyecto_id: this.srd_proyecto.proyecto_id, 
                        user_id: this.currentUser,
                        nivel2_id: this.accion2.id,
                        elemento_id: this.elemento.id, 
                        fecha: this.date, 
                        cantidadHoras: this.cantidadHoras, 
                        viaje: this.srd_proyecto.viaje}

                    axios.post(`/srd_proyectos`, params)
                        .then(
                            this.seleccionado = '',
                            this.cantidadHoras = '',
                            this.srd_proyecto.id = '',
                            this.srd_proyecto.proyecto_id = '',
                            this.accion2.nombre = '',
                            this.accion2.id = '',
                            this.elemento.id = '',
                            this.elemento.nombre = ''
                        )
                }else{
                    const params = {
                        seccion_user_nivel2: this.seccion_user.nivel2, 
                        proyecto_id: this.srd_proyecto.proyecto_id, 
                        user_id: this.currentUser, 
                        fecha: this.date, 
                        cantidadHoras: this.cantidadHoras, 
                        viaje: this.srd_proyecto.viaje}

                    axios.post(`/srd_proyectos`, params)
                        .then(
                            this.seleccionado = '',
                            this.cantidadHoras = '',
                            this.srd_proyecto.id = '',
                            this.srd_proyecto.proyecto_id = ''
                        )
                }


            }else{
                console.log('Soy una letra, voy a guardarme')
                const params = {letra_id: this.srd_letra.letra_id, user_id: this.currentUser, fecha: this.date, cantidadHoras: this.cantidadHoras}
                axios.post(`/srd_letras`, params)
                    .then(
                        this.seleccionado = '',
                        this.cantidadHoras = '',
                        this.srd_letra.id = '',
                        this.srd_letra.letra_id = ''
                    )
                    .catch(err => console.log(err));
                
            }   
        },
        seccionElegida(item)
        {
            this.seccion_user = item;
            axios.get(`/proyectos/${this.seccion_user.id}`)
                    .then(res=>{
                        this.proyectos = res.data;
                    })
        },
        accion2Elegida(item)
        {
            this.accion2 = item;
        },
        elementoElegido(item)
        {
            this.elemento = item;
        },
        guardarActual(item, bool)
        {
            if(bool === true) //Se ha mandado desde proyecto
            {
                this.letra_proyecto = true;
                this.proyecto = item;
                this.srd_letra.letra_id = ''; //Cuando asigno alguno del otro grupo elimino el srd anterior
                this.srd_proyecto.proyecto_id = item.id;
                this.seleccionado = item.nombre;
                axios.get(`/elementos/${this.srd_proyecto.proyecto_id}`)
                    .then(res=>{
                        this.elementos = res.data;
                    })
            }else //Se ha mandado desde letra
            { 
                this.letra_proyecto = false;
                this.letra = item;
                this.srd_proyecto.proyecto_id = ''; //Cuando asigno alguno del otro grupo elimino el srd anterior
                this.srd_letra.letra_id = item.id;
                this.seleccionado = item.nombre;
            }
        },
        cancelar()
        {
            this.seleccionado = '',
            this.cantidadHoras = '',
            this.srd_proyecto.viaje=''; 
            this.srd_letra.id = '',
            //Borro los posibles datos que hayan sido guardados
            this.srd_letra.letra_id = '',
            this.srd_letra.letra_nombre = '';
            this.srd_proyecto.id = '',
            this.srd_proyecto.proyecto_id = '',
            this.srd_proyecto.proyecto_nombre = ''
        },
        añadirLetra(item)
        {
            //Sartu beharko det letra hau User_letra taulan eta gero deittu berriz axios.get(`/letras`) eitteko, ta hola letras-en
            //array-e berritzen da. Direktamene todoletras-etik letras-ea geitzen hasi daiket, baino datu basene sartu beharko detenez, 
            //selecta berriz eittea bakarrik da.
            this.todoLetra = item;
            for(var i=0; i<this.letras.length; i++)
            {
                if(this.letras[i].id === this.todoLetra.id)
                {
                    alert("Esta letra ya esta en la lista");
                    return;
                }
            }
            console.log("He entrado a añadir una nueva letra");
            const params = {letra_id: item.id, user_id: this.currentUser}
            axios.post(`/letras`, params)
            axios.get('/letras')
                .then(res=>{
                    this.letras = null;
                    this.letras = res.data;
            });
        },
        eliminar(item) //False=letra
        {
            console.log("Se procede a eliminar letraUser")
            axios.delete(`/letras/${item.id}/${this.currentUser}`)
            axios.get(`/letras`)
                .then(res=>{
                    this.letras = null;
                    this.letras = res.data;
                })
        }
    }
}
/*for(var i=0; i<=this.proyectos.length; i++)
        {
            axios.get(`/elementos/${this.proyectos[i].id}`)
                .then(res=>{
                    this.proyectos[i].elemento = res.data;
                })
        }
        this.proyectos.forEach(proyecto =>
        {
            axios.get(`/elementos/${proyecto.id}`)
                .then(res=>{
                    this.proyecto.elemento
                })
        });*/
</script>
