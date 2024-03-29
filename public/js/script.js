$(function() {
    // DataTables
    $('.datatable').DataTable({
        "paging": false,    
        "ordering": true,  
        "searching": true,
        language: {
            search: 'Buscar:',
            sZeroRecords: 'No se encontraron registros coincidentes'
        }
    });

    $('#reservasClases-table').DataTable({
        "paging": false,   
        "ordering": true,  
        "searching": true,
        "order": [[1, "desc"], [2, "desc"]], 
        language: {
            search: 'Buscar:',
            sZeroRecords: 'No se encontraron registros coincidentes'
        }
    });

    $('#reservasServicios-table').DataTable({
        "paging": false,   
        "ordering": true,  
        "searching": true,
        "order": [[6, "desc"], [1, "desc"]], 
        language: {
            search: 'Buscar:',
            sZeroRecords: 'No se encontraron registros coincidentes'
        }
    });
    

    // Duplicar Horario Modal
    $('.duplicar-horario').on("click", function(){
        var object = $(this).data('object');
        var object_id = $(this).data('id');
        
        if(object) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/duplicarHorarioForm',
                data: {
                    id: object_id,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#horario-modal-content').empty().append(data);

                    // Muestra el modal
                    $('#modal-duplicar-'+object).modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.crear-horario').on("click", function(){
        var object = $(this).data('object');

        if(object) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/crearHorarioForm',
                data: {
                    object: object,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#horario-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-crear-horario').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.editar-horario').on("click", function(){
        var object_id = $(this).data('id');

        if(object_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/editarHorarioModal',
                data: {
                    id: object_id,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#horario-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-editar-horario').modal('show');

                    // Espera a que el modal se muestre completamente
                    $('#modal-editar-horario').on('shown.bs.modal', function (e) {
                        $('#fecha_desde').on('change', function() {
                            console.log($('#fecha_desde').val());
                            if ($(this).val() !== '' && $('#fecha_hasta').val() === '') {
                                $('#fecha_hasta').prop('required', true);
                                console.log('Hasta requiered');
                            }
                            if ($(this).val() === '' && $('#fecha_hasta').val() !== '') {
                                console.log('desde requiered');
                                $(this).prop('required', true);
                            }
                            if ($(this).val() === '' && $('#fecha_hasta').val() === '') {
                                $(this).prop('required', false);
                                $('#fecha_hasta').prop('required', false);
                                console.log('hasta no requiered');
                                console.log('desde no requiered');
                            }
                        });

                        $('#fecha_hasta').on('change', function() {
                            console.log($('#fecha_desde').val());
                            console.log($('#fecha_hasta').val());
                            if ($(this).val() !== '' && $('#fecha_desde').val() === '') {
                                $('#fecha_desde').prop('required', true);
                                console.log('desde requiered');
                            }
                            if ($(this).val() === '' && $('#fecha_desde').val() !== '') {
                                $(this).prop('required', true);
                                console.log('hasta requiered');
                            }
                            if ($(this).val() === '' && $('#fecha_desde').val() === '') {
                                $(this).prop('required', false);
                                $('#fecha_desde').prop('required', false);
                                console.log('hasta no requiered');
                                console.log('desde no requiered');
                            }
                        });
                    });
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.reservaUsuario').on("click", function(){
        var object = $(this).data('object');
        var type = $(this).data('type');
        
        if(object) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/usuarioReservaForm',
                data: {
                    object: object,
                    tipo: type,
                },
                success: function(data) {
                    $('#reserva-modal-content').empty().append(data);
                    $('#modal-usuario-reserva').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });
    
    $('.reserva-item').on("click", function(){
        var item = $(this).data('item');
        var usuario_id = $(this).data('usuario');
        var reserva = $(this).data('reserva');
        var fecha = $(this).data('fecha');
        var type = $(this).data('type');

        if (type == 'clase') {
            url = '/reservaClaseForm';
        }
        if (type == 'servicio') {
            url = '/reservaServicioForm';
        }
        if(item) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: url,
                data: {
                    item: item,
                    usuario_id: usuario_id,
                    reserva: reserva,
                    fecha: fecha,
                    type: type
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#reserva-item-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-crear-reserva').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.reserva-item-list').on("click", function(){
        var reserva_id = $(this).data('id');
        var type = $(this).data('type');

        if(type == 'clases') {
            url = '/eliminarReservaClaseForm'
        }
        if (type == 'servicios') {
            url = '/eliminarReservaServicioForm'
        }

        if(reserva_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: url,
                data: {
                    reserva_id: reserva_id,
                    type: type
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#reserva-item-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-eliminar-reserva-list').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.eliminar-itemHorario').on("click", function(){
        var object_id = $(this).data('id');
        var type = $(this).data('type');
        var fecha = $(this).data('fecha');

        if (type == 'clase') {
            url = '/eliminarClaseHorarioForm';
        } 
        
        if (type == 'servicio') {
            url = '/eliminarServicioHorarioForm';
        }

        if(object_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: url,
                data: {
                    id: object_id,
                    fecha: fecha,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#horario-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-eliminar-horario').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.eliminar-horario').on("click", function(){
        var object_id = $(this).data('id');

        if(object_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/eliminarHorarioForm',
                data: {
                    id: object_id,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#horario-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-eliminar-horario').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.eliminar-clase').on("click", function(){
        var object_id = $(this).data('id');

        if(object_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/eliminarClaseForm',
                data: {
                    id: object_id,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#clase-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-eliminar-clase').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.eliminar-sala').on("click", function(){
        var object_id = $(this).data('id');

        if(object_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/eliminarSalaForm',
                data: {
                    id: object_id,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#sala-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-eliminar-sala').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.eliminar-usuario').on("click", function(){
        var object_id = $(this).data('id');
        var page = $(this).data('page');

        if(page == 'usuarios') {
            url = '/eliminarUsuarioForm';
        }
        if(page == 'personal') {
            url = '/eliminarPersonalForm';
        }

        if(object_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: url,
                data: {
                    id: object_id,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#usuario-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-eliminar-usuario').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.close-btn').on("click", function() {
        $message = $(this).parent()[0];
        $message.style.display = 'none';
    })

    // Menú nav
    var currentUrl = window.location.pathname;
    
    var secondSlashIndex = currentUrl.indexOf('/', currentUrl.indexOf('/') + 1);
    if (secondSlashIndex !== -1) {
        var newPath = currentUrl.substring(0, secondSlashIndex);
        currentUrl = newPath;
    }

    const routes = {
        dashboard: [
            '/dashboard',
        ],
        usuarios: [
            '/mostrarUsuarios',
            '/crearUsuarioForm',
            '/crearUsuario',
            '/eliminarUsuarioForm',
            '/eliminarUsuario',
            '/restablecerContraseñaUsuario',
            '/editarPerfilUsuario',
            '/editarUsuario',
            '/miPerfilUsuario',
            '/verUsuario'
        ],
        personal: [
            '/mostrarPersonal',
            '/crearPersonalForm',
            '/crearPersonal',
            '/eliminarPersonalForm',
            '/eliminarPersonal',
            '/restablecerContraseñaPersonal',
            '/editarPerfilPersonal',
            '/editarPersonal',
        ],
        salas: [
            '/mostrarSalas',
            '/crearSalaForm',
            '/crearSala',
            '/editarSala',
            '/editarSala',
            '/eliminarSalaForm',
            '/eliminarSala'
        ],
        clases: [
            '/mostrarClases',
            '/crearClaseForm',
            '/crearClase',
            '/eliminarClaseForm',
            '/eliminarClase',
            '/editarClase',
            '/editarClase'
        ],
        horarios: [
            '/mostrarHorarios',
            '/crearHorarioForm',
            '/crearHorario',
            '/duplicarHorarioForm',
            '/duplicarHorario',
            '/editarHorario',
            '/editarHorarioForm',
            '/eliminarHorarioModal',
            '/eliminarHorarioForm',
            '/eliminarHorario',
            '/guardarHorario',
            '/verHorario'
        ],
        servicios: [
            '/mostrarHorariosServicios',
            '/crearServicioHorario',
            '/eliminarServicioHorarioForm',
            '/eliminarServicioHorario'
        ],
        reservas: [
            '/usuarioReservaForm',
            '/mostrarReservasClases',
            '/crearReservaClaseForm',
            '/reservaClaseForm',
            '/crearReservaClase',
            '/eliminarReservaClase',
            '/eliminarReservaClaseForm',
            '/eliminarReservaClaseList',
            '/mostrarReservasServicios',
            '/crearReservaServicioForm',
            '/reservaServicioForm',
            '/crearReservaServicio',
            '/eliminarReservaServicio',
            '/eliminarReservaServicioForm',
            '/eliminarReservaServicioList'
        ],
        perfil: [
            '/editarPerfilUsuario',
            '/editarUsuario',
            '/miPerfilUsuario',
            '/verUsuario',
            '/editarPersonal',
            '/editarMiPerfil',
            '/miPerfilPersonal',
        ]
    };

    function isActiveGroup(groupUrls) {
        return groupUrls.some(function(url) {
            return currentUrl.startsWith(url);
        });
    }

    const enlacesMenu = document.querySelectorAll('nav li a');
    enlacesMenu.forEach(enlace => {
        enlace.classList.remove('active');
    });


    for (const grupo in routes) {
        if (routes[grupo].includes(currentUrl)) {
            const enlacesMenu = document.querySelectorAll(`nav li a[href^="${routes[grupo][0]}"]`);
    
            // Iterar sobre cada enlace y agregar la clase "active"
            const enlacesGrupo = document.querySelectorAll(`.${grupo}`);
            enlacesGrupo.forEach(enlace => {
                enlace.classList.add('active');
            });
        }
    }
})