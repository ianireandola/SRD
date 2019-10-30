<template>
<div>
    <h3 class="text-center mb-3">Gestión de Fases</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarFase(fase)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="fase.nombre">
        <input type="text" class="form-control mb-2" placeholder="Descripcion" v-model="fase.descripcion">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="fase.nombre">
        <input type="text" class="form-control mb-2" placeholder="Descripcion" v-model="fase.descripcion">
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
            <tr v-for="(item, index) in fases" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">{{item.descripcion}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarFase(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

</div> 
</template>

<script>
export default {
    name: "FaseComponent",
    data(){
        return{
            fases: [],
            fase:
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
        console.log('FaseComponent created')
        axios.get('/admin/fases/create')
            .then(res=>{
                this.fases = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            if(this.fase.nombre.trim() === '' || this.fase.descripcion.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.fase.nombre, descripcion: this.fase.descripcion};

            this.fase.nombre = '';
            this.fase.descripcion = '';

            axios.post(`/admin/fases`, params)
                .then(res=>{
                    this.fases.push(res.data);
                })
        },
        editarFase(item)
        {
            const params = {nombre: item.nombre, descripcion: item.descripcion}
            axios.put(`/admin/fases/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.fases.findIndex(faseBuscar => faseBuscar.id === res.data.id)
                    this.fases[index] = res.data;

                    this.fase = {nombre:'', descripcion:''};
                })
        },
        eliminarFase(fase, index)
        {
            axios.delete(`/admin/fases/${fase.id}`)
                .then(()=>{
                    this.fases.splice(index, 1);
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.fase = {nombre: '', descripcion: ''};
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.fase.nombre = item.nombre;
            this.fase.descripcion = item.descripcion;
            this.fase.id = item.id;
        }
    }
}
</script>