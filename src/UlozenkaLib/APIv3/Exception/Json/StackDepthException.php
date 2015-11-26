<?php

namespace UlozenkaLib\APIv3\Exception\Json;

/**
 * StackDepthException
 */
class StackDepthException extends JsonException
{

    protected $code = JSON_ERROR_DEPTH;
    protected $message = 'The maximum JSON data stack depth has been exceeded.';
}
