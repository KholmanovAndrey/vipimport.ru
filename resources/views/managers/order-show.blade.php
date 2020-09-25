@extends('layouts.app')

@section('title', 'Личный кабинет')

@section('sidebar')
    @parent

    <div class="sidebar col">
        <x-office/>
    </div>
@endsection

@section('content')
    <div class="items col-lg-9">
        <h2>Заказы:</h2>

        <form method="POST"
              action="{{ route('manager.order-status', $order) }}">
            @csrf
            @method('PUT')
            <select name="status_id"
                    id="status_id"
                    class="form-control"
                    required>
                @foreach ($statuses as $status)
                    <option {{ (int)$status->id === (int)$order->status_id ? 'selected="selected"' : '' }} value="{{ $status->id }}">
                        {{ $status->title }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-danger item__link">
                {{ __('Изменить статус') }}
            </button>
        </form>

        <form method="POST"
              action="{{ route('manager.order-transfer', $order) }}">
            @csrf
            @method('PUT')
            <select name="manager_id"
                    id="manager_id"
                    class="form-control"
                    required>
                @foreach ($managers as $manager)
                    <option {{ (int)$manager->id === (int)$order->manager_id ? 'selected="selected"' : '' }} value="{{ $manager->id }}">
                        {{ $manager->profile['lastname'] }} ({{ $manager->name }})
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-danger item__link">
                {{ __('Передать заказ') }}
            </button>
        </form>
    </div>
@endsection