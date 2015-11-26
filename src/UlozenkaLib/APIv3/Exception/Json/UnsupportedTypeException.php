<?php

namespace UlozenkaLib\APIv3\Exception\Json;

/**
 * UnsupportedTypeException
 */
class UnsupportedTypeException extends JsonException
{

    protected $code = JSON_ERROR_UNSUPPORTED_TYPE;
    protected $message = 'Invalid JSON data. A value of a type that cannot be encoded was given.';
}
