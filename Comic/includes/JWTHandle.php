<?php
require_once __DIR__ . '/../vendor/autoload.php'; // autoload thư viện

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

class JWTHandler {
    private static $secret_key = "DUCHACKER"; // đổi thành key bảo mật của bạn
    private static $algo = "HS256";

    public static function generateToken($payload, $exp = 86400) {
        $issuedAt = time();
        $payload['iat'] = $issuedAt;
        $payload['exp'] = $issuedAt + $exp;
        return JWT::encode($payload, self::$secret_key, self::$algo);
    }

    public static function decodeToken($jwt) {
        return JWT::decode($jwt, new Key(self::$secret_key, self::$algo));
    }

    public static function getTokenFromHeader() {
        $headers = getallheaders();
        if (isset($headers['Authorization'])) {
            $parts = explode(" ", $headers['Authorization']);
            return $parts[1] ?? null;
        }
        return null;
    }
}
?>