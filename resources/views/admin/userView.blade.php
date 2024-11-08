@extends('layouts.admin')

@section('content')
    <h2 class="mt-4 mb-3">Просмотр пользователя</h2>
    <div>
        <table class="table">
            <thead>
            @include('admin.parts.userViewRow', [
                'key' => 'Поле',
                'value' => 'Значение',
                'header' => true
            ])
            </thead>
            <tbody>
            @include('admin.parts.userViewRow', [
                'key' => 'ФИО',
                'value' => $item->full_name
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'Остаток на счёте (тенге)',
                'value' => $item->money_amount_kzt
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'Адрес',
                'value' => $item->address
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'Название компании, место работы',
                'value' => $item->company_name
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'Фото',
                'fileUrl' => empty($item->photo) ? '' : $item->photoUrl
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'Контактный телефон',
                'value' => $item->phone
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'E-mail',
                'value' => $item->email
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'Должность',
                'value' => $item->position
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'Диплом участника',
                'fileUrl' => empty($item->diploma) ? '' : $item->diplomaUrl
            ])
            @include('admin.parts.userViewRow', [
                'key' => 'Получать новости об акциях, скидках и т.д.',
                'value' => $item->receive_news_accept ? 'Да' : 'Нет'
            ])
            </tbody>
        </table>
    </div>
@endsection
