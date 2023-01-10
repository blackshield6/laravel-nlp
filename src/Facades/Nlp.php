<?php

namespace LvlupDev\Nlp\Facades;

use Illuminate\Support\Facades\Facade;

class Nlp extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \LvlupDev\Nlp\Nlp::class;
    }
}
