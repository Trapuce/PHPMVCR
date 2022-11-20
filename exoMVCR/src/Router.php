<?php
// use \view\View;
// use \controller\Controller;
// use \model\ComputerStorage;


class Router{

private $view ;
private $controller ;
private $db;
	public function __construct(ComputerStorage $db){
		$this->db = $db ;
		//$this->db->reinit();
	}

	public function main(){
		session_start();

		$feedback = key_exists('feedback', $_SESSION) ? $_SESSION['feedback'] : '';
		$_SESSION['feedback'] = '';
		 
		$this->view = new View($this,$feedback);
		$this->controller = new Controller($this->view , $this->db);
		if(array_key_exists("id",$_GET))
		{
			
			$this->controller->showInformationId($_GET['id']);


		}
		if(array_key_exists("list",$_GET))
		{
			
			$this->controller->showList();
		}
		if(array_key_exists("action",$_GET)){
			if($_GET['action'] == "new"){
				try{
					$this->controller->newComputer();
				}catch(Exception $e){
					echo $e;
				}
			}
			if($_GET['action'] == "saveNew"){
				try{
					$this->controller->saveNewComputer($_POST,$_FILES);
				}catch(Exception $e){
					echo $e;
				}
			}
			if($_GET['action'] == "delete" && !empty($_GET['id'])){
				try{

					$this->controller->askComputerDeletion($_GET['id']);
				}catch(Exception $e){
					echo $e;
				}
			}
			if($_GET['action'] == "confirmdelete"&& !empty($_GET['id'])){
				try{
					$this->controller->deleteComputer($_GET['id']);
				}catch(Exception $e){
					echo $e;
				}
			}
			if($_GET['action'] == "update" && !empty($_GET['id'])){
				try{
					$this->controller->askComputerUpdate($_GET['id']);
				}catch(Exception $e){
					echo $e;
				}
			}
			if($_GET['action'] == "confirmupdate"&& !empty($_GET['id'])){
				try{
					$this->controller->updateComputer($_GET['id'] ,$_POST,$_FILES);
				}catch(Exception $e){
					echo $e;
				}
			}
		}
		
		if($_GET == []){
			$this->view->makeTestPage();
		}
		if(array_key_exists("about",$_GET))
		{
			
			$this->view->makeAboutPage();
		}
		
			//$this->view->makeDebugPage($_SERVER['REQUEST_URI']);
		$this->view->render();

		 
	}
	/**
	 * homePage url
	 * @return string home url
	 */
	public function getHomePage(){
		return "Computer.php";
	}
	/**
	 * all Computer page url
	 * @return string computer list url
	 */
	public function getComputersListURL(){
		return "?list";
	}
	/**
	 * Computer url
	 * @return string computer page url
	 */
	public function getComputerURL($id){

		 return "?id=$id";
	}

	/**
	 * @return string create computer form url
	 */
	 public function getComputerCreationURL(){
	 	return "?action=new";
	 }
	 /**
	 * @return string create computer confirmed url
	 */
	 public function getComputerSaveURL(){
	 	return "?action=saveNew";
	 }
	public function getComputerAskDeletionURL($id){
	 	return "?id=$id&action=delete";
	}
	/**
	 * Computer deletion page url
	 * @return string delete computer url
	 */
	 public function getComputerDeletionURL($id){
	 	return "?id=$id&action=confirmdelete";
	 }
	 /**
	 * Computer modify page url
	 * @return string modify computer form url
	 */
	public function getAskComputerUpdateURL($id){
	 	return "?id=$id&action=update";
	 }
	 /**
	 * Computer update page url
	 * @return string modify computer confirmed url
	 */
	 public function getComputerUpdateURL($id){
	 	return "?id=$id&action=confirmupdate";
	 }
	 /**
	 * about page url
	 * @return string about url
	 */
	public function aboutPage(){
		return "?about";
	}
	 /**
	 * POST-redirect-GET function
	 * @param string $url      redirection link
	 * @param string $feedback redirection message
	 */
	 public function  POSTredirect($url, $feedback){
	  	$_SESSION['feedback'] = $feedback;
	  	header("Location:" . $url, 303);
	 }
}
?>