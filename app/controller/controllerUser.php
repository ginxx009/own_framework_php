<?php

/**
 * controllerUser
 * @author Paul Kevin B. Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class controllerUser extends controllerBase
{
    /**
     * @var modelUser $oModel
     */
    private $oModel = null;

    /**
     * __construct
     */
    public function __construct($aParams)
    {
        parent::__construct($aParams);
        $this->oModel = new modelUser();
        $this->sTplDir = 'user';
        $this->checkLoginUser();
    }

    /**
     * index
     */
    public function index()
    {
        
        $username = librarySession::get('username');
        $aUserData = $this->oModel->HistoryLogHelper($username);
        $aGetBalance = $this->oModel->FetchTopUp($username);

        $aData  = array(
            'getUser'       => $username,
            'isAccountActivated' => $this->oModel->AccountActivated($username),
            'userprofile' => $aUserData,
            'userhistory' => $this->oModel->ShowHistoryLog($aUserData),
            'getBalance' => $aGetBalance

        );

        $this->view('index', $aData);
    }

    /**
     * User Top Up
     */
    public function user_topup()
    {
        $username = librarySession::get('username');

        $aData = array(
            'getUser' => $username,
            'isAccountActivated' => $this->oModel->AccountActivated($username)
        );

        $this->view('user_topup',$aData);
    }

    /**
     * User Top up Request
     */
    public function top_up_request()
    {
        $amount = $this->aPostData['amount'];
        $user_id = $this->oModel->UserFetchId(librarySession::get('username'));
        $username = librarySession::get('username');
        $date_log = date('Y-m-d H:i:s');
        $log_message = "You requested an amount of " . $amount . " to top up. Waiting for approval";
        $default_date = "0000-00-00 00:00:00";


       $this->oModel->TopUpRequest($user_id,$username,$amount,0,$default_date);
       $this->oModel->InsertHistoryLog($user_id,$log_message,$date_log);

        $result = array(
            'iAmount' => $amount,
            'sMsg'    => "Success",
            'bResult' => true
        );
        echo json_encode($result);
        // libraryJavascript::redirect('/user/user_topup');
    }

    public function Logout()
    {
        $this->doLogout();
    }
}
