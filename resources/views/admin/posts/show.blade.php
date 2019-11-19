@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Models\Post $post */
    @endphp
    <div class="row">
        <div class="col card">
            <div class="card-body">
                <h1>Просмотр поста</h1>
                <table class="table table-bordered table-striped">
                    <tbody>
                        <tr>
                            <th>ID</th>
                            <td>{{ $post->id }}</td>
                        </tr>
                        <tr>
                            <th>Заголовок</th>
                            <td>{{ $post->h1 }}</td>
                        </tr>
                        <tr>
                            <th>Фото</th>
                            <td>
                                <img src="{{ $post->avatar->getImage() }}" alt="{{ $post->avatar->alt }}">
                            </td>
                        </tr>
                        <tr>
                            <th>Псевдоним</th>
                            <td>{{ $post->slug }}</td>
                        </tr>
                        <tr>
                            <th>Мета заголовок</th>
                            <td>{{ $post->title }}</td>
                        </tr>
                        <tr>
                            <th>Мета описание</th>
                            <td>{{ $post->description }}</td>
                        </tr>
                        <tr>
                            <th>Мета ключевые слова</th>
                            <td>{{ $post->keywords }}</td>
                        </tr>
                        <tr>
                            <th>Текст</th>
                            <td>{{ $post->text }}</td>
                        </tr>
                        <tr>
                            <th>Статус</th>
                            <td>{{ $post->getStatusName() }}</td>
                        </tr>
                        <tr>
                            <th>Теги</th>
                            <td>{{ implode(', ', \Illuminate\Support\Arr::pluck($post->tags,'name', 'id')) }}</td>
                        </tr>
                        <tr>
                            <th>Дата создания</th>
                            <td>{{ $post->created_at }}</td>
                        </tr>
                        <tr>
                            <th>Дата редактирования</th>
                            <td>{{ $post->updated_at }}</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
