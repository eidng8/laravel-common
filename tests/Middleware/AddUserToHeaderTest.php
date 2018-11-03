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

namespace eidng8\Tests\Middleware;

use edign8\Laravel\Middleware\AddUserToHeader;
use Orchestra\Testbench\TestCase;

class SUT extends AddUserToHeader
{
    protected $headers = [
        'x-test-foo' => 'bar',
        'x-test-baz' => 'baz',
    ];
}



class MockRequest
{
    public function user()
    {
        return ['bar' => 'me bar', 'baz' => 'you baz'];
    }
}



class AddUserToHeaderTest extends TestCase
{
    public function testHandle()
    {
        $ware = new SUT();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockRequest(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(['x-test-foo' => ['me bar']], $actual);
        self::assertArraySubset(['x-test-baz' => ['you baz']], $actual);
    }
}
