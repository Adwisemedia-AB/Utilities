<?php

namespace Adwisemedia\Utilities;

class Util
{
    public static function pp($print, $wp_die = false)
    {
        echo '<pre>';
        print_r($print);
        echo '</pre>';

        if (function_exists('wp_die') && $wp_die) {
            wp_die();
        }
    }

     /**
     * Helper function to find and replace last occurence of a word in string.
     * @return type
     */
    public static function strLReplace($search, $replace, $subject)
    {
        $pos = strrpos($subject, $search);

        if ($pos !== false) {
            $subject = substr_replace($subject, $replace, $pos, strlen($search));
        }

        return $subject;
    }

    /**
     * Parse string like "title:Hello world|weekday:Monday" to array( 'title' => 'Hello World', 'weekday' => 'Monday' )
     *
     * @param $value
     * @param array $default
     *
     * @since 4.2
     * @return array
     */
    public static function buildLink($value, $default = ['url' => false, 'title' => false, 'target' => '_self', 'rel' => ''])
    {
        $result = $default;

        if (gettype($value) === 'string') {
            $params_pairs = explode('|', $value);

            if (! empty($params_pairs)) {
                foreach ($params_pairs as $pair) {
                    $param = preg_split('/\:/', $pair);

                    if (! empty($param[0]) && isset($param[1])) {
                        switch ($param[0]) {
                            case 'url':
                                $result['href'] = rawurldecode($param[1]);
                                unset($result['url']);
                                break;

                            case 'title':
                                $result['aria-label'] = rawurldecode($param[1]);
                                $result[ $param[0] ] = rawurldecode($param[1]);
                                break;

                            default:
                                $result[ $param[0] ] = rawurldecode($param[1]);
                                break;
                        }
                    }
                }
            }
        }

        return (object) $result;
    }

    /**
     * Parse array, all string values that are "true" or "false" will be returned as booleans.
     *
     * @param array &$atts
     */
    public static function parseBool(&$atts)
    {
        if (! is_array($atts)) {
            return $atts;
        }

        array_walk_recursive($atts, function (&$a) {
            if ($a === "true") {
                $a = true;
            } elseif ($a === "false") {
                $a = false;
            }
        });
    }

    /**
     * Check if string is JSON
     *
     * @param string $string
     * @return boolean
     */
    public static function isJson($string)
    {
        json_decode($string);
        return ( json_last_error() == JSON_ERROR_NONE );
    }
}
