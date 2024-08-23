<?php

namespace IbrahimBougaoua\Filawidget\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \IbrahimBougaoua\Filawidget\Filawidget
 */
class Filawidget extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \IbrahimBougaoua\Filawidget\Filawidget::class;
    }
}
