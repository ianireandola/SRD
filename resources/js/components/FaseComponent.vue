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
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col" width="20%">NOMBRE</th>
                <th class="text-center" scope="col" width="35%">DESCRIPCION</th>
                <th class="text-center" scope="col" width="35%">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in fases" v-bind:key="index">
                <td>{{item.nombre}}</td>
                <td>{{item.descripcion}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="relacionHitos(item)" class="btn btn-info">Relación con hitos</button>
                    <button type="button" @click="eliminarFase(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal size="xl" id="modal-hitos" ref="btnFase" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Fase a eliminar: <b> {{fase.nombre}} </b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionada con los siguientes atributos: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">HITO</th>
                    <th class="text-center" scope="col">ELEGIR OTRA FASE</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(hito_coincidente, index) in hito_coincidentes" v-bind:key="index">
                    <td>{{hito_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="hito_coincidente.fase_id" v-on:change="guardarCambios(hito_coincidente, index)">
                            <option v-for="fase in fases" v-bind:key="fase.id" :value="fase.id">{{fase.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal()"> Cerrar </b-button>
            </b-col>
        </b-row>        
    </b-modal>

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
            editarActivo: false,
            hitos: [],
            hito: 
            {
                id: '',
                fase_id: '',
                nombre: '',
                descripcion: ''
            },
            hito_coincidentes: [],
            hito_coincidente: 
            {
                id: '',
                fase_id: '',
                nombre: '',
                descripcion: ''
            }
        }
    },
    created()
    {
        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/fases/create')
            .then(res=>{
                this.fases = res.data;
            });
        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/hitos/create')
            .then(res=>{
                this.hitos = res.data;
            })
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

            axios.post(`http://localhost/laravel/prueba4/public/index.php/admin/fases`, params)
                .then(res=>{
                    this.fases.push(res.data);
                });

            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarFase(item)
        {
            const params = {nombre: item.nombre, descripcion: item.descripcion}
            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/fases/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.fases.findIndex(faseBuscar => faseBuscar.id === res.data.id)
                    this.fases[index] = res.data;

                    this.fase = {nombre:'', descripcion:''};
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Modificación realizada',
                showConfirmButton: false,
                timer: 1300})
        },
        relacionHitos(item)
        {
            this.fase.nombre = item.nombre;
            this.fase.descripcion = item.descripcion;
            this.fase.id = item.id;

            for(var i=0; i<this.hitos.length; i++)
            {
                if(this.hitos[i].fase_id === item.id)
                {
                    this.hito_coincidentes.push(this.hitos[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-hitos', '#btnShow')
        },
        eliminarFase(fase, index)
        {
            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/hitos/${fase.id}/edit`)
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
                                axios.delete(`http://localhost/laravel/prueba4/public/index.php/admin/fases/${fase.id}`)
                                    .then(()=>{
                                        this.fases.splice(index, 1);
                                    });
                                this.$swal.fire({
                                    position: 'top-end',
                                    type: 'success',
                                    title: 'Eliminado',
                                    showConfirmButton: false,
                                    timer: 1300})
                            }
                        })
                    }else{
                        alert("La fase tiene hitos relacionados, no se puede eliminar")
                    }
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.fase = {nombre: '', descripcion: ''};
        },
        cancelarEdicionModal()
        {
            this.fase = {nombre: '', descripcion: ''};
            this.hito_coincidentes = [];
            this.$root.$emit('bv::hide::modal', 'modal-hitos')
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.fase.nombre = item.nombre;
            this.fase.descripcion = item.descripcion;
            this.fase.id = item.id;
        },
        guardarCambios(item, index)
        {
            const params = {fase_id: item.fase_id, nombre: item.nombre, descripcion: item.descripcion}
            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/hitos/${item.id}`, params)
                .then(res=>{
                    const index = this.hitos.findIndex(hitoBuscar => hitoBuscar.id === res.data.id)
                    this.hitos[index] = res.data;
                });
            this.$root.$emit('bv::hide::modal', 'modal-hitos', '#btnShow');
            this.fase = {nombre: '', descripcion: ''};
            this.hito_coincidentes = [];
        }
    }
}
</script>