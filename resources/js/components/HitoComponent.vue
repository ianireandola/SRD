<template>
<div>
    <h3 class="text-center mb-3">Gestión de Hitos</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarHito(hito)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="hito.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="hito.descripcion"/>
        <b-form-group label="Fase relacionada:">
            <b-form-select class="form-control mb-2" v-model="fase" v-on:change="faseElegida(fase)">
                <option v-for="fase in fases" v-bind:key="fase.id" :value="fase">{{fase.id}} - {{fase.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="hito.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="hito.descripcion"/>
        <b-form-group label="Fase relacionada:">
            <b-form-select class="form-control mb-2" v-model="fase" v-on:change="faseElegida(fase)">
                <option v-for="fase in fases" v-bind:key="fase.id" :value="fase">{{fase.id}} - {{fase.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col" width="3%">ID</th>
                <th class="text-center" scope="col" width="15%">NOMBRE</th>
                <th class="text-center" scope="col" width="35%">DESCRIPCIÓN</th>
                <th class="text-center" scope="col" width="25%">FASE PERTENECIENTE</th>
                <th class="text-center" scope="col" width="25%">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(hito, index) in hitos" v-bind:key="hito.id">
                <td class="text-center">{{hito.id}}</td>
                <td >{{hito.nombre}}</td>
                <td>{{hito.descripcion}}</td>
                <template v-for="fase in fases">
                    <td v-if="fase.id === hito.fase_id" v-bind:key="`A-${fase.id}`">
                        {{fase.nombre}}
                    </td>
                </template>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(hito)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarHito(hito, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>
<script>
export default {
    name: "HitoComponent",
    data(){
        return{
            hitos: [],
            hito:
            {
                id: '',
                nombre: '',
                descripcion: '',
                fase_id: ''
            },
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
        axios.get('/admin/hitos/create')
            .then(res=>{
                this.hitos = res.data;
            });

        axios.get('/admin/fases/create')
            .then(res=>{
                this.fases = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            if(this.hito.nombre.trim() === '' || this.hito.fase_id === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.hito.nombre, descripcion: this.hito.descripcion, fase_id: this.hito.fase_id};

            this.hito.nombre = '';
            this.hito.descripcion = '';
            this.hito.fase_id = '';
            this.fase = ''

            axios.post(`/admin/hitos`, params)
                .then(res=>{
                    this.hitos.push(res.data);
                });

            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarHito(item)
        {
            const params = {nombre: item.nombre, descripcion: item.descripcion, fase_id: this.hito.fase_id}
            axios.put(`/admin/hitos/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.hitos.findIndex(hitoBuscar => hitoBuscar.id === res.data.id)
                    this.hitos[index] = res.data;

                    this.hito.nombre = '';
                    this.hito.descripcion = '';
                    this.hito.fase_id = '';
                    this.fase = ''
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
            this.hito = {nombre: '', descripcion: '', fase_id: ''};
            this.fase = ''
        },
        faseElegida(fase)
        {
            this.hito.fase_id = fase.id;
        },
        editarFormulario(hito)
        {
            this.editarActivo = true;
            this.hito.nombre = hito.nombre;
            this.hito.descripcion = hito.descripcion;
            this.hito.id = hito.id;

            for(var i=0; i<this.fases.length; i++)
            {
                if(this.fases[i].id === hito.fase_id)
                {
                    this.fase = this.fases[i];
                    this.hito.fase_id = this.fases[i].id;
                }
            }
        },
        eliminarHito(hito, index)
        {
            axios.get(`/admin/hitos/${hito.id}`)
                .then(res =>{
                    if(res.data === 0)
                    {
                        this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                            okVariant: 'danger',
                            okTitle: 'Eliminar',
                            cancelTitle: 'Cancelar'
                    }).then(value=>{
                        if(value === true)
                        {
                            axios.delete(`/admin/hitos/${hito.id}`)
                                .then(()=>{
                                    this.hitos.splice(index, 1);
                                });
                            this.$swal.fire({
                                position: 'top-end',
                                type: 'success',
                                title: 'Registro realizado',
                                showConfirmButton: false,
                                timer: 1300})
                        }
                    })
                }else
                {
                    alert("El hito tiene proyectos, no se puede eliminar")
                }
            })
        }
    }
}
</script>