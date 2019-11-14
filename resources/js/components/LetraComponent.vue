<template>
<div>
    <h3 class="text-center mb-3">Gestión de Letras</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarLetra(letra)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="letra.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="letra.descripcion"/>
        <b-form-group label="IMPORTANTE: Escoger solamente UNA opción: ">
            <b-form-checkbox v-model="no_presencia" v-on:change="cambiarDedicacion(3)">No presencia</b-form-checkbox>
            <b-form-checkbox v-model="gasto_general" v-on:change="cambiarDedicacion(2)">Gasto General</b-form-checkbox>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="letra.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="letra.descripcion"/>
        <b-form-group label="IMPORTANTE: Escoger solamente UNA opción: ">
            <b-form-checkbox v-model="no_presencia" v-on:change="cambiarDedicacion(3)">No presencia</b-form-checkbox>
            <b-form-checkbox v-model="gasto_general" v-on:change="cambiarDedicacion(2)">Gasto General</b-form-checkbox>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">DESCRIPCIÓN</th>
                <th class="text-center" scope="col">DEDICACIÓN</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(letra, index) in letras" v-bind:key="letra.id">
                <td class="text-center">{{letra.id}}</td>
                <td >{{letra.nombre}}</td>
                <td>{{letra.descripcion}}</td>
                <td v-if="letra.dedicacion_id === 2">Gasto General</td>
                <td v-else>No presencia</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(letra)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarLetra(letra, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>
</div>
</template>

<script>
export default {
    name: "LetraComponent",
    data(){
        return{
            no_presencia: false,
            gasto_general: false,
            dedicacion: '',
            letras: [],
            letra:
            {
                id: '',
                nombre: '',
                descripcion: '',
                dedicación_id: ''
            },
            editarActivo: false
        }
    },
    created()
    {
        axios.get('/admin/letras/create')
            .then(res=>{
                this.letras = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.letra.nombre.trim() === '' || this.dedicacion === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            this.letra.dedicación_id = this.dedicacion;
            const params = {nombre: this.letra.nombre, descripcion: this.letra.descripcion, dedicacion_id: this.letra.dedicación_id};

            this.letra.nombre = '';
            this.letra.descripcion = '';
            this.letra.dedicación_id = '';
            this.no_presencia = false;
            this.gasto_general = false;

            axios.post(`/admin/letras`, params)
                .then(res=>{
                    this.letras.push(res.data);
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarLetra(item)
        {
            const params = {nombre: item.nombre, descripcion: item.descripcion, dedicacion_id: this.dedicacion}
            axios.put(`/admin/letras/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.letras.findIndex(letraBuscar => letraBuscar.id === res.data.id)
                    this.letras[index] = res.data;

                    this.letra.nombre = '';
                    this.letra.descripcion = '';
                    this.letra.dedicación_id = '';
                    this.no_presencia = false;
                    this.gasto_general = false;
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
            this.letra = {nombre: '', descripcion: '', dedicacion_id: ''};
            this.gasto_general = false;
            this.no_presencia = false;
        },
        editarFormulario(item)
        {
            this.gasto_general = false;
            this.no_presencia = false;

            this.editarActivo = true;
            this.letra.nombre = item.nombre;
            this.letra.descripcion = item.descripcion;
            this.letra.id = item.id;
            if(item.dedicacion_id === 2)
            {
                this.gasto_general = true;
            }else{
                this.no_presencia = true;
            }
        },
        cambiarDedicacion(valor)
        {
            this.dedicacion = valor;
            console.log("Valor de dedicacion: " + this.dedicacion)
        },
        eliminarLetra(letra, index)
        {
            axios.get(`/srd_letras/showLetra/${letra.id}`)
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
                            axios.delete(`/admin/letras/${letra.id}`)
                                .then(()=>{
                                    this.letras.splice(index, 1);
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
                    alert("La letra tiene horas de trabajadores asignadas, no se puede eliminar")
                }
            })
        }
    }
}
</script>