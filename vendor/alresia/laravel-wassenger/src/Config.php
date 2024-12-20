<?php

namespace Alresia\LaravelWassenger;


/**
 * @internal
 */
class Config
{
    /*
    |--------------------------------------------------------------------------
    | Authorisation
    |--------------------------------------------------------------------------
    |
    | User API key token needs to be used on every API request that requires
    | authentication. Get or create your API key from the Web Console.
    | Note: chat agents and supervisors have no access to the API.
    |
    */

    public const API_KEY = 'ced5df9fb6b5c258c7686c45ddcb75b578e546b998a4af3fdbbbebfdcc2e5d27db5a16b979396122';
    public const API_HOST = 'https://api.wassenger.com';
    public const API_VERSION = 1;
    public const DEFAULT_DEVICE = '63623c580abe0e0083055c3c';

    /*
    |--------------------------------------------------------------------------
    | HTTP CLIENT CONFIGURATION
    |--------------------------------------------------------------------------
    */

    public const RETURN_JSON_ERRORS = false;
}
