<template>
<div>
    <h3 class="text-center mb-3">Gestión de Acciones de nivel 2</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarAccion2(accion2)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="accion2.nombre">
        <input type="text" class="form-control mb-2" placeholder="Descripcion" v-model="accion2.descripcion">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="accion2.nombre">
        <input type="text" class="form-control mb-2" placeholder="Descripcion" v-model="accion2.descripcion">
        <button type="submit" class="btn btn-success btn-block mb-7">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">DESCRIPCION</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in accion2s" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">{{item.descripcion}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarAccion2(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>
</template>

<script>
export default {
    name: "Accion2Component",
    data(){
        return{
            accion2s: [],
            accion2:
            {
                id: '',
                nombre: '',
                descripcion: ''
            },
            editarActivo: false
        }
    },
    created()
    {
        console.log('Accion2Component created')
        axios.get('/admin/accion2s/create')
            .then(res=>{
                this.accion2s = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            if(this.accion2.nombre.trim() === '' || this.accion2.descripcion.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.accion2.nombre, descripcion: this.accion2.descripcion};

            this.accion2.nombre = '';
            this.accion2.descripcion = '';

            axios.post(`/admin/accion2s`, params)
                .then(res=>{
                    this.accion2s.push(res.data);
                })
        },
        editarAccion2(item)
        {
            const params = {nombre: item.nombre, descripcion: item.descripcion}
            axios.put(`/admin/accion2s/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.accion2s.findIndex(accion2Buscar => accion2Buscar.id === res.data.id)
                    this.accion2s[index] = res.data;

                    this.accion2 = {nombre:'', descripcion:''};
                })
        },
        eliminarAccion2(accion2, index)
        {
            axios.delete(`/admin/accion2s/${accion2.id}`)
                .then(()=>{
                    this.accion2s.splice(index, 1);
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.accion2 = {nombre: '', descripcion: ''};
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.accion2.nombre = item.nombre;
            this.accion2.descripcion = item.descripcion;
            this.accion2.id = item.id;
        }
    }
}
</script>