<?php
//namespace model;

class ComputerBuilder
{

	protected $data;
	protected $errors;
	protected $imageData;


	/**
	 * Creates a new instance, with the data passed as an argument if they exist,
	 * and otherwise with the default values of the fields for creating a computer.
	 * @param string $data  $_POST data
	 * @param string $avatarData $_FILE data
	 */
	public function __construct($data = null, $imageData = null)
	{
		if ($data === null) {
			$data = array(
				"name" => "",
				"mark" => "",
				"features" => "",
				"description" => "",
			);
		}
		$this->data = $data;
		$this->imageData = $imageData;
		$this->errors = [];
	}

	public function getData($ref)
	{
		return key_exists($ref, $this->data) ? $this->data[$ref] : '';
	}

	public function getErrors($ref)
	{
		return key_exists($ref, $this->errors) ? $this->errors[$ref] : null;
	}
	/**
	 * Returns the reference of the field representing the name of a computer.
	 * @return string name
	 */
	public function getNameRef()
	{
		return "name";
	}
	/**
	 * Returns the reference of the field representing the mark of a computer.
	 * @return string mark
	 */
	public function getMarkRef()
	{
		return "mark";
	}
	/**
	 * Returns the reference of the field representing the features of a computer.
	 * @return string features
	 */
	public function getFeatRef()
	{
		return "features";
	}
	/**
	 * Returns the reference of the field representing the name of a computer.
	 * @return string image
	 */
	public function getImageRef()
	{
		return "image";
	}
	/**
	 * Returns the reference of the field representing the description of a computer.
	 * @return string description
	 */
	public function getDescriRef()
	{
		return "description";
	}

	/**
	 * Create a new instance of Computer with the data provided.
	 * If all are not present, an exception is thrown.
	 * @return Computer
	 */
	public  function createComputer()
	{

		if (!key_exists("name", $this->data)) {
			throw new Exception("Missing fields for computer creation");
		}
		if (!key_exists("mark", $this->data)) {
			throw new Exception("Missing fields for computer creation");
		}
		if (!key_exists("features", $this->data)) {
			throw new Exception("Missing fields for computer creation");
		}
		if (!key_exists("description", $this->data)) {
			throw new Exception("Missing fields for computer creation");
		}
		if (!key_exists("image", $this->imageData)) {
			throw new Exception("Missing fields for computer creation");
		}
		$name = $this->data["name"];
		$mark = $this->data["mark"];
		$features = $this->data["features"];
		$description = $this->data["description"];
		$image = $this->imageData["image"];

		return new Computer($name, $mark, $features, $description , $image);
	}

	/**
	 * Returns a new instance of ComputerBuilder with the editable data of the computer passed as an argument.
	 * @param  Computer $computer
	 * @return array instance of ComputerBuilder
	 */
	public static function builderFromToComputer(Computer $c)
	{
		return [
			"name" => $c->getName(),
			"mark" => $c->getMark(),
			"features" => $c->getFeatures(),
			"description" => $c->getDescription(),
		];
	}

	/**
	 * Verifies the validity of the data sent by the client
	 * @return boolean true is valid. False if not
	 */
	public function isValid()
	{
		$this->errors = [];
		if (!key_exists("name", $this->data) || $this->data["name"] === "") {
			$this->errors["name"] = "You must enter a computer's name.";
		} else if (mb_strlen($this->data["name"], 'UTF-8') >= 25) {
			$this->errors["name"] = "computer's name must be under 25 characters.";
		}
		if (!key_exists("mark", $this->data) || $this->data["mark"] === "") {
			$this->errors["mark"] = "You must enter a computer's mark.";
		} else if (mb_strlen($this->data["mark"], 'UTF-8') >= 25) {
			$this->errors["mark"] = "computer's mark must be under 25 characters.";
		}
		if (!key_exists("features", $this->data) || $this->data["features"] === "") {
			$this->errors["features"] = "You must enter a features.";
		} else if (mb_strlen($this->data["features"], 'UTF-8') >= 1000) {
			$this->errors["features"] = "computer's features must be under 1000 characters.";
		} else if (mb_strlen($this->data["features"], 'UTF-8') < 5) {
			$this->errors["features"] = "computer's features must be at least 5 characters long.";
		}
		if (!key_exists("description", $this->data) || $this->data["description"] === "") {
			$this->errors["description"] = "You must enter a description.";
		} else if (mb_strlen($this->data["description"], 'UTF-8') >= 1000) {
			$this->errors["description"] = "Computer's description must be under 1000 characters.";
		} else if (mb_strlen($this->data["description"], 'UTF-8') < 5) {
			$this->errors["description"] = "Computer's description must be at least 5 characters long.";
		}
		if (!key_exists("image", $this->imageData) || $this->imageData["image"]["name"] === "") {
			$this->errors["image"] = "You must choose an image for your computer.";
		} else if ($this->imageData["image"]['size'] >= 750000) {
			$this->errors["image"] = "Image size is too big.";
		}
		return count($this->errors) === 0;
		// if (!empty($this->data["name"]) && !empty($this->data["mark"])  && !empty($this->data["features"]) && !empty($this->data["description"])) {

		// 	return true;
		// } else {

		// 	if (empty($this->data["name"])) {
		// 		$this->errors["name"] = "Name is required";
		// 	}
		// 	if (empty($this->data["mark"])) {
		// 		$this->errors["mark"] = "mark is required";
		// 	}
		// 	if (empty($this->data["features"])) {
		// 		$this->errors["features"] = "features is required";
		// 	}
		// 	if (empty($this->data["description"])) {
		// 		$this->errors["description"] = "description is  required";
		// 	}


		// 	return false;
		// }
	}
	/**
	 * Updates an instance of Computer with the data provided
	 * @param  Computer $c
	 */
	public function updateComputer(Computer $c)
	{
		if (key_exists("name", $this->data))
			$c->setName($this->data["name"]);
		if (key_exists("mark", $this->data))
			$c->setMark($this->data["mark"]);
		if (key_exists("features", $this->data))
			$c->setFeatures($this->data["features"]);
		if (key_exists("description", $this->data))
			$c->setDescription($this->data["description"]);
	}
}
