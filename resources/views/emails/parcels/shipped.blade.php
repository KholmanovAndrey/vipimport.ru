@component('mail::message')
# Посылка № P{{ $parcel->id }} "{{ $parcel->title }}"

<article>
    <div>
        <div>
            <div>Клиент: {{ $parcel->client->name }}</div>
            <div>Дата создания: {{ date('d.m.Y H:i', date_timestamp_get($parcel->created_at)) }}</div>
            <div>Дата обновления: {{ date('d.m.Y H:i', date_timestamp_get($parcel->updated_at)) }}</div>
            <div>{{ $parcel->description }}</div>
        </div>
        <div>
            <div>Данные доставки:</div>
            <div>ФИО: {{ $parcel->fio }}</div>
            <div>Адрес: {{ $parcel->address }}</div>
            <div>Телефон: {{ $parcel->phone }}</div>
        </div>
    </div>
</article>

<h2>Заказы:</h2>
<table style="width: 100%;">
    <tr>
        <th>№</th>
        <th>Наименование</th>
        <th>Кол-во</th>
    </tr>
    @foreach($parcel->orders as $order)
        <tr>
            <td style="text-align: center;">Z{{ $order->id }}</td>
            <td>{{ $order->title }}</td>
            <td style="text-align: center;">{{ $order->count }}</td>
        </tr>
    @endforeach
</table>

@component('mail::button', ['url' => route('parcel.index')])
    Перейти на сайт
@endcomponent

Спасибо,<br>
VIPIMPORT.RU - Товары из США
@endcomponent
