<?php

namespace Mep\Http\Middleware;

class President extends IsTypeGlobal
{
    public function getType()
    {
        return 5;
    }
}
