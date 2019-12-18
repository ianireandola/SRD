<template>
    <div>
        <h3 class="text-center mb-3">Gestión de Composición (Proyecto - Tipo de Elemento)</h3>

        <!--Cuando "editarActivo=true" EDITAR-->
        <form @submit.prevent="editarComposicion()" v-if="editarActivo" class="mb-5">
            <b-form-group label="Proyecto:">
                <b-form-select v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                    <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.identificador}} - {{proyecto.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <b-form-group label="Tipo de Elemento:">
                <b-form-select class="form-control" v-model="tipo_elemento" v-on:change="asignarTipoElemento(tipo_elemento)">
                    <option v-for="tipo_elemento in tipo_elementos" v-bind:key="tipo_elemento.id" :value="tipo_elemento">{{tipo_elemento.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <button type="submit" class="btn btn-success btn-block">Guardar</button>
            <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
        </form>

        <!--Cuando "editarActivo=false" AGREGAR -->
        <form @submit.prevent="agregar" v-else class="mb-5">
            <b-form-group label="Proyecto:">
                <b-form-select v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                    <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.identificador}} - {{proyecto.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <b-form-group label="Tipo de Elemento:">
                <b-form-select class="form-control" v-model="tipo_elemento" v-on:change="asignarTipoElemento(tipo_elemento)">
                    <option v-for="tipo_elemento in tipo_elementos" v-bind:key="tipo_elemento.id" :value="tipo_elemento">{{tipo_elemento.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <button type="submit" class="btn btn-success btn-block mb-7 md-2">Agregar</button>
        </form>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col" width="37,5%">PROYECTO</th>
                    <th class="text-center" scope="col" width="37,5%">TIPO DE ELEMENTO</th>
                    <th class="text-center" scope="col" width="25%">OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(composicion, index) in composiciones" v-bind:key="index">
                    <template v-for="proyecto in proyectos">
                        <td v-if="proyecto.id === composicion.proyecto_id" v-bind:key="`B-${proyecto.id}`">
                            {{proyecto.identificador}} - {{proyecto.nombre}}
                        </td>
                    </template>
                    <template v-for="tipo_elemento in tipo_elementos">
                        <td v-if="tipo_elemento.id === composicion.tipoElemento_id" v-bind:key="`A-${tipo_elemento.id}`">
                            {{tipo_elemento.nombre}}
                        </td>
                    </template>
                    <td class="text-center">
                        <button type="button" @click="editarFormulario(composicion)" class="btn btn-primary">Modificar</button>
                        <button type="button" @click="eliminarComposicion(composicion, index)" class="btn btn-secondary">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default  {
        name: "ComposicionComponent",
        data()
        {
            return{
                composiciones: [],
                composicion:
                {
                    id: '',
                    proyecto_id: '',
                    tipoElemento_id: ''
                },
                tipo_elementos: [],
                tipo_elemento:
                {
                    id: '',
                    nombre: ''
                },
                proyectos: [],
                proyecto:
                {
                    id: '',
                    identificador: '',
                    nombre: '', 
                    proyectoPadre_id: ''
                },
                editarActivo: false
            }
        },
        created()
        {
            axios.get('http://localhost/laravel/prueba4/public/index.php/admin/composicion/create')
                .then(res=>{
                    this.composiciones = res.data;
                });
            axios.get('http://localhost/laravel/prueba4/public/index.php/admin/tipo_elementos/create')
                .then(res=>{
                    this.tipo_elementos = res.data;
                }); 
            axios.get('http://localhost/laravel/prueba4/public/index.php/admin/proyectos/create')
                .then(res=>{
                    this.proyectos = res.data;
                });        
        },
        methods:
        {
            agregar()
            {
                if(this.composicion.proyecto_id === '' || this.composicion.tipoElemento_id === '')
                {
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                }
                const params = {proyecto_id: this.composicion.proyecto_id, tipoElemento_id: this.composicion.tipoElemento_id}

                this.composicion.tipoElemento_id = '',
                this.composicion.proyecto_id = '',
                this.proyecto = '',
                this.tipo_elemento = ''

                axios.post(`http://localhost/laravel/prueba4/public/index.php/admin/composicion`, params)
                    .then(res=>{
                        this.composiciones.push(res.data);
                    });
                this.$swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Registro realizado',
                    showConfirmButton: false,
                    timer: 1300})
            },
            asignarProyecto(proyecto)
            {
                this.composicion.proyecto_id = proyecto.id;
            },
            asignarTipoElemento(tipo_elemento)
            {
                this.composicion.tipoElemento_id = tipo_elemento.id;
            },
            editarFormulario(composicion)
            {
                this.editarActivo = true;
                this.composicion.tipoElemento_id = composicion.tipoElemento_id;
                this.composicion.id = composicion.id;
                this.composicion.proyecto_id = composicion.proyecto_id;

                for(var i=0; i<this.tipo_elementos.length; i++)
                {
                    if(this.tipo_elementos[i].id === composicion.tipoElemento_id)
                    {
                        this.tipo_elemento = this.tipo_elementos[i];
                        this.composicion.tipoElemento_id = this.tipo_elementos[i].id;
                    }
                }

                for(var i=0; i<this.proyectos.length; i++)
                {
                    if(this.proyectos[i].id === composicion.proyecto_id)
                    {
                        this.proyecto = this.proyectos[i];
                        this.composicion.proyecto_id = this.proyectos[i].id;
                    }
                }
            },
            editarComposicion()
            {
                const params = {
                    id: this.composicion.id,
                    tipoElemento_id: this.composicion.tipoElemento_id,
                    proyecto_id: this.composicion.proyecto_id}
                
                axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/composicion/${this.composicion.id}`, params)
                    .then(res=>{
                        this.editarActivo = false;
                        const index = this.composiciones.findIndex(composicionBuscar => composicionBuscar.id === res.data.id)
                        this.composiciones[index] = res.data;

                        this.composicion.tipoElemento_id = '',
                        this.composicion.proyecto_id = '',
                        this.proyecto = '',
                        this.tipo_elemento = ''
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
                this.composicion.tipoElemento_id = '',
                this.composicion.proyecto_id = '',
                this.tipo_elemento = '',
                this.proyecto = ''
            },
            eliminarComposicion(composicion, index)
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
                        axios.delete(`http://localhost/laravel/prueba4/public/index.php/admin/composicion/${composicion.id}`)
                            .then(()=>
                            {
                                this.composiciones.splice(index, 1);
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