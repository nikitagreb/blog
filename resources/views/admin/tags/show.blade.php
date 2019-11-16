@extends('layouts.app')

@section('content')
    @php
        /** @var \App\Models\Tag $tag */
    @endphp
    <div class="row">
        <div class="col card">
            <div class="card-body">
                <h1>Просмотр тега</h1>
                <table class="table table-bordered table-striped">
                    <tbody>
                    <tr>
                        <th>ID</th>
                        <td>{{ $tag->id }}</td>
                    </tr>
                    <tr>
                        <th>Название</th>
                        <td>{{ $tag->name }}</td>
                    </tr>
                    <tr>
                        <th>Статус</th>
                        <td>{{ $tag->getStatusName() }}</td>
                    </tr>
                    <tr>
                        <th>Псевдоним</th>
                        <td>{{ $tag->slug }}</td>
                    </tr>
                    <tr>
                        <th>Дата создания</th>
                        <td>{{ $tag->created_at }}</td>
                    </tr>
                    <tr>
                        <th>Дата редактирования</th>
                        <td>{{ $tag->updated_at }}</td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
