<?php

namespace App\Support;

use Firebase\JWT\JWT as JWTDecoder;

class Token
{
    /**
     * @var string
     */
    private $jwt;
    /**
     * @var object
     */
    private $payload;
    /**
     * @var object
     */
    private $header;

    /**
     * Token constructor.
     * @param string $jwt
     * @param object $header
     * @param object $payload
     */
    private function __construct(string $jwt, object $header, object $payload)
    {
        $this->jwt = $jwt;
        $this->header = $header;
        $this->payload = $payload;
    }

    function __toString()
    {
        return $this->jwt;
    }

    /**
     * @param string $jwt
     * @return Token|null
     */
    static function parse(string $jwt)
    {
        $data = explode('.', $jwt);
        if (count($data) === 3) {
            try {
                $header = JWTDecoder::jsonDecode(JWTDecoder::urlsafeB64Decode($data[0]));
                $payload = JWTDecoder::jsonDecode(JWTDecoder::urlsafeB64Decode($data[1]));

                return new Token($jwt,$header,$payload);
            } catch (\DomainException $e) {
            }
        }
        return null;
    }

    /**
     * @return object
     */
    function getHeader()
    {
        return $this->header;
    }

    /**
     * @return object
     */
    function getClaims()
    {
        return $this->payload;
    }

    /**
     * @param string $key
     * @return mixed|null
     */
    function getClaim(string $key)
    {
        $claim = $this->payload->$key;
        return isset($claim) ? $claim : null;
    }

    /**
     * @return int
     */
    function getSubject() {
        return $this->payload->sub;
    }

    /**
     * @return bool
     */
    function isExpired()
    {
        $exp = $this->getClaim('exp');
        return isset($exp) && time() >= $exp;
    }

    /**
     * @return bool
     */
    function beforeValid()
    {
        $iat = $this->getClaim('iat');
        return isset($iat) && $iat > time();
    }

    /**
     * @param string $role 'admin', 'medico' o 'paciente'
     * @return bool
     */
    function hasRole(string $role){
        $roles = $this->getClaim('roles');
        return array_search($role, $roles) !== false;
    }
}
