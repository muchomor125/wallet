<?php
declare(strict_types=1);
namespace App\Decoder;

use App\Entity\Password;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Encoder\PasswordEncoderInterface;

/**
 * @method bool needsRehash(string $encoded)
 */
class OwnPasswordDecoder implements PasswordEncoderInterface
{

    public function encodePassword($raw, $salt)
    {
        // TODO: Implement encodePassword() method.
    }

    public function isPasswordValid($encoded, $raw, $salt)
    {
        // TODO: Implement isPasswordValid() method.

    }

    public function __call($name, $arguments)
    {
        // TODO: Implement @method bool needsRehash(string $encoded)
    }

    public function ownEncoder($raw,$secret)
    {
        if (null == $raw)
            return null;

        // Generate an initialization vector
        $iv = openssl_random_pseudo_bytes(openssl_cipher_iv_length('aes-256-cbc'));
        // Encrypt the data using AES 256 encryption in CBC mode using our encryption key and initialization vector.
        $encrypted = openssl_encrypt($raw, 'aes-256-cbc', $secret, 0, $iv);
        // The $iv is just as important as the key for decrypting, so save it with our encrypted data using a unique separator (::)
        return base64_encode($encrypted . '::' . $iv);
    }
    public function ownDecoder($raw
        ,$secret)
    {
        if (null == $raw)
            return null;

        // To decrypt, split the encrypted data from our IV - our unique separator used was "::"
        list($encrypted_data, $iv) = explode('::', base64_decode($raw), 2);
        return openssl_decrypt($encrypted_data, 'aes-256-cbc', $secret, 0, $iv);

    }
    public function saltEncoder($raw, $salt)
    {

        return $password;
    }
}
