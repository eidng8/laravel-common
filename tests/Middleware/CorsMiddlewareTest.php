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

use edign8\Laravel\Middleware\CorsMiddleware;
use Orchestra\Testbench\TestCase;

class MockedCorsRequest
{
    public const ORIGIN = 'http://localhost:12345';

    public const METHOD = 'post';

    public const HEADER = 'content-type';


    public function header($name)
    {
        switch (strtolower($name)) {
            case 'access-control-request-method':
                return self::METHOD;

            case 'access-control-request-headers':
                return self::HEADER;

            case 'origin':
                return self::ORIGIN;

            default:
                throw new \DomainException('Invalid header name');
        }
    }
}



class MockedCorsRequestWithoutOrigin extends MockedCorsRequest
{
    public function header($name)
    {
        if ('origin' == (strtolower($name))) {
            return null;
        }

        return parent::header($name);
    }
}



class MockedCorsRequestWithoutMethod extends MockedCorsRequest
{
    public function header($name)
    {
        if ('access-control-request-method' == (strtolower($name))) {
            return null;
        }

        return parent::header($name);
    }
}



class MockedCorsRequestWithoutHeaders extends MockedCorsRequest
{
    public function header($name)
    {
        if ('access-control-request-headers' == (strtolower($name))) {
            return null;
        }

        return parent::header($name);
    }
}



class MockedCorsRequestWithMultipleHeaders extends MockedCorsRequest
{
    public function header($name)
    {
        if ('access-control-request-headers' == (strtolower($name))) {
            return ['Content-Type', ' X-Some-Header'];
        }

        return parent::header($name);
    }
}



class CorsMiddlewareTest extends TestCase
{

    public function testHandle()
    {
        $ware = new CorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-origin' => [MockedCorsRequest::ORIGIN],
                'access-control-allow-methods' => [MockedCorsRequest::METHOD],
                'access-control-allow-headers' => [MockedCorsRequest::HEADER],
            ],
            $actual
        );
    }


    public function testNoOrigin()
    {
        $ware = new CorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedCorsRequestWithoutOrigin(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-methods' => [MockedCorsRequest::METHOD],
                'access-control-allow-headers' => [MockedCorsRequest::HEADER],
            ],
            $actual
        );
        self::assertArrayNotHasKey('access-control-allow-origin', $actual);
    }


    public function testNoMethod()
    {
        $ware = new CorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedCorsRequestWithoutMethod(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-origin' => [MockedCorsRequest::ORIGIN],
                'access-control-allow-headers' => [MockedCorsRequest::HEADER],
            ],
            $actual
        );
        self::assertArrayNotHasKey('access-control-allow-methods', $actual);
    }


    public function testNoHeader()
    {
        $ware = new CorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedCorsRequestWithoutHeaders(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-origin' => [MockedCorsRequest::ORIGIN],
                'access-control-allow-methods' => [MockedCorsRequest::METHOD],
            ],
            $actual
        );
        self::assertArrayNotHasKey('access-control-allow-headers', $actual);
    }


    public function testMultipleHeader()
    {
        $ware = new CorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedCorsRequestWithMultipleHeaders(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-origin' => [MockedCorsRequest::ORIGIN],
                'access-control-allow-methods' => [MockedCorsRequest::METHOD],
                'access-control-allow-headers' => ['Content-Type, X-Some-Header'],
            ],
            $actual
        );
    }
}
