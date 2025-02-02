<?php

namespace App\Orchid\Screens\CommentArticle;

use Orchid\Screen\Screen;
use App\Models\CommentArticle;
use App\Orchid\Layouts\CommentArticle\CommentArticleListTable;

class CommentArticleScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'comment_list' =>CommentArticle::orderby('created_at', 'desc')->paginate(10)
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
            CommentArticleListTable::class,
        ];
    }
}
