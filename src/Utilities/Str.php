<?php

namespace Adwisemedia\Utilities;

class Str
{
    /**
     * Simple function to convert a slug like a-random-slug to A Random Slug.
     *
     * @param string $word
     * @return string
     */
    public static function wordify($word)
    {
        return ucwords(str_replace(['-', '_'], ' ', $word));
    }

    public static function lmatch($str, $match = '')
    {
        if ($match === '') {
            return;
        }

        return substr($str, 0, strlen($match)) === $match;
    }

    /**
     * Helper function to genereate a unique alphanumeric string.
     *
     * @param type $limit
     * @return type
     */
    public function uniqueId($limit = 10)
    {
        return substr(base_convert(sha1(uniqid(mt_rand())), 16, 36), 0, $limit);
    }

     /**
     * Helper function to find and replace last occurence of a word in string.
     * @return type
     */
    public static function lreplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }
}
