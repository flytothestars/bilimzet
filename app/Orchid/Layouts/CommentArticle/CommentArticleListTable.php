<?php

namespace App\Orchid\Layouts\CommentArticle;

use App\Models\CommentArticle;

class CommentArticleListTable extends Table
{
    /**
     * Data source.
     *
     * The name of the key to fetch it from the query.
     * The results of which will be elements of the table.
     *
     * @var string
     */
    protected $target = 'comment_list';

    /**
     * Get the table cells to be displayed.
     *
     * @return TD[]
     */
    protected function columns(): iterable
    {
        return [
            TD::make('id', 'ID'),
            TD::make('user_id', 'Автор')->render(function(CommentArticle $сomment){
                $user = User::find($сomment->user_id);
                if($user){
                    return $user->full_name;
                }
            }),
            TD::make('comment', 'Комментария'),
            TD::make('created_at', 'Дата создание'),
        ];
    }
}