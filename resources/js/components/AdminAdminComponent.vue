<template>
<div>
    <h3 class="text-center mb-3">Gestión de Administradores</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarAdmin(admin)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="admin.nombre">
        <input type="text" class="form-control mb-2" placeholder="Contraseña" v-model="admin.password_confirmation">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="registrarAdmin" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="admin.nombre">
        <input type="text" class="form-control mb-2" placeholder="Contraseña" v-model="admin.password_confirmation">
        <button type="submit" class="btn btn-success btn-block mb-7">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">CONTRASEÑA</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in admins" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">{{item.password_confirmation}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarAdmin(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>  
</template>

<script>
export default {
    name: "AdminAdminComponent",
    props: ['currentAdmin'],
    data(){
        return{
            admins: [],
            admin:
            {
                id: '',
                nombre: '',
                password: '',
                password_confirmation: ''
            },
            editarActivo: false
        }
    },
    created()
    {
        console.log('AdminAdminComponent created')
        axios.get('/admin/admins/create')
            .then(res=>{
                this.admins = res.data;
            });
    },
    methods:
    {
        registrarAdmin()
        {
            if(this.admin.nombre.trim() === '' || this.admin.password_confirmation === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.admin.nombre, password_confirmation: this.admin.password_confirmation};

            axios.post(`/admin/admins`, params)
                .then(res=>{
                    this.admins.push(res.data);
                })
        },
        eliminarAdmin(admin, index)
        {
            if(admin.id === this.currentAdmin)
            {
                alert('Eres tú mismo no te puedes eliminar');
                return;
            }else{
                axios.delete(`/admin/admins/${admin.id}`)
                    .then(()=>{
                        this.admins.splice(index, 1);
                    })
            }
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.admin.nombre = item.nombre;
            this.admin.password_confirmation = item.password_confirmation;
            this.admin.id = item.id;
        },
        editarAdmin(item)
        {
            const params = {nombre: item.nombre, password_confirmation: item.password_confirmation}
            axios.put(`/admin/admins/${item.id}`, params)
                .then(res=>{
                    this.editarActivo = false;
                    const index = this.admins.findIndex(adminBuscar => adminBuscar.id === res.data.id)
                    this.admins[index] = res.data;

                    this.admin = {nombre: '', password_confirmation: ''};
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.admin = {nombre: '', password_confirmation: ''}
        }
    }
}
</script>