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

/* @noinspection PhpUndefinedFieldInspection */

namespace eidng8\Tests\Traits\Database\Eloquent;

use Orchestra\Testbench\TestCase;

class SUT extends \Illuminate\Database\Eloquent\Model
{
    use \edign8\Laravel\Traits\Database\Eloquent\ReadOnly;

    public $exists = true;

    public $readonlyDatabase;
}



class ReadOnlyTest extends TestCase
{
    /**
     * @var SUT
     */
    private $sut;


    protected function setUp()
    {
        parent::setUp();

        $this->sut = new SUT();
    }


    /**
     * @expectedException \edign8\Laravel\Exceptions\ReadOnlyModelException
     */
    public function testSaveShouldThrowError()
    {
        $this->sut->save();
    }


    /**
     * @expectedException \edign8\Laravel\Exceptions\ReadOnlyModelException
     * @throws \Exception
     */
    public function testDeleteShouldThrowError()
    {
        $this->sut->delete();
    }


    /**
     * @expectedException \edign8\Laravel\Exceptions\ReadOnlyModelException
     * @throws \Exception
     */
    public function testSetAttributeShouldThrowError()
    {
        $this->sut->abc = 'def';
    }


    /**
     * @expectedException \edign8\Laravel\Exceptions\ReadOnlyModelException
     * @throws \Exception
     */
    public function testSetOffsetShouldThrowError()
    {
        $this->sut['abc'] = 'def';
    }


    /**
     * @expectedException \edign8\Laravel\Exceptions\ReadOnlyModelException
     * @throws \Exception
     */
    public function testUnsetOffsetShouldThrowError()
    {
        unset($this->sut['abc']);
    }


    public function testRODBSetAttributeShouldNotThrowError()
    {
        $this->sut->readonlyDatabase = true;
        $this->sut->abc = 'def';
        self::assertSame('def', $this->sut->abc);
    }


    public function testRODBSetOffsetShouldNotThrowError()
    {
        $this->sut->readonlyDatabase = true;
        $this->sut['abc'] = 'def';
        self::assertSame('def', $this->sut['abc']);
    }


    public function testRODBUnsetOffsetShouldNotThrowError()
    {
        $this->sut->readonlyDatabase = true;
        $this->sut['abc'] = 'def';
        unset($this->sut['abc']);
        self::assertArrayNotHasKey('abc', $this->sut);
    }
}
