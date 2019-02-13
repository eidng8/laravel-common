<?php
/**
 * MIT License
 *
 * Copyright (c) Jackey Cheung
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to
 * deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING
 * FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE
 * SOFTWARE.
 *
 */

namespace edign8\Laravel\Middleware;

use Closure;

/**
 * A middleware that allows CORS requests from all sub-domains & ports.
 *
 * Please note that if the request fails CORS check, an empty response wit 401
 * status code will be returned immediately without any further process.
 * Thus controllers won't have any chance of processing.
 */
class DomainCorsMiddleware extends CorsMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $regex = '#^(?:.+://)?(?:.+\.)?([^.]+\.\w+)(?::\d+)?$#';
        $domain = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? false;
        if (!$domain) {
            // something wrong with the host
            return $this->emptyResponse();
        }
        if (false !== strpos($domain, '127.0.0.1')
            || false !== strpos($domain, 'localhost')) {
            // allow all request if running on localhost.
            return parent::handle($request, $next);
        }
        if (!preg_match($regex, $domain, $matches)) {
            // can't extract domain name
            return $this->emptyResponse();
        }
        $domain = $matches[1];

        $origin = $request->header('origin');
        if (!$origin) {
            // no Origin header, so this is not a CORS request
            return $next($request);
        }
        if (!preg_match($regex, $origin, $matches)) {
            // can't extract domain name from Origin
            return $this->emptyResponse();
        }
        if ($matches[1] != $domain) {
            // request is from another domain
            return $this->emptyResponse();
        }

        return parent::handle($request, $next);
    }


    private function emptyResponse()
    {
        return response('', 401);
    }
}
