<?php


namespace App\Util\Export;


class UserExportSchema
{
    const FULL_SCHEMA = [
        ['ФИО', 'prop', 'full_name'],
        ['Остаток на счёте (тенге)', 'prop', 'money_amount_kzt'],
        ['Адрес', 'prop', 'address'],
        ['Название компании, место работы', 'prop', 'company_name'],
        ['Фото', 'prop', 'photo'],
        ['Контактный телефон', 'prop', 'phone'],
        ['E-mail', 'prop', 'email'],
        ['Должность', 'prop', 'position'],
        ['Диплом участника', 'prop', 'diploma'],
        ['Получать новости об акциях, скидках и т.д.', 'prop', 'receive_news_accept'],
    ];
}
