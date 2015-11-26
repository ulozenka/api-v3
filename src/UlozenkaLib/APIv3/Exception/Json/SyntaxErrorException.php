<?php

namespace UlozenkaLib\APIv3\Exception\Json;

/**
 * SyntaxErrorException
 */
class SyntaxErrorException extends JsonException
{

    protected $code = JSON_ERROR_SYNTAX;
    protected $message = 'Invalid or malformed JSON data.';
}
