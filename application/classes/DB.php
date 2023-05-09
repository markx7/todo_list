<?php

class DB
{
    private $driver = "pgsql";
    private $host = "localhost";
    private $db_name = "postgres";
    private $login = "test3";
    private $password = "test3";

    private $DBH;
    private $transaction;
    public $connect;
    public $error;

    public function __construct(){

        try{
            $this->DBH = new PDO($this->driver.":host = ".$this->host."; dbname=".$this->db_name, $this->login, $this->password);
            $this->connect = true;
            $this->DBH->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch(Exception $e) {

            $this->connect = false;
            $this->error = mb_convert_encoding($e->getMessage(), "utf-8", "windows-1251");
            file_put_contents("PDOErrors.txt", date("d.m.Y H:i:s")." :: ".$e->getMessage()."\r\n", FILE_APPEND);
        }
    }

    public function beginTransaction(){
        $DBH = $this-> DBH;
        $DBH -> beginTransaction();
        $this -> transaction = true;
    }

    public function commit(){
        try{
            $DBH = $this-> DBH;
            $DBH -> commit();
            return true;
        }
        catch(PDOException $e){
            $DBH = $this-> DBH;
            $this->error = mb_convert_encoding($e->getMessage(), "utf-8", "windows-1251");
            file_put_contents("PDOErrors.txt", date("d.m.Y H:i:s")." :: ".$e->getMessage()."\r\n", FILE_APPEND);
            return false;
        }
    }

    public function processing($request, $data, $type=null){
        try{
            $DBH = $this-> DBH;
            $STH = $DBH -> prepare($request);
            $STH -> execute($data);

            if($type === "getAll"){
                $arr_response = $STH -> fetchAll(PDO::FETCH_ASSOC);
                return $arr_response;
            }
            elseif($type === "getRow"){
                $arr_response = $STH -> fetch(PDO::FETCH_ASSOC);
                return $arr_response;
            }
            else{
                return true;
            }
        }
        catch(PDOException $e){
            if($this -> transaction)
                $DBH->rollBack();

            $this->error = mb_convert_encoding($e->getMessage(), "utf-8", "windows-1251");
            file_put_contents("PDOErrors.txt", date("d.m.Y H:i:s")." :: ".$e->getMessage()."\r\n", FILE_APPEND);
            return false;
        }
    }

    public function execute($request, $data){
        return $this->processing($request, $data);
    }

    public function getAll($request, $data=null){
        return $this->processing($request, $data, "getAll");
    }

    public function getRow($request, $data=null){
        return $this->processing($request, $data, "getRow");
    }
}
?>