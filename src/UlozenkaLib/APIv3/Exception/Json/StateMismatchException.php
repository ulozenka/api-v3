<?php

namespace UlozenkaLib\APIv3\Exception\Json;

/**
 * StateMismatchException
 */
class StateMismatchException extends JsonException
{

    protected $code = JSON_ERROR_STATE_MISMATCH;
    protected $message = 'Invalid or malformed JSON data.';
}
