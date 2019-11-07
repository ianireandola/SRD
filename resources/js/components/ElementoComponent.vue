<template>
<div>
    <h3 class="text-center mb-3">Gestión de Elementos</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarElemento(elemento)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="elemento.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="elemento.descripcion"/>
        <b-form-group label="Tipo de Elemento relacionado:">
            <b-form-select v-model="tipo_elemento" v-on:change="asignarTipoElemento(tipo_elemento)">
                <option v-for="tipo_elemento in tipo_elementos" v-bind:key="tipo_elemento.id" :value="tipo_elemento">{{tipo_elemento.id}} - {{tipo_elemento.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <b-form-group label="Proyecto relacionado:">
            <b-form-select class="form-control" v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.id}} - {{proyecto.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <b-form-group label="Estado:">
            <b-form-select v-model="estado" v-on:change="asignarEstado(estado)" :value="estado">
                <option>Activo</option>
                <option>Cerrado</option>
                <option>Bloqueado</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="elemento.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="elemento.descripcion"/>
        <b-form-group label="Tipo de Elemento relacionado:">
            <b-form-select v-model="tipo_elemento" v-on:change="asignarTipoElemento(tipo_elemento)">
                <option v-for="tipo_elemento in tipo_elementos" v-bind:key="tipo_elemento.id" :value="tipo_elemento">{{tipo_elemento.id}} - {{tipo_elemento.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <b-form-group label="Proyecto relacionado:">
            <b-form-select v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.id}} - {{proyecto.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <b-form-group label="Estado:">
            <b-form-select v-model="estado" v-on:change="asignarEstado(estado)" :value="estado">
                <option>Activo</option>
                <option>Cerrado</option>
                <option>Bloqueado</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block mb-7 md-2">Agregar</button>
    </form>


    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col" width="3%">ID</th>
                <th scope="col" width="15%">NOMBRE</th>
                <th scope="col" width="15%">DESCRIPCIÓN</th>
                <th scope="col" width="15%">TIPO ELEMENTO</th>
                <th scope="col" width="35%">PROYECTO</th>
                <th class="text-center" scope="col" width="17%" >OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(elemento, index) in elementos" v-bind:key="elemento.id">
                <td class="text-center">{{elemento.id}}</td>
                <td >{{elemento.nombre}}</td>
                <td>{{elemento.descripcion}}</td>
                <template v-for="tipo_elemento in tipo_elementos">
                    <td v-if="tipo_elemento.id === elemento.tipoElemento_id" v-bind:key="`A-${tipo_elemento.id}`">
                        {{tipo_elemento.nombre}}
                    </td>
                </template>
                <template v-for="proyecto in proyectos">
                    <td v-if="proyecto.id === elemento.proyecto_id" v-bind:key="`B-${proyecto.id}`">
                        {{proyecto.nombre}}
                    </td>
                </template>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(elemento)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarElemento(elemento, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    name: "ElementoComponent",
    data(){
        return{
            estado: '',
            elementos: [],
            elemento:
            {
                id: '',
                tipoElemento_id: '',
                proyecto_id: '',
                nombre: '',
                descripcion: '',
                estado: ''
            },
            proyectos: [],
            proyecto:
            {
                id: '',
                proyectoPadre_id: '',
                nombre: '',
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: ''
            },
            tipo_elementos: [],
            tipo_elemento:
            {
                id: '',
                nombre: ''
            },
            editarActivo: false
        }
    },
    created()
    {
        axios.get('/admin/elementos/create')
            .then(res=>{
                this.elementos = res.data;
            });

        axios.get('/admin/proyectos/create')
            .then(res =>{
                this.proyectos = res.data;
            });

        axios.get('/admin/tipo_elementos/create')
            .then(res=>{
                this.tipo_elementos = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            if(this.elemento.nombre.trim() === '' || this.elemento.tipoElemento_id === '' || this.elemento.proyecto_id === '' || this.elemento.estado === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {
                nombre: this.elemento.nombre, 
                descripcion: this.elemento.descripcion, 
                estado: this.elemento.estado, 
                tipoElemento_id: this.elemento.tipoElemento_id,
                proyecto_id: this.elemento.proyecto_id}

            this.elemento.nombre = '',
            this.elemento.descripcion = '',
            this.elemento.estado = '',
            this.elemento.tipoElemento_id = '',
            this.elemento.proyecto_id = '',
            this.proyecto = '',
            this.tipo_elemento = '',
            this.estado = ''
            
            axios.post('/admin/elementos', params)
                .then(res=>{
                    this.elementos.push(res.data);
                })
        },
        asignarTipoElemento(tipo_elemento)
        {
            this.elemento.tipoElemento_id = tipo_elemento.id;
        },
        asignarProyecto(proyecto)
        {
            this.elemento.proyecto_id = proyecto.id;
        },
        asignarEstado(estado)
        {
            this.elemento.estado = estado;
        },
        editarElemento(elemento)
        {
            const params = {
                nombre: this.elemento.nombre, 
                descripcion: this.elemento.descripcion, 
                estado: this.elemento.estado, 
                tipoElemento_id: this.elemento.tipoElemento_id,
                proyecto_id: this.elemento.proyecto_id}

            axios.put(`/admin/elementos/${elemento.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.elementos.findIndex(elementoBuscar => elementoBuscar.id === res.data.id)
                    this.elementos[index] = res.data;

                    this.elemento.id = '',
                    this.elemento.nombre = '',
                    this.elemento.descripcion = '',
                    this.elemento.estado = '',
                    this.elemento.tipoElemento_id = '',
                    this.elemento.proyecto_id = '',
                    this.proyecto = '',
                    this.tipo_elemento = '',
                    this.estado = ''
                })
        },
        eliminarElemento(elemento, index)
        {
           axios.get(`/srd_proyectos/showElemento/${elemento.id}`)
                .then(res=>{
                    if(res.data === 0)
                    {
                        this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                            okVariant: 'danger',
                            okTitle: 'Eliminar',
                            cancelTitle: 'Cancelar'
                    }).then(value=>{
                        if(value === true)
                        {
                            axios.delete(`/admin/elementos/${elemento.id}`)
                                .then(()=>{
                                    this.elementos.splice(index, 1);
                                })
                        }
                    })
                }else
                {
                    alert("El elemento tiene horas de trabajadores asignadas, no se puede eliminar")
                }
            })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.elemento = {id: '', nombre: '', tipoElemento_id: '', proyecto_id: '', estado: ''}
            this.proyecto = '',
            this.estado = '',
            this.tipo_elemento = ''
        },
        editarFormulario(elemento)
        {
            this.editarActivo = true;
            this.elemento.nombre = elemento.nombre;
            this.elemento.id = elemento.id;
            this.elemento.descripcion = elemento.descripcion;
            this.elemento.estado = elemento.estado;
            this.estado = elemento.estado;

            for(var i=0; i<this.tipo_elementos.length; i++)
            {
                if(this.tipo_elementos[i].id === elemento.tipoElemento_id)
                {
                    this.tipo_elemento = this.tipo_elementos[i];
                    this.elemento.tipoElemento_id = this.tipo_elementos[i].id;
                }
            }
            for(var i=0; i<this.proyectos.length; i++)
            {
                if(this.proyectos[i].id === elemento.proyecto_id)
                {
                    this.proyecto = this.proyectos[i];
                    this.elemento.proyecto_id = this.proyectos[i].id;
                }
            }
        }
    }
}
</script>