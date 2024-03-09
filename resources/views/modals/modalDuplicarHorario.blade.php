<div class="modal fade" id="modal-duplicar-horario" tabindex="-1" aria-labelledby="modal-duplicate-content-label" aria-hidden="true">
    <div class="modal-dialog text-xs">
        <div class="modal-content shadow-md">
            <div class="modal-header text-dark-blue uppercase bg-slate-300 font-bold">
                <h5 class="modal-title" id="modal-duplicate-content-label">Duplicar <?= $horario->nombre; ?></h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form action="{{route('duplicarHorario')}}" method="POST" autocomplete='off'>
                    @csrf
                    <div class="flex justify-between mb-6">
                        <div class="w-2/5">
                            <label for="fecha_desde" class="block mb-2 text-sm font-medium text-gray-900">Desde:</label>
                            <input name="fecha_desde" type="date" id="fecha_desde" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" required>
                        </div>
                        <div class="w-2/5">
                            <label for="fecha_hasta" class="block mb-2 text-sm font-medium text-gray-900">Hasta:</label>
                            <input name="fecha_hasta" type="date" id="fecha_hasta" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" required>
                        </div>
                    </div>
                    <div class="flex justify-between mb-6">
                        <div class="w-full">
                            <label for="nombre" class="block mb-2 text-sm font-medium text-gray-900">Nombre:</label>
                            <input name="nombre" type="text" id="nombre" class="block w-full p-2 text-gray-900 border border-gray-300 rounded bg-gray-50 outline-1" value="<?= $horario->nombre ?> - copia" required>
                        </div>
                    </div>
                    <input name="horario_duplicar_id" type="hidden" value="<?= $horario->id ?>">
                    <div class="mt-10 text-center">
                        <button type="submit" class="btn secondaryBtn">
                            Crear horario
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>