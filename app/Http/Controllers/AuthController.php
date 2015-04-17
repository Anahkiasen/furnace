<?php
namespace Furnace\Http\Controllers;

use Auth;
use Collective\Annotations\Routing\Annotations\Annotations\Get;
use Collective\Annotations\Routing\Annotations\Annotations\Middleware;
use Collective\Annotations\Routing\Annotations\Annotations\Post;
use Furnace\Commands\SocializeUserCommand;
use Illuminate\Auth\Guard;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Laravel\Socialite\Contracts\Factory;
use Redirect;
use URL;
use View;

class AuthController extends AbstractController
{
    /**
     * @type Factory
     */
    private $socialize;

    /**
     * @param Factory $socialize
     */
    public function __construct(Factory $socialize)
    {
        $this->socialize = $socialize;
    }

    /**
     * @Get("auth/login", as="auth.login")
     * @Middleware("guest")
     */
    public function login()
    {
        return View::make('auth/login');
    }

    /**
     * @Post("auth/login", as="auth.authenticate")
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
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout()
    {
        Auth::logout();

        return Redirect::home();
    }

    /**
     * @Get("auth/socialize/{provider}", as="auth.socialize")
     * Socialize with a provider
     *
     * @param string $provider
     *
     * @return RedirectResponse
     */
    public function socialize($provider)
    {
        return $this->socialize->with($provider)->redirect();
    }

    /**
     * @Get("auth/socialize/{provider}/callback", as="auth.callback")
     * @param string $provider
     *
     * @return RedirectResponse
     */
    public function callback($provider)
    {
        $user = $this->socialize->with($provider)->user();
        $user = $this->dispatchFromArray(SocializeUserCommand::class, [
            'provider' => $provider,
            'user'     => $user,
        ]);

        Auth::login($user);

        return Redirect::home();
    }
}
