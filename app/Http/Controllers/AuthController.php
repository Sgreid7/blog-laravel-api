<?php

namespace App\Http\Controllers;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;

class AuthController extends Controller
{
    protected $server;
    protected $tokens;
    protected $jwt;


    public function __construct(AuthorizationServer $server,
                                TokenRepository $tokens,
                                JwtParser $jwt)
    {
        $this->jwt = $jwt;
        $this->server = $server;
        $this->tokens = $tokens;
    }


    public function login(ServerRequestInterface $request)
    {
        $controller = new AccessTokenController($this->server, $this->tokens, $this->jwt);

        $request = $request->withParsedBody($request->getParsedBody() +
        [
            'grant_type' => 'password',
            'client_id' => config('services.passport.client_id'), //client id
            'client_secret' => config('services.passport.client_secret'), //client secret
        ]);


        return with(new AccessTokenController($this->server, $this->tokens, $this->jwt))
            ->issueToken($request);
        
    }

    public function signup(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
        ]);

        return User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens->each(function ($token, $key) {
            $token->delete();
        });

        return response()->json('Successfully logged out.', 200);
    }
}
