$(function() {
    // DataTables
    $('.datatable').DataTable({
        "paging": false,    
        "ordering": true,  
        "searching": true,
        language: {
            search: 'Buscar:'
        }
    });

    $('#reservasClases-table').DataTable({
        "paging": false,   
        "ordering": true,  
        "searching": true,
        "order": [[1, "desc"], [2, "desc"]], 
        language: {
            search: 'Buscar:'
        }
    });

    $('#reservasServicios-table').DataTable({
        "paging": false,   
        "ordering": true,  
        "searching": true,
        "order": [[6, "desc"], [1, "desc"]], 
        language: {
            search: 'Buscar:'
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

    $('.reservaUsuario').on("click", function(){
        var object = $(this).data('object');
        var userInfo = JSON.parse($(this).attr('data-userinfo')); 
        var userType = $(this).data('usertype');
        var type = $(this).data('type');

        if (userType == 'usuario') {
            if (type == 'clase') {
                window.location.href = "/crearReservaClaseForm";
            }
            if (type == 'servicio') {
                window.location.href = "/crearReservaServicioForm";
            }
        } else { // ToDo: AQUI HABRIA QUE DIFERENCIAR TAMBIEN AL PERSONAL QUE NO ES ADMINISTRADOR, HABRIA QUE RESTRINGIR TODAS LAS RUTAS DE CLASES, YA
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
        }
        
    });
    
    $('.reserva-item').on("click", function(){
        var item = $(this).data('item');
        var usuario_id = $(this).data('usuario');
        var reserva = $(this).data('reserva');
        var fecha = $(this).data('fecha');
        var type = $(this).data('type');

        if(item) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/reservaClaseForm',
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
})