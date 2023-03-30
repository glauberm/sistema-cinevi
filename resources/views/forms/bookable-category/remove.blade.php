<x-form.form
    method="POST"
    action="{{ route('authentication.register--action') }}"
>
 
    <x-form.button
        type="button"
        class="btn btn-danger"
        data-bs-toggle="modal"
        data-bs-target="#remove-form-modal"
    >
        Remover
    </x-form.button>

    <div
        class="modal fade"
        id="remove-form-modal"
        tabindex="-1"
        aria-labelledby="remove-form-modal-label"
        aria-hidden="true"
    >
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="remove-form-modal-label">Confirmar remoção</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Fechar"></button>
                </div>
                <div class="modal-body">
                    <p>Tem certeza de que deseja remover este item? Essa ação não poderá ser desfeita.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                    <x-form.button
                        type="submit"
                        class="btn btn-danger"
                    >
                        Remover
                    </x-form.button>
                </div>
            </div>
        </div>
    </div>

</x-form.form>