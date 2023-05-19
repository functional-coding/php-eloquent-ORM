<?php

namespace FunctionalCoding\ORM\Eloquent\Http;

use FunctionalCoding\Service;
use Illuminate\Support\Arr;

class ServiceRunMiddleware
{
    public function handle($request, $next)
    {
        $response = $next($request);
        $content = $response->getOriginalContent();

        if (!Service::isInitable($content)) {
            return $response;
        }

        $service = Service::initService($content);
        $content = $service->getResponseBody();
        $response->{'JsonResponse' == Arr::last(explode('\\', get_class($response))) ? 'setData' : 'setContent'}($content);

        return $response;
    }
}
