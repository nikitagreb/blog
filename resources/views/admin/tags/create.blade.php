@extends('layouts.app')

@php
    /** @var array $statusList */
@endphp

@section('content')
    <div class="row">
        <div class="col card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.tags.store') }}">
                    <fieldset>
                        <legend>Добавлнение тега</legend>
                        @csrf
                        @include('common.forms.input-text', ['attribute' => 'name', 'label' => 'Название'])
                        @include('common.forms.select', ['attribute' => 'status', 'label' => 'Статус', 'data' => $statusList])
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Создать</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
