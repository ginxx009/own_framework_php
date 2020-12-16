<?php

/**
 * controllerBase
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class controllerBase extends coreController
{
    /**
     * @var array $aUrlParams
     * URL query parameters.
     */
    protected $aUrlParams;

    /**
     * @var array $aPostData
     * $_POST request parameters.
     */
    protected $aPostData;

    /**
     * __construct
     */
    public function __construct($aUrlParams)
    {
        $this->aUrlParams = $aUrlParams;
        $this->aPostData = $_POST;
    }

    /**
     * checkLogin for admin
     */
    public function checkLoginAdmin()
    {
        if (librarySession::isLogined() === false) 
        {
            libraryJavascript::redirect('/login');
        }
    }

     /**
     * checkLogin for admin
     */
    public function checkLoginUser()
    {
        if (librarySession::isLogined() === false) 
        {
            libraryJavascript::redirect('/login');
        }
    }

    /**
     * Logout
     */

    public function doLogout()
    {
        librarySession::destroy();
        libraryJavascript::redirect('/');
    }
}