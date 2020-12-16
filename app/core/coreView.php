<?php

/**
 * coreView
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class coreView
{
    /**
     * @param string $sViewFile
     * The file name of the template.
     */
    protected $sViewFile;

    /**
     * @param array $aViewData
     * The data to be passed on the template.
     */
    protected $aViewData;

    /**
     * @var string $sTplDir
     */
    private $sTplDir;

    /**
     * __construct
     * @param string $sViewFile
     * @param array  $aViewData
     */
    public function __construct($sViewFile, $aViewData)
    {
        $this->sViewFile = VIEW . $sViewFile . '.phtml';
        $this->aViewData = $aViewData;
        $aViewFile = explode('/', $sViewFile);
        $this->aViewData['sPageName'] = $aViewFile[1];
        $this->sTplDir = $aViewFile[0];
        $this->render();
    }

    /**
     * render
     * Includes the template file.
     */
    private function render()
    {
        if (file_exists($this->sViewFile) === true) {
            extract($this->aViewData);
            include_once $this->sTplDir . '/template/header.phtml';
            include_once $this->sViewFile;
            include_once $this->sTplDir . '/template/footer.phtml';
        }
    }
}
