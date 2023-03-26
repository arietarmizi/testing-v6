<?php

namespace common\encryption;

use phpseclib3\Crypt\AES;
use phpseclib3\Crypt\RSA;
use phpseclib3\Crypt\Common\SymmetricKey;
use yii\helpers\Json;

class Tokopedia
{
    const TAG_LENGTH   = 16;
    const NONCE_LENGTH = 12;

    public static function decryptContent($secret, $content)
    {
        $key            = self::decryptKey($secret);
        $decodedMessage = base64_decode($content);
        $nonce          = substr($decodedMessage, strlen($decodedMessage) - self::NONCE_LENGTH, strlen($decodedMessage));
        $nonceCipher    = substr($decodedMessage, 0, strlen($decodedMessage) - self::NONCE_LENGTH);

        $tag        = substr($nonceCipher, strlen($nonceCipher) - self::TAG_LENGTH, strlen($nonceCipher));
        $cipherText = substr($nonceCipher, 0, strlen($nonceCipher) - self::TAG_LENGTH);


        $aes = new AES('gcm');
        $aes->setPreferredEngine(SymmetricKey::ENGINE_OPENSSL_GCM);
        $aes->setKey($key);
        $aes->setNonce($nonce);
        $aes->setTag($tag);
        return Json::decode($aes->decrypt($cipherText));
    }

    public static function decryptKey($encryptedKey)
    {
        $privateKey = file_get_contents(__DIR__ . '/signature/private.key');
        $private    = RSA::loadPrivateKey($privateKey);
        return $private->decrypt(base64_decode($encryptedKey));
    }
}