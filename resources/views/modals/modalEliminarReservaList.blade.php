<div class="modal fade" id="modal-eliminar-reserva-list" tabindex="-1" aria-labelledby="modal-delete-content-label" aria-hidden="true">
    <div class="modal-dialog modal-lg text-xs">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold">
                <h5 class="modal-title" id="modal-delete-content-label">¿Seguro que quieres eliminar esta reserva?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-base text-center">
                @if ($type == 'clases')
                    <table id="horario" style="margin: 0 auto;">
                        <body>
                            <tr class="text-center">
                                <td class="icon"><i class="fa-solid fa-person"></i></td>
                                <td class="icon"><i class="fa-regular fa-star"></i></td>
                                <td class="icon"><i class="fa-regular fa-calendar"></i></td>
                                <td class="icon"><i class="fa-regular fa-clock"></i></td>
                            </tr>
                            <tr class="text-center">
                                <td class="icon">{{$reserva->usuario_nombre}}</td>
                                <td class="icon">{{$reserva->clase_nombre}}</td>
                                <td class="icon">{{$reserva->dia_semana_nombre}} </br> {{$reserva->fecha}}</td>
                                <td class="icon">{{$reserva->franja_horaria_nombre}}</td>
                            </tr>
                        </body>
                    </table>

                    <form action="{{route('eliminarReservaClaseList')}}" method="POST" autocomplete='off'>
                        @csrf
                        <input type="hidden" name="reserva_id" value="{{$reserva->id}}">
                        <input type="hidden" name="type" value="clase">

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-outline-danger">
                                Eliminar reserva
                            </button>
                        </div>
                    </form>
                @elseif ($type == 'servicios')
                    <table id="horario" style="margin: 0 auto;">
                        <body>
                            <tr class="text-center">
                                <td class="icon"><i class="fa-solid fa-person"></i></td>
                                <td class="icon"><i class="fa-regular fa-star"></i></td>
                                <td class="icon"><i class="fa-solid fa-person"></i></td>
                                <td class="icon"><i class="fa-regular fa-calendar"></i></td>
                                <td class="icon"><i class="fa-regular fa-clock"></i></td>
                            </tr>
                            <tr class="text-center">
                                <td class="icon">{{$reserva->usuario_nombre}}</td>
                                <td class="icon">{{$reserva->role_nombre}}</td>
                                <td class="icon">{{$reserva->profesional_nombre}}</td>
                                <td class="icon">{{$reserva->fecha}}</td>
                                <td class="icon">{{$reserva->franja_horaria_nombre}}</td>
                            </tr>
                        </body>
                    </table>

                    <form action="{{route('eliminarReservaServicioList')}}" method="POST" autocomplete='off'>
                        @csrf
                        <input type="hidden" name="reserva_id" value="{{$reserva->id}}">
                        <input type="hidden" name="type" value="servicio">

                        <div class="mt-4 text-center">
                            <button type="submit" class="btn btn-outline-danger">
                                Eliminar reserva
                            </button>
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>