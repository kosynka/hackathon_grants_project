@section('title', 'Заявка')
@extends('layouts.app_jury')
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
                            <img src="{{ asset($offer->image_path) }}" style="max-width: 600px" class="rounded mx-auto m-3">
                        @endif
                        <br><br>
                        <table class="table table-striped table-bordered">
                            <thead>
                                <tr></tr>
                            </thead>

                            <tbody>
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

                        @if (!isset($rate))
                            <form method="POST" action="{{ route('store-rate', ['id' => $offer->id]) }}" enctype="multipart/form-data">
                                @csrf
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Идея</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="idea" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">План реализации</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="realization" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group row">
                                    <label for="staticEmail" class="col-sm-2 col-form-label">Актуальность</label>
                                    <div class="col-sm-4">
                                        <select class="form-control" name="relevance" id="exampleFormControlSelect1">
                                            <option>1</option>
                                            <option>2</option>
                                            <option>3</option>
                                            <option>4</option>
                                            <option>5</option>
                                            <option>6</option>
                                            <option>7</option>
                                            <option>8</option>
                                            <option>9</option>
                                            <option>10</option>
                                        </select>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary">Оценить</button>
                            </form>
                        @else
                            <table class="table table-striped table-bordered">
                                <thead>
                                    <tr></tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <th scope="row"><b>Идея: </b></th>
                                        <td>
                                            {{ $rate->rate_idea }}
                                            @for ($i = 0; $i < $rate->rate_idea; $i++)
                                                <i class="fa fa-star" style="color: yellow"></i>
                                            @endfor
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><b>План реализации: </b></th>
                                        <td>
                                            {{ $rate->rate_realization }}
                                            @for ($i = 0; $i < $rate->rate_realization; $i++)
                                                <i class="fa fa-star" style="color: yellow"></i>
                                            @endfor
                                        </td>
                                    </tr>
                                    <tr>
                                        <th scope="row"><b>Актуальность: </b></th>
                                        <td>
                                            {{ $rate->rate_relevance }}
                                            @for ($i = 0; $i < $rate->rate_relevance; $i++)
                                                <i class="fa fa-star" style="color: yellow"></i>
                                            @endfor
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        @endif
                        <br><br>

                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection