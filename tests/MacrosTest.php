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

namespace eidng8\Tests;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Orchestra\Testbench\TestCase;

class MacrosTest extends TestCase
{

    /**
     * @inheritdoc
     */
    protected function getEnvironmentSetUp($app)
    {
        parent::getEnvironmentSetUp($app);

        // Setup default database to use sqlite :memory:
        $app['config']->set('database.default', 'test-bench');
        $app['config']->set(
            'database.connections.test-bench',
            ['driver' => 'sqlite', 'database' => ':memory:',]
        );

        Schema::create(
            'test_table',
            function (Blueprint $table) {
                $table->string('name');
            }
        );
    }


    protected function setUp()
    {
        parent::setUp();

        \edign8\Laravel\Database\Query\Builder::macros();
    }


    public function testContrains(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereContains('col1', 'val1');
        self::assertRegExp('/["`]col1["`] like \?/', $query->toSql());
        self::assertSame(['%val1%'], $query->getBindings());
    }


    public function testOrContrains(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereContains('col1', 'val1');
        $query->orWhereContains('col2', 'val2');
        self::assertRegExp('/ or ["`]col2["`] like \?/', $query->toSql());
        self::assertSame(['%val1%', '%val2%'], $query->getBindings());
    }


    public function testNotContrains(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereNotContains('col1', 'val1');
        self::assertRegExp('/["`]col1["`] not like \?/', $query->toSql());
        self::assertSame(['%val1%'], $query->getBindings());
    }


    public function testOrNotContrains(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereNotContains('col1', 'val1');
        $query->orWhereNotContains('col2', 'val2');
        self::assertRegExp('/ or ["`]col2["`] not like \?/', $query->toSql());
        self::assertSame(['%val1%', '%val2%'], $query->getBindings());
    }


    public function testStartsWith(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereStartsWith('col1', 'val1');
        self::assertRegExp('/["`]col1["`] like \?/', $query->toSql());
        self::assertSame(['val1%'], $query->getBindings());
    }


    public function testOrStartsWith(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereStartsWith('col1', 'val1');
        $query->orWhereStartsWith('col2', 'val2');
        self::assertRegExp('/ or ["`]col2["`] like \?/', $query->toSql());
        self::assertSame(['val1%', 'val2%'], $query->getBindings());
    }


    public function testNotStartsWith(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereNotStartsWith('col1', 'val1');
        self::assertRegExp('/["`]col1["`] not like \?/', $query->toSql());
        self::assertSame(['val1%'], $query->getBindings());
    }


    public function testOrNotStartsWith(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereNotStartsWith('col1', 'val1');
        $query->orWhereNotStartsWith('col2', 'val2');
        self::assertRegExp('/ or ["`]col2["`] not like \?/', $query->toSql());
        self::assertSame(['val1%', 'val2%'], $query->getBindings());
    }


    public function testEndsWith(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereEndsWith('col1', 'val1');
        self::assertRegExp('/["`]col1["`] like \?/', $query->toSql());
        self::assertSame(['%val1'], $query->getBindings());
    }


    public function testOrEndsWith(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereEndsWith('col1', 'val1');
        $query->orWhereEndsWith('col2', 'val2');
        self::assertRegExp('/ or ["`]col2["`] like \?/', $query->toSql());
        self::assertSame(['%val1', '%val2'], $query->getBindings());
    }


    public function testNotEndsWith(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereNotEndsWith('col1', 'val1');
        self::assertRegExp('/["`]col1["`] not like \?/', $query->toSql());
        self::assertSame(['%val1'], $query->getBindings());
    }


    public function testOrNotEndsWith(): void
    {
        $query = new Builder($this->app->make(ConnectionInterface::class));
        $query->whereNotEndsWith('col1', 'val1');
        $query->orWhereNotEndsWith('col2', 'val2');
        self::assertRegExp('/ or ["`]col2["`] not like \?/', $query->toSql());
        self::assertSame(['%val1', '%val2'], $query->getBindings());
    }
}
