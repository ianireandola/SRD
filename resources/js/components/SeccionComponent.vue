<template>
<div>
    <h3 class="text-center mb-3">Gestión de Secciones</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarSeccion(seccion)" v-if="editarActivo" class="mb-5">
        <b-row>
            <b-col >
                <input type="text" class="form-control mb-2" placeholder="Identificador" v-model="seccion.identificador">
            </b-col>
            <b-col>
                <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="seccion.nombre">
            </b-col>
        </b-row>
        <b-form-checkbox v-model="checkbox_nivel2">Nivel 2</b-form-checkbox>
        <b-form-group label="Área relacionada:">
            <b-form-select class="form-control" v-model="area" v-on:change="areaElegida(area)">
                <option v-for="area in areas" v-bind:key="area.id" :value="area">{{area.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <b-form-group label="Planta relacionada:">
            <b-form-select class="form-control mb-2" v-model="planta" v-on:change="plantaElegida(planta)">
                <option v-for="planta in plantas" v-bind:key="planta.id" :value="planta">{{planta.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <b-row>
            <b-col>
                <input type="text" class="form-control mb-2" placeholder="Identificador" v-model="seccion.identificador">
            </b-col>
            <b-col>
                <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="seccion.nombre">
            </b-col>
        </b-row>
        <b-form-checkbox v-model="checkbox_nivel2">Nivel 2</b-form-checkbox>
        <b-form-group label="Área relacionada:">
            <b-form-select class="form-control" v-model="area" v-on:change="areaElegida(area)">
                <option v-for="area in areas" v-bind:key="area.id" :value="area">{{area.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <b-form-group label="Planta relacionada:">
            <b-form-select class="form-control mb-2" v-model="planta" v-on:change="plantaElegida(planta)">
                <option v-for="planta in plantas" v-bind:key="planta.id" :value="planta">{{planta.nombre}}</option>
            </b-form-select>
        </b-form-group>
        <button type="submit" class="btn btn-success btn-block mb-7">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead class="thead-light">
            <tr>
                <th class="text-center" scope="col">IDENTIFICADOR</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">NIVEL 2</th>
                <th scope="col">ÁREA PERTENECIENTE</th>
                <th scope="col">PLANTA PERTENECIENTE</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(seccion, index) in secciones" v-bind:key="index">
                <td class="text-center">{{seccion.identificador}}</td>
                <td>{{seccion.nombre}}</td>
                <td class="text-center">
                    <input class="form-check-input" type="checkbox" v-model="seccion.nivel2" disabled>
                </td>
                <template v-for="area in areas">
                    <td v-if="area.id === seccion.area_id" v-bind:key="`A-${area.id}`">
                        {{area.nombre}}
                    </td>
                </template>
                <template v-for="planta in plantas">
                    <td v-if="planta.id === seccion.planta_id" v-bind:key="`B-${planta.id}`">
                        {{planta.nombre}}
                    </td>
                </template>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(seccion)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarSeccion(seccion, index)" class="btn btn-secondary">Eliminar</button>
                </td>
            </tr>
        </tbody>
    </table>

</div>
</template>

<script>
export default {
    name: "SeccionComponent",
    data(){
        return{
            checkbox_nivel2: false,
            secciones: [],
            seccion:
            {
                id: '',
                identificador: '',
                nombre: '',
                nivel2: '',
                area_id: '',
                area_nombre: '',
                planta_id: '',
                planta_nombre: ''
            },
            areas:[],
            area:
            {
                id:'',
                nombre:''
            },
            plantas:[],
            planta:
            {
                id:'',
                nombre: ''
            },
            editarActivo: false,
            total: 0
        }
    },
    created()
    {
        axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/secciones/create`)
            .then(res=>{
                this.secciones = res.data;               
            });
        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/areas/create')
            .then(res=>{
                this.areas = res.data;
            });
        axios.get('http://localhost/laravel/prueba4/public/index.php/admin/plantas/create')
            .then(res=>{
                this.plantas = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            if(this.checkbox_nivel2 === true)
            {
                this.seccion.nivel2 = 1;
            }else{
                this.seccion.nivel2 = 0;
            }
            if(this.seccion.identificador.trim() === '' || this.seccion.nombre.trim() === '' || this.seccion.area_id === '' || 
                this.seccion.planta_id === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {
                identificador: this.seccion.identificador,
                nombre: this.seccion.nombre, 
                nivel2: this.seccion.nivel2, 
                area_id: this.seccion.area_id, 
                planta_id: this.seccion.planta_id}

            this.seccion.identificador = '',
            this.seccion.nombre = '',
            this.seccion.nivel2 = '',
            this.seccion.area_id = '',
            this.seccion.planta_id = '',
            this.checkbox_nivel2 = false,
            this.area = '',
            this.planta = ''
            
            axios.post('http://localhost/laravel/prueba4/public/index.php/admin/secciones', params)
                .then(res=>{
                    this.secciones.push(res.data);
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Registro realizado',
                showConfirmButton: false,
                timer: 1300})
        },
        editarSeccion(seccion)
        {
            if(this.checkbox_nivel2 === true)
            {
                this.seccion.nivel2 = 1;
            }else{
                this.seccion.nivel2 = 0;
            }
            const params={
                identificador: this.seccion.identificador,
                nombre: this.seccion.nombre, 
                nivel2: this.seccion.nivel2, 
                area_id: this.seccion.area_id, 
                planta_id: this.seccion.planta_id}

            axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/secciones/${seccion.id}`, params)
                .then(res =>{
                    this.editarActivo = false;
                    const index = this.secciones.findIndex(seccionBuscar => seccionBuscar.id === res.data.id)
                    this.secciones[index] = res.data;

                    this.seccion.identificador = '',
                    this.seccion.nombre = '',
                    this.seccion.nivel2 = '',
                    this.seccion.area_id = '',
                    this.seccion.planta_id = '',
                    this.checkbox_nivel2 = false,
                    this.area = '',
                    this.planta = ''
                });
            this.$swal.fire({
                position: 'top-end',
                type: 'success',
                title: 'Modificación realizada',
                showConfirmButton: false,
                timer: 1300})
        },
        areaElegida(item)
        {
            this.seccion.area_id = item.id;
        },
        plantaElegida(item)
        {
            this.seccion.planta_id = item.id;
        },
        editarFormulario(seccion)
        {
            this.editarActivo = true;
            this.seccion.identificador = seccion.identificador;
            this.seccion.nombre = seccion.nombre;
            this.seccion.id = seccion.id;
            this.seccion.descripcion = seccion.descripcion;
            this.seccion.area_id = seccion.area_id;
            this.seccion.planta_id = seccion.planta_id;

            for(var i=0; i<this.plantas.length; i++)
            {
                if(this.plantas[i].id === seccion.planta_id)
                {
                    this.planta = this.plantas[i];
                    this.seccion.planta_id = this.plantas[i].id;
                }
            }
            for(var i=0; i<this.areas.length; i++)
            {
                if(this.areas[i].id === seccion.area_id)
                {
                    this.area = this.areas[i];
                    this.seccion.aread_id = this.areas[i].id;
                }
            }
            
            if(seccion.nivel2 === 1)
            {
                this.checkbox_nivel2 = true;
            }else{
                this.checkbox_nivel2 = false;
            }
        },
        nivel2Modificado()
        {
            if(this.checkbox_nivel2 === false)
            {
                this.checkbox_nivel2 = true;
            }else{
                this.checkbox_nivel2 = false;
            }
        },
        eliminarSeccion(seccion, index)
        {
            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/usuarios/showSeccion/${seccion.id}`)
                .then(res=>{
                    this.total = res.data;
                })
            axios.get(`http://localhost/laravel/prueba4/public/index.php/admin/secciones/showTrabajan/${seccion.id}`)
                .then(res=>{
                    this.total = this.total + res.data;
                    if(this.total === 0)
                    {
                        this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",{
                            okVariant: 'danger',
                            okTitle: 'Eliminar',
                            cancelTitle: 'Cancelar'
                    }).then(value=>{
                        if(value === true)
                        {
                            axios.delete(`http://localhost/laravel/prueba4/public/index.php/admin/secciones/${seccion.id}`)
                                .then(()=>{
                                    this.secciones.splice(index, 1);
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
                    alert("La sección tiene usuarios o proyectos asignados, no se puede eliminar")
                }
            })
        },
        cancelarEdicion()
        {
            this.editarActivo = false;
            this.seccion = { 
                id: '', 
                identificador: '',
                nombre: '',
                nivel2: '', 
                area_id: '', 
                area_nombre: '', 
                planta_id: '', 
                planta_nombre: ''}
            this.area = '',
            this.planta = ''
        }
    }
}
</script>
