<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">Permisos</h4>
                <p class="card-category"> Aquí se administran todos los permisos</p>
              </div>
              <div class="card-body">
                                <div class="row">
                  <div class="col-12 text-right">
                    <a href="#" class="btn btn-sm btn-primary" @click="NewPermission()" >Añadir Permiso</a>
                  </div>
                </div>
                <div class="table-responsive">
                  <table class="table">
                    <thead class=" text-primary">
                        <tr>
                            <th>
                                ID
                            </th>
                            <th>
                            Nombre del permiso
                            </th>
                            <th class="text-right">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- @foreach ($permissions as $permission) -->
                        <tr v-for="permission in permissions" :key="permission.id">
                            <td>
                            {{permission.id}}
                            </td>
                            <td>
                            <!-- {{ $permission->name}} -->
                            {{permission.name}}
                            </td>
                            <td class="td-actions text-right">
                                <button rel="tooltip" class="btn btn-success btn-link" @click="EditPermission(permission)" >
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </button>
                                <button rel="tooltip" class="btn btn-danger btn-link" @click="DeletePermission(permission)">
                                    <i class="material-icons">delete</i>
                                    <div class="ripple-container"></div>
                                </button>
                            </td>
                        </tr>
                        <!-- @endforeach -->
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
        </div>
      </div>
</template>

<script>
    export default {
        data() {
            return {
                permissions:[],
                mensaje: ''
            }            
        },
        methods:{
            getPermissions(){
                let url = '/api/permissions';
                axios.get(url).then(response=>{
                    console.log(response.data);
                    this.permissions=response.data;
                })
            },
            NewPermission(){
                //console.log("nuevo dato");
                Swal.fire({
                title: 'Nombre del permiso',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Crear permiso',
                cancelButtonText: 'Cancelar!',
                html:
                    '<div id="swal2-content" style="display: block;">Puede ser algo simple, como: "editar permisos"</div>' +
                    '<input id="nombre" name="nombre" class="swal2-input" placeholder="" type="text" style="display: flex;">',
                focusConfirm: false,
                preConfirm: async () => {
                    await axios.post('/api/permissions', {
                        name: document.getElementById('nombre').value
                    })
                    .then(function (response) {
                        //console.log(response.data);
                        toastr.success(response.data);
                    })
                    .catch(function (error) {
                        if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        // console.log(error.response.data);
                        // console.log(error.response.status);
                        toastr.error('¡Vaya! Parece que ya existe ese permiso. No se realizaron cambios.', 'Algo salió mal');
                        console.log(error.response.headers);
                        } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        console.log('segundo error');
                        //console.log(error.request);
                        } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log('tercer error');
                        //console.log('Error', error.message);
                        }
                        //console.log(error.config);
                    });
                    this.getPermissions();

                    //return toastr.success(this.mensaje);
                }
                })
                
            },
            DeletePermission(permission){
                console.log(permission);
                Swal.fire({
                    title: 'Estás seguro?',
                    text: "¿Realmente quieres eliminar a "+permission.name+"? ¡Al eliminado es imposible recuperarlo!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, eliminar!',
                    cancelButtonText: 'No, dejalo!'
                    }).then( async (result) => {
                    if (result.value) {
                        await axios.delete('/api/permissions/'+permission.id)
                        .then(function (response) {
                            //console.log(response.data);
                            toastr.success(response.data);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        this.getPermissions();
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        toastr.success(permission.name+' vivirá un día más!');
                    }
                    })
            },
            EditPermission(permission){
                console.log(permission);

                Swal.fire({
                title: 'Editar a '+permission.name,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Realizar cambios!',
                cancelButtonText: 'Cancelar!',
                html:
                    '<div id="swal2-content" style="display: block;">Nombre</div>' +
                    '<input id="nombre" name="nombre" class="swal2-input" placeholder="" type="text" style="display: flex;">',
                focusConfirm: false,
                preConfirm: async () => {
                    await axios.put('/api/permissions/'+permission.id, {
                        name: document.getElementById('nombre').value
                    })
                    .then(function (response) {
                        //console.log(response.data);
                        toastr.success(response.data);
                    })
                    .catch(function (error) {
                        if (error.response) {
                        // The request was made and the server responded with a status code
                        // that falls out of the range of 2xx
                        // console.log(error.response.data);
                        // console.log(error.response.status);
                        toastr.error('¡Vaya! Parece que ya existe ese permiso. No se realizaron cambios.', 'Algo salió mal');
                        //console.log(error.response.headers);
                        } else if (error.request) {
                        // The request was made but no response was received
                        // `error.request` is an instance of XMLHttpRequest in the browser and an instance of
                        // http.ClientRequest in node.js
                        console.log('segundo error');
                        //console.log(error.request);
                        } else {
                        // Something happened in setting up the request that triggered an Error
                        console.log('tercer error');
                        //console.log('Error', error.message);
                        }
                        console.log(error.config);
                    });
                    this.getPermissions();

                    //return toastr.success(this.mensaje);
                }
                })

                document.getElementById('nombre').value = permission.name;
            }
        },
        mounted(){
            this.getPermissions();
        }
    }
</script>