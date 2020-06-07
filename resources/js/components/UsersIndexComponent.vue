<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
              <div class="card-header card-header-primary">
                <h4 class="card-title ">Usuarios</h4>
                <p class="card-category"> Aquí se administran todos los usuarios</p>
              </div>
              <div class="card-body">
                                <div class="row">
                  <div class="col-12 text-right">
                    <a href="#" class="btn btn-sm btn-primary" @click="NewUser()" >Añadir usuario</a>
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
                            Nombre
                            </th>
                            <th>
                                Email
                            </th>
                            <th class="text-right">
                                Acciones
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <!-- @foreach ($users as $user) -->
                        <tr v-for="user in users" :key="user.id">
                            <td>
                                {{user.id}}
                            </td>
                            <td>
                            <!-- {{ $user->name}} -->
                            {{user.name}}
                            </td>
                            <td>
                            <!-- {{ $user->email }} -->
                            {{user.email}}
                            </td>
                            <td class="td-actions text-right">
                                <button rel="tooltip" class="btn btn-success btn-link" @click="EditUser(user)" >
                                    <i class="material-icons">edit</i>
                                    <div class="ripple-container"></div>
                                </button>
                                <button rel="tooltip" class="btn btn-danger btn-link" @click="DeleteUser(user)">
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
                users:[],
                mensaje: ''
            }            
        },
        methods:{
            getUsers(){
                let url = '/api/users';
                axios.get(url).then(response=>{
                    // console.log(response.data);
                    this.users=response.data;
                })
            },
            NewUser(){
                //console.log("nuevo dato");
                Swal.mixin({
                    input: 'text',
                    confirmButtonText: 'Next &rarr;',
                    showCancelButton: true,
                    progressSteps: ['1', '2', '3']
                    }).queue([
                    {
                        title: 'Escribe el nombre:',
                        text: 'Nombres y apellidos',
                        input: 'text',
                        inputValidator: (value) => {
                            if (!value) {
                                toastr.error('Es indispensable el nombre!', 'Error');
                            return 'Es indispensable el nombre!'
                            }
                        }
                    },
                    {
                        title: 'Escribe el correo:',
                        text: 'ejemplo: usuario@ejemplo.com',
                        input: 'email',
                        inputValidator: (value) => {
                            if (!value) {
                                toastr.error('Es indispensable el correo!', 'Error');
                            return 'Es indispensable el correo!'
                            }
                        }
                    },
                    {
                        title: 'Escribe la contraseña:',
                        text: 'Ésta deberá cambiarse despues',
                        input: 'password',
                        inputValidator: (value) => {
                            if (!value) {
                                toastr.error('Es indispensable el password!', 'Error');
                            return 'Es indispensable el password!'
                            }
                        }
                    },
                    ]).then( async (result) => {
                    if (result.value) {
                        await axios.post('/api/users', {
                            name: result.value[0],
                            email: result.value[1],
                            password: result.value[2],
                        })
                        .then(function (response) {
                            //console.log(response.data);
                            toastr.success(response.data);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });

                        this.getUsers();                      
                        
                    }
                })
            },
            DeleteUser(user){
                console.log(user);
                Swal.fire({
                    title: 'Estás seguro?',
                    text: "¿Realmente quieres eliminar a "+user.name+"? ¡Al eliminado es imposible recuperarlo!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Si, eliminar!',
                    cancelButtonText: 'Que viva un día más!'
                    }).then( async (result) => {
                    if (result.value) {
                        await axios.delete('/api/users/'+user.id)
                        .then(function (response) {
                            //console.log(response.data);
                            toastr.success(response.data);
                        })
                        .catch(function (error) {
                            console.log(error);
                        });
                        this.getUsers();

                        Swal.fire(
                        'Eliminado!',
                        'Ya no sabremos más de '+user.name,
                        'success'
                        )
                    } else if (result.dismiss === Swal.DismissReason.cancel) {
                        toastr.success(user.name+' vivirá un día más!');
                    }
                    })
            },
            EditUser(user){
                console.log(user);

                Swal.fire({
                title: 'Editar a '+user.name,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Realizar cambios!',
                cancelButtonText: 'Cancelar!',
                html:
                    '<div id="swal2-content" style="display: block;">Nombre</div>' +
                    '<input id="nombre" name="nombre" class="swal2-input" placeholder="" type="text" style="display: flex;">' +
                    '<div id="swal2-content" style="display: block;">Correo electrónico</div>' +
                    '<input id="email" name="email" class="swal2-input" placeholder="" type="email" style="display: flex;">',
                focusConfirm: false,
                preConfirm: async () => {
                    await axios.put('/api/users/'+user.id, {
                        name: document.getElementById('nombre').value,
                        email: document.getElementById('email').value
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
                        toastr.error('¡Vaya! Parece que alguien ya tiene ese correo. No se realizaron cambios.', 'Algo salió mal');
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
                    this.getUsers();

                    //return toastr.success(this.mensaje);
                }
                })

                document.getElementById('nombre').value = user.name;
                document.getElementById('email').value = user.email;
            }
        },
        mounted(){
            this.getUsers();
        }
    }
</script>