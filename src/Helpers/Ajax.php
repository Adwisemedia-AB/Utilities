<?php

namespace Adwisemedia\Helpers;

// phpcs:disable
if (!defined('ABSPATH')) {
    exit;
}

// phpcs:enable

class Ajax
{
    /**
     * Contains Ajax Response
     */
    private static $response = null;

    public static function newResponse()
    {
        self::resetResponse();
    }

    private static function resetResponse()
    {
        self::$response = new \stdClass();
        self::$response->status = 200;
        self::$response->message = '';
    }

    public static function setResponse($field, $value)
    {
        if ($field !== 'status') {
            self::$response->{$field} = $value;
        }
    }

    public static function setStatus($value, $default_error_status = false)
    {
        if ($default_error_status === true && self::$response->status !== 200) {
            return false;
        }

        self::$response->status = $value;
    }

    public static function sendResponse()
    {
        if (wp_doing_ajax()) {
            @header('Content-Type: application/json; charset=' . get_option('blog_charset'));
            status_header(self::$response->status);
            echo json_encode(self::$response);
            wp_die('', '', ['response' => null]);
        }

        if (!wp_doing_ajax()) {
            die();
        }
    }
}
