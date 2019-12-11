<template>
<div>
    <h3 class="text-center mb-3">Gestión de Plantas</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarPlanta(planta)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="planta.nombre">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="planta.nombre">
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
            <tr v-for="(item, index) in plantas" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="relacionSecciones(item)" class="btn btn-info">Relación con secciones</button>
                    <button type="button" @click="eliminarPlanta(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal size="xl" id="modal-planta" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Planta a eliminar: <b> {{planta.id}} - {{planta.nombre}}</b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionada con los siguientes atributos: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">SECCIÓN</th>
                    <th class="text-center" scope="col">ELEGIR OTRA PLANTA</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(seccion_coincidente, index) in secciones_coincidentes" v-bind:key="index">
                    <td>{{seccion_coincidente.id}} - {{seccion_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="seccion_coincidente.planta_id" v-on:change="guardarCambios(seccion_coincidente, index)">
                            <option v-for="planta in plantas" v-bind:key="planta.id" :value="planta.id">{{planta.id}} - {{planta.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal($bvModal.hide('modal-planta'))">Cerrar</b-button>
            </b-col>
        </b-row>
    </b-modal>

</div>
</template>

<script>
export default {
    name: "PlantaComponent",
    data(){
        return{
            plantas: [],
            planta:
            {
                id: '',
                nombre: ''
            },
            editarActivo: false,
            secciones: [],
            seccion:
            {
                id: '',
                nombre: '',
                nivel2: '',
                area_id: '',
                planta_id: ''
            },
            secciones_coincidentes: [],
            seccion_coincidente:
            {
                id: '',
                nombre: '',
                nivel2: '',
                area_id: '',
                planta_id: ''
            }
        }
    },
    created()
    {
        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/plantas/create')
            .then(res=>{
                this.plantas = res.data;
            });
        axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/secciones/create`)
            .then(res=>{
                this.secciones = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.planta.nombre.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.planta.nombre};

            this.planta.nombre = '';

            axios.post(`http://localhost/laravel/prueba4/public/index.php/admin/plantas`, params)
                .then(res=>{
                    this.plantas.push(res.data);
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarPlanta(item)
        {
            const params = {nombre: item.nombre}
            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/plantas/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.plantas.findIndex(plantaBuscar => plantaBuscar.id === res.data.id)
                    this.plantas[index] = res.data;

                    this.planta = {nombre:''};
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Modificación realizada',
                showConfirmButton: false,
                timer: 1300})
        },
        relacionSecciones(item)
        {
            this.planta.nombre = item.nombre;
            this.planta.id = item.id;

            for(var i=0; i<this.secciones.length; i++)
            {
                if(this.secciones[i].planta_id === item.id)
                {
                    this.secciones_coincidentes.push(this.secciones[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-planta', '#btnShow')
        },
        eliminarPlanta(item, index)
        {
            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/secciones/${item.id}/edit`)
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
                                axios.delete(`http://localhost/laravel/prueba4/public/index.php/admin/plantas/${item.id}`)
                                    .then(()=>{
                                        this.plantas.splice(index, 1);
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
                        alert("La planta tiene secciones relacionadas, no se puede eliminar")
                    }
                })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.planta = {nombre: ''};
        },
        cancelarEdicionModal($event)
        {
            this.planta = {nombre: ''};
            this.secciones_coincidentes = [];
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.planta.nombre = item.nombre;
            this.planta.id = item.id;
        },
        guardarCambios(item, index)
        {
            const params = {nombre: item.nombre, nivel2: item.nivel2, area_id: item.area_id, planta_id: item.planta_id}
            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/secciones/${item.id}`, params)
                .then(res=>{
                    const index = this.secciones.findIndex(seccionBuscar =>seccionBuscar.id === res.data.id)
                    this.secciones[index] = res.data;
                });
            this.$root.$emit('bv::hide::modal', 'modal-planta', '#btnShow');
            this.planta = {nombre: ''};
            this.secciones_coincidentes = [];
        }
    }
}
</script>