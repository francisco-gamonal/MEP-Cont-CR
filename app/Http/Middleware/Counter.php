<?php

namespace Mep\Http\Middleware;

class Counter extends IsTypeGlobal
{
    public function getType()
    {
        return 3;
    }
}
