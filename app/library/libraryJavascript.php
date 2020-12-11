<?php

/**
 * libraryJavascript
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
class libraryJavascript
{
    /**
     * redirect
     */
    public static function redirect($sUrl)
    {
        $aJsCode = array(
            'window.location.href = "' . $sUrl . '";'
        );

        self::executeJsCode($aJsCode);
    }

    /**
     * historyBack
     */
    public static function historyBack()
    {
        $aJsCode = array(
            'window.history.back();'
        );

        self::executeJsCode($aJsCode);
    }

    /**
     * alert
     */
    public static function alert($sAlertMsg)
    {
        $aJsCode = array(
            'alert("' . $sAlertMsg . '");'
        );

        self::executeJsCode($aJsCode);
    }

    /**
     * alertBack
     * @param string $sAlertMsg
     */
    public static function alertBack($sAlertMsg)
    {
        self::alert($sAlertMsg);
        self::historyBack();
    }

    /**
     * alertRedirect
     * @param string $sAlertMsg
     * @param string $sRedirectUrl
     */
    public static function alertRedirect($sAlertMsg, $sRedirectUrl)
    {
        self::alert($sAlertMsg);
        self::redirect($sRedirectUrl);
    }

    /**
     * executeJsCode
     */
    private static function executeJsCode($aJsCode)
    {
        echo '<script>';

        foreach ($aJsCode as $sCommand) {
            echo $sCommand;
        }

        echo '</script>';
    }
}
