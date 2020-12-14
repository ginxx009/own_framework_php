<?php

/**
 * modelAdmin
 * Class for admin-related database functionalities.
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
class modelRegister extends modelBase
{
    public function Register($fullname, $username, $password, $category)
    {

        //name doesn't exist so proceed to registration
        $new_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $this->prepare("INSERT INTO credential(fullname,username,password,category) VALUES(:fullname, :username, :password, :category)");
        return $stmt->execute(array(':fullname' => $fullname, ':username' => $username, ':password' => $new_password, 'category' => $category));
    }

    public function CheckUsernameIfExist($username)
    {
        $checkUser = $this->prepare("SELECT * FROM credential WHERE username=:username");
        $checkUser->execute(array(':username' => $username));
        if ($checkUser->rowCount() > 0) {
            librarySession::set('ExistUsername', true);
            return true;
        }
        librarySession::set('ExistUsername', false);
        return false;
    }
}
