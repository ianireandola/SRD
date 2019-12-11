<template>
    <div>
        <h3 class="text-center mb-3">Gestión de Avances de Proyecto</h3>

        <!--Cuando "editarActivo=true" EDITAR-->
        <form @submit.prevent="editarAvance()" v-if="editarActivo" class="mb-5">
            <b-form-group label="Proyecto Padre:">
                <b-form-select v-model="proyecto_padre" v-on:change="asignarProyectoPadre(proyecto_padre)">
                    <option v-for="proyecto_padre in proyectos_padre" v-bind:key="proyecto_padre.id" :value="proyecto_padre">{{proyecto_padre.id}} - {{proyecto_padre.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <b-form-group label="Hito:">
                <b-form-select class="form-control" v-model="hito" v-on:change="asignarHito(hito)">
                    <option v-for="hito in hitos" v-bind:key="hito.id" :value="hito">{{hito.id}} - {{hito.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <b-form-input class="mb-4" type="number" v-model="avance.NTP" placeholder="NTP"/>
            <button type="submit" class="btn btn-success btn-block">Guardar</button>
            <button class="btn btn-danger btn-block mb-7" type="submit" @click="cancelarEdicion()">Cancelar</button>
        </form>

        <!--Cuando "editarActivo=false" AGREGAR -->
        <form @submit.prevent="agregar" v-else class="mb-5">
            <b-form-group label="Proyecto Padre:">
                <b-form-select v-model="proyecto_padre" v-on:change="asignarProyectoPadre(proyecto_padre)">
                    <option v-for="proyecto_padre in proyectos_padre" v-bind:key="proyecto_padre.id" :value="proyecto_padre">{{proyecto_padre.id}} - {{proyecto_padre.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <b-form-group label="Hito:">
                <b-form-select class="form-control" v-model="hito" v-on:change="asignarHito(hito)">
                    <option v-for="hito in hitos" v-bind:key="hito.id" :value="hito">{{hito.id}} - {{hito.nombre}}</option>
                </b-form-select>
            </b-form-group>
            <b-form-input class="mb-4" type="number" v-model="avance.NTP" placeholder="NTP"/>
            <button type="submit" class="btn btn-success btn-block mb-7 md-2">Agregar</button>
        </form>
        <table class="table table-hover">
            <thead class="thead-light">
                <tr>
                    <th class="text-center" scope="col" width="37,5%">PROYECTO PADRE</th>
                    <th class="text-center" scope="col" width="37,5%">HITO</th>
                    <th class="text-center" scope="col" width="5%">NTP</th>
                    <th class="text-center" scope="col" width="20%">OPCIONES</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="(avance, index) in avances" v-bind:key="index">
                    <template v-for="proyecto_padre in proyectos_padre">
                        <td v-if="proyecto_padre.id === avance.proyectoPadre_id" v-bind:key="`B-${proyecto_padre.id}`">
                            {{proyecto_padre.nombre}}
                        </td>
                    </template>
                    <template v-for="hito in hitos">
                        <td v-if="hito.id === avance.hito_id" v-bind:key="`A-${hito.id}`">
                            {{hito.nombre}}
                        </td>
                    </template>
                    <td>{{avance.NTP}}</td>
                    <td class="text-center">
                        <button type="button" @click="editarFormulario(avance)" class="btn btn-primary">Modificar</button>
                        <button type="button" @click="eliminarAvance(avance, index)" class="btn btn-secondary">Eliminar</button>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
</template>

<script>
    export default  {
        name: "AvanceComponent",
        data()
        {
            return{
                avances: [],
                avance:
                {
                    id: '',
                    hito_id: '',
                    proyectoPadre_id: '', 
                    NTP: ''
                },
                hitos: [],
                hito:
                {
                    id: '',
                    nombre: '',
                    descripcion: '',
                    fase_id: ''
                },
                proyectos_padre: [],
                proyecto_padre:
                {
                    id: '',
                    nombre: '', 
                    descripcion: '', 
                    estado: '',
                    Q_Proyecto: '',
                    planificacion: '',
                    safety: '',
                    homologaciones: '',
                    tipoProyecto_id: '',
                    nacion_id: '',
                    dedicacion_id: ''
                },
                editarActivo: false
            }
        },
        created()
        {
            axios.get('http://localhost/laravel/prueba4/public/index.php/admin/avance_proyectos/create')
                .then(res=>{
                    this.avances = res.data;
                });
            axios.get('http://localhost/laravel/prueba4/public/index.php/admin/hitos/create')
                .then(res=>{
                    this.hitos = res.data;
                }); 
            axios.get('http://localhost/laravel/prueba4/public/index.php/admin/proyectospadre/create')
                .then(res=>{
                    this.proyectos_padre = res.data;
                });        
        },
        methods:
        {
            agregar()
            {
                if(this.avance.proyectoPadre_id === '' || this.avance.hito_id === '' || this.avance.NTP === '')
                {
                    alert('Debes completar todos los campos antes de guardar');
                    return;
                }
                const params = { hito_id: this.avance.hito_id, proyectoPadre_id: this.avance.proyectoPadre_id, NTP: this.avance.NTP }

                this.avance.hito_id = '',
                this.avance.proyectoPadre_id = '',
                this.avance.NTP = '',
                this.proyecto_padre = '',
                this.hito = ''

                axios.post(`http://localhost/laravel/prueba4/public/index.php/admin/avance_proyectos`, params)
                    .then(res=>{
                        this.avances.push(res.data);
                    });
                this.$swal.fire({
                    position: 'top-end',
                    type: 'success',
                    title: 'Registro realizado',
                    showConfirmButton: false,
                    timer: 1300})
            },
            asignarProyectoPadre(proyecto_padre)
            {
                this.avance.proyectoPadre_id = proyecto_padre.id;
            },
            asignarHito(hito)
            {
                this.avance.hito_id = hito.id;
            },
            editarFormulario(avance)
            {
                this.editarActivo = true;
                this.avance.hito_id = avance.hito_id;
                this.avance.id = avance.id;
                this.avance.proyectoPadre_id = avance.proyectoPadre_id;
                this.avance.NTP = avance.NTP;

                for(var i=0; i<this.hitos.length; i++)
                {
                    if(this.hitos[i].id === avance.hito_id)
                    {
                        this.hito = this.hitos[i];
                        this.avance.hito_id = this.hitos[i].id;
                    }
                }

                for(var i=0; i<this.proyectos_padre.length; i++)
                {
                    if(this.proyectos_padre[i].id === avance.proyectoPadre_id)
                    {
                        this.proyecto_padre = this.proyectos_padre[i];
                        this.avance.proyectoPadre_id = this.proyectos_padre[i].id;
                    }
                }
            },
            editarAvance()
            {
                const params = {
                    id: this.avance.id,
                    hito_id: this.avance.hito_id,
                    proyectoPadre_id: this.avance.proyectoPadre_id,
                    NTP: this.avance.NTP }
                
                axios.put(`http://localhost/laravel/prueba4/public/index.php/admin/avance_proyectos/${this.avance.id}`, params)
                    .then(res=>{
                        this.editarActivo = false;
                        const index = this.avances.findIndex(avanceBuscar => avanceBuscar.id === res.data.id)
                        this.avances[index] = res.data;

                        this.avance.hito_id = '',
                        this.avance.proyectoPadre_id = '',
                        this.avance.NTP = '',
                        this.proyecto_padre = '',
                        this.hito = ''
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
                this.avance.hito_id = '',
                this.avance.proyectoPadre_id = '',
                this.avance.NTP = '',
                this.hito = '',
                this.proyecto_padre = ''
            },
            eliminarAvance(avance, index)
            {
                this.$bvModal.msgBoxConfirm("¿Quiere eliminar?",
                {
                    okVariant: 'danger',
                    okTitle: 'Eliminar',
                    cancelTitle: 'Cancelar'
                }).then(value=>
                {
                    if(value === true)
                    {
                        axios.delete(`http://localhost/laravel/prueba4/public/index.php/admin/avance_proyectos/${avance.id}`)
                            .then(()=>
                            {
                                this.avances.splice(index, 1);
                            });
                        this.$swal.fire({
                            position: 'top-end',
                            type: 'success',
                            title: 'Eliminado',
                            showConfirmButton: false,
                            timer: 1300})
                    }
                })
                
            }
        }
    }
</script>