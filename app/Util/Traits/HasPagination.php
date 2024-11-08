<?php namespace App\Util\Traits;

trait HasPagination
{
    /**
     * Loads and saves page variable from session
     */
    private function onPaginationIndex(): void
    {
        $sessionValue = session($this->getSessionPageName(), 1);
        $page = (int)request('page', $sessionValue);
        request()->merge(['page' => $page]);
        session([$this->getSessionPageName() => $page]);
    }

    private function getSessionPageName()
    {
        return 'page_' . get_class();
    }
}
