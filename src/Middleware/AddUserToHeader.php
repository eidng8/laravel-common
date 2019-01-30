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

/**
 * Adds various pieces of user information to response headers. Override the
 * {@see $headers} member to customize output headers.
 *
 * Use case may include responding user ID or username to HTTP servers. So the
 * server can add the information to its access/error logs. This approach is
 * described here: https://stackoverflow.com/a/39480113/1353368
 *
 * The pro is that logs are consolidated to one facility.
 */
class AddUserToHeader
{

    /**
     * An associative array of output header definitions. Keys are names of
     * headers, and values are columns to be taken from user model.
     *
     * @var string[]
     */
    protected $headers = [
        'x-user-id' => 'id',
        'x-user-name' => 'name',
    ];


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure                 $next
     * @return mixed
     */
    public function handle($request, $next)
    {
        $response = $next($request);
        $user = $request->user();
        if ($user) {
            foreach ($this->headers as $header => $column) {
                $response->headers->set($header, $user[$column]);
            }
        }

        return $response;
    }
}
