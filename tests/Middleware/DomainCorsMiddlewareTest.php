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

use edign8\Laravel\Middleware\DomainCorsMiddleware;
use Orchestra\Testbench\TestCase;

class MockedNotCorsRequest
{

    public function header(
        /* @noinspection PhpUnusedParameterInspection */
        $name
    ) {
        return null;
    }
}



class MockedDomainCorsRequest
{
    public const ORIGIN = 'http://sub.example.com:12345';

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



class MockedDomainDifferentOriginRequest extends MockedDomainCorsRequest
{
    public const ORIGIN = 'http://different.domain';

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



class MockedDomainInvalidOriginRequest extends MockedDomainCorsRequest
{
    public const ORIGIN = 'http://different';

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



class DomainCorsMiddlewareTest extends TestCase
{

    public function testHandle()
    {
        $_SERVER['HTTP_HOST'] = 'www.example.com';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-origin' =>
                    [MockedDomainCorsRequest::ORIGIN],
                'access-control-allow-methods' =>
                    [MockedDomainCorsRequest::METHOD],
                'access-control-allow-headers' =>
                    [MockedDomainCorsRequest::HEADER],
            ],
            $actual
        );
    }


    public function testHandleUsingServerName()
    {
        $_SERVER['HTTP_HOST'] = null;
        $_SERVER['SERVER_NAME'] = 'www.example.com';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-origin' =>
                    [MockedDomainCorsRequest::ORIGIN],
                'access-control-allow-methods' =>
                    [MockedDomainCorsRequest::METHOD],
                'access-control-allow-headers' =>
                    [MockedDomainCorsRequest::HEADER],
            ],
            $actual
        );
    }


    public function testHandleLocalhost()
    {
        $_SERVER['HTTP_HOST'] = null;
        $_SERVER['SERVER_NAME'] = 'localhost';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-origin' =>
                    [MockedDomainCorsRequest::ORIGIN],
                'access-control-allow-methods' =>
                    [MockedDomainCorsRequest::METHOD],
                'access-control-allow-headers' =>
                    [MockedDomainCorsRequest::HEADER],
            ],
            $actual
        );

        $_SERVER['SERVER_NAME'] = '127.0.0.1';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        $actual = $actual->headers->all();
        self::assertArraySubset(
            [
                'access-control-allow-origin' =>
                    [MockedDomainCorsRequest::ORIGIN],
                'access-control-allow-methods' =>
                    [MockedDomainCorsRequest::METHOD],
                'access-control-allow-headers' =>
                    [MockedDomainCorsRequest::HEADER],
            ],
            $actual
        );
    }


    public function testHandleEmptyDomain()
    {
        $_SERVER['HTTP_HOST'] = null;
        $_SERVER['SERVER_NAME'] = null;
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        self::assertSame(401, $actual->getStatusCode());
    }


    public function testHandleInvalidDomain()
    {
        $_SERVER['HTTP_HOST'] = 'test';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        self::assertSame(401, $actual->getStatusCode());
    }


    public function testHandleDifferentDomain()
    {
        $_SERVER['HTTP_HOST'] = 'just.a.test';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        self::assertSame(401, $actual->getStatusCode());
    }


    public function testHandleDifferentOrigin()
    {
        $_SERVER['HTTP_HOST'] = 'just.a.test';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainDifferentOriginRequest(),
            function () {
                return response('just a test');
            }
        );
        self::assertSame(401, $actual->getStatusCode());
    }


    public function testHandleInvalidOrigin()
    {
        $_SERVER['HTTP_HOST'] = 'just.a.test';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedDomainInvalidOriginRequest(),
            function () {
                return response('just a test');
            }
        );
        self::assertSame(401, $actual->getStatusCode());
    }


    public function testHandleNotCorsRequest()
    {
        $_SERVER['HTTP_HOST'] = 'just.a.test';
        $ware = new DomainCorsMiddleware();
        /* @var \Symfony\Component\HttpFoundation\Response $actual */
        /* @noinspection PhpParamsInspection */
        $actual = $ware->handle(
            new MockedNotCorsRequest(),
            function () {
                return response('just a test');
            }
        );
        self::assertEquals('just a test', $actual->getContent());
    }
}
