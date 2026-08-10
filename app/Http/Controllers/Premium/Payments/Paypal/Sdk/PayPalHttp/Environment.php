<?php

namespace App\Http\Controllers\Premium\Payments\Paypal\Sdk\PayPalHttp;

/**
 * Interface Environment
 * @package PayPalHttp
 *
 * Describes a domain that hosts a REST API, against which an HttpClient will make requests.
 * @see HttpClient
 */
interface Environment
{
    /**
     * @return string
     */
    public function baseUrl();
}
