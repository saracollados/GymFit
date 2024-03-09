<div class="modal fade" id="modal-usuario-reserva" tabindex="-1" aria-labelledby="modal-create-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold">
                <h5 class="modal-title" id="modal-create-content-label">Selecciona un usuario</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('crearReservaClaseForm')}}" method="POST" autocomplete='off'>
                    @csrf
                    <div class="flex justify-between mb-6">
                        <div class="w-full">
                            <label for="dni" class="block mb-2 text-sm font-medium text-gray-900">DNI usuario:</label>
                            <input name="dni" type="text" id="dni" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" required>
                        </div>
                    </div>
                    <div class="mt-10 text-center">
                        <button type="submit" class="btn secondaryBtn">
                            Seleccionar usuario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>