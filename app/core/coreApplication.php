<?php

/**
 * coreApplication
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class coreApplication
{
    /**
     * @var string $sController
     */
    private $sController = '';

    /**
     * @var string $sAction
     */
    private $sAction = '';

    /**
     * @var array $aParams
     * Holder of parameter values fetched from the URL.
     */
    private $aParams = array();

    /**
     * @var stdClass $oClass
     * The controller instance.
     */
    private $oClass = null;

    /**
     * __construct
     */
    public function __construct()
    {
        $this->prepareUrl();
        $this->instantiateController();
    }

    /**
     * prepareUrl
     */
    private function prepareUrl()
    {
        $sRequestUri = trim($_SERVER['REQUEST_URI'], '/');
        if (empty($sRequestUri) === true) {
            $this->sController = 'controllerHome';
            return false;
        }
        
        $aUrl = explode('/', $sRequestUri);
        if($aUrl[0] == 'api')
        {
            include_once $aUrl[1];
            return false;
        }
        else
        {
            $this->sController = 'controller' . strtoupper($aUrl[0] ?? 'home');
            $this->sAction = $aUrl[1] ?? 'index';
            unset($aUrl[0], $aUrl[1]);
            $this->aParams = array_values($aUrl) ?? array();
        }
    }

    /**
     * instantiateController
     */
    private function instantiateController()
    {
        if(empty($this->sController))
            return false;

        // Check if controller file actually exists.
        if (file_exists(CONTROLLER . $this->sController . '.php') === true) {
            $this->oClass = new $this->sController($this->aParams);
            // Check if method exists.
            if (method_exists($this->oClass, $this->sAction) === true) {
                // Invoke the method, and pass the parameters, if any.
                call_user_func_array(array(
                    $this->oClass, $this->sAction
                ), $this->aParams);
                return true;
            }
            // Redirect to index method.
            $this->oClass->index();
            return false;
        }

        // Perform history back.
        libraryJavascript::historyBack();
        return false;
    }
}
