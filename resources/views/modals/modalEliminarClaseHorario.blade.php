<div class="modal fade" id="modal-eliminar-claseHorario" tabindex="-1" aria-labelledby="modal-delete-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold">
                <h5 class="modal-title" id="modal-delete-content-label">¿Seguro que quieres eliminar esta clase?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-base">
                <table id="horario">
                    <body>
                        <tr>
                            <td class="icon"><i class="fa-regular fa-star"></i></td>
                            <td class="icon"><i class="fa-regular fa-calendar"></i></td>
                            <td class="icon"><i class="fa-regular fa-clock"></i></td>
                        </tr>
                        <tr>
                            <td class="icon">{{$clase->clase_nombre}}</td>
                            <td class="icon">{{$clase->dia_semana_nombre}}</td>
                            <td class="icon">{{$clase->franja_horaria_nombre}}</td>
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
            </div>
        </div>
    </div>
</div>