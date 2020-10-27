@component('mail::message')
# Заказ № Z{{ $order->id }} "{{ $order->title }}"

Данные заказа:
<div>Дата создания заказа: {{ date('d.m.Y H:i', date_timestamp_get($order->created_at)) }}</div>
<div>Дата обновления заказа: {{ date('d.m.Y H:i', date_timestamp_get($order->updated_at)) }}</div>
<div>Количество: {{ $order->count }}</div>
@if($order->link)
    <div>Ссылка: <a href="{{ $order->link }}">{{ $order->link }}</a></div>
@endif
@if($order->color)
    <div>Ссылка: {{ $order->color }}</div>
@endif
@if($order->size)
    <div>Ссылка: {{ $order->size }}</div>
@endif
<p>{{ $order->description }}</p>


@component('mail::button', ['url' => route('order.index')])
Перейти на сайт
@endcomponent

Спасибо,<br>
VIPIMPORT.RU - Товары из США
@endcomponent
