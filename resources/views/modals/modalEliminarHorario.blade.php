<div class="modal fade" id="modal-eliminar-horario" tabindex="-1" aria-labelledby="modal-delete-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold">
                <h5 class="modal-title" id="modal-delete-content-label">¿Seguro que quieres eliminar {{$horario->nombre}}?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-center text-base">
                <form action="{{route('eliminarHorario')}}" method="POST" autocomplete='off'>
                    @csrf
                    <input type="hidden" name="horario_id" value="{{$horario->id}}">

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