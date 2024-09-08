<?php

namespace IbrahimBougaoua\Filawidget\Services;

use IbrahimBougaoua\Filawidget\Models\Page;
use Illuminate\Database\Eloquent\Collection;

class PageService
{
    public static function getAllPages(): ?Collection
    {
        $pages = Page::father()->active()->with('children')->ordered()->get();

        return $pages->isEmpty() ? collect() : $pages;
    }

    public static function getPageBySlug(string $slug): ?Page
    {
        return Page::active()->with('children')->where('slug', $slug)->first();
    }

    public static function counts()
    {
        return Page::active()->count();
    }
}
