@php
/** @var $data array */
/** @var $attribute string */
/** @var $label string */
/** @var $value \Illuminate\Database\Eloquent\Collection */

$value = $value ?? [];
$ids = [];
if ($value) {
    foreach ($value as $item) {
        $ids[] = $item->id;
    }
}

$ids = old($attribute, $ids);

@endphp

<div class="form-group">
    <label for="{{ $attribute }}" class="col-form-label">{{ $label }}</label>
    <select id="{{ $attribute }}" class="form-control{{ $errors->has($attribute) ? ' is-invalid' : '' }}" name="{{ $attribute }}[]" multiple>
        @foreach ($data as $key => $valueName)
            <option value="{{ $key }}"{{ in_array($key, $ids, false) ? ' selected' : '' }}>{{ $valueName }}</option>
        @endforeach;
    </select>
    @if ($errors->has($attribute))
        <span class="invalid-feedback"><strong>{{ $errors->first($attribute) }}</strong></span>
    @endif
</div>
