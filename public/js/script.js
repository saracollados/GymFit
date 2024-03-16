$(function() {
    // DataTables
    $('.datatable').DataTable({
        "paging": false,    // Habilitar paginación
        "ordering": true,  // Habilitar ordenación
        "searching": true,  // Habilitar búsqueda
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

        if (userType == 'usuario') {
            window.location.href = "/crearReservaClaseForm";
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
                    },
                    success: function(data) {
                        // Actualiza el contenido del modal con las variables
                        $('#reserva-modal-content').empty().append(data);
                        // Muestra el modal
                        $('#modal-usuario-reserva').modal('show');
                    },
                    error: function(error) {
                        console.error('Error en la solicitud Ajax:', error);
                    }
                });
            }
        }
        
    });
    
    $('.reserva-clase').on("click", function(){
        var clase = $(this).data('clase');
        var usuario_id = $(this).data('usuario');
        var reserva = $(this).data('reserva');

        if(clase) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/reservaClaseForm',
                data: {
                    clase: clase,
                    usuario_id: usuario_id,
                    reserva: reserva
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#reserva-clase-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-crear-reserva').modal('show');
                },
                error: function(error) {
                    console.error('Error en la solicitud Ajax:', error);
                }
            });
        }
    });

    $('.eliminar-claseHorario').on("click", function(){
        var object_id = $(this).data('id');

        console.log(object_id);

        if(object_id) {
            $.ajax({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                method: "post",
                url: '/eliminarClaseHorarioForm',
                data: {
                    id: object_id,
                },
                success: function(data) {
                    // Actualiza el contenido del modal con las variables
                    $('#horarioclases-modal-content').empty().append(data);
                    // Muestra el modal
                    $('#modal-eliminar-claseHorario').modal('show');
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

    $('.close-btn').on("click", function() {
        $message = $(this).parent()[0];
        $message.style.display = 'none';
    })
})