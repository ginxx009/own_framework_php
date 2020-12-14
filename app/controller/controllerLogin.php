<?php

/**
 * controllerAdmin
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
class controllerLogin extends controllerBase
{
    /**
     * @var modelLogin $oModel
     */
    private $oModel = null;

    /**
     * __construct
     */
    public function __construct($aParams)
    {
        parent::__construct($aParams);
        $this->oModel = new modelLogin();
        $this->sTplDir = 'login';
    }


    /**
     * login
     */
    public function index()
    {
        $this->view('index');
    }

    /**
     * doLogin
     */
    public function doLogin()
    {
        $username = $this->aPostData['username'];
        $password = $this->aPostData['password'];

        $aQueryResult = $this->oModel->Login($username);
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
}
