<?php

namespace App\Http\Middleware;

use Closure;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Exceptions\TokenExpiredException;
use Tymon\JWTAuth\JWTAuth;
use App\Http\Traits\ApiResponse;

class ApiJwtAuth
{
    use ApiResponse;

    protected $auth;
    
    public function __construct(JWTAuth $auth)
    {
        $this->auth = $auth;
    }

    public function handle($request, Closure $next)
    {
        if (! $this->auth->parser()->setRequest($request)->hasToken()) {
            return $this->TokenRrror('token_not_provided', 422); //缺少令牌
        }
        try {
            if (!$user = $this->auth->parseToken()->authenticate()) {
                return $this->TokenRrror('user_not_found', 404);
            }
        } catch (TokenExpiredException $e) {
            return $this->TokenRrror('token_expired', 401); //令牌过期
        } catch (JWTException $e) {
            return $this->TokenRrror('token_invalid', 400); //令牌无效
        }

        return $next($request);
    }

    protected function TokenRrror($error, $status)
    {
        return $this->failed($error, $status);
    }

}
