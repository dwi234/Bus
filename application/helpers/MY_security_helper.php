<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if ( ! function_exists('csrf_field'))
{
    /**
     * csrf_field
     *
     * Generates a hidden HTML input field containing the active CSRF token.
     * Keeps the site secure and allows easy form integration.
     *
     * @return string
     */
    function csrf_field()
    {
        $CI =& get_instance();
        $name = $CI->security->get_csrf_token_name();
        $hash = $CI->security->get_csrf_hash();
        return '<input type="hidden" name="' . htmlspecialchars($name, ENT_QUOTES, 'UTF-8') . '" value="' . htmlspecialchars($hash, ENT_QUOTES, 'UTF-8') . '" style="display:none;" />';
    }
}

if ( ! function_exists('csrf_hash'))
{
    /**
     * csrf_hash
     *
     * Returns the active CSRF token hash.
     *
     * @return string
     */
    function csrf_hash()
    {
        $CI =& get_instance();
        return $CI->security->get_csrf_hash();
    }
}

if ( ! function_exists('csrf_token'))
{
    /**
     * csrf_token
     *
     * Returns the active CSRF token name.
     *
     * @return string
     */
    function csrf_token()
    {
        $CI =& get_instance();
        return $CI->security->get_csrf_token_name();
    }
}
