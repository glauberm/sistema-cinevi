<div class="mb-4">

    <label
        for="{{ $name }}"
        class="form-label"
    >
        {{ $label }}
    </label>

    <input
        type="{{ $type }}"
        name="{{ $name }}"
        id="{{ $name }}"
        class="form-control @if ($errors->has($name)) is-invalid @endif"
        @if ($errors->has($name)) aria-describedby="{{ $name }}-feedback" @endif   
        @if ($type !== 'password' && old($name)) value="{{ old($name) }}" @endif
        @isset ($maxlength) maxlength="{{ $maxlength }}" @endisset
        @isset ($numeric)
            inputmode="numeric"
            pattern="[0-9]*"
        @endisset
    >

    @if ($errors->any($name))
        <ul class="ps-3 mb-0 invalid-feedback">
        @foreach($errors->get($name) as $error)
            <li>{{ $error }}</li>
        @endforeach
        </ul>
    @endif

    @isset ($messages)
        <ul class="ps-3 mb-0">
        @foreach($messages as $message)
            <li class="form-text">{{ $message }}</li>
        @endforeach
        </ul>
    @endisset

</div>

<br class="d-none" /> 