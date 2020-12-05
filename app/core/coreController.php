<?php

/**
 * coreController
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
class coreController
{
    /**
     * @var coreView $oView
     * The View instance.
     */
    protected $oView;

    /**
     * @var string $sTplDir
     * The template directory.
     */
    protected $sTplDir;

    /**
     * view
     * Instantiates the View class.
     */
    public function view($sViewName, $aData = array())
    {
        $this->oView = new coreView($this->sTplDir . '/' . $sViewName, $aData);
    }
}
