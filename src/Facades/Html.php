<?php

namespace LvlupDev\Nlp\Facades;

use Illuminate\Support\Facades\Facade;

class Html extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LvlupDev\Nlp\Html::class;
    }
}
