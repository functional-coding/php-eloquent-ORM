<?php

namespace SimplifyServiceLayer\ORM\Eloquent\Http;

use Illuminate\Support\Arr;
use SimplifyServiceLayer\Service;

class ServiceParameterMiddleware
{
    public function handle($request, $next)
    {
        $response = $next($request);
        $content = $response->getOriginalContent();

        if (!Service::isInitable($content)) {
            return $response;
        }

        $class = $content[0];
        $data = Arr::get($content, 1, []);
        $names = Arr::get($content, 2, []);
        $ruleListKeys = [];

        foreach (array_keys($class::getAllRuleLists()) as $v) {
            foreach (array_keys($class::getAllRuleLists()[$v]) as $k) {
                $ruleListKeys[] = $k;
            }
        }

        $data['auth_token'] = $request->bearerToken() ?: '';
        $names['auth_token'] = 'header[authorization]';

        if ($request->route('id')) {
            $data['id'] = $request->route('id') ? $request->route('id') : '';
            $names['id'] = $request->route('id') ? $request->route('id') : '';
        }

        if (!isset($data['token']) && !isset($names['token']) && $request->offsetExists('token')) {
            $data['token'] = $request->offsetGet('token');
            $names['token'] = '[token]';
        }

        foreach ([
            'expands',
            'fields',
            'limit',
            'order_by',
            'group_by',
            'cursor_id',
            'page'
        ] as $key) {
            if (in_array($key, $ruleListKeys) || $request->offsetExists($key)) {
                $data[$key] = Arr::get($request->all(), $key, '');
                $names[$key] = '['.$key.']';
            }
        }

        $response->{'JsonResponse' == Arr::last(explode('\\', get_class($response))) ? 'setData' : 'setContent'}([$class, $data, $names]);

        return $response;
    }
}
