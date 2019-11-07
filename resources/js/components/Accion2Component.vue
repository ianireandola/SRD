<template>
<div>
    <h3 class="text-center mb-3">Gestión de Acciones de nivel 2</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarAccion2(accion2)" v-if="editarActivo" class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="accion2.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="accion2.descripcion"/>
        <b-form-group label="Proyecto relacionado:">
            <b-form-select v-model="proyecto" v-on:change="asignarProyecto(proyecto)">
                <option v-for="proyecto in proyectos" v-bind:key="proyecto.id" :value="proyecto">{{proyecto.id}} - {{proyecto.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="accion2.nombre">
        <textarea class="form-control mb-2" placeholder="Descripcion" rows="3" v-model="accion2.descripcion"/>
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
                <th class="text-center" scope="col" width="3%">ID</th>
                <th scope="col" width="25%">NOMBRE</th>
                <th scope="col" width="30%">PROYECTO PERTENECIENTE</th>
                <th class="text-center" scope="col" width="10%">DESCRIPCION</th>
                <th class="text-center" scope="col" width="32%" >OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(accion2, index) in accion2s" v-bind:key="index">
                <td class="text-center">{{accion2.id}}</td>
                <td>{{accion2.nombre}}</td>
                <!--<template v-for="proyecto in proyectos">
                    <td v-if="proyecto.id === accion2.proyecto_id" v-bind:key="`A-${proyecto.id}`">
                        {{proyecto.nombre}}
                    </td>
                </template>-->
                <td>{{accion2.nombre_proyecto}}</td>
                <td class="text-center">{{accion2.descripcion}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(accion2)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarAccion2(accion2, index)" class="btn btn-secondary">Eliminar</button>
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
                nombre: '',
                descripcion: ''
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
            const params = {nombre: item.nombre, descripcion: item.descripcion, proyecto_id: this.accion2.proyecto_id}
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
            axios.get(`/srd_proyectos/showAccion2/${accion2.id}`)
                .then(res=>{
                    if(res.data===0)
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
                    }else{
                        alert("La accion nivel 2 tiene horas de trabajadores asignadas, no se puede eliminar")
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
            console.log('entro' + item.nombre_proyecto);
            this.editarActivo = true;
            this.accion2.nombre = item.nombre;
            this.accion2.descripcion = item.descripcion;
            this.accion2.id = item.id;

            for(var i=0; i<this.proyectos.length; i++)
            {
                if(this.proyectos[i].nombre === item.nombre_proyecto)
                {
                    this.proyecto = this.proyectos[i];
                    this.accion2.proyecto_id = this.proyectos[i].id;
                    this.accion2.nombre_proyecto = this.proyectos[i].nombre;
                }
            }
        },
        asignarProyecto(item)
        {
            this.accion2.proyecto_id = item.id;
            this.accion2.nombre_proyecto = item.nombre;
        }
    }
}
</script>