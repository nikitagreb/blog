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
                            'attribute' => 'preview_text',
                            'label' => 'Текст превью',
                            'value' => $post->preview_text,
                        ])

                        <main-photo model-id="{{ $post->id }}"
                                    model-type="{{ get_class($post) }}"
                                    current-image-id="{{ !$post->avatar ? 'null' : $post->avatar->id }}"
                                    current-image-alt="{{ !$post->avatar ? 'null' : $post->avatar->alt }}"
                                    current-image-url="{{ !$post->avatar ? 'null' : $post->avatar->getImage() }}"
                                    delete-url="{{ route('admin.image.delete-main') }}"
                                    update-alt-url="{{ route('admin.image.update-main-alt') }}"
                                    upload-url="{{ route('admin.image.upload-main') }}">
                        </main-photo>

                        <text-photos model-id="{{ $post->id }}"
                                     model-type="{{ get_class($post) }}"
                                     upload-url="{{ route('admin.image.upload-image') }}"
                                     delete-url="{{ route('admin.image.delete-image') }}"
                                     get-images-url="{{ route('admin.image.get-images') }}"
                                     update-alt-url="{{ route('admin.image.update-image-alt') }}">
                        </text-photos>

                        <markdown-editor
                            attribute="text"
                            label="Текст"
                            value="{{ old('text', $post->text) }}"
                            has-error="{{ $errors->has('text') }}"
                            text-error="{{ $errors->has('text') ? $errors->first('text') : null }}"
                        ></markdown-editor>

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
