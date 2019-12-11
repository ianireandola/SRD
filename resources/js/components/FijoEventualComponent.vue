<template>
<div>
    <h3 class="text-center mb-3">Gestión de Fijos Eventuales</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarFijoEventual(fijo_eventual)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="fijo_eventual.nombre">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="fijo_eventual.nombre">
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
            <tr v-for="(item, index) in fijos_eventuales" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="relacionUsuarios(item)" class="btn btn-info">Relación con usuarios</button>
                    <button type="button" @click="eliminarFijoEventual(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal size="xl" id="modal-fijoeventual" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Fijo/Eventual a eliminar: <b> {{fijo_eventual.id}} - {{fijo_eventual.nombre}}</b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionado con los siguientes atributos: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">USUARIO</th>
                    <th class="text-center" scope="col">ELEGIR OTRO FIJO/EVENTUAL</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(usuario_coincidente, index) in usuarios_coincidentes" v-bind:key="index">
                    <td>{{usuario_coincidente.id}} - {{usuario_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="usuario_coincidente.fijoeventual_id" v-on:change="guardarCambios(usuario_coincidente, index)">
                            <option v-for="fijo_eventual in fijos_eventuales" v-bind:key="fijo_eventual.id" :value="fijo_eventual.id">{{fijo_eventual.id}} - {{fijo_eventual.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal($bvModal.hide('modal-fijoeventual'))">Cerrar</b-button>
            </b-col>
        </b-row>
    </b-modal>

</div>
</template>

<script>
export default {
    name: "FijoEventualComponent",
    data(){
        return{
            fijos_eventuales: [],
            fijo_eventual:
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
                fijoeventual_id: ''
            },
            usuarios_coincidentes: [],
            usuario_coincidente:
            {
                id: '',
                chapa: '',
                nombre: '',
                fijoeventual_id: ''
            }
        }
    },
    created()
    {
        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/fijos_eventuales/create')
            .then(res=>{
                this.fijos_eventuales = res.data;
            });
        axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/usuarios/create`)
            .then(res=>{
                this.usuarios = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.fijo_eventual.nombre.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.fijo_eventual.nombre};

            this.fijo_eventual.nombre = '';

            axios.post(`http://localhost/laravel/prueba4/public/index.php/admin/fijos_eventuales`, params)
                .then(res=>{
                    this.fijos_eventuales.push(res.data);
                });

            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarFijoEventual(item)
        {
            const params = {nombre: item.nombre}
            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/fijos_eventuales/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.fijos_eventuales.findIndex(fijoEventualBuscar => fijoEventualBuscar.id === res.data.id)
                    this.fijos_eventuales[index] = res.data;

                    this.fijo_eventual = {nombre:''};
                });

            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Modificación realizada',
                showConfirmButton: false,
                timer: 1300})
        },
        relacionUsuarios(item)
        {
            this.fijo_eventual.nombre = item.nombre;
            this.fijo_eventual.id = item.id;

            for(var i=0; i<this.usuarios.length; i++)
            {
                if(this.usuarios[i].fijoeventual_id === item.id)
                {
                    this.usuarios_coincidentes.push(this.usuarios[i]);
                }
            }

            this.$root.$emit('bv::show::modal', 'modal-fijoeventual', '#btnShow')
        },
        eliminarFijoEventual(item, index)
        {
            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/usuarios/${item.id}/buscarFE`)
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
                                axios.delete(`http://localhost/laravel/prueba4/public/index.php/admin/fijos_eventuales/${item.id}`)
                                    .then(()=>{
                                        this.fijos_eventuales.splice(index, 1);
                                    });
                                this.$swal.fire({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Eliminado',
                                    showConfirmButton: false,
                                    timer: 1300})
                            }
                        })
                    }else
                    {
                        alert("El fijo/eventual tiene usuarios relacionados, no se puede eliminar")
                    }
                })           
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.fijo_eventual = {nombre: ''};
        },
        cancelarEdicionModal($event)
        {
            this.fijo_eventual = {nombre: ''};
            this.usuarios_coincidentes = [];
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.fijo_eventual.nombre = item.nombre;
            this.fijo_eventual.id = item.id;
        },
        guardarCambios(item, index)
        {
            const params = {fijo_eventual_id: item.fijoeventual_id}
            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/usuarios/fijoeventualUpdate/${item.id}`, params)
                .then(res=>{
                    const index = this.usuarios.findIndex(usuarioBuscar => usuarioBuscar.id === res.data.id)
                    this.usuarios[index] = res.data;
                });
            this.$root.$emit('bv::hide::modal', 'modal-fijoeventual', '#btnShow');
            this.fijo_eventual = {nombre: ''};
            this.usuarios_coincidentes = [];
        }
    }
}
</script>