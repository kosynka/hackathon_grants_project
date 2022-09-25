@section('title', 'Заявки')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Заявки</h4>
                </div>
                <div class="col-md-12">
                  <h4>Заявки</h4>
                </div>
                  <div class="table-responsive col-lg-12">
                    <table class="table">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Заголовок</th>
                            <th scope="col">Статус</th>
                            <th scope="col">Пользователь</th>
                            <th scope="col">Дата создания заявки</th>
                            <th scope="col">Картинка</th>
                            <th scope="col"></th>
                        </tr>
                        </thead>
                        <tbody>
                            @foreach ($offers as $offer)
                                <tr>
                                    <th scope="row">{{ $offer->id }}</th>
                                    <td>{{ $offer?->title }}</td>
                                    <td>
                                        @if ($offer->status == "ACCEPTED")
                                            <a class="text-success">{{ $offer->getStatus() }}</a>
                                        @else
                                            <a class="text-danger">{{ $offer->getStatus() }}</a>
                                        @endif
                                    </td>
                                    <td>{{ $offer->user->name }}</td>
                                    <td>{{ $offer->created_at }}</td>
                                    @if ($offer->image_path)
                                        {{-- <td class="text-warning">
                                            <img src="{{ url($offer->image_path) }}" style="max-width: 200px" class="rounded mx-auto m-3">
                                        </td>
                                    @else --}}
                                        <td class="text-warning">
                                            <img src="https://img.freepik.com/free-vector/shrug-concept-illustration_114360-9375.jpg?w=740&t=st=1664105632~exp=1664106232~hmac=988a7cca8b19f5e209b3a60ad0b1d3b315fba7b27c5c48fb1abb1b5bf3e379a5" style="max-width: 200px" class="rounded mx-auto m-3">
                                        </td>
                                    @endif
                                    <td>
                                        <a class="btn btn-default" href="{{ route('details', ['id' => $offer->id]) }}">посмотреть заявку</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                  </div>
              </div>
        </div>
    </div>
</section>
@endsection