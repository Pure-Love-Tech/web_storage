<?php

namespace App\Http\Controllers\Premium\Payments\Paypal\Sdk\Core;

use App\Http\Controllers\Premium\Payments\Paypal\Sdk\PayPalHttp\Injector;

class GzipInjector implements Injector
{
    public function inject($httpRequest)
    {
        $httpRequest->headers["Accept-Encoding"] = "gzip";
    }
}
