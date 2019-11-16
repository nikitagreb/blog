@php
/** @var $data array */
/** @var $attribute string */
/** @var $label string */
/** @var $value mixed */

$value = $value ?? null;
@endphp

<div class="form-group">
    <label for="{{ $attribute }}" class="col-form-label">{{ $label }}</label>
    <select id="{{ $attribute }}" class="form-control{{ $errors->has($attribute) ? ' is-invalid' : '' }}" name="{{ $attribute }}">
        @foreach ($data as $key => $valueName)
            <option value="{{ $key }}"{{ $value === old($attribute, $value) ? ' selected' : '' }}>{{ $valueName }}</option>
        @endforeach;
    </select>
    @if ($errors->has($attribute))
        <span class="invalid-feedback"><strong>{{ $errors->first($attribute) }}</strong></span>
    @endif
</div>
