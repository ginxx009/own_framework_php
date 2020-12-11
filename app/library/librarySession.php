<?php

/**
 * librarySession
 * Class library for setting, getting, and checking session state.
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
class librarySession
{
    /**
     * set
     * Set a session variable.
     */
    public static function set($sKey, $sValue)
    {
        $_SESSION[$sKey] = $sValue;
    }

    /**
     * get
     * Get a session variable.
     */
    public static function get($sKey)
    {
        return $_SESSION[$sKey];
    }

    /**
     * isset
     * Check if a session variable is set.
     */
    public static function isset($sKey)
    {
        return (isset($_SESSION[$sKey]));
    }

    /**
     * all
     * Fetch all session variables.
     */
    public static function all()
    {
        return $_SESSION;
    }

    /**
     * isLogined
     */
    public static function isLogined()
    {
        return self::isset('isLoggedIn') === true && (int) self::get('user_category') !== 2;
    }
}
