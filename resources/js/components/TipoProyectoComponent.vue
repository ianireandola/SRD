<template>
 <div>
    <h3 class="text-center mb-3">Gestión de Tipos de Proyecto</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarTipoProyecto(tipo_proyecto)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="tipo_proyecto.nombre">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="tipo_proyecto.nombre">
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
            <tr v-for="(item, index) in tipos_proyecto" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarTipoProyecto(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>   

</template>

<script>
export default {
    name: "TipoProyectoComponent",
    data(){
        return{
            tipos_proyecto: [],
            tipo_proyecto:
            {
                id: '',
                nombre: ''
            },
            editarActivo: false
        }
    },
    created()
    {
        console.log('TipoProyectoComponent created')
        axios.get('/admin/tipos_proyecto/create')
            .then(res=>{
                this.tipos_proyecto = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            if(this.tipo_proyecto.nombre.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.tipo_proyecto.nombre};

            this.tipo_proyecto.nombre = '';

            axios.post(`/admin/tipos_proyecto`, params)
                .then(res=>{
                    this.tipos_proyecto.push(res.data);
                })
        },
        editarTipoProyecto(item)
        {
            const params = {nombre: item.nombre}
            axios.put(`/admin/tipos_proyecto/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.tipos_proyecto.findIndex(tipo_proyectoBuscar => tipo_proyectoBuscar.id === res.data.id)
                    this.tipos_proyecto[index] = res.data;

                    this.tipo_proyecto = {nombre:''};
                })
        },
        eliminarTipoProyecto(tipo_proyecto, index)
        {
            axios.delete(`/admin/tipos_proyecto/${tipo_proyecto.id}`)
                .then(()=>{
                    this.tipos_proyecto.splice(index, 1);
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.tipo_proyecto = {nombre: ''};
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.tipo_proyecto.nombre = item.nombre;
            this.tipo_proyecto.id = item.id;
        }
    }
}
</script>