<template>
<div>
    <h3 class="text-center mb-3">Gestión de Acciones de nivel 2</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarAccion2(accion2)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="accion2.nombre">
        <input type="text" class="form-control mb-2" placeholder="Descripcion" v-model="accion2.descripcion">
        <b-form-group label="Proyecto relacionado:">
            <b-form-select v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="accion2.nombre">
        <input type="text" class="form-control mb-2" placeholder="Descripcion" v-model="accion2.descripcion">
        <b-form-group label="Proyecto relacionado:">
            <b-form-select v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block mb-7 md-2">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">PROYECTO PERTENECIENTE</th>
                <th class="text-center" scope="col">DESCRIPCION</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in accion2s" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td>{{item.nombre}}</td>
                <td>{{item.nombre_proyecto}}</td>
                <td class="text-center">{{item.descripcion}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarAccion2(item, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>
</template>

<script>
export default {
    name: "Accion2Component",
    data(){
        return{
            accion2s: [],
            accion2:
            {
                id: '',
                nombre: '',
                descripcion: '',
                proyecto_id: '',
                nombre_proyecto: ''
            },
            proyectos: [],
            proyecto:
            {
                id: '',
                proyectoPadre_id: '',
                nombre: '',
                descripcion: '',
                estado: '',
                cantidadActual: '',
                cantidadTotal: '',
                Ed_PF: '',
                ultimaRevision: '',
                fabricacion: ''
            },
            editarActivo: false
        }
    },
    created()
    {
        axios.get('/admin/accion2s/create')
            .then(res=>{
                this.accion2s = res.data;
            });

        axios.get('/admin/proyectos/create')
            .then(res =>{
                this.proyectos = res.data;
            })
    },
    methods:
    {
        agregar()
        {
            if(this.accion2.nombre.trim() === '' || this.accion2.proyecto_id === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.accion2.nombre, descripcion: this.accion2.descripcion, proyecto_id: this.accion2.proyecto_id, nombre_proyecto: this.accion2.nombre_proyecto};

            axios.post(`/admin/accion2s`, params)
                .then(res=>{
                    this.accion2s.push(res.data);
                });

            this.accion2.nombre = '';
            this.accion2.descripcion = '';
            this.accion2.proyecto_id = '';
            this.accion2.nombre_proyecto = '';
            this.proyecto = '';

            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado!',
                showConfirmButton: false,
                timer: 1500
            })
        },
        editarAccion2(item)
        {
            const params = {nombre: item.nombre, descripcion: item.descripcion, proyecto_id: this.accion2.proyecto_id, nombre_proyecto: this.accion2.nombre_proyecto}
            axios.put(`/admin/accion2s/${item.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.accion2s.findIndex(accion2Buscar => accion2Buscar.id === res.data.id)
                    this.accion2s[index] = res.data;

                    this.accion2 = {nombre:'', descripcion:'', proyecto_id: '', nombre_proyecto: ''};
                    this.proyecto = '';
                })
        },
        eliminarAccion2(accion2, index)
        {
            this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                okVariant: 'danger',
                okTitle: 'Eliminar',
                cancelTitle: 'Cancelar'
            }).then(value=>{
                if(value === true)
                {
                    axios.delete(`/admin/accion2s/${accion2.id}`)
                        .then(()=>{
                            this.accion2s.splice(index, 1);
                        })
                }
            })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.accion2 = {nombre: '', descripcion: ''};
        },
        editarFormulario(item)
        {
            this.editarActivo = true;
            this.accion2.nombre = item.nombre;
            this.accion2.descripcion = item.descripcion;
            this.accion2.id = item.id;
        },
        asignarProyecto(item)
        {
            console.log("Asigno a accion2.proyecto_id: " + item.id);
            this.accion2.proyecto_id = item.id;
            this.accion2.nombre_proyecto = item.nombre;

            console.log("Proyecto asignado: " + this.accion2.proyecto_id)
        }
    }
}
</script>