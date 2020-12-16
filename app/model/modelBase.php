<?php

/**
 * modelBase
 * @author Paul Kevin Macandili <macandili09@gmail.com>
 * @since 2020.12.05
 */
class modelBase extends PDO
{
    /**
     * @var string $sHost
     */
    private $sHost     = '';

    /**
     * @var string $sDbName
     */
    private $sDbName   = '';

    /**
     * @var string $sUsername
     */
    private $sUsername = '';

    /**
     * @var string $sPassword
     */
    private $sPassword = '';

    /**
     * __construct
     */
    public function __construct()
    {
        $this->setDsn();

        try {
            $sDsn = 'mysql:host=' . $this->sHost . ';dbname=' . $this->sDbName . ';';
            $aOptions = array(
                PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES   => false,
                PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
            );

            parent::__construct($sDsn, $this->sUsername, $this->sPassword, $aOptions);
        } catch (PDOException $oException) {
            echo 'Connection failed: ' . $oException->getMessage();
        }
    }

    /**
     * setDsn
     */
    private function setDsn()
    {
        $this->sHost     = 'localhost';
        $this->sDbName   = 'delmover_db';
        $this->sUsername = 'root';
        $this->sPassword = '';
    }
}
