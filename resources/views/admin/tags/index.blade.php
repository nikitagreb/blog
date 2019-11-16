@extends('layouts.app')

@php
    /** @var \Illuminate\Pagination\LengthAwarePaginator $tags */
@endphp

@section('content')
    <div class="row">
        <div class="col-md-12">
            <h1>Теги</h1>
        </div>
        <div class="col-md-12">
            <div class="form-group">
                <a href="{{ route('admin.tags.create') }}" class="btn btn-primary">
                    Добавить тег
                </a>
            </div>
        </div>
        <div class="col-md-12">
            <table class="table table-striped table-bordered">
                <thead>
                <tr>
                    <td>ID</td>
                    <td>Название</td>
                    <td>Псевдоним</td>
                    <td>Статус</td>
                    <td>Действия</td>
                </tr>
                </thead>
                <tbody>
                @forelse($tags as $tag)
                    @php
                        /** @var \App\Models\Tag $tag */
                    @endphp
                    <tr>
                        <td>{{ $tag->id }}</td>
                        <td>{{ $tag->name }}</td>
                        <td>{{ $tag->slug }}</td>
                        <td>
                            <form method="POST" action="{{ route('admin.tags.destroy', compact('tag')) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="{{ $tag->isActive() ? 'btn btn-sm btn-danger' : 'btn btn-sm btn-success' }}">
                                        @if ($tag->isActive())
                                            Деактивировать
                                        @else
                                            Активировать
                                        @endif
                                    </button>
                            </form>
                        </td>
                        <td>
                            <div class="btn-group-sm">
                                <a class="btn btn-default" href="{{ route('admin.tags.show', compact('tag')) }}">
                                    Просмотр
                                </a>
                                <a class="btn btn-info" href="{{ route('admin.tags.edit', compact('tag')) }}">
                                    Редактировать
                                </a>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5">Тегов нет</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
            {{ $tags->links() }}
        </div>
    </div>
@endsection
