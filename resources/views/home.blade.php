@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header">{{ __('Мои счета') }}</div>

                <div class="card-body">
                    <table class="table">
                        <thead>
                            <tr>
                                <th scope="col">Номер счёта</th>
                                <th scope="col">Валюта</th>
                                <th scope="col">Баланс</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($accounts)
                                @foreach ($accounts as $account)
                                    <tr>
                                        <td>{{$account->number}}</td>
                                        <td>{{$account->currency->title}}</td>
                                        <td>{{$account->amount}} {{$account->currency->title}}</td>
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
        <div class="col-md-3">
            <div class="card">
                <div class="card-header">{{ __('Перевод средств') }}</div>

                <div class="card-body">

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
