<?php

namespace Adwisemedia\Utilities;

class Arr
{
    public static function search($key, $value, $array)
    {
        $results = [];

        if (is_array($array)) {
            if (isset($array[ $key ]) && $array[ $key ] == $value) {
                $results[] = $array;
            }

            foreach ($array as $subarray) {
                $results = array_merge($results, self::search($key, $value, $subarray));
            }
        }

        return $results;
    }

    public static function findParentKey($array, $needle, $parent = null)
    {
        foreach ($array as $key => $value) {
            if (! is_array($value)) {
                $pass = $parent;

                if (is_string($key)) {
                    $pass = $key;
                }

                $found = self::findParentKey($value, $needle, $pass);

                if ($found !== false) {
                    return $found;
                }
            } elseif ($key === 'id' && $value === $needle) {
                return $parent;
            }
        }

        return false;
    }
}
