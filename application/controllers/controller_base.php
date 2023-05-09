<?php

class Controller_Base extends Controller
{

    function __construct(){
        $this->model = new Model_Base();
        $this->view = new View();
    }

	function action_index(){
        $page = null;

        if(isset($_GET["page"])){
            $page = $_GET["page"];
        }

        $sort = null;

        if(isset($_GET["sort"])){
            $sort = $_GET["sort"];
        }

        $data = $this->model->get_data($page, $sort);
		$this->view->generate('base_view.php', 'temp_view.php', $data);
	}

	function action_save(){

        $err = [];

        if((trim($_POST['name']) == "")){
            $err[] = "name";
        }

        if(!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)){
            $err[] = "email";
        }

        if((trim($_POST['text']) == "")){
            $err[] = "text";
        }

        if(count($err) != 0){
            echo json_encode(["status" => false, "error" => implode(",", $err)]);
            return;
        }

        $post = [
            "name" => $_POST['name'],
            "email" => $_POST['email'],
            "text" => $_POST['text'],
        ];

        $data = $this->model->set_data($post);
        echo $data;
        return;
    }

    function action_authorization(){

        $err = [];

        if((trim($_POST['login']) == "")){
            $err[] = "login";
        }

        if((trim($_POST['password']) == "")){
            $err[] = "password";
        }

        if(count($err) != 0){
            echo json_encode(["status" => false, "error" => implode(",", $err)]);
            return;
        }

        $post = [
            "login" => $_POST['login'],
            "password" => $_POST['password']
        ];

        $data = $this->model->auth($post);
        echo $data;
        return;
    }

    function action_exit(){
        $data = $this->model->exit();
        echo $data;
        return;
    }

    function action_saveform(){

        if(isset($_SESSION["Login"])){
            if($_SESSION["Login"] === "YES"){

            }
            else{
                echo json_encode(["status" => false, "error" => "not_session"]);
                return;
            }
        }
        else{
            echo json_encode(["status" => false, "error" => "not_session"]);
            return;
        }

        $err = [];

        if((trim($_POST['id']) == "")){
            $err[] = "id";
        }

        if((trim($_POST['text']) == "")){
            $err[] = "text";
        }

        if((trim($_POST['status']) == "")){
            $err[] = "status";
        }

        if(count($err) != 0){
            echo json_encode(["status" => false, "error" => implode(",", $err)]);
            return;
        }

        $post = [
            "text" => $_POST['text'],
            "status" => $_POST['status'],
            "id" => $_POST['id']
        ];

        $data = $this->model->set_form($post);
        echo $data;
        return;
    }
}