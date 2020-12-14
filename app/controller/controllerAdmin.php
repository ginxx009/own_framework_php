<?php

/**
 * controllerAdmin
 * @author Aries V. Macandili <macandili.aries@gmail.com>
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
    }

    /**
     * index
     */
    public function index()
    {
        $this->checkLogin();

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
        $this->checkLogin();
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
        $this->checkLogin();
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
     * login
     */
    public function login()
    {
        $this->view('login');
    }

    /**
     * doLogin
     */
    public function doLogin()
    {
        $username = $this->aPostData['username'];
        $password = $this->aPostData['password'];

        $aQueryResult = $this->oModel->Login($username, $password);
        $aUserDetails = $aQueryResult['details'];

        $result = array(
            'bResult' => false,
            'sMsg'    => 'No Existing Credential Found!'
        );

        if ($aQueryResult['rowCount'] > 0) {
            if (password_verify($password, $aUserDetails['password'])) {
                librarySession::set('user_session', $aUserDetails['username']);
                librarySession::set('user_category', $aUserDetails['category']);
                librarySession::set('username', $aUserDetails['fullname']);
                librarySession::set('isLoggedIn', $aUserDetails['category'] != 2);

                if ($aUserDetails['category'] == 0) {
                    $result = array(
                        'bResult' => true,
                        'sUrl'    => '/user'
                    );
                } else if ($aUserDetails['category'] == 1) {
                    $result = array(
                        'bResult' => true,
                        'sUrl'    => '/admin'
                    );
                }
            } else {
                $result = array(
                    'bResult' => false,
                    'sMsg'    => 'Incorrect credentials!'
                );
            }
        }

        echo json_encode($result);
    }

    /**
     * register
     */
    public function register()
    {
        $this->view('register');
    }

    /**
     * doRegister
     */
    public function doRegister()
    {
        // if (isset($_POST['fullname']) && isset($_POST['username']) && isset($_POST['password'])) {
        //     if ($user->CheckUsernameIfExist($_POST['username'])) {
        //         libraryJavascript::alert('Username Already Exist! Please change the username.');
        //     } else {
        //     if ($user->Registration($_POST['fullname'], $_POST['username'], $_POST['password'], 0)) {
        //         libraryJavascript::alertRedirect('Registration Success', '/admin/login');
        //     }
        //     exit();
        // }
    }

    public function doLogout()
    {
        librarySession::destroy();
        libraryJavascript::redirect('/');
    }
}
