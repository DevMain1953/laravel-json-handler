<?php

namespace App\Services\Encryptor;
use Spatie\Crypto\Rsa\KeyPair;
use Spatie\Crypto\Rsa\PrivateKey;
use Spatie\Crypto\Rsa\PublicKey;

/**
 * This class contains methods to encrypt and decrypt data using public and private RSA key pair.
 */
class RSA
{
    /**
     * Contains private key.
     *
     * @var string
     */
    private $privateKey;

    /**
     * Contains public key.
     *
     * @var string
     */
    private $publicKey;

    /**
     * Creates new class object and generates key pair.
     */
    public function __construct()
    {
        [$this->privateKey, $this->publicKey] = (new KeyPair())->generate();
    }

    /**
     * Encrypts the input data and returns the result.
     *
     * @param $data - the data to encrypt
     * @return string
     */
    public function encrypt($data)
    {
        $prKey = PrivateKey::fromString($this->privateKey);
        return $prKey->encrypt($data);
    }

    /**
     * Decrypts the input data and returns the result.
     *
     * @param $data - the data to decrypt
     * @return string
     */
    public function decrypt($data)
    {
        $pubKey = PublicKey::fromString($this->publicKey);
        return $pubKey->decrypt($data);
    }
}
