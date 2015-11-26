<?php

namespace UlozenkaLib\APIv3\Exception\Json;

/**
 * RecursiveReferencesException
 */
class RecursiveReferencesException extends JsonException
{

    protected $code = JSON_ERROR_RECURSION;
    protected $message = 'Invalid JSON data. One or more recursive references in the value to be encoded.';
}
