<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Http;

class RequestInputMiddleware
{
    public function handle($request, $next)
    {
        foreach ($request->all() as $key => $value) {
            if (null === $value) {
                $value = '';
            } elseif ('null' === $value) {
                $value = null;
            } elseif ('false' === $value) {
                $value = false;
            } elseif ('true' === $value) {
                $value = true;
            }

            $request->offsetSet($key, $value);
        }

        return $next($request);
    }
}
