<?php

namespace Adwisemedia\WordPress;

class Transients
{

    /**
     * Prefix all transients
     *
     * @author Jan Thore Skjelfjord
     * @since 1.0.0
     */
    private static $prefix = 'awm';

    /**
     * Languages if
     * Currently only works with Poylang.
     *
     * @author Jan Thore Skjelfjord
     * @since 1.0.0
     */
    private static $lang = 'default';

    /**
     * Default transient expiration time.
     *
     * @author Jan Thore Skjelfjord
     * @since 1.0.0
     */
    private static $default_expiration = ( HOUR_IN_SECONDS * 12 );


    public function __construct()
    {
        $this->setupLang();
        $this->setupActions();
    }

    public static function get($transient)
    {
        return get_transient(self::name($transient));
    }

    public static function set($transient, $value, $expiration = null)
    {
        $expiration = $expiration !== null ? $expiration : self::$default_expiration;
        return set_transient(self::name($transient), $value, $expiration);
    }

    public static function delete($transient)
    {
        return delete_transient(self::name($transient));
    }

    public static function deleteAll()
    {
        global $wpdb;

        if ($wpdb) {
            $wpdb->query(
                'DELETE FROM ' . $wpdb->options . ' WHERE option_name
                LIKE "_transient_' . self::$prefix . '%"'
            );
        }
    }

    private function setupActions()
    {
        add_action('edit_post', [__CLASS__, 'deleteAll']);
        add_action('create_post', [__CLASS__, 'deleteAll']);
        add_action('create_term', [__CLASS__, 'deleteAll']);
        add_action('delete_term', [__CLASS__, 'deleteAll']);
        add_action('edit_term', [__CLASS__, 'deleteAll']);
    }

    private function setupLang()
    {
        if (function_exists('pll_current_language')) {
            self::$lang = pll_current_language();
        }
    }

    public static function name($transient)
    {
        $name = sprintf('%1$s_%2$s_%3$s', self::$prefix, $transient, self::$lang);
        $name = str_replace('-', '_', $name);
        return $name;
    }
}
