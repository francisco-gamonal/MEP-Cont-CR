<?php

namespace Mep\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Illuminate\Session\Store;

abstract class IsTypeGlobal {

    private $auth;
    private $session;

    public function __construct(Guard $auth, Store $session) {
        $this->auth = $auth;
        $this->session = $session;
    }

    abstract public function getType();

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next) {
        /**/
        if (!$this->auth->user()->is($this->getType())) {
            /**/
            $this->auth->logout();
            /**/
            if ($request->ajax()) {
                return response('Unauthorized.', 401);
            } else {
                return redirect()->to('/');
            }
        }
        return $next($request);
    }

}
