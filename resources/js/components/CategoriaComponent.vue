<template>
<div>
    <h3 class="text-center mb-3">Gestión de Categorías</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarCategoria(categoria)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="categoria.nombre">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="categoria.nombre">
        <button type="submit" class="btn btn-success btn-block mb-7">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in categorias" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="relacionUsuarios(item)" class="btn btn-info">Relación con usuarios</button>
                    <button type="button" @click="eliminarCategoria(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

     <b-modal size="xl" id="modal-categoria" ref="btnUser" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Categoría a eliminar: <b> {{categoria.id}} - {{categoria.nombre}} </b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionada con los siguientes atributos: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">USUARIO</th>
                    <th class="text-center" scope="col">ELEGIR OTRA CATEGORÍA</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(usuario_coincidente, index) in usuarios_coincidentes" v-bind:key="index">
                    <td>{{usuario_coincidente.id}} - {{usuario_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="usuario_coincidente.categoria_id" v-on:change="guardarCambios(usuario_coincidente, index)">
                            <option v-for="categoria in categorias" v-bind:key="categoria.id" :value="categoria.id">{{categoria.id}} - {{categoria.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal($bvModal.hide('modal-categoria'))"> Cerrar </b-button>
            </b-col>
        </b-row>        
    </b-modal>

</div> 

</template>

<script>
export default {
    name: "CategoriaComponent",
    data(){
        return{
            categorias: [],
            categoria:
            {
                id: '',
                nombre: ''
            },
            editarActivo: false,
            usuarios: [],
            usuario:
            {
                id: '',
                chapa: '', 
                nombre: '',
                categoria_id: '' 
            },
            usuarios_coincidentes: [],
            usuario_coincidente:
            {
                id: '',
                chapa: '', 
                nombre: '',
                categoria_id: '' 
            }
        }
    },
    created()
    {
        axios.get('/admin/categorias/create')
            .then(res=>{
                this.categorias = res.data;
            });
        axios.get(`/admin/usuarios/create`)
            .then(res=>{
                this.usuarios = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.categoria.nombre.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.categoria.nombre};

            this.categoria.nombre = '';

            axios.post(`/admin/categorias`, params)
                .then(res=>{
                    this.categorias.push(res.data);
                })
        },
        editarCategoria(item)
        {
            const params = {nombre: item.nombre}
            axios.put(`/admin/categorias/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.categorias.findIndex(categoriaBuscar => categoriaBuscar.id === res.data.id)
                    this.categorias[index] = res.data;

                    this.categoria = {nombre:''};
                })
        },
        relacionUsuarios(item)
        {
            this.categoria.nombre = item.nombre;
            this.categoria.id = item.id;
            
            for(var i=0; i<this.usuarios.length; i++)
            {
                if(this.usuarios[i].categoria_id === item.id)
                {
                    this.usuarios_coincidentes.push(this.usuarios[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-categoria', '#btnShow')
        },
        eliminarCategoria(item, index)
        {
            axios.get(`/admin/usuarios/${item.id}/edit`)
                .then(res=>{
                    if (res.data === 0 )
                    {
                        this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                            okVariant: 'danger',
                            okTitle: 'Eliminar',
                            cancelTitle: 'Cancelar'
                        }).then(value=>{
                            if(value === true)
                            {
                                axios.delete(`/admin/categorias/${item.id}`)
                                    .then(()=>{
                                        this.categorias.splice(index, 1);
                                    })
                            }
                        })
                    }else
                    {
                        alert("La categoría tiene usuarios relacionados, no se puede eliminar")
                    }
                })           
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.categoria = {nombre: ''};
        },
        cancelarEdicionModal($event)
        {
            this.categoria = {nombre: ''};
            this.usuarios_coincidentes = [];
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.categoria.nombre = item.nombre;
            this.categoria.id = item.id;
        },
        guardarCambios(item, index)
        {
            const params = {categoria_id: item.categoria_id}
            axios.put(`/admin/usuarios/categoriaUpdate/${item.id}`, params)
                .then(res=>{
                    const index = this.usuarios.findIndex(usuarioBuscar => usuarioBuscar.id === res.data.id)
                    this.usuarios[index] = res.data;
                });
            this.$root.$emit('bv::hide::modal', 'modal-categoria', '#btnShow');
            this.categoria = {nombre: ''};
            this.usuarios_coincidentes = [];
        }
    }
}
</script>