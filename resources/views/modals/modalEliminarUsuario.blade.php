<div class="modal fade" id="modal-eliminar-usuario" tabindex="-1" aria-labelledby="modal-delete-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold">
                @if ($userType == 'usuario') {
                    <h5 class="modal-title" id="modal-delete-content-label">¿Seguro que quieres eliminar este usuario?</h5>
                }
                @endif
                @if ($userType == 'personal') {
                    <h5 class="modal-title" id="modal-delete-content-label">¿Seguro que quieres eliminar este trabajador?</h5>
                }
                @endif
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body text-base text-center">
                <table id="horario">
                    <body>
                        <p class="mb-3 uppercase"><b>{{$usuario->nombre}}</b></p>
                        <p>{{$usuario->dni}}</p>
                    </body>
                </table>

                <form action="{{$userType == 'usuario' ? route('eliminarUsuario') : route('eliminarPersonal')}}" method="POST" autocomplete='off'>
                    @csrf
                    <input type="hidden" name="usuario_id" value="{{$usuario->id}}">

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