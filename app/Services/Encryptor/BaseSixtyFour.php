<?php

namespace App\Services\Encryptor;

/**
 * This class contains methods to encode and decode data using base64.
 */
class BaseSixtyFour
{
    /**
     * Returns the encoded string.
     *
     * @param $data - the data to encode
     * @return string
     */
    public static function encode($data)
    {
        return base64_encode($data);
    }

    /**
     * Returns the decoded string.
     *
     * @param $data - the data to decode
     * @return string
     */
    public static function decode($data)
    {
        return base64_decode($data);
    }
}
