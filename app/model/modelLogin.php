<?php

/**
 * modelAdmin
 * Class for admin-related database functionalities.
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
class modelLogin extends modelBase
{
    public function Login($username)
    {
        $query = "SELECT * FROM credential WHERE username = :username";
        $stmt = $this->prepare($query);
        $stmt->execute(array(':username' => $username));

        return array(
            'details'  => $stmt->fetch(),
            'rowCount' => $stmt->rowCount()
        );
    }
}
