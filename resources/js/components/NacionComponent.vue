<template>
<div>
    <h3 class="text-center mb-3">Gestión de Naciones</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarNacion(nacion)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="nacion.nombre">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="nacion.nombre">
        <button type="submit" class="btn btn-success btn-block mb-7">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in naciones" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarNacion(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>
</template>

<script>
export default {
    name: "NacionComponent",
    data(){
        return{
            naciones: [],
            nacion:
            {
                id: '',
                nombre: ''
            },
            editarActivo: false
        }
    },
    created()
    {
        console.log('NacionComponent created')
        axios.get('/admin/naciones/create')
            .then(res=>{
                this.naciones = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            if(this.nacion.nombre.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.nacion.nombre};

            this.nacion.nombre = '';

            axios.post(`/admin/naciones`, params)
                .then(res=>{
                    this.naciones.push(res.data);
                })
        },
        editarNacion(item)
        {
            const params = {nombre: item.nombre}
            axios.put(`/admin/naciones/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.naciones.findIndex(nacionBuscar => nacionBuscar.id === res.data.id)
                    this.naciones[index] = res.data;

                    this.nacion = {nombre:''};
                })
        },
        eliminarNacion(nacion, index)
        {
            axios.delete(`/admin/naciones/${nacion.id}`)
                .then(()=>{
                    this.naciones.splice(index, 1);
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.nacion = {nombre: ''};
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.nacion.nombre = item.nombre;
            this.nacion.id = item.id;
        }
    }
}
</script>