@php
/** @var $attribute string */
/** @var $label string */
$value = $value ?? null;
@endphp
<div class="form-group">
    <label for="{{ $attribute }}" class="col-form-label">{{ $label }}</label>
    <input id="{{ $attribute }}" class="form-control{{ $errors->has($attribute) ? ' is-invalid' : '' }}" name="{{ $attribute }}" value="{{ old($attribute, $value) }}">
    @if ($errors->has($attribute))
        <span class="invalid-feedback"><strong>{{ $errors->first($attribute) }}</strong></span>
    @endif
</div>
