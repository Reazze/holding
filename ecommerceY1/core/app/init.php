<?php

if(!isset($_GET["action"])){
//	Bootload::load("default");
	Module::loadLayout("index");
}else{
	Action::load($_GET["action"]);
}

?>