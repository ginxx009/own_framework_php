<?php

/**
 * controllerAdmin
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class controllerRegister extends controllerBase
{
    /**
     * @var modelRegister $oModel
     */
    private $oModel = null;

    /**
     * __construct
     */
    public function __construct($aParams)
    {
        parent::__construct($aParams);
        $this->oModel = new modelRegister();
        $this->sTplDir = 'register';
    }

    /**
     * login
     */
    public function index()
    {
        $this->view('index');
    }

    public function doRegister()
    {
        $fullname = $this->aPostData['fullname'];
        $username = $this->aPostData['username'];
        $password = $this->aPostData['password'];

        if($this->oModel->CheckUsernameIfExist($username))
        {
            $result = array(
                'bResult'  => false,
                'sMsg'     => 'Username is already taken'
            );
        }
        else
        {
            $this->oModel->Register($fullname,$username,$password,0);
            $result = array(
                'bResult'   => true,
                'sMsg'      => 'Successfully Registered'
            );
        }

        echo json_encode($result);
    }
}
