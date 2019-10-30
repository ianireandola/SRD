<template>
<div>
    <h3 class="text-center mb-3">Gestión de Secciones</h3>

    <!--Cuando "editarActivo=true" EDITAR-->
    <form @submit.prevent="editarSeccion(area)" v-if="editarActivo" class="mb-5">
        <div class="row">
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="seccion.nombre">
            </div>
            <div class="col">
                <label class="checkbox" for="Nivel2"> Nivel2   </label>
                <input type="checkbox" id="Nivel2" v-model="seccion.nivel2">
            </div>
            <div class="col">
                <select class="form-control" v-model="seccion.area_id">
                    <option>{{seccion.area_id}}</option>
                </select>
            </div>
            <div class="col">
                <select class="form-control" v-model="seccion.planta_id">
                    <option>{{seccion.planta_id}}</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-block">Guardar</button>
        <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
    </form>

    <!--Cuando "editarActivo=false" AGREGAR -->
    <form @submit.prevent="agregar" v-else class="mb-5">
        <div class="row">
            <div class="col">
                <input type="text" class="form-control mb-2" placeholder="Nombre" v-model="seccion.nombre">
            </div>
            <div class="col">
                <label class="checkbox" for="Nivel2"> Nivel2   </label>
                <input type="checkbox" id="Nivel2" v-model="seccion.nivel2">
            </div>
            <div class="col">
                <select class="form-control" v-model="area" v-on:change="areaElegida(area)">
                    <option v-for="area in areas" v-bind:key="area.id" :value="area">{{area.id}} - {{area.nombre}}</option>
                </select>
            </div>
            <div class="col">
                <select class="form-control" v-model="planta" v-on:change="plantaElegida(planta)">
                    <option v-for="planta in plantas" v-bind:key="planta.id" :value="planta">{{planta.id}} - {{planta.nombre}}</option>
                </select>
            </div>
        </div>
        <button type="submit" class="btn btn-success btn-block mb-7">Agregar</button>
    </form>

    <table class="table table-hover">
        <thead>
            <tr>
                <th class="text-center" scope="col">ID</th>
                <th class="text-center" scope="col">NOMBRE</th>
                <th class="text-center" scope="col">NIVEL 2</th>
                <th class="text-center" scope="col">ÁREA PERTENECIENTE</th>
                <th class="text-center" scope="col">PLANTA PERTENECIENTE</th>
                <th class="text-center" scope="col">OPCIONES</th>
            </tr>
        </thead>
        <tbody>
            <tr v-for="(item, index) in secciones" v-bind:key="index">
                <td class="text-center">{{item.id}}</td>
                <td class="text-center">{{item.nombre}}</td>
                <td class="text-center">{{item.nivel2}}</td>
                <td class="text-center">{{item.area_id}}</td>
                <td class="text-center">{{item.planta_id}}</td>
                <td class="text-center">
                    <button type="button" @click="editarFormulario(item)" class="btn btn-primary">Modificar</button>
                    <button type="button" @click="eliminarArea(item, index)" class="btn btn-secondary">Eliminar</button>
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
            secciones: [],
            seccion:
            {
                id: '',
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
            editarActivo: false
        }
    },
    created()
    {
        console.log('SeccionComponent created')
        axios.get(`/admin/secciones/create`)
            .then(res=>{
                this.secciones = res.data;               
            });
        axios.get('/admin/areas/create')
            .then(res=>{
                this.areas = res.data;
            });
        axios.get('/admin/plantas/create')
            .then(res=>{
                this.plantas = res.data;
            });
    },
    methods:
    {
        agregar()
        {
            console.log(this.area.id);
            if(this.seccion.nombre.trim() === '' || this.area.id === '' || this.planta.id === '')
            {
                alert('Debes completar todos los campos antes de guardar');
                return;
            }
            const params = {nombre: this.seccion.nombre, nivel2: this.seccion.nivel2, area_id: this.area.id, planta_id: this.planta.id}

            this.seccion.nombre = '';
            this.seccion.nivel2 = '',
            this.area.id = '';
            this.planta.id = ''

            axios.post('/admin/secciones', params)
                .then(res=>{
                    this.secciones.push(res.data);
                })
        },
        areaElegida(item)
        {
            this.area = item;
        },
        plantaElegida(item)
        {
            this.planta = item;
        }
    }
}
</script>