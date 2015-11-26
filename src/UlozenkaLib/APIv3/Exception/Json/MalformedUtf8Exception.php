<?php

namespace UlozenkaLib\APIv3\Exception\Json;

/**
 * MalformedUtf8Exception
 */
class MalformedUtf8Exception extends JsonException
{

    protected $code = JSON_ERROR_UTF8;
    protected $message = 'Invalid JSON data. Malformed UTF-8 characters, possibly incorrectly encoded.';
}
