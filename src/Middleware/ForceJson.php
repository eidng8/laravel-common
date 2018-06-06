<?php

namespace edign8\Laravel\Middleware;

class ForceJson
{

    /**
     * @param          $request
     * @param callable $next
     */
    public function handle($request, $next)
    {
        $request->headers->set('Accept', 'application/json');

        return $next($request);
    }
}
