<?php

namespace UlozenkaLib\APIv3\Exception\Json;

/**
 * ControlCharacterException
 */
class ControlCharacterException extends JsonException
{

    protected $code = JSON_ERROR_CTRL_CHAR;
    protected $message = 'Invalid JSON data. Control character error, possibly incorrectly encoded.';
}
