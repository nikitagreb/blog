@php
/** @var $attribute string */
/** @var $label string */
$value = $value ?? null;
@endphp

<div class="form-group">
    <label for="{{ $attribute }}">{{ $label }}</label>
    <textarea id="{{ $attribute }}" class="form-control{{ $errors->has($attribute) ? ' is-invalid' : '' }}" rows="3" name="{{ $attribute }}">{{ old($attribute, $value) }}</textarea>
    @if ($errors->has($attribute))
        <span class="invalid-feedback"><strong>{{ $errors->first($attribute) }}</strong></span>
    @endif
</div>

