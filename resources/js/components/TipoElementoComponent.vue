<template>
<div>
    <h3 class="text-center mb-3">Gestión de Tipos de Elementos</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarTipoElemento(tipo_elemento)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="tipo_elemento.nombre">
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="tipo_elemento.nombre">
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
            <tr v-for="(tipo_elemento, index) in tipo_elementos" v-bind:key="index">
                <td class="text-center">{{tipo_elemento.id}}</td>
                <td class="text-center">{{tipo_elemento.nombre}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(tipo_elemento)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="relacionElementos(tipo_elemento)" class="btn btn-info">Relación con elementos</button>
                    <button type="button" @click="eliminarTipoElemento(tipo_elemento, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

     <b-modal size="xl" id="modal-tipoelemento" ref="btnElemento" hide-footer no-close-on-esc hide-header-close>
        <template v-slot:modal-title>
            Tipo de Elemento a eliminar: <b> {{tipo_elemento.id}} - {{tipo_elemento.nombre}} </b>
        </template>
        <div>
            <p>No se puede eliminar, está relacionado con los siguientes atributos: </p>
        </div>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col">ELEMENTO</th>
                    <th class="text-center" scope="col">ELEGIR OTRO TIPO DE ELEMENTO</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(elemento_coincidente, index) in elementos_coincidentes" v-bind:key="index">
                    <td>{{elemento_coincidente.id}} - {{elemento_coincidente.nombre}}</td>
                    <td class="text-center">
                        <b-form-select v-model="elemento_coincidente.tipoElemento_id" v-on:change="guardarCambios(elemento_coincidente, index)">
                            <option v-for="tipo_elemento in tipo_elementos" v-bind:key="tipo_elemento.id" :value="tipo_elemento.id">{{tipo_elemento.id}} - {{tipo_elemento.nombre}}</option>
                        </b-form-select>
                    </td>
                </tr>
            </tbody>
        </table>
        <b-row>
            <b-col>
                <b-button class="mt-3" block @click="cancelarEdicionModal($bvModal.hide('modal-tipoelemento'))"> Cerrar </b-button>
            </b-col>
        </b-row>        
    </b-modal>

</div> 

</template>
<script>
export default {
    name: "TipoElementoComponent",
    data(){
        return{
            tipo_elementos: [],
            tipo_elemento:
            {
                id: '',
                nombre: ''
            },
            editarActivo: false,
            elementos: [],
            elemento:
            {
                id: '',
                nombre: '',
                descripcion: '',
                estado: '',
                tipoElemento_id: '', 
                proyecto_id: ''
            },
            elementos_coincidentes: [],
            elemento_coincidente:
            {
                id: '',
                nombre: '',
                descripcion: '',
                estado: '',
                tipoElemento_id: '', 
                proyecto_id: '' 
            },
            total: 0
        }
    },
    created()
    {
        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/tipo_elementos/create')
            .then(res=>{
                this.tipo_elementos = res.data;
            });
        axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/elementos/create`)
            .then(res=>{
                this.elementos = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.tipo_elemento.nombre.trim() === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.tipo_elemento.nombre};

            this.tipo_elemento.nombre = '';

            axios.post(`http://localhost/laravel/prueba4/public/index.php/admin/tipo_elementos`, params)
                .then(res=>{
                    this.tipo_elementos.push(res.data);
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300});
        },
        editarTipoElemento(tipo_elemento)
        {
            const params = {nombre: tipo_elemento.nombre}
            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/tipo_elementos/${tipo_elemento.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.tipo_elementos.findIndex(tipoElementoBuscar => tipoElementoBuscar.id === res.data.id)
                    this.tipo_elementos[index] = res.data;

                    this.tipo_elemento = {nombre:''};
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Modificación realizada',
                showConfirmButton: false,
                timer: 1300})
        },
        relacionElementos(tipo_elemento)
        {
            this.tipo_elemento.nombre = tipo_elemento.nombre;
            this.tipo_elemento.id = tipo_elemento.id;
            
            for(var i=0; i<this.elementos.length; i++)
            {
                if(this.elementos[i].tipoElemento_id === tipo_elemento.id)
                {
                    this.elementos_coincidentes.push(this.elementos[i]);
                }
            }
            this.$root.$emit('bv::show::modal', 'modal-tipoelemento', '#btnShow')
        },
        eliminarTipoElemento(tipo_elemento, index)
        {
            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/elementos/${tipo_elemento.id}`)
                .then(res=>{
                    this.total = res.data;
                });
            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/tipo_elementos/${tipo_elemento.id}`)
                .then(res=>{
                    this.total = this.total + res.data;
                    if(this.total ===0)
                    {
                        this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                            okVariant: 'danger',
                            okTitle: 'Eliminar',
                            cancelTitle: 'Cancelar'
                    }).then(value=>{
                        if(value === true)
                        {
                            axios.delete(`http://localhost/laravel/prueba4/public/index.php/admin/tipo_elementos/${tipo_elemento.id}`)
                                .then(()=>{
                                    this.tipo_elementos.splice(index, 1);
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
                    alert("El tipo de elemento tiene elementos o proyectos asignados, no se puede eliminar")
                }
            })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.tipo_elemento = {nombre: ''};
        },
        cancelarEdicionModal($event)
        {
            this.tipo_elemento = {nombre: ''};
            this.elementos_coincidentes = [];
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.tipo_elemento.nombre = item.nombre;
            this.tipo_elemento.id = item.id;
        },
        guardarCambios(elemento_coincidente, index)
        {
            const params= {tipoElemento_id: elemento_coincidente.tipoElemento_id}
            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/elementos/tipoElementoUpdate/${elemento_coincidente.id}`, params)
                .then(res =>{
                    const index = this.elementos.findIndex(elementoBuscar => elementoBuscar.id === res.data.id)
                    this.elementos[index] = res.data;
                });
            this.$root.$emit('bv::hide::modal', 'modal-tipoelemento', '#btnShow');
            this.tipo_elemento = { nombre: ''};
            this.elementos_coincidentes = [];
        }
    }
}
</script>