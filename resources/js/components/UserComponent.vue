<template>
<div>
    <h3 class="text-center mb-3">Gestión de Usuarios</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarUsuario(usuario)" v-if="editarActivo" class="mb-5">
        <b-button v-b-toggle.collapse-1 class="btn-block">Modificar Usuario</b-button>
        <b-collapse id="collapse-1" class="mt-2">
            <b-container fluid>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="chapa">Chapa:</label>
                    </b-col>
                    <b-col sm="9">
                        <input class="form-control mb-2" type="number" id="chapa" v-model="usuario.chapa"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Nombre:</label>
                    </b-col>
                    <b-col sm="9">
                        <input class="form-control mb-2" id="nombre" v-model="usuario.nombre" type="text"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Email:</label>
                    </b-col>
                    <b-col sm="9">
                        <input class="form-control mb-2" id="email" v-model="usuario.email" type="email"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Contraseña:</label>
                    </b-col>
                    <b-col sm="9">
                        <input class="form-control mb-2" id="password" :state="null" v-model="usuario.password_confirmation"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Función:</label>
                    </b-col>
                    <b-col sm="9">
                        <input class="form-control mb-2" id="función" :state="null" v-model="usuario.funcion"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Comentario:</label>
                    </b-col>
                    <b-col sm="9">
                        <input class="form-control mb-2" id="comentario" :state="null" v-model="usuario.comentario"/>
                    </b-col>
                </b-row>
                 <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Sección:</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-select class="form-control" v-model="seccion" v-on:change="seccionElegida(seccion)">
                            <option v-for="seccion in secciones" v-bind:key="seccion.id" :value="seccion">{{seccion.nombre}}</option>
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Categoría:</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-select class="form-control" v-model="categoria" v-on:change="categoriaElegida(categoria)">
                            <option v-for="categoria in categorias" v-bind:key="categoria.id" :value="categoria">{{categoria.nombre}}</option>
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Fijo/Eventual:</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-select class="form-control" v-model="fijo_eventual" v-on:change="fijoEventualElegido(fijo_eventual)">
                            <option v-for="fijo_eventual in fijos_eventuales" v-bind:key="fijo_eventual.id" :value="fijo_eventual">{{fijo_eventual.nombre}}</option>
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Elegido: <b>{{usuario.CPUportatil_nombre}}</b></label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-checkbox v-model="usuario.CPUportatil" name="CPUportatil_check" switch>
                            Activado: CPU - Desactivado: Portátil
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Fecha CPU/Portatil:</label>
                    </b-col>
                    <b-col sm="9">
                        <date-picker class="mb-4" format="YYYY-MM-DD" dateFormat="YYYY-MM-DD" :first-day-of-week= "1" v-model="usuario.fechaCPUportatil" lang="es"/> 
                    </b-col>
                </b-row>
            </b-container>
            <b-button v-b-toggle.collapse-1 class="btn-block" variant="success" type="submit">Guardar modificado</b-button>
            <b-button v-b-toggle.collapse-1 class="btn-block" variant="danger" @click="cancelarEdicion()">Cancelar</b-button>
        </b-collapse>
    </form>


    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregarUsuario()" v-else class="mb-5">
        <b-button v-b-toggle.collapse-1 class="btn-block">Nuevo Usuario</b-button>
        <b-collapse id="collapse-1" class="mt-2">
            <b-container fluid>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="chapa">Chapa:</label>
                    </b-col>
                    <b-col sm="9">
                        <input id="chapa" class="form-control mb-2" v-model="usuario.chapa" type="number"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Nombre:</label>
                    </b-col>
                    <b-col sm="9">
                        <input id="nombre" class="form-control mb-2" v-model="usuario.nombre" type="text"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Email:</label>
                    </b-col>
                    <b-col sm="9">
                        <input id="email" class="form-control mb-2" v-model="usuario.email" type="email"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Contraseña:</label>
                    </b-col>
                    <b-col sm="9">
                        <input id="password" class="form-control mb-2" v-model="usuario.password_confirmation"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Función:</label>
                    </b-col>
                    <b-col sm="9">
                        <input id="función" class="form-control mb-2" v-model="usuario.funcion"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Comentario:</label>
                    </b-col>
                    <b-col sm="9">
                        <input id="comentario" class="form-control mb-2" v-model="usuario.comentario"/>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Sección:</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-select class="form-control" v-model="seccion" v-on:change="seccionElegida(seccion)">
                            <option v-for="seccion in secciones" v-bind:key="seccion.id" :value="seccion">{{seccion.nombre}}</option>
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Categoría:</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-select class="form-control" v-model="categoria" v-on:change="categoriaElegida(categoria)">
                            <option v-for="categoria in categorias" v-bind:key="categoria.id" :value="categoria">{{categoria.nombre}}</option>
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Fijo/Eventual:</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-select class="form-control" v-model="fijo_eventual" v-on:change="fijoEventualElegido(fijo_eventual)">
                            <option v-for="fijo_eventual in fijos_eventuales" v-bind:key="fijo_eventual.id" :value="fijo_eventual">{{fijo_eventual.nombre}}</option>
                        </b-form-select>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">CPU/Portatil:</label>
                    </b-col>
                    <b-col sm="9">
                        <b-form-checkbox v-model="usuario.CPUportatil" name="CPUportatil_check" switch>
                            Activado: CPU - Desactivado: Portátil
                        </b-form-checkbox>
                    </b-col>
                </b-row>
                <b-row class="my-1">
                    <b-col sm="3">
                        <label for="input-none">Fecha CPU/Portatil:</label>
                    </b-col>
                    <b-col sm="9">
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
                    </b-col>
                </b-row>
            </b-container>
            <b-button v-b-toggle.collapse-1 class="btn-block" variant="success" type="submit">Agregar</b-button>
            <b-button v-b-toggle.collapse-1 class="btn-block" variant="danger" @click="cancelarEdicion()">Cancelar</b-button>
        </b-collapse>
    </form>

    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col">CHAPA</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">CONTRASEÑA</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in usuarios" v-bind:key="index">
                <td class="text-center">{{item.chapa}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">{{item.password_confirmation}}</td>
                <td class="text-center">
                    <b-button v-b-modal.center @click="mostrarDetalle(item)">Detalle</b-button>
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarUsuario(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal id="modal-center" hide-footer>
        <template v-slot:modal-title>
            Detalle del Usuario: <b> {{usuario.chapa}} - {{usuario.nombre}} </b>
        </template>
        <div class="d-block text-left">
            <p><b>Chapa:</b> {{usuario.chapa}}</p>
            <p><b>Nombre:</b> {{usuario.nombre}}</p>
            <p><b>Email:</b> {{usuario.email}}</p>
            <p><b>Contraseña:</b> {{usuario.password_confirmation}}</p>
            <p><b>Funcion:</b> {{usuario.funcion}}</p>
            <p><b>Comentario:</b> {{usuario.comentario}}</p>
            <p><b>Sección:</b> {{usuario.seccion_id}} - {{usuario.seccion_nombre}}</p>
            <p><b>Categoria:</b> {{usuario.categoria_id}} - {{usuario.categoria_nombre}}</p>
            <p><b>Fijo/Eventual:</b> {{usuario.fijoeventual_id}} - {{fijo_eventual.nombre}}</p>
            <p><b>CPU/Portatil:</b> {{usuario.CPUportatil_nombre}}</p>
            <p><b>Fecha CPU/Portatil:</b> {{usuario.fechaCPUportatil}}</p>
        </div>
        <b-button class="mt-3" block @click="$bvModal.hide('modal-center')">Cerrar</b-button>
    </b-modal>
</div>  
</template>

<script>
import Datepicker from 'vue2-datepicker'
import moment from "moment";

export default {
    name: "UserComponent",
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
            usuarios: [],
            usuario:
            {
                id: '',
                chapa: '', 
                nombre: '',
                email: '', 
                password: '',
                password_confirmation: '', 
                funcion: '',
                comentario: '',
                seccion_id: '',
                seccion_nombre: '',
                categoria_id: '', 
                categoria_nombre: '',
                fijoeventual_id: '',
                fijoeventual_nombre: '',
                CPUportatil: false,
                CPUportatil_nombre: '',
                fechaCPUportatil: null
            },
            editarActivo: false,
            categorias:[],
            categoria:
            {
                id:'',
                nombre: ''
            },
            fijos_eventuales:[],
            fijo_eventual:
            {
                id:'',
                nombre:''
            },
            secciones: [],
            seccion:
            {
                id: '',
                nombre: ''
            }

        }
    },
    created()
    {
        axios.get('/admin/usuarios/create')
            .then(res=>{
                this.usuarios = res.data;
            });
        axios.get('/admin/categorias/create')
            .then(res=>{
                this.categorias = res.data;
            });
        axios.get('/admin/fijos_eventuales/create')
            .then(res=>{
                this.fijos_eventuales = res.data;
            });
        axios.get('/admin/secciones/create')
            .then(res=>{
                this.secciones = res.data;
            })
    },
    methods:
    {
        mostrarDetalle(item)
        {
            this.usuario.fechaCPUportatil = this.date;
            this.usuario = item;

            for(var i=0; i<this.secciones.length; i++)
            {
                if(this.usuario.seccion_id === this.secciones[i].id)
                {
                    this.usuario.seccion_nombre = this.secciones[i].nombre;
                    this.seccion = this.secciones[i];
                }
            }

            for(var i=0; i<this.categorias.length; i++)
            {
                this.usuario.categoria_nombre = this.categorias[i].nombre;
                this.categoria = this.categorias[i];
            }

            for(var i=0; i<this.fijos_eventuales.length; i++)
            {
                this.usuario.fijoeventual_nombre = this.fijos_eventuales[i].nombre;
                this.fijo_eventual = this.fijos_eventuales[i];
            }
            if(this.usuario.CPUportatil === 0 )
            {
                this.usuario.CPUportatil_nombre = 'CPU'
            }else
            {
                this.usuario.CPUportatil_nombre = 'Portatil'
            }
            this.$root.$emit('bv::show::modal', 'modal-center', '#btnShow')
        },
        cancelarEdicion()
        {
            this.editarActivo = false
        },
        fijoEventualElegido(item)
        {
            this.usuario.fijoeventual_id = item.id;
            this.usuario.fijoeventual_nombre = item.nombre;
        },
        categoriaElegida(item)
        {
            this.usuario.categoria_id = item.id;
            this.usuario.categoria_nombre = item.nombre;
        },
        seccionElegida(item)
        {
            this.usuario.seccion_id = item.id;
            this.usuario.seccion_nombre = item.nombre;
        },
        agregarUsuario()
        {
            this.usuario.fechaCPUportatil = this.date;
            if(this.usuario.chapa === '' || this.usuario.nombre.trim() === '' || this.usuario.email.trim() === '' || this.usuario.password_confirmation.trim() === '' ||
                this.usuario.categoria_id === '' || this.usuario.seccion_id === '' || this.usuario.fijoeventual_id === '' || this.usuario.fechaCPUportatil === '')
            {
                alert("Comprueba que los campos necesarios estan llenos");
                return
            }
            else{
                if(this.usuario.funcion === '')
                {
                    this.usuario.funcion = ' ';
                }if(this.usuario.comentario === '')
                {
                    this.usuario.comentario = ' ';
                }
                const params ={
                    chapa: this.usuario.chapa,
                    nombre: this.usuario.nombre,
                    email: this.usuario.email,
                    password_confirmation: this.usuario.password_confirmation,
                    funcion: this.usuario.funcion,
                    comentario: this.usuario.comentario,
                    seccion_id: this.usuario.seccion_id,
                    categoria_id: this.usuario.categoria_id,
                    fijoeventual_id: this.usuario.fijoeventual_id,
                    CPUportatil: this.usuario.CPUportatil,
                    fechaCPUportatil: this.usuario.fechaCPUportatil
                }
                axios.post(`/admin/usuarios`, params)
                    .then(res=>{
                        this.usuario.chapa = '',
                        this.usuario.nombre = '',
                        this.usuario.email = '',
                        this.usuario.password_confirmation = '',
                        this.usuario.funcion = '',
                        this.usuario.comentario = '',
                        this.usuario.categoria_id = '',
                        this.usuario.categoria_nombre = '',
                        this.usuario.fijoeventual_id = '',
                        this.usuario.fijoeventual_nombre = '',
                        this.usuario.CPUportatil = '',
                        this.usuario.CPUportatil_nombre = '',
                        this.usuario.fechaCPUportatil = '',
                        this.seccion = '',
                        this.fijo_eventual = '',
                        this.categoria = '',
                        this.date = ''
                    });
                this.$swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Registro realizado',
                    showConfirmButton: false,
                    timer: 1300});
                axios.get('/admin/usuarios/create')
                    .then(res=>{
                        this.usuarios = res.data;
                    });
            }
        },
        eliminarUsuario(usuario, index)
        {
            this.$bvModal.msgBoxConfirm("¿Quiere eliminar el usuario y todas las horas que haya registrado?", {
                okVariant: 'danger',
                okTitle: 'Eliminar',
                cancelTitle: 'Cancelar'
            }).then(value=>{
                if(value === true)
                {
                    //Se buscan separadamente las horas a proyectos y letras dedicadas de cada usuario y se devuelven los ids. Esos ids estan en res y se borran en el for
                    axios.get(`/srd_proyectos/showUsuario/${usuario.id}`)
                        .then(res =>{
                            for(var i=0; i<res.length; i++)
                            {
                                axios.delete(`/srd_proyectos/${res[i]}`)
                            }
                        });
                    axios.get(`/srd_letras/showUsuario/${usuario.id}`)
                        .then(res=>{
                            for(var i=0; i<res.length; i++)
                            {
                                axios.delete(`/srd_letras/${res[i]}`)
                            }
                        })
                    axios.delete(`/admin/usuarios/${usuario.id}`)
                        .then(()=>{
                            this.usuarios.splice(index, 1);
                        });
                    this.$swal.fire({
                        position: 'top-end',
                        type: 'success',
                        title: 'Eliminado',
                        showConfirmButton: false,
                        timer: 1300})
                }
            })
            
        },
        editarUsuario(item)
        {
            this.usuario.fechaCPUportatil = this.date;
             const params ={
                chapa: this.usuario.chapa,
                nombre: this.usuario.nombre,
                email: this.usuario.email,
                password_confirmation: this.usuario.password_confirmation,
                funcion: this.usuario.funcion,
                comentario: this.usuario.comentario,
                seccion_id: this.usuario.seccion_id,
                categoria_id: this.usuario.categoria_id,
                fijoeventual_id: this.usuario.fijoeventual_id,
                CPUportatil: this.usuario.CPUportatil,
                fechaCPUportatil: this.usuario.fechaCPUportatil
            }
            axios.put(`/admin/usuarios/${item.id}`, params)
                .then(res=>{
                    this.editarActivo = false;
                    const index = this.usuarios.findIndex(usuarioBuscar => usuarioBuscar.id === res.data.id)
                    this.usuarios[index] = res.data;

                    this.usuario ={
                        chapa: '',
                        nombre: '',
                        email: '',
                        password_confirmation: '',
                        funcion: '',
                        comentario: '',
                        seccion_id: '',
                        seccion_nombre: '',
                        categoria_id: '',
                        categoria_nombre: '',
                        fijoeventual_id: '',
                        fijoeventual_nombre: '',
                        CPUportatil: '',
                        CPUportatil_nombre: '',
                        fechaCPUportatil: ''
                    }
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Modificación realizada',
                showConfirmButton: false,
                timer: 1300})
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.usuario = item;
            this.date = this.usuario.fechaCPUportatil;

            if(this.usuario.CPUportatil === 0 )
            {
                this.usuario.CPUportatil_nombre = 'CPU'
            }else
            {
                this.usuario.CPUportatil_nombre = 'Portatil'
            }

            for(var i=0; i<this.secciones.length; i++)
            {
                if(this.usuario.seccion_id === this.secciones[i].id)
                {
                    this.usuario.seccion_nombre = this.secciones[i].nombre;
                    this.seccion = this.secciones[i];
                }
            }

            for(var i=0; i<this.categorias.length; i++)
            {
                if(this.usuario.categoria_id === this.categorias[i].id)
                {
                    this.usuario.categoria_nombre = this.categorias[i].nombre;
                    this.categoria = this.categorias[i];
                }
            }

            for(var i=0; i<this.fijos_eventuales.length; i++)
            {
                if(this.usuario.fijoeventual_id === this.fijos_eventuales[i].id)
                {
                    this.usuario.fijoeventual_nombre = this.fijos_eventuales[i].nombre;
                    this.fijo_eventual = this.fijos_eventuales[i];
                }
            }
        }
    }
    
}
</script>