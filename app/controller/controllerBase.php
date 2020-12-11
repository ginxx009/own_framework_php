<?php

/**
 * controllerBase
 * @author Aries V. Macandili <macandili.aries@gmail.com>
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
     * checkLogin
     */
    public function checkLogin()
    {
        if (librarySession::isLogined() === false) {
            libraryJavascript::redirect('/admin/login');
            exit();
        }
    }
}