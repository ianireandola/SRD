<template>
<div>
    <h3 class="text-center mb-3">Gestión de Dedicaciones</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarDedicacion(dedicacion)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="dedicacion.nombre">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="dedicacion.nombre">
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
            <tr v-for="(item, index) in dedicaciones" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarDedicacion(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>  
</template>

<script>
export default {
    name: "DedicacionComponent",
    data(){
        return{
            dedicaciones: [],
            dedicacion:
            {
                id: '',
                nombre: ''
            },
            editarActivo: false
        }
    },
    created()
    {
        console.log('DedicacionComponent created')
        axios.get('/admin/dedicaciones/create')
            .then(res=>{
                this.dedicaciones = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            if(this.dedicacion.nombre.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.dedicacion.nombre};

            this.dedicacion.nombre = '';

            axios.post(`/admin/dedicaciones`, params)
                .then(res=>{
                    this.dedicaciones.push(res.data);
                })
        },
        editarDedicacion(item)
        {
            const params = {nombre: item.nombre}
            axios.put(`/admin/dedicaciones/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.dedicaciones.findIndex(dedicacionBuscar => dedicacionBuscar.id === res.data.id)
                    this.dedicaciones[index] = res.data;

                    this.dedicacion = {nombre:''};
                })
        },
        eliminarDedicacion(dedicacion, index)
        {
            axios.delete(`/admin/dedicaciones/${dedicacion.id}`)
                .then(()=>{
                    this.dedicaciones.splice(index, 1);
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.area = {nombre: '', Q_Ind: ''};
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.dedicacion.nombre = item.nombre;
            this.dedicacion.id = item.id;
        }
    }
}
</script>