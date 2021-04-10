<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Contracts\Auth\Factory as Auth;
use App\Models\User;
use Illuminate\Support\Facades\Auth as Authenticate;

/**
 * Class Authenticate
 */
class SwooleAuthenticate {
    /**
     * The authentication factory instance.
     *
     * @var \Illuminate\Contracts\Auth\Factory|mixed
     */
    protected $auth;

    /**
     * Create a new middleware instance.
     *
     * @param  \Illuminate\Contracts\Auth\Factory $auth
     *
     * @return void
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     *
     * @return mixed
     *
     */
    public function handle($request, Closure $next) {
        $user = NULL;
        $email = $request->query()["email"];
        $password = $request->query()["password"];
        if (Authenticate::attempt(['email' => $email, 'password' => $password])) {
            $user = Authenticate::user();
        } else {
            $user = User::where([
                "email" => $email,
                "password" => $password,
            ])->get()->first();
        }

        if ($user !== NULL) {
            $this->auth->setRequest($request);
            $request->setUserResolver(function() use ($user) {
                return $user;
            });
        }
        return $next($request);
    }
}
