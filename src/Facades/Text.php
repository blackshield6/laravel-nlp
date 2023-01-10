<?php

namespace LvlupDev\Nlp\Facades;

use Illuminate\Support\Facades\Facade;

class Text extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LvlupDev\Nlp\Text::class;
    }
}
