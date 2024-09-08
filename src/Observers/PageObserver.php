<?php

namespace IbrahimBougaoua\Filawidget\Observers;

use IbrahimBougaoua\Filawidget\Models\Page;
use Illuminate\Support\Str;

class PageObserver
{
    public function creating(Page $page)
    {
        $page->slug = Str::slug($page->title, '-');
    }
}
