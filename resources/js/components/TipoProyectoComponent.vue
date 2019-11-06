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
                    <button type="button" @click="relacionProyectosPadre(item)" class="btn btn-info">Relación con proyectos padre</button>
                    <button type="button" @click="eliminarTipoProyecto(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal size="xl" id="modal-proyectopadre" ref="btnUser" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Tipo Proyecto a eliminar: <b> {{tipo_proyecto.id}} - {{tipo_proyecto.nombre}} </b>
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
                        <b-form-select v-model="proyectopadre_coincidente.tipoProyecto_id" v-on:change="guardarCambios(proyectopadre_coincidente, index)">
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
    name: "TipoProyectoComponent",
    data(){
        return{
            tipos_proyecto: [],
            tipo_proyecto:
            {
                id: '',
                nombre: ''
            },
            editarActivo: false,
            proyectospadre: [],
            proyectopadre:
            {
                id: '',
                tipoProyecto_id: '',
                nombre: '',
            },
            proyectospadre_coincidentes: [],
            proyectopadre_coincidente: 
            {
                id: '',
                tipoProyecto_id: '',
                nombre: ''
            }
        }
    },
    created()
    {
        axios.get('/admin/tipos_proyecto/create')
            .then(res=>{
                this.tipos_proyecto = res.data;
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
        relacionProyectosPadre(item)
        {
            this.tipo_proyecto.nombre = item.nombre;
            this.tipo_proyecto.id = item.id;

            for(var i=0; i<this.proyectospadre.length; i++)
            {
                if(this.proyectospadre[i].tipoProyecto_id === item.id)
                {
                    this.proyectospadre_coincidentes.push(this.proyectospadre[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-proyectopadre', '#btnShow')
        },
        eliminarTipoProyecto(tipo_proyecto, index)
        {
            axios.get(`/admin/proyectospadre/${tipo_proyecto.id}`)
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
                                axios.delete(`/admin/tipos_proyecto/${tipo_proyecto.id}`)
                                    .then(()=>{
                                        this.tipos_proyecto.splice(index, 1);
                                    })
                            }
                        })
                    }else{
                        alert("El tipo proyecto tiene proyectos padre relacionados, no se puede eliminar")
                    }
                })

            
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.tipo_proyecto = {nombre: ''};
        },
        cancelarEdicionModal($event)
        {
            this.tipo_proyecto = {nombre: ''};
            this.proyectospadre_coincidentes = [];
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.tipo_proyecto.nombre = item.nombre;
            this.tipo_proyecto.id = item.id;
        },
        guardarCambios(item, index)
        {
            const params = {tipoProyecto_id: item.tipoProyecto_id}
            axios.put(`/admin/proyectospadre/tipoProyectoUpdate/${item.id}`, params)
                .then(res=>{
                    const index = this.proyectospadre.findIndex(proyectopadreBuscar => proyectopadreBuscar.id === res.data.id)
                    this.proyectospadre[index] = res.data;
                });
            this.$root.$emit('bv::hide::modal', 'modal-proyectopadre', '#btnShow');
            this.tipo_proyecto = {nombre: ''};
            this.proyectospadre_coincidentes = [];
        }
    }
}
</script>