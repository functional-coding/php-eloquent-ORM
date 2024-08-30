<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Http;

use Illuminate\Support\Arr;
use SimplifyServiceLayer\Service;

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
        $service->run();
        $content = $service->getResponseBody();

        $response->{'JsonResponse' == Arr::last(explode('\\', get_class($response))) ? 'setData' : 'setContent'}($content);

        return $response;
    }
}
