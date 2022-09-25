@section('title', 'Пользователь')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Пользователь</h4>
                </div>
                <div class="col-md-12">
                    <h4></h4>
                </div>
                <div class="container">
                    <div class="table-responsive col-lg-12">
                        <h3>Пользователь {{ $user->name }}</h3>
                        @if ($user->photo_path)
                            <img class="img rounded text-center" src="{{ url($user->photo_path) }}" style="max-width: 300px">
                            <br><br>
                        @endif
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr></tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 25%"><b>Имя: </b></th>
                                    <td>{{ $user->name }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Телефон: </b></th>
                                    <td>+7 {{ $user->phone }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Эл.почта: </b></th>
                                    <td>{{ $user->email }}</td>
                                </tr>
                            </tbody>
                        </table>
                        <br>

                        <h3>Заявки:</h3>
                        @if (!$user->offers->isEmpty())
                            <table class="table table-hover table-bordered">
                                <thead>
                                    <tr>
                                        <th>id</th>
                                        <th>Статус</th>
                                        <th>Заголовок</th>
                                        <th>Описание</th>

                                        <th>Документ заявки</th>
                                        <th>Фото</th>
                                        <th></th>
                                    </tr>
                                </thead>

                                <tbody>
                                    @foreach ($user->offers as $offer)
                                        <tr>
                                            <th scope="row">{{ $offer->id }}</th>
                                            <td>{{ $offer->getStatus() }}</td>
                                            <td>{{ $offer->title }}</td>
                                            <td>{{ $offer->description }}</td>
                                            <td>
                                                <a href="https://docs.google.com/document/d/1EvNTsJN8YfWOz-17-jeyHV-1i2uyaEqS_hwaSNiiLao/edit?usp=sharing" download="Заявка.doc">скачать</a>
                                            </td>
                                            @if ($offer->image_path)
                                                <td class="text-warning">
                                                    <img src="https://img.freepik.com/free-vector/shrug-concept-illustration_114360-9375.jpg?w=740&t=st=1664105632~exp=1664106232~hmac=988a7cca8b19f5e209b3a60ad0b1d3b315fba7b27c5c48fb1abb1b5bf3e379a5" style="width: 200px !important; height: 200px !important" class="rounded mx-auto m-3">
                                                </td>
                                            @else
                                                <td class="text-warning"></td>
                                            @endif
                                            <td>
                                                <a class="btn btn-default" href="{{ route('details', ['id' => $offer->id]) }}">посмотреть заявку</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            @else
                            <h4>Отсутствуют заявки</h4>
                            @endif
                        <br>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection