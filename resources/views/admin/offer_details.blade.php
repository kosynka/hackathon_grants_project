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
                        @if ($offer->image_path)
                            <img src="https://img.freepik.com/free-vector/shrug-concept-illustration_114360-9375.jpg?w=740&t=st=1664105632~exp=1664106232~hmac=988a7cca8b19f5e209b3a60ad0b1d3b315fba7b27c5c48fb1abb1b5bf3e379a5" style="width: 300px !important; height: 300px !important" class="rounded mx-auto m-3">
                        @endif
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
                                <tr style="width: 200px">
                                    <th scope="row"><b>Идея: </b></th>
                                    <td>
                                        {{ $mean['mean_idea'] }}
                                        
                                    </td>
                                </tr>
                                <tr style="width: 200px">
                                    <th scope="row"><b>План реализации: </b></th>
                                    <td>
                                        {{ $mean['mean_realization'] }}
                                        
                                    </td>
                                </tr>
                                <tr style="width: 200px">
                                    <th scope="row"><b>Актуальность: </b></th>
                                    <td>
                                        {{ $mean['mean_relevance'] }}
                                        
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        <br><br>

                        <table class="table table-striped table-bordered">
                            <thead>
                                <th><b>Жюри: </b></th>
                                <th><b>Идея: </b></th>
                                <th><b>План реализации: </b></th>
                                <th><b>Актуальность: </b></th>
                            </thead>
                            <tbody>
                                @foreach ($rates as $rate)
                                <tr>
                                    <td>
                                        {{ $rate->admin_id - 1}}
                                    </td>
                                    <td>
                                        {{ $rate->rate_idea }}
                                        @for ($i = 0; $i < $rate->rate_idea; $i++)
                                            <i class="fa fa-star" style="color: yellow"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        {{ $rate->rate_realization }}
                                        @for ($i = 0; $i < $rate->rate_realization; $i++)
                                            <i class="fa fa-star" style="color: yellow"></i>
                                        @endfor
                                    </td>
                                    <td>
                                        {{ $rate->rate_relevance }}
                                        @for ($i = 0; $i < $rate->rate_relevance; $i++)
                                            <i class="fa fa-star" style="color: yellow"></i>
                                        @endfor
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>

                        <br><br><br>
                        <br><br><br>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection