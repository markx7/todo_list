<?php

class Model_Base extends Model
{
	
	public function get_data($page=null, $sort=null)
	{
        $db = new DB;

        if(!$db->connect){
            echo "Ошибка подключения к БД  - ( ". $db->error." )";
            return;
        }

        $count = $db -> getRow("SELECT count(id) FROM to_do_list ")["count"];

        if($sort == null || $sort == "default"){
            $order = "ORDER BY id";
        }
        else{
            $arr_sort = explode("_", $sort);

            $order = "ORDER BY ".$arr_sort[0];

            if($arr_sort[1] == "z")
                $order .= " DESC";
        }

        if($page == null){
            $to_do_list = $db -> getAll("SELECT id, name, email, text, status FROM to_do_list ".$order." LIMIT 3 OFFSET 0");
        }
        else{
            $to_do_list = $db -> getAll("SELECT id, name, email, text, status FROM to_do_list ".$order." LIMIT 3 OFFSET ?", [($page-1) * 3]);
        }

        if(!$to_do_list)
            print_r($db->error);

        return ["count" => $count, "list" => $to_do_list];
	}

	public function set_data($post){

        $db = new DB;

        if(!$db->connect){
            return json_encode(["status" => false, "error" => $db->error]);
        }

        $result = $db -> execute("INSERT INTO to_do_list (name, email, text, status) VALUES (?, ?, ?, null)", [$post["name"], $post["email"], $post["text"]]);

        if(!$result)
            return json_encode(["status" => false, "error" => $db->error]);

        return json_encode(["status" => true, "data" => null]);
    }

    public function auth($post){

	    if($post["login"] == "admin" && $post["password"] == "123"){
            //session_start();
            $_SESSION["Login"] = "YES";
            return json_encode(["status" => true, "data" => null]);
        }
	    else{
            //session_start();
            $_SESSION["Login"] = "NO";
            return json_encode(["status" => false, "error" => null]);
        }
    }

    public function exit(){
        session_destroy();
        return json_encode(["status" => true, "data" => null]);
    }

    public function set_form($post){
        $db = new DB;

        if(!$db->connect){
            return json_encode(["status" => false, "error" => $db->error]);
        }

        $result = $db -> execute("UPDATE to_do_list SET (text, status) = (?, ?) WHERE id = ?", [$post["text"], $post["status"], $post["id"]]);

        if(!$result)
            return json_encode(["status" => false, "error" => $db->error]);

        return json_encode(["status" => true, "data" => null]);
    }

}
