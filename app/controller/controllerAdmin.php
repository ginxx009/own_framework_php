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
        $this->view('index');
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
        var_dump($this->aPostData);

        // if (isset($_POST['btn-login'])) {
        //     $username = $_POST['username'];
        //     $password = $_POST['password'];
        //     if ($user->Login($username, $password)) {

        //         $category = $_SESSION['user_category'];

        //         if ($category == 0) {
        //             libraryJavascript::redirect('/user');
        //         }
        //         else if ($category == 1) {
        //             libraryJavascript::redirect('/admin');
        //         }
        //         else {
        //             $error = "No Existing Credential Found!";
        //         }
        //     } else {
        //         libraryJavascript::alert('Incorrect Credential');
        //     }
        // }
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
}
