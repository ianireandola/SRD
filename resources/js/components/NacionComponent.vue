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
                    <button type="button" @click="relacionProyectosPadre(item)" class="btn btn-info">Relación con proyectos padre</button>
                    <button type="button" @click="eliminarNacion(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>


    <b-modal size="xl" id="modal-proyectopadre" ref="btnUser" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Nación a eliminar: <b> {{nacion.id}} - {{nacion.nombre}} </b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionada con los siguientes atributos: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">PROYECTO PADRE</th>
                    <th class="text-center" scope="col">ELEGIR OTRO PROYECTO PADRE</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(proyectopadre_coincidente, index) in proyectospadre_coincidentes" v-bind:key="index">
                    <td>{{proyectopadre_coincidente.id}} - {{proyectopadre_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="proyectopadre_coincidente.nacion_id" v-on:change="guardarCambios(proyectopadre_coincidente, index)">
                            <option v-for="proyectopadre in proyectospadre" v-bind:key="proyectopadre.id" :value="proyectopadre.id">{{proyectopadre.id}} - {{proyectopadre.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal($bvModal.hide('modal-proyectopadre'))"> Cerrar </b-button>
            </b-col>
        </b-row>        
    </b-modal>

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
            editarActivo: false,
            proyectospadre: [],
            proyectopadre:
            {
                id: '',
                nacion_id: '',
                nombre: '',
            },
            proyectospadre_coincidentes: [],
            proyectopadre_coincidente:
            {
                id: '', 
                nacion_id: '',
                nombre: ''
            }
        }
    },
    created()
    {
        axios.get('/admin/naciones/create')
            .then(res=>{
                this.naciones = res.data;
            });

        axios.get('/admin/proyectospadre/create')
            .then(res=>{
                this.proyectospadre = res.data;
            })
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
        relacionProyectosPadre(item)
        {
            this.nacion.nombre = item.nombre;
            this.nacion.id = item.id;

            for(var i=0; i<this.proyectospadre.length; i++)
            {
                if(this.proyectospadre[i].nacion_id === item.id)
                {
                    this.proyectospadre_coincidentes.push(this.proyectospadre[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-proyectopadre', '#btnShow')
        },
        eliminarNacion(nacion, index)
        {
            axios.get(`/admin/proyectospadre/${nacion .id}/edit`)
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
                                axios.delete(`/admin/naciones/${nacion.id}`)
                                    .then(()=>{
                                        this.naciones.splice(index, 1);
                                    })
                            }
                        })
                    }else{
                        alert("La nacion tiene proyectos padre relacionados, no se puede eliminar")
                    }
                })
            
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.nacion = {nombre: ''};
        },
        cancelarEdicionModal($event)
        {
            this.nacion = {nombre: ''};
            this.proyectospadre_coincidentes = [];
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.nacion.nombre = item.nombre;
            this.nacion.id = item.id;
        },
        guardarCambios(item, index)
        {
            const params = {nacion_id: item.nacion_id}
            axios.put(`/admin/proyectospadre/nacionUpdate/${item.id}`, params)
                .then(res=>{
                    const index = this.proyectospadre.findIndex(proyectopadreBuscar => proyectopadreBuscar.id === res.data.id)
                    this.proyectospadre[index] = res.data;
                });
            this.$root.$emit('bv::hide::modal', 'modal-proyectopadre', '#btnShow');
            this.nacion = {nombre: ''};
            this.proyectospadre_coincidentes = [];
        }
    }
}
</script>