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

namespace edign8\Laravel\Database\Query;

use Illuminate\Database\Query\Builder as QueryBuilder;

class Builder
{
    public static function macros(): void
    {
        //region contains `LIKE '%xxx%'` string filter
        QueryBuilder::macro(
            'whereContains',
            function (
                $column,
                $value = null,
                $boolean = 'and',
                $useWildcard = false
            ) {
                $this->where(
                    $column,
                    'like',
                    sql_like($value, true, true, $useWildcard),
                    $boolean
                );
            }
        );

        QueryBuilder::macro(
            'orWhereContains',
            function ($column, $value = null, $useWildcard = false) {
                $this->whereContains($column, $value, 'or', $useWildcard);
            }
        );

        QueryBuilder::macro(
            'whereNotContains',
            function (
                $column,
                $value = null,
                $boolean = 'and',
                $useWildcard = false
            ) {
                $this->where(
                    $column,
                    'not like',
                    sql_like($value, true, true, $useWildcard),
                    $boolean
                );
            }
        );

        QueryBuilder::macro(
            'orWhereNotContains',
            function ($column, $value = null, $useWildcard = false) {
                $this->whereNotContains($column, $value, 'or', $useWildcard);
            }
        );
        //endregion

        //region starts with `LIKE 'xxx%'` string filter
        QueryBuilder::macro(
            'whereStartsWith',
            function (
                $column,
                $value = null,
                $boolean = 'and',
                $useWildcard = false
            ) {
                $this->where(
                    $column,
                    'like',
                    sql_like($value, true, false, $useWildcard),
                    $boolean,
                    $useWildcard
                );
            }
        );

        QueryBuilder::macro(
            'orWhereStartsWith',
            function ($column, $value = null, $useWildcard = false) {
                $this->whereStartsWith($column, $value, 'or', $useWildcard);
            }
        );

        QueryBuilder::macro(
            'whereNotStartsWith',
            function (
                $column,
                $value = null,
                $boolean = 'and',
                $useWildcard = false
            ) {
                $this->where(
                    $column,
                    'not like',
                    sql_like($value, true, false, $useWildcard),
                    $boolean,
                    $useWildcard
                );
            }
        );

        QueryBuilder::macro(
            'orWhereNotStartsWith',
            function ($column, $value = null, $useWildcard = false) {
                $this->whereNotStartsWith($column, $value, 'or', $useWildcard);
            }
        );
        //endregion

        //region ends with `LIKE '%xxx'` string filter
        QueryBuilder::macro(
            'whereEndsWith',
            function (
                $column,
                $value = null,
                $boolean = 'and',
                $useWildcard = false
            ) {
                $this->where(
                    $column,
                    'like',
                    sql_like($value, false, true, $useWildcard),
                    $boolean,
                    $useWildcard
                );
            }
        );

        QueryBuilder::macro(
            'orWhereEndsWith',
            function (
                $column,
                $value = null,
                $useWildcard = false
            ) {
                $this->whereEndsWith($column, $value, 'or', $useWildcard);
            }
        );

        QueryBuilder::macro(
            'whereNotEndsWith',
            function (
                $column,
                $value = null,
                $boolean = 'and',
                $useWildcard = false
            ) {
                $this->where(
                    $column,
                    'not like',
                    sql_like($value, false, true, $useWildcard),
                    $boolean,
                    $useWildcard
                );
            }
        );

        QueryBuilder::macro(
            'orWhereNotEndsWith',
            function ($column, $value = null, $useWildcard = false) {
                $this->whereNotEndsWith($column, $value, 'or', $useWildcard);
            }
        );
        //endregion

    }
}
