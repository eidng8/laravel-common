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

namespace eidng8\Tests\Providers;

use edign8\Laravel\Providers\MacroServiceProvider;
use Illuminate\Http\Request;
use Orchestra\Testbench\TestCase;

class MacrosTest extends TestCase
{
    protected function getPackageProviders($app)
    {
        return array_merge(
            parent::getPackageProviders($app),
            [MacroServiceProvider::class]
        );
    }


    public function testRequestBool()
    {
        $request = new Request(['a' => 'y', 'b' => null]);
        self::assertTrue($request->bool('a'));
        self::assertFalse($request->bool('b'));
    }


    public function testRequestCsv()
    {
        $request = new Request(['a' => 'a,b,c']);
        self::assertEquals(['a', 'b', 'c'], $request->csv('a'));
    }


    public function testRequestCsvEmpty()
    {
        $request = new Request(['a' => '']);
        self::assertCount(0, $request->csv('a'));
    }


    public function testRequestCsvArray()
    {
        $request = new Request(['a' => [1]]);
        self::assertSame([1], $request->csv('a'));
    }
}
