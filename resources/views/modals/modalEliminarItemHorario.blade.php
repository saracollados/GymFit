<div class="modal fade" id="modal-eliminar-horario" tabindex="-1" aria-labelledby="modal-delete-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold">
                @if(isset($clase))
                    <h5 class="modal-title" id="modal-delete-content-label">¿Seguro que quieres eliminar esta clase?</h5>
                @endif
                @if(isset($servicio))
                    <h5 class="modal-title" id="modal-delete-content-label">¿Seguro que quieres eliminar este servicio?</h5>
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-base">
                @if(isset($clase))
                    <table id="horario">
                        <body>
                            <tr class="text-center">
                                <td class="icon"><i class="fa-regular fa-star"></i></td>
                                <td class="icon"><i class="fa-regular fa-calendar"></i></td>
                                <td class="icon"><i class="fa-regular fa-clock"></i></td>
                                <td class="icon"><i class="fa-solid fa-person"></i></td>
                            </tr>
                            <tr class="text-center">
                                <td class="icon">{{$clase->clase_nombre}}</td>
                                <td class="icon">{{$clase->dia_semana_nombre}}</td>
                                <td class="icon">{{$clase->franja_horaria_nombre}}</td>
                                <td class="icon">{{$clase->monitor_nombre}}</td>
                            </tr>
                        </body>
                    </table>

                    <form action="{{route('eliminarClaseHorario')}}" method="POST" autocomplete='off'>
                        @csrf
                        <input type="hidden" name="clase_id" value={{$clase->id}}>
                        <input type="hidden" name="horario_id" value={{$clase->horario_id}}>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-outline-danger">
                                Eliminar
                            </button>
                        </div>
                    </form>
                @endif
                @if(isset($servicio))
                    <table id="horario">
                        <body>
                            <tr class="text-center">
                                <td class="icon"><i class="fa-regular fa-star"></i></td>
                                <td class="icon"><i class="fa-regular fa-calendar"></i></td>
                                <td class="icon"><i class="fa-regular fa-clock"></i></td>
                                <td class="icon"><i class="fa-regular fa-clock"></i></td>
                            </tr>
                            <tr class="text-center">
                                <td class="icon">{{$servicio->role_nombre}}</td>
                                <td class="icon">{{$servicio->profesional_nombre}}</td>
                                <td class="icon">{{$servicio->fecha}}</td>
                                <td class="icon">{{$servicio->franja_horaria_nombre}}</td>
                            </tr>
                        </body>
                    </table>

                    <form action="{{route('eliminarServicioHorario')}}" method="POST" autocomplete='off'>
                        @csrf
                        <input type="hidden" name="servicio_id" value={{$servicio->id}}>
                        <input type="hidden" name="inicioSemana" value={{$inicioSemana}}>

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-outline-danger">
                                Eliminar
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>