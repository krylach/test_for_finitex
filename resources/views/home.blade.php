@extends('layouts.app')

@section('content')
<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card">
                <div class="card-header">{{ __('Мои счета') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Номер счёта</th>
                                <th scope="col">Валюта</th>
                                <th scope="col">Баланс</th>
                                <th scope="col">Действие</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($accounts)
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{$account->number}}</td>
                                        <td>{{$account->currency->title}}</td>
                                        <td>{{$account->amount}} {{$account->currency->title}}</td>
                                        <td>
                                            <form action="{{route('account.close')}}" method="post">
                                                {{ csrf_field() }}
                                                <input type="hidden" name="account" value="{{$account->number}}">
                                                <button type="submit" class="btn btn-danger">Закрыть</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                {{__('Создайте первый счёт')}}
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">{{ __('Создание счёта') }}</div>

                <div class="card-body">
                    <form action="{{route('account.create')}}" method="post">
                        <div class="form-group">
                            <label for="currency">Валюта:</label>
                            <select class="form-control" name="currency" id="currency">
                                @foreach ($currencies as $currency)
                                    <option value="{{$currency->id}}">{{$currency->title}}</option>
                                @endforeach
                            </select>
                        </div>
                        {{ csrf_field() }}
                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Создать</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-header">{{ __('Перевод средств') }}</div>

                <div class="card-body">
                <form action="{{route('account.transaction')}}" method="post">
                        <div class="form-group">
                            <label for="from">Откуда:</label>
                            <select class="form-control" name="from" id="from">
                                @if ($accounts)
                                    @foreach ($accounts as $account)
                                        <option value="{{$account->number}}">{{$account->number}} ({{$account->amount}} {{$account->currency->title}})</option>
                                    @endforeach
                                @endif
                            </select>
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('from') }}</strong>
                            </span>
                        </div>
                               
                        <div class="form-group">
                            <label for="from">Куда:</label>
                            <select class="form-control" name="to" id="to">
                                @if ($all_accounts)
                                    @foreach ($all_accounts as $account)
                                    <option value="{{$account->number}}">{{$account->number}} (*.** {{$account->currency->title}})</option>
                                    @endforeach
                                @endif
                            </select>

                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('to') }}</strong>
                            </span>
                        </div>

                        <div class="form-group">
                            <label for="sum">Сумма перевода:</label>
                            <input type="number" name="sum" min="0.0001" step="0.0001" value="0.01" class="form-control">
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $errors->first('sum') }}</strong>
                            </span>
                        </div>
                        {{ csrf_field() }}
                        <div class="form-group d-flex justify-content-end">
                            <button type="submit" class="btn btn-success">Перевести</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
