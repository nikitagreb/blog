@extends('layouts.app')

@php
    /** @var array $statusList */
    /** @var array $tagList */
@endphp

@section('content')
    <div class="row">
        <div class="col card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.posts.store') }}">
                    <fieldset>
                        <legend>Добавлнение поста</legend>
                        @csrf
                        @include('common.forms.input-text', ['attribute' => 'h1', 'label' => 'Заголовок'])
                        @include('common.forms.input-text', ['attribute' => 'title', 'label' => 'Мета заголовок'])
                        @include('common.forms.textarea', ['attribute' => 'description', 'label' => 'Мета описание'])
                        @include('common.forms.textarea', ['attribute' => 'keywords', 'label' => 'Мета ключевые слова'])
                        @include('common.forms.textarea', ['attribute' => 'text', 'label' => 'Текст'])
                        @include('common.forms.select', ['attribute' => 'status', 'label' => 'Статус', 'data' => $statusList])
                        @include('common.forms.select-multiple', ['attribute' => 'tags', 'label' => 'Теги', 'data' => $tagList])
                        <div class="form-group">
                            <button type="submit" class="btn btn-primary">Создать</button>
                        </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
@endsection
