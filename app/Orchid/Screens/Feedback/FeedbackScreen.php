<?php

namespace App\Orchid\Screens\Feedback;

use Orchid\Screen\Screen;
use App\Orchid\Layouts\Feedback\FeedbackListTable;
use App\Models\Feedback;
use Orchid\Support\Facades\Toast;

class FeedbackScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'feedback_list' => Feedback::paginate(10)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Обратный связь';
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
            FeedbackListTable::class
        ];
    }

    public function noInterviewed(Feedback $feedback)
    {
        $feedback->update([
            'is_feedbacked' => 0,
        ]);
        Toast::info('Не опрошен');

    }

    public function interviewed(Feedback $feedback)
    {
        $feedback->update([
            'is_feedbacked' => 1,
        ]);
        Toast::info('Опрошен');

    }
}
