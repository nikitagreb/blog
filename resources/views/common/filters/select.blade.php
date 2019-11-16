@php
/** @var $data array */
/** @var $attribute string */
/** @var $label string */

$value = $value ?? null;
@endphp

<div class="form-group">
    <label for="{{ $attribute }}" class="col-form-label">{{ $label }}</label>
    <select id="{{ $attribute }}" class="form-control" name="{{ $attribute }}">
        <option value=""></option>
        @foreach ($data as $value => $label)
            <option value="{{ $value }}"{{ $value === request($attribute) ? ' selected' : '' }}>{{ $label }}</option>
        @endforeach;
    </select>
</div>
