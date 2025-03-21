<?php

namespace App\Orchid\Screens\TransactionLog;

use Orchid\Screen\Screen;
use App\Models\TransactionLog;
use App\Orchid\Layouts\TransactionLog\TransactionLogListTable;
use Orchid\Support\Facades\Layout;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Layouts\Modal;
use Orchid\Screen\Sight;

class TransactionLogScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'transaction_log_list' => TransactionLog::orderBy('created_at', 'desc')->paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Логи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            TransactionLogListTable::class,
            Layout::modal('detailLog', 
                Layout::legend('logs',[
                    Sight::make('id'),
                    Sight::make('pg_order_id'),
                    Sight::make('pg_payment_id'),
                    Sight::make('pg_amount'),
                    Sight::make('pg_currency'),
                    Sight::make('pg_net_amount'),
                    Sight::make('pg_ps_amount'),
                    Sight::make('pg_ps_full_amount'),
                    Sight::make('pg_ps_currency'),
                    Sight::make('pg_description'),
                    Sight::make('pg_result'),
                    Sight::make('pg_can_reject'),
                    Sight::make('pg_user_phone'),
                    Sight::make('pg_need_phone_notification'),
                    Sight::make('pg_user_contact_email'),
                    Sight::make('pg_need_email_notification'),
                    Sight::make('pg_testing_mode'),
                    Sight::make('pg_payment_method'),
                    Sight::make('pg_captured'),
                    Sight::make('pg_failure_description'),
                    Sight::make('pg_failure_code'),
                    Sight::make('pg_salt'),
                    Sight::make('pg_sig'),
                ])
            )->withoutApplyButton()->async('asyncGetLogs')->size(Modal::SIZE_LG),
        ];
    }

    public function asyncGetLogs(TransactionLog $logs): array
    {
        // dd($logs);
        return [
            'logs' => $logs
        ];
    }
}
