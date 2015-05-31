<?php

namespace Mep\Http\Middleware;

class Director extends IsTypeGlobal
{
    public function getType()
    {
        return 4;
    }
}
