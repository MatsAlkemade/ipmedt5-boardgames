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
        var_dump("MIDDLEWARE");
        if (Authenticate::attempt(['email' => $email, 'password' => $password])) {
            $user = Authenticate::user();
            var_dump("1");
            var_dump($user);
        } else {
            $user = User::where([
                "email" => $email,
                "password" => $password,
            ])->get()->first();
            var_dump("2");
            var_dump($user);
        }

        if ($user !== NULL) {
            $this->auth->setRequest($request);
            var_dump("yes");
            $request->setUserResolver(function() use ($user) {
                return $user;
            });
            // $websocket->loginUsing($user);
            // $websocket->emit('login', [ 'loggedIn' => true ]);
            // var_dump($websocket->getUserId());
        } else {
            var_dump("no");
            // $websocket->emit('login', [ 'loggedIn' => false ]);
        }
        // var_dump($this->auth);
        // try {
        //     $this->auth->setRequest($request);
        //     if ($user = $this->auth->authenticate()) {
        //         $request->setUserResolver(function () use ($user) {
        //             return $user;
        //         });
        //     }
        // } catch (AuthenticationException $e) {
        //     // do nothing
        //     var_dump($e);
        // }

        return $next($request);
    }
}
