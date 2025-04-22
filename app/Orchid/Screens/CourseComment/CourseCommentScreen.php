<?php

namespace App\Orchid\Screens\CourseComment;

use Orchid\Screen\Screen;
use App\Models\CommentCourse;
use App\Orchid\Layouts\CourseComment\CourseCommentListTable;

class CourseCommentScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(int $coursePart): iterable
    {
        $this->coursePart = $coursePart;

        return [
            'course_comment_list' => CommentCourse::where('part_id', $coursePart)->orderBy('created_at', 'desc')->paginate(20)
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Комментарии';
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
            CourseCommentListTable::class
        ];
    }
}
