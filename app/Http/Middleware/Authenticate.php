<?php
namespace Furnace\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Guard;
use Redirect;
use Response;
use URL;

class Authenticate
{
    /**
     * The Guard implementation.
     *
     * @type Guard
     */
    protected $auth;

    /**
     * Create a new filter instance.
     *
     * @param Guard $auth
     */
    public function __construct(Guard $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Closure                 $next
     *
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if ($this->auth->guest()) {
            if ($request->ajax()) {
                return Response::make('Unauthorized.', 401);
            } else {
                return Redirect::guest(URL::route('users.login'));
            }
        }

        return $next($request);
    }
}
