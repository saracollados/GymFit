<div class="modal fade" id="modal-crear-reserva" tabindex="-1" aria-labelledby="modal-create-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs modal-lg">
        <div class="modal-content shadow-md">
            @if($tipo == 'clase')
                <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold" style="background-color: {{$item['color']}}">
                    <div class="w-full flex justify-between">
                        <h5 class="modal-title" id="modal-create-content-label">Reservar clase</h5>
                        <h5 class="modal-title">{{$usuario['nombre']}} - {{$usuario['dni']}}</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            @if($tipo == 'servicio')
                <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold @if($item['role_id'] == '3') bg-emerald-300 @elseif($item['role_id'] == '4') bg-cyan-300 @endif">
                    <div class="w-full flex justify-between">
                        <h5 class="modal-title" id="modal-create-content-label">Reservar servicio</h5>
                        <h5 class="modal-title">{{$usuario['nombre']}} - {{$usuario['dni']}}</h5>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
            @endif
            <div class="modal-body text-base">
                @if($tipo == 'clase')
                    <table id="horario" class="flex justify-center text-center">
                        <body>
                            <tr>
                                <td class="icon"><i class="fa-regular fa-star"></i></td>
                                <td class="icon"><i class="fa-regular fa-calendar"></i></td>
                                <td class="icon"><i class="fa-regular fa-clock"></i></td>
                                <td class="icon"><i class="fa-solid fa-location-dot"></i></td>
                                <td class="icon"><i class="fa-solid fa-person"></i></td>
                            </tr>
                            <tr>
                                <td class="icon">{{$item['clase_nombre']}}</td>
                                <td class="icon">{{$item['dia_semana_nombre']}}<br> {{$item['fecha']['fecha']}}</td>
                                <td class="icon">{{$item['franja_horaria_nombre']}}</td>
                                <td class="icon">{{$item['sala_nombre']}}</td>
                                <td class="icon">{{$item['monitor_nombre']}}</td>
                            </tr>
                        </body>
                    </table>

                    <form action="{{ $reserva ? route('eliminarReservaClase') : route('crearReservaClase') }}" method="POST" autocomplete="off">
                        @csrf

                        <input type="hidden" name="usuario_id" value="{{$usuario['id']}}">
                        <input type="hidden" name="dni" value="{{$usuario['dni']}}">
                        <input type="hidden" name="clase_id" value="{{$item['id']}}">
                        <input type="hidden" name="fecha_id" value="{{$item['fecha']['fecha_id']}}">
                        <input type="hidden" name="franja_horaria_id" value="{{$item['franja_horaria_id']}}">
                        <input type="hidden" name="inicioSemana" value="{{$fecha}}">

                        <div class="mt-4 text-center">
                            @if ($reserva)
                                <button type="submit" class="btn secondaryBtn">
                                    Eliminar reserva
                                </button>
                            @else
                                <button type="submit" class="btn primaryBtn">
                                    Reservar
                                </button>
                            @endif
                        </div>
                    </form>
                @endif
                @if($tipo == 'servicio')
                    <table id="horario" class="flex justify-center text-center">
                        <body>
                            <tr>
                                <td class="icon"><i class="fa-regular fa-star"></i></td>
                                <td class="icon"><i class="fa-solid fa-person"></i></td>
                                <td class="icon"><i class="fa-regular fa-calendar"></i></td>
                                <td class="icon"><i class="fa-regular fa-clock"></i></td>
                            </tr>
                            <tr>
                                <td class="icon">{{$item['role_nombre']}}</td>
                                <td class="icon">{{$item['profesional_nombre']}}</td>
                                <td class="icon">{{$item['fecha']}}</td>
                                <td class="icon">{{$item['franja_horaria_nombre']}}</td>
                            </tr>
                        </body>
                    </table>

                    <form action="{{ $reserva ? route('eliminarReservaServicio') : route('crearReservaServicio') }}" method="POST" autocomplete="off">
                        @csrf

                        <input type="hidden" name="usuario_id" value="{{$usuario['id']}}">
                        <input type="hidden" name="dni" value="{{$usuario['dni']}}">
                        <input type="hidden" name="servicio" value="{{ json_encode($item) }}">
                        <input type="hidden" name="servicio_id" value="{{ $item['id']}}">
                        <input type="hidden" name="fecha" value="{{$item['fecha']}}">
                        <input type="hidden" name="franja_horaria_id" value="{{$item['franja_horaria_id']}}">
                        <input type="hidden" name="inicioSemana" value="{{$fecha}}">
                        @if($reserva)
                            <input type="hidden" name="reserva_id" value="{{$reserva['id']}}">
                        @endif

                        <div class="mt-4 text-center">
                            @if ($reserva)
                                <button type="submit" class="btn secondaryBtn">
                                    Eliminar reserva
                                </button>
                            @else
                                <button type="submit" class="btn primaryBtn">
                                    Reservar
                                </button>
                            @endif
                        </div>
                    </form>
                @endif
            </div>
        </div>
    </div>
</div>