<?php
/**
 * MIT License
 *
 * Copyright (c) Jackey Cheung
 *
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in all
 * copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
 * SOFTWARE.
 *
 */

/* @noinspection AutoloadingIssuesInspection, PhpUnusedParameterInspection */

namespace Illuminate\Database\Query {

    class Builder
    {
        /**
         * Generate `LIKE '%xxx%'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param string                $boolean
         * @param bool                  $useWildcard `true` to allow wildcard
         *                                           in `$value`
         * @return Builder
         */
        public function whereContains(
            $column,
            $value = null,
            $boolean = 'and',
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `LIKE '%xxx%'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function orWhereContains(
            $column,
            $value = null,
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `NOT LIKE '%xxx%'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param string                $boolean
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function whereNotContains(
            $column,
            $value = null,
            $boolean = 'and',
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `NOT LIKE '%xxx%'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function orWhereNotContains(
            $column,
            $value = null,
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `LIKE 'xxx%'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param string                $boolean
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function whereStartsWith(
            $column,
            $value = null,
            $boolean = 'and',
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `LIKE 'xxx%'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function orWhereStartsWith(
            $column,
            $value = null,
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `NOT LIKE 'xxx%'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param string                $boolean
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function whereNotStartsWith(
            $column,
            $value = null,
            $boolean = 'and',
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `NOT LIKE 'xxx%'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function orWhereNotStartsWith(
            $column,
            $value = null,
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `LIKE '%xxx'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param string                $boolean
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function whereEndsWith(
            $column,
            $value = null,
            $boolean = 'and',
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `LIKE '%xxx'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function orWhereEndsWith(
            $column,
            $value = null,
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `NOT LIKE '%xxx'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param string                $boolean
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function whereNotEndsWith(
            $column,
            $value = null,
            $boolean = 'and',
            $useWildcard = false
        ): self {
            return $this;
        }


        /**
         * Generate `NOT LIKE '%xxx'` string filter
         *
         * @param string|array|\Closure $column
         * @param mixed                 $value
         * @param bool                  $useWildcard  `true` to allow wildcard
         *                                            in `$value`
         * @return Builder
         */
        public function orWhereNotEndsWith(
            $column,
            $value = null,
            $useWildcard = false
        ): self {
            return $this;
        }

    }
}

