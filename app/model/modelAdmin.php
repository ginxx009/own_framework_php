<?php

/**
 * modelAdmin
 * Class for admin-related database functionalities.
 * @author Aries V. Macandili <macandili.aries@gmail.com>
 * @since 2020.12.05
 */
class modelAdmin extends modelBase
{
    public function CountDriver()
    {
        $stmt = $this->prepare("SELECT COUNT(*) FROM user_profile WHERE account_activated = 0");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function FetchLegitDrivers()
    {
        $stmt = $this->prepare("SELECT * FROM user_profile WHERE account_activated = 1");
        $stmt->execute();
        return $stmt = $stmt->fetchAll();
    }

    public function CountLegitDrivers()
    {
        $stmt = $this->prepare("SELECT COUNT(*) FROM user_profile WHERE account_activated = 1");
        $stmt->execute();
        return $stmt = $stmt->fetchColumn();
    }

    public function GetAllTopUpRequest()
    {
        $stmt = $this->prepare("SELECT COUNT(*) FROM topup_request WHERE confirmed = 0");
        $stmt->execute();
        return $stmt = $stmt->fetchColumn();
    }

    public function FetchAllDriver()
    {
        $stmt = $this->prepare("SELECT * FROM user_profile WHERE account_activated = 0");
        $stmt->execute();
        return $stmt = $stmt->fetchAll();
    }

    public function FetchTopUpRequest()
    {
        $stmt = $this->prepare("SELECT * FROM topup_request");
        $stmt->execute();
        return $stmt = $stmt->fetchAll();
    }

    public function ApproveDriver($id, $activated_account)
    {
        $stmt = $this->prepare("UPDATE user_profile SET account_activated=:activated_account WHERE id=:id");
        $stmt->bindParam(":activated_account", $activated_account);
        $stmt->bindParam(":id", $id);
        return $stmt->execute();
    }

    public function InsertHistoryLog($user_id, $log_message, $date_log)
    {
        $stmt = $this->prepare("INSERT INTO user_history(user_id,log_message,date_log) VALUES(:user_id,:log_message,:date_log)");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":log_message", $log_message);
        $stmt->bindParam(":date_log", $date_log);
        return $stmt->execute();
    }

    public function GetTopUpRequest($user_id)
    {
        $stmt = $this->prepare("SELECT * FROM topup_request WHERE user_id=:user_id AND confirmed=0");
        $stmt->execute(array(':user_id' => $user_id));
        return $stmt->fetch();
    }

    public function fetchUserDataID($user_id)
    {
        $stmt = $this->prepare("SELECT * FROM user_profile WHERE id=:user_id");
        $stmt->execute(array(':user_id' => $user_id));
        return $stmt->fetch();
    }

    public function AddELoad($user_id, $amount)
    {
        $stmt = $this->prepare("UPDATE user_profile SET top_up=:amount WHERE id=:user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":amount", $amount);
        $stmt->execute();
        return $stmt;
    }

    public function UpdateConfirmation($user_id, $confirmed, $date_approved)
    {
        $stmt = $this->prepare("UPDATE topup_request SET confirmed=:confirmed, date_approved=:date_approved WHERE user_id=:user_id");
        $stmt->bindParam(":user_id", $user_id);
        $stmt->bindParam(":confirmed", $confirmed);
        $stmt->bindParam(":date_approved", $date_approved);
        $stmt->execute();
        return $stmt;
    }
}
