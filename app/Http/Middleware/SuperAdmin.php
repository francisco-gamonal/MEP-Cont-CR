<?php namespace Mep\Http\Middleware;



class SuperAdmin extends IsTypeGlobal {

    public function getType() {
        return 1;
    }

}
