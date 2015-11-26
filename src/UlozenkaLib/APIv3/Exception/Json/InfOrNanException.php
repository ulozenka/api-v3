<?php

namespace UlozenkaLib\APIv3\Exception\Json;

/**
 * InfOrNanException
 */
class InfOrNanException extends JsonException
{

    protected $code = JSON_ERROR_INF_OR_NAN;
    protected $message = 'Invalid JSON data. One or more NAN or INF values in the value to be encoded.';
}
