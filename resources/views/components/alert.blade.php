<blockquote
    class="alert alert-dismissible fade show alert-{{ $type ?? 'info' }}"
    role="alert"
>
    {{ $slot }}

    <button
        type="button"
        class="btn-close"
        data-bs-dismiss="alert"
    >
        <span class="visually-hidden">Dispensar</span>
    </button>
</blockquote>