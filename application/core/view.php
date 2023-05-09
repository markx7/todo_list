<?php

class View
{

    public $session;

	function generate($content_view, $template_view, $data = null)
	{
        if(isset($_SESSION["Login"])){
            if($_SESSION["Login"] === "YES"){
                $this->session = true;
            }
            else{
                $this->session = false;
            }
        }
        else{
            $this->session = false;
        }

		include 'application/views/'.$template_view;
	}
}
