<?php namespace Mep\Http\Middleware;

use Closure;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken as BaseVerifier;

class VerifyCsrfToken extends BaseVerifier {

	/**
	 * Handle an incoming request.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  \Closure  $next
	 * @return mixed
	 */
	public function handle($request, Closure $next)
	{
		if($request->ajax())
		{
		    \Input::merge([
		        '_token' => $request->header('X-CSRF-Token')
		    ]);
		}
		return parent::handle($request, $next);
	}

}
