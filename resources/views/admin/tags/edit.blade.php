@extends('layouts.app')

@section('content')

    @php
        /** @var \App\Models\Tag $tag */
    @endphp
    <div class="row">
        <div class="col card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.tags.update', compact('tag')) }}">
                    <fieldset>
                        <legend>Редактирование тега</legend>
                        @csrf
                        @method('PUT')
                        @include('common.forms.input-text', [
                            'attribute' => 'name',
                            'label' => 'Название',
                            'value' => $tag->name,
                        ])
                        @include('common.forms.select', [
                            'attribute' => 'status',
                            'label' => 'Статус',
                            'data' => $statusList,
                            'value' => $tag->name,
                        ])
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Редактировать</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
