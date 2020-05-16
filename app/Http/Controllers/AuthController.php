<?php

namespace App\Http\Controllers;

use Laravel\Passport\Http\Controllers\AccessTokenController;
use Laravel\Passport\TokenRepository;
use Lcobucci\JWT\Parser as JwtParser;
use League\OAuth2\Server\AuthorizationServer;
use Psr\Http\Message\ServerRequestInterface;
// use Illuminate\Http\Request;

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
            'client_id' => 2, //client id
            'client_secret' => 'B3wuJT5ZzcrvqvqbGttLI53GJBvplLSByokkWfrG', //client secret
        ]);


        return with(new AccessTokenController($this->server, $this->tokens, $this->jwt))
            ->issueToken($request);
        
    }
}
