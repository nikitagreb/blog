@extends('layouts.app')

@section('content')

    @php
        /** @var \App\Models\Post $post */
    @endphp
    <div class="row">
        <div class="col card">
            <div class="card-body">
                <form method="POST" action="{{ route('admin.posts.update', compact('post')) }}">
                    <fieldset>
                        <legend>Редактирование поста</legend>
                        @csrf
                        @method('PUT')
                        @include('common.forms.input-text', [
                            'attribute' => 'h1',
                            'label' => 'Заголовок',
                            'value' => $post->h1,
                        ])
                        @include('common.forms.input-text', [
                            'attribute' => 'title',
                            'label' => 'Мета заголовок',
                            'value' => $post->title,
                        ])
                        @include('common.forms.textarea', [
                            'attribute' => 'description',
                            'label' => 'Мета описание',
                            'value' => $post->description,
                        ])
                        @include('common.forms.textarea', [
                            'attribute' => 'keywords',
                            'label' => 'Мета ключевые слова',
                            'value' => $post->keywords,
                        ])
                        @include('common.forms.textarea', [
                            'attribute' => 'text',
                            'label' => 'Текст',
                            'value' => $post->text,
                        ])
                        @include('common.forms.select', [
                            'attribute' => 'status',
                            'label' => 'Статус',
                            'data' => $statusList,
                            'value' => $post->status,
                        ])
                        @include('common.forms.select-multiple', [
                            'attribute' => 'tags',
                            'label' => 'Теги',
                            'data' => $tagList,
                            'value' => $post->tags,
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
