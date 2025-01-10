<?php

namespace App\Orchid\Layouts\TransactionLog;

use Orchid\Screen\TD;
use Orchid\Screen\Layouts\Table;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\ModalToggle;
use Orchid\Screen\Fields\Group;
use App\Models\User;
use App\Models\Course;
use App\Models\CoursePart;

class TransactionLogListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'transaction_log_list';

    protected $styleButton = '
                        display: flex;
                        justify-content: center;
                        align-items: center;
                        height: 100%;';
    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('pg_order_id', 'ID заказ'),
            TD::make('', 'Пользователь')->render(function($logs){
                $order = explode('-', $logs['pg_order_id']);
                $user = User::where('id', $order[2])->first();
                return $user->full_name;
            }),
            TD::make('', 'Курс')->render(function($logs){
                $order = explode('-', $logs['pg_order_id']);
                $course = Course::where('id', $order[0])->first();
                $coursePart = CoursePart::where('id', $order[1])->first();
                return $course->title.'('.$coursePart->title.')';
            }),
            TD::make('pg_amount', 'Сумма'),
            TD::make('pg_result', 'Статус')->render(function($logs){
                $status = $logs->pg_result == 1 ? 'Оплачен' : 'Не оплачен';
                return $status;
            })->width('90px'),
            TD::make('created_at', 'Дата'),
            TD::make('action', 'Действие')->render(function ($logs) {
                return Group::make([
                    ModalToggle::make('')
                        ->icon('bs.eye')
                        ->modal('detailLog')
                        ->modalTitle('Подробнее ' . $logs->pg_order_id)
                        ->asyncParameters([
                            'logs' => $logs->id
                        ])
                        ->class('btn btn-warning text-center rounded-2')
                        ->style($this->styleButton),
                ]);
            }),
        ];
    }
}