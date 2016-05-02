<?php

    namespace Slimmer;

    class Util {

        /**
         * Converts a string with any delimiter to a camelCased string
         *
         * @param string $string
         * @param string $delimiter
         * @param bool $ucfirst
         *
         * @return string
         */
        static function transformStringToCamelCase ($string, $delimiter, $ucfirst = false) {
            $camelCased = static::uppercaseStringPartsByDelimiter($string, $delimiter, '');

            return ($ucfirst) ? $camelCased : lcfirst($camelCased);
        }

        /**
         * Converts all parts of a delimiter separated string to upper case
         *
         * @param string $string
         * @param string $delimiter
         * @param string $afterConvertDelimiter
         *
         * @return string
         */
        static function uppercaseStringPartsByDelimiter ($string, $delimiter, $afterConvertDelimiter = null) {
            $afterConvertDelimiter = (!is_null($afterConvertDelimiter)) ? $afterConvertDelimiter : $delimiter;

            return implode($afterConvertDelimiter, array_map(function ($fragment) {
                return ucfirst($fragment);
            }, explode($delimiter, $string)));
        }

    }