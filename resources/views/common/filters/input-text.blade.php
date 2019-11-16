@php
/** @var $attribute string */
/** @var $label string */
$value = $value ?? null;
@endphp

<div class="form-group">
    <label for="{{ $attribute }}" class="col-form-label">{{ $label }}</label>
    <input id="{{ $attribute }}" class="form-control" name="{{ $attribute }}" value="{{ request($attribute) }}">
</div>
