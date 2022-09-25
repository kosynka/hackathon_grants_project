@section('title', 'Заявка')
@extends('layouts.app')
@section('content')
    <div class="content-panel">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <h4>Заявки</h4>
                </div>
                <div class="col-md-12">
                    <h4></h4>
                </div>
                <div class="container">
                    <div class="table-responsive col-lg-12">
                        @if (Session::has('error'))
                            <div class="alert alert-danger alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ Session::get('error') }}
                            </div>
                        @endif

                        @if (Session::has('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ Session::get('success') }}
                            </div>
                        @endif

                        @if ($errors->any())
                            @foreach ($errors->all() as $error)
                                <div class="alert alert-danger alert-dismissible" role="alert">
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                    {{ $error }}
                                </div>
                            @endforeach
                        @endif

                        <h3>Заявка №{{ $offer->id }}</h3>
                        {{-- @if ($offer->image_path) --}}
                            <img src="{{ asset($offer->image_path) }}" style="max-width: 600px" class="rounded mx-auto m-3">
                        {{-- @endif --}}
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr></tr>
                            </thead>

                            <tbody>
                                <tr>
                                    <th scope="row" style="width: 25%"><b>Имя создавшего пользователя: </b></th>
                                    @if ($offer->user)
                                        <td>{{ $offer->user->name }}</td>
                                    @else
                                        <td class="text-warning">Пользователь удален</td>
                                    @endif
                                </tr>
                                <tr>
                                    <th scope="row"><b>Статус: </b></th>
                                    <td>{{ $offer->getStatus() }}</td>
                                </tr>
                                <tr>
                                    <th scope="row"><b>Дата создания: </b></th>
                                    <td>{{ $offer->created_at }}</td>
                                </tr>
                                <tr style="width: 200px">
                                    <th scope="row"><b>Документ: </b></th>
                                    <td>
                                        <a href="https://docs.google.com/document/d/1EvNTsJN8YfWOz-17-jeyHV-1i2uyaEqS_hwaSNiiLao/edit?usp=sharing" download="Заявка.doc">скачать</a>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection