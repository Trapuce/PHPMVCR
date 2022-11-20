<?php
// namespace view;
// use \model\Computer;
// use \model\ComputerBuilder;
class View {

	private $title ;
	private $content;
	private $router;
	private $feedback;
	

    /* CONSTRUCTOR */
	public function __construct($router, $feedback){
			$this->router = $router;
			$this->feedback = $feedback;
	}


	/*Render the page */ 
	public function render(){

		require "Squelette.php";
	}
    /******************************************************************************/
	/* HELPERS                                                                    */
	/******************************************************************************/
	public function getMenu() {
		return array(
			"Home" => $this->router->getHomePage(),
			"PC" => $this->router->getComputersListURL(),
			"Add new Pc" => $this->router->getComputerCreationURL(),
			"About"=>$this->router->aboutPage()
		);
	}
	public function makeDebugPage($variable) {
		$this->title = 'Debug';
		$this->content = '<pre>'.htmlspecialchars(var_export($variable, true)).'</pre>';
		}
	public function makeTestPage(){

		$this->title = "welcome to the computers site ";
		$this->content = "look at our models";
		
	}
    /** 
	 * Method displaying a specific computer.
	 * @param $id The identifier of the computer to retrieve
	 * @param Computer $computer 
	 * 
	*/
	public function makeComputerPage($id , $computer){
		$this->title = self::htmlesc($computer["name"]);
		$this->content = '<div>';
		$this->content ='<span><strong>Mark: </strong>'.self::htmlesc($computer["mark"]).'</span><br><br>';
		$this->content .= '<span><strong>Product information :</strong>'.self::htmlesc($computer["features"]).'</span><br><br>';
		$this->content .= '<span><strong>Description :</strong>'.self::htmlesc($computer["description"]).'</span><br><br>';
		$this->content .= '<div>';
		$this->content .= '<button><a href="'.$this->router->getAskComputerUpdateURL($id).'">Modify</a></button><br><br>';
		$this->content .= '<button><a href="'.$this->router->getComputerAskDeletionURL($id).'">Delete</a></button><br><br>';
		$this->content .= '</div>';
		$this->content .='</div>';
	

	}
    /**
	 * Method displaying errors messages.
	 * @param string $title
	 * @param string $message
	 * 
	 */
	public function makeUnknownComputerPage(){
		$this->title = "This planet doesn't exist";
		$this->content = "NOT FOUND";
	}
    /**
	 * Methods that displays a
	 * list of computers Each entry is an instance of Computers.
	 * @param array Computer
	 * 
	 */
	public function makeListPage($tabs){
		$this->title = "Computers";
		$this->content ='<ul class="listOrdi">';
		foreach ($tabs as  $value) {
			   $this->content .= '<li><a href="'.$this->router->getComputerURL($value['id']).'">'.$value['name'].'</a></li><br>';
		}
		$this->content .= '</ul>';

	}

	/**
	 * @param ComputerBuilder
	 * Method that displays a creation form
	 */
	public function makeCreateComputerPage(ComputerBuilder $computerbuilder){
		$name = $computerbuilder->getNameRef();
		$mark = $computerbuilder->getMarkRef();
		$feat = $computerbuilder->getFeatRef();
		$descri = $computerbuilder->getDescriRef();
		$image = $computerbuilder->getImageRef();
		$errName = ($computerbuilder->getErrors($name))?$computerbuilder->getErrors($name):'';
		$errMark = ($computerbuilder->getErrors($mark))?$computerbuilder->getErrors($mark):'';
		$errFeat = ($computerbuilder->getErrors($feat))?$computerbuilder->getErrors($feat):'';
		$errDescri = ($computerbuilder->getErrors($descri))?$computerbuilder->getErrors($descri):'';
		$errImage = ($computerbuilder->getErrors($image))?$computerbuilder->getErrors($image):'';


		$this->title = 'Add a New PC';
        $this->content =  '<form action="'.$this->router->getComputerSaveURL().'" method="post" enctype= "multipart/form-data">';
        $this->content .= '<label for="name">Name :<input type="Text" Placeholder="Enter name" id="name" name="'.$name.'" value="'.self::htmlesc($computerbuilder->getData($name)).'"></label>';
		$this->content .= '<span class="error">* '. $errName .'</span><br><br>';
        $this->content .= '<label for="mark">Mark :<input type="Text" Placeholder="Enter  mark" id="mark" name="'.$mark.'"value="'.self::htmlesc($computerbuilder->getData($mark)).'"></label>';
		$this->content .= '<span class="error">* '. $errMark .'</span><br><br>';
        $this->content .= '<label for="feat">Features :<textarea type="Text" Placeholder="give a product information " id="feat" name="'.$feat.'">'.self::htmlesc($computerbuilder->getData($feat)).'</textarea></label>';
		$this->content .= '<span class="error">* '.$errFeat.'</span><br><br>';
		$this->content .= '<label for="descri">Description :<textarea type="Text" Placeholder="give a computer description" id="descri" name="'.$descri.'">'.self::htmlesc($computerbuilder->getData($descri)).'</textarea></label>';
		$this->content .= '<span class="error">* '.$errDescri.'</span><br><br>';
		$this->content .= "<label>Select your computer's looks: </label><input type='file' name='".$image."'>";
		$this->content .= '<span class="error">* '.$errImage.'</span><br><br>';
        $this->content .=  '<input type="submit" value="Valider"></form>';
        
	}

	/**
	 * @param string $id
	 * @param ComputerBuilder
	 * displays a form with given ComputerBuilder
	*/
	public function makeModifyComputer($computerid , ComputerBuilder $computerbuilder){
		$name = $computerbuilder->getNameRef();
		$mark = $computerbuilder->getMarkRef();
		$feat = $computerbuilder->getFeatRef();
		$descri = $computerbuilder->getDescriRef();
		$image = $computerbuilder->getImageRef();

		$errName = ($computerbuilder->getErrors($name))?$computerbuilder->getErrors($name):'';
		$errMark = ($computerbuilder->getErrors($mark))?$computerbuilder->getErrors($mark):'';
		$errFeat = ($computerbuilder->getErrors($feat))?$computerbuilder->getErrors($feat):'';
		$errDescri = ($computerbuilder->getErrors($descri))?$computerbuilder->getErrors($descri):'';
		$errImage = ($computerbuilder->getErrors($image))?$computerbuilder->getErrors($image):'';

		$this->title = "Modify Computer";
        $this->content =  '<form action="'.$this->router->getComputerUpdateURL($computerid).'" method="post";enctype= "multipart/form-data">';
        $this->content .= '<label for="name">Name :<input type="Text" Placeholder="Enter name" id="name" name="'.$name.'" value="'.self::htmlesc($computerbuilder->getData($name)).'"></label>';
		$this->content .= '<span class="error">* '. $errName .'</span><br><br>';
        $this->content .= '<label for="mark">Mark :<input type="Text" Placeholder="Enter  mark" id="mark" name="'.$mark.'"value="'.self::htmlesc($computerbuilder->getData($mark)).'"></label>';
		$this->content .= '<span class="error">* '. $errMark .'</span><br><br>';
        $this->content .= '<label for="feat">Features :<textarea type="Text" Placeholder="give a product information " id="feat" name="'.$feat.'">'.self::htmlesc($computerbuilder->getData($feat)).'</textarea></label>';
		$this->content .= '<span class="error">* '.$errFeat.'</span><br><br>';
		$this->content .= '<label for="descri">Description :<textarea type="Text" Placeholder="give a computer description" id="descri" name="'.$descri.'">'.self::htmlesc($computerbuilder->getData($descri)).'</textarea></label>';
		$this->content .= '<span class="error">* '.$errDescri.'</span><br><br>';
		$this->content .= "<label>Select your computer's looks: </label><input type='file' name='".$image."'>";
		$this->content .= '<span class="error">* '.$errImage.'</span><br><br>';
        $this->content .=  '<input type="submit" value="Modify"></form>';





		
	}

	/**
	 * @param $id
	 *@param Computer
	 *displays a page delete
	 */
	public function makeComputerDeletionPage($id , $computer){
			$this->title ="delete";
			$this->content ="are you sure to delete computer".$computer["name"];
			$this->content .='<button><a href="'.$this->router->getComputerDeletionURL($id).'">Confirm</a></button>';
	}
	public function makeAboutPage(){
		$this->title = "About this website";
		$this->style = "about.css";
		$this->content = "";
		$this->content .= "<div class='about'>";
		$this->content .= "<h2> Why?</h2>";
		$this->content .= "<p> This website was created by <u>21600538</u></p>";
	}
	/* Une fonction pour échapper les caractères spéciaux de HTML,
	* car celle de PHP nécessite trop d'options. */
	public static function htmlesc($str) {
		return htmlspecialchars($str,
			/* on échappe guillemets _et_ apostrophes : */
			ENT_QUOTES
			/* les séquences UTF-8 invalides sont
			* remplacées par le caractère �
			* au lieu de renvoyer la chaîne vide…) */
			| ENT_SUBSTITUTE
			/* on utilise les entités HTML5 (en particulier &apos;) */
			| ENT_HTML5,
			'UTF-8');
	}

	/******************************************************************************/
	/* Redirection                                                                 */
	/******************************************************************************/
	public function	displayComputerCreationSuccess($id){
		$this->router->POSTredirect( $this->router->getComputerURL( $id ) ,"You have successfully created your computer");
	}
	public function	displayComputerDeletionSuccess($id){
		$this->router->POSTredirect($this->router->getComputersListURL() ,"This computer was destroyed!");
	}
	

   public function displayComputerNotCreatedPage(){
	$this->router->POSTredirect($this->router->getComputerCreationURL() ,"Your computer was not created!");

   }
  
   
  

	public function displayComputerModifiedPage($id){
		$this->router->POSTredirect($this->router->getComputerURL($id), "Your creation has been successfully modified!");
	}

	public function displayComputerNotModifiedPage($id){
		$this->router->POSTredirect($this->router->getAskComputerUpdateURL($id), "Failed to modify your computer.");
	}
      
}