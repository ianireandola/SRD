<template>
<div>
    <h3 class="text-center mb-3">Gestión de Áreas</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarArea(area)" v-if="editarActivo" class="mb-5">
        <div class="row">
            <div class="col-8">
                <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="area.nombre">
            </div>
            <div class="col">
                <input class="form-check-input" type="checkbox" v-model="area.Q_Ind">
                <label for="checkbox"> Q_Ind </label>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <div class="row">
            <div class="col-8">
                <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="area.nombre">
            </div>
            <div class="col">
                <input class="form-check-input" type="checkbox" v-model="area.Q_Ind">
                <label for="checkbox"> Q_Ind </label>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-block mb-7">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">Q_IND</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in areas" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">{{item.Q_Ind}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="relacionSecciones(item)" class="btn btn-info">Relación con secciones</button>
                    <button type="button" @click="eliminarArea(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

    <b-modal size="xl" id="modal-seccion" ref="btnArea" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Área a eliminar: <b> {{area.id}} - {{area.nombre}} </b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionada con las siguientes secciones: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">SECCIÓN</th>
                    <th class="text-center" scope="col">ELEGIR OTRA ÁREA</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(seccion_coincidente, index) in secciones_coincidentes" v-bind:key="index">
                    <td>{{seccion_coincidente.id}} - {{seccion_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="seccion_coincidente.area_id" v-on:change="guardarCambios(seccion_coincidente, index)">
                            <option v-for="area in areas" v-bind:key="area.id" :value="area.id">{{area.id}} - {{area.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal($bvModal.hide('modal-seccion'))"> Cerrar </b-button>
            </b-col>
        </b-row>        
    </b-modal>

</div>
</template>

<script>
export default {
    name: "AreaComponent",
    data(){
        return{
            areas: [],
            area:
            {
                id: '',
                nombre: '',
                Q_Ind: ''
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
        axios.get('/admin/areas/create')
            .then(res=>{
                this.areas = res.data;
            });

        axios.get(`/admin/secciones/create`)
            .then(res=>{
                this.secciones = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.area.nombre.trim() === '' || this.area.Q_Ind === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.area.nombre, Q_Ind: this.area.Q_Ind};

            this.area.nombre = '';
            this.area.Q_Ind = '';

            axios.post(`/admin/areas`, params)
                .then(res=>{
                    this.areas.push(res.data);
                })
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarArea(item)
        {
            const params = {nombre: item.nombre, Q_Ind: item.Q_Ind}
            axios.put(`/admin/areas/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.areas.findIndex(areaBuscar => areaBuscar.id === res.data.id)
                    this.areas[index] = res.data;

                    this.area = {nombre:'', Q_Ind:''};
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
            this.area.nombre = item.nombre;
            this.area.Q_Ind = item.Q_Ind;
            this.area.id = item.id;

            for(var i=0; i<this.secciones.length; i++)
            {
                if(this.secciones[i].area_id === item.id)
                {
                    this.secciones_coincidentes.push(this.secciones[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-seccion', '#btnShow')
        },
        eliminarArea(area, index)
        {
            axios.get(`/admin/secciones/${area.id}`)
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
                                axios.delete(`/admin/areas/${area.id}`)
                                    .then(()=>{
                                        this.areas.splice(index, 1);
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
                        alert("El área tiene secciones relacionadas, no se puede eliminar")
                    }
                })
            
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.area = {nombre: '', Q_Ind: ''};
        },
        cancelarEdicionModal($event)
        {
            this.area = {nombre: '', Q_Ind: ''};
            this.secciones_coincidentes = [];
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.area.nombre = item.nombre;
            this.area.Q_Ind = item.Q_Ind;
            this.area.id = item.id;
        },
        guardarCambios(item, index)
        {
            const params = {nombre: item.nombre, nivel2: item.nivel2, area_id: item.area_id, planta_id: item.planta_id}
            axios.put(`/admin/secciones/${item.id}`, params)
                .then(res=>{
                    const index = this.secciones.findIndex(seccionBuscar => seccionBuscar.id === res.data.id)
                    this.secciones[index] = res.data;
                });
            this.$root.$emit('bv::hide::modal', 'modal-seccion', '#btnShow');
            this.area = {nombre: '', Q_Ind: ''};
            this.secciones_coincidentes = [];
        }
    }
}
</script>