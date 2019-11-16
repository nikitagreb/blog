@extends('layouts.app')

@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $post */
@endphp

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Посты</h1>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <a href="{{ route('admin.posts.create') }}" class="btn btn-primary">
                    Добавить пост
                </a>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Заголовок</td>
                    <td>Псевдоним</td>
                    <td>Опубликовано</td>
                    <td>Действия</td>
                </tr>
                </thead>
                <tbody>
                @forelse($posts as $post)
                    @php
                        /** @var \App\Models\Post $post */
                    @endphp
                    <tr>
                        <td>{{ $post->id }}</td>
                        <td>{{ $post->h1 }}</td>
                        <td>{{ $post->slug }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.posts.destroy', compact('post')) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{ $post->isPublished() ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success' }}">
                                        @if ($post->isPublished())
                                            Снять с публикации
                                        @else
                                            Опубликовать
                                        @endif
                                    </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group-sm">
                                <a class="btn btn-default" href="{{ route('admin.posts.show', compact('post')) }}">
                                    Просмотр
                                </a>
                                <a class="btn btn-info" href="{{ route('admin.posts.edit', compact('post')) }}">
                                    Редактировать
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Постов нет</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $posts->links() }}
        </div>
    </div>
@endsection
