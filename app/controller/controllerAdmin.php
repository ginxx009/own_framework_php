<?php

/**
 * controllerAdmin
 * @author Paul Kevin B. Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class controllerAdmin extends controllerBase
{
    /**
     * @var modelAdmin $oModel
     */
    private $oModel = null;

    /**
     * __construct
     */
    public function __construct($aParams)
    {
        parent::__construct($aParams);
        $this->oModel = new modelAdmin();
        $this->sTplDir = 'admin';
        $this->checkLoginAdmin();
    }

    /**
     * index
     */
    public function index()
    {
        
        $aData  = array(
            'getUser'       => librarySession::get('username'),
            'applicants'    => $this->oModel->CountDriver(),
            'drivers'       => $this->oModel->FetchLegitDrivers(),
            'countDriver'   => $this->oModel->CountLegitDrivers(),
            'topuprequests' => $this->oModel->GetAllTopUpRequest()
        );

        $this->view('index', $aData);
    }

    /**
     * Drivers
     */
    public function drivers()
    {
        
        $aData = array(
            'getUser'      => librarySession::get('username'),
            'getAllDriver' => $this->oModel->FetchAllDriver()
        );
        $this->view('drivers', $aData);
    }

    /**
     * TopUpRequest
     */

    public function topuprequest()
    {
       
        $aData = array(
            'getUser'       => librarySession::get('username'),
            'getAllRequest' => $this->oModel->FetchTopUpRequest()
        );
        $this->view('topuprequest', $aData);
    }

    /**
     * Admin Confirmation for accepting driver
     */
    public function admin_confirm()
    {
        $id = $this->aUrlParams[0];
        $log_message = "Welcome to delmover. Get your first top up now !";
        $date_log = date('Y-m-d H:i:s');
        if ($this->oModel->ApproveDriver($id, 1)) {
            $this->oModel->InsertHistoryLog($id, $log_message, $date_log);
            libraryJavascript::redirect('/admin/drivers');
        } else {

            libraryJavascript::alertRedirect('There was something wrong.', '/admin/drivers');
        }
    }

    /**
     * Admin Top Up Confirm
     */
    public function top_up_confirm()
    {
        $getId = $this->aUrlParams[0];
        $topUpRequest = $this->oModel->GetTopUpRequest($getId);
        $log_message = "Successfully added an amount of ".$topUpRequest['amount']." to your load balance";
        $date_log = date('Y-m-d H:i:s');
        $getBalance = $this->oModel->fetchUserDataID($getId);
        $newAmount = $getBalance['top_up'] + $topUpRequest['amount'];

        $aData = $this->oModel->AddELoad($getId,$newAmount);
        $this->oModel->UpdateConfirmation($getId,1,$date_log);
        $this->oModel->InsertHistoryLog($getId,$log_message,$date_log);
        libraryJavascript::redirect('/admin/topuprequest');
    }

    public function Logout()
    {
        $this->doLogout();
    }
}
