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

/* @noinspection PhpUndefinedMethodInspection */
/* @noinspection PhpUndefinedFieldInspection, PhpUnusedParameterInspection */

namespace edign8\Laravel\Traits\Database\Eloquent;

use edign8\Laravel\Exception\ReadOnlyModelException;

/**
 * Makes the model read-only. If the `readonlyDatabase` member property is set
 * to `true`, only database changes are prohibited. Otherwise, all changes are
 * prohibited.
 */
trait ReadOnly
{

    /**
     * Prevent saving model to database
     */
    public static function bootReadOnly()
    {
        static::saving(
            function () {
                static::throwReadOnlyException();
            }
        );
        static::deleting(
            function () {
                static::throwReadOnlyException();
            }
        );
    }


    /**
     * Throws the read-only exception.
     *
     * @throws ReadOnlyModelException
     */
    public static function throwReadOnlyException()
    {
        throw new ReadOnlyModelException('This instance is read only');
    }


    /**
     * Prevent changing model properties
     *
     * @param $key
     * @param $value
     * @throws ReadOnlyModelException
     */
    public function setAttribute($key, $value)
    {
        if ($this->readonlyDatabase) {
            static::throwReadOnlyException();
        }
    }


    /**
     * Prevent changing model properties
     *
     * @param $offset
     * @param $value
     * @throws ReadOnlyModelException
     */
    public function offsetSet($offset, $value)
    {
        if ($this->readonlyDatabase) {
            static::throwReadOnlyException();
        }
    }


    /**
     * Prevent changing model properties
     *
     * @param $offset
     * @throws ReadOnlyModelException
     */
    public function offsetUnset($offset)
    {
        if ($this->readonlyDatabase) {
            static::throwReadOnlyException();
        }
    }
}
