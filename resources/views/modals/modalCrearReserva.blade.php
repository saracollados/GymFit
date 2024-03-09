<div class="modal fade" id="modal-crear-reserva" tabindex="-1" aria-labelledby="modal-create-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs modal-lg">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold" style="background-color: {{$clase['color']}}">
                <div class="w-full flex justify-between">
                    <h5 class="modal-title" id="modal-create-content-label">Reservar clase</h5>
                    <h5 class="modal-title">{{$usuario['nombre']}} - {{$usuario['dni']}}</h5>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-base">
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
                            <td class="icon">{{$clase['clase_nombre']}}</td>
                            <td class="icon">{{$clase['dia_semana_nombre']}}<br> {{$clase['fecha']['fecha']}}</td>
                            <td class="icon">{{$clase['franja_horaria_nombre']}}</td>
                            <td class="icon">{{$clase['sala_nombre']}}</td>
                            <td class="icon">{{$clase['monitor_nombre']}}</td>
                        </tr>
                    </body>
                </table>

                {{-- <form action="{{route('crearReservaClase')}}" method="POST" autocomplete='off'> --}}
                {{-- <form action="{{route({{$reserva == '1' ? 'eliminarReservaClase' : 'crearReservaClase'}})}}" method="POST" autocomplete='off'> --}}
                <form action="{{ $reserva ? route('eliminarReservaClase') : route('crearReservaClase') }}" method="POST" autocomplete="off">
                    @csrf

                    <input type="hidden" name="usuario_id" value="{{$usuario['id']}}">
                    <input type="hidden" name="dni" value="{{$usuario['dni']}}">
                    <input type="hidden" name="clase_id" value="{{$clase['id']}}">
                    <input type="hidden" name="fecha_id" value="{{$clase['fecha']['fecha_id']}}">
                    <input type="hidden" name="franja_horaria_id" value="{{$clase['franja_horaria_id']}}">

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
            </div>
        </div>
    </div>
</div>