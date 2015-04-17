<?php
namespace Furnace\Http\Controllers;

use Auth;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Illuminate\Auth\Guard;
use Illuminate\Http\Request;
use Redirect;
use URL;
use View;

class AuthController extends AbstractController
{
    /**
     * @Get("auth/login", as="auth.login")
     * @Middleware("guest")
     */
    public function login()
    {
        return View::make('auth/login');
    }

    /**
     * @Post("auth/login")
     *
     * @param Request $request
     * @param Guard   $auth
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function authenticate(Request $request, Guard $auth)
    {
        $credentials = $request->only('name', 'password');
        if (!$auth->attempt($credentials)) {
            return Redirect::back()->with('error', true);
        }

        return Redirect::intended(URL::route('home'));
    }

    /**
     * @Get("auth/logout", as="auth.logout")
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return Redirect::home();
    }
}
