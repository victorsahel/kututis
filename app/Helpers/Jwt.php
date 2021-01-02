<?php


namespace App\Helpers;

use App\Support\Payload;
use App\Support\Token;
use \Firebase\JWT\JWT as JWTDecoder;
use Illuminate\Support\Facades\Cookie;

class Jwt
{
    /**
     * @param Token|string $jwt
     * @param int $time
     */
    public static function storeToken($jwt, $time)
    {
        $token = is_string($jwt) ? $jwt : (string)$jwt;
        Cookie::queue(Cookie::make('jwt', $token, $time / 60));
    }

    public static function clearToken()
    {
        Cookie::queue(Cookie::forget('jwt'));
    }

    /**
     * @return string|null
     */
    public static function getTokenString()
    {
        return Cookie::get('jwt');
    }

    /**
     * @return Token|null
     */
    public static function getToken()
    {
        if ($jwt = self::getTokenString()) {
            return Token::parse($jwt);
        }
        return null;
    }
}
