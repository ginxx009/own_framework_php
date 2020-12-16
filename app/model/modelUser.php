<?php

/**
 * modelUser
 * Class for admin-related database functionalities.
 * @author Paul Kevin B. Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class modelUser extends modelBase
{
    public function AccountActivated($username)
    {
        $stmt = $this->prepare("SELECT * FROM user_profile WHERE username=:username");
        $stmt->bindParam(":username", $username);
        $stmt->execute();
        $stmt->fetchColumn();
        if ($stmt->rowCount() > 0)
            return true;
        else
            return false;
    }

    public function ShowHistoryLog($user_id)
    {
        $stmt = $this->prepare("SELECT * FROM user_history WHERE user_id=:user_id");
        $stmt->execute(array(':user_id' => $user_id));
        return $stmt->fetchAll();
    }

    public function HistoryLogHelper($username)
    {
        $stmt = $this->prepare("SELECT * FROM user_profile WHERE username=:username");
        $stmt->execute(array(':username' => $username));
        return $stmt->fetchColumn();
    }

    public function FetchTopUp($username)
    {
        $stmt = $this->prepare("SELECT top_up FROM user_profile WHERE username=:username");
        $stmt->execute(array(':username' => $username));
        return $stmt->fetchColumn();
    }

    public function UserFetchData($username)
    {
        $stmt = $this->prepare("SELECT * FROM user_profile WHERE username=:username");
        $stmt->execute(array(':username' => $username));
        return $stmt->fetch();
    }

    public function UserFetchId($username)
    {
        $stmt = $this->prepare("SELECT * FROM user_profile WHERE username=:username");
        $stmt->execute(array(':username' => $username));
        return $stmt->fetchColumn();
    }

    public function TopUpRequest($user_id, $username, $amount, $confirmed, $date_approved)
    {
        $stmt = $this->prepare("INSERT INTO topup_request(user_id,username,amount,confirmed,date_approved) VALUES(:user_id,:username,:amount,:confirmed,:date_approved)");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":amount", $amount);
        $stmt->bindParam(":username", $username);
        $stmt->bindParam(":confirmed", $confirmed);
        $stmt->bindParam(":date_approved", $date_approved);
        $stmt->execute();
        return $stmt;
    }

    public function InsertHistoryLog($user_id, $log_message, $date_log)
    {
        $stmt = $this->prepare("INSERT INTO user_history(user_id,log_message,date_log) VALUES(:user_id,:log_message,:date_log)");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":log_message", $log_message);
        $stmt->bindParam(":date_log", $date_log);
        $stmt->execute();
        return $stmt;
    }
}
