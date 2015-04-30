<?php

namespace Mep\Http\Middleware;


class Administrator extends IsTypeGlobal {

    public function getType() {
        return 2;
    }

}
