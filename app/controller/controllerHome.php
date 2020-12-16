<?php

/**
 * controllerHome
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class controllerHome extends controllerBase
{
    /**
     * __construct
     */
    public function __construct($aParams)
    {
        parent::__construct($aParams);
        $this->sTplDir = 'home';
    }

    /**
     * index
     */
    public function index()
    {
        $this->view('index');
    }

    /**
     * deliver
     */
    public function deliver()
    {
        $this->view('deliver');
    }
}