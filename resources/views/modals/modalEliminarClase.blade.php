<div class="modal fade" id="modal-eliminar-clase" tabindex="-1" aria-labelledby="modal-delete-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold">
                <h5 class="modal-title" id="modal-delete-content-label">¿Seguro que quieres eliminar esta clase?</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-base text-center">
                <table id="horario">
                    <body>
                        <p class="mb-4 uppercase"><b>{{$clase->nombre}}</b></p>
                        <p>{{$clase->descripcion}}</p>
                    </body>
                </table>

                <form action="{{route('eliminarClase')}}" method="POST" autocomplete='off'>
                    @csrf
                    <input type="hidden" name="clase_id" value="{{$clase->id}}">

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