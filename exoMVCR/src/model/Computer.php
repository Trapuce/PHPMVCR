<?php
//namespace model;

class Computer
{
	private $mark;
	private $name;
	private $description;
	private $features;


	/**
	 * Computer constructor
	 * @param string $name
	 * @param string $description
	 * @param string $mark
	 * @param string $features
	 */
	public function __construct($name, $mark, $features, $description, $image)
	{
		if (!self::isNameValid($name)) {
			throw new Exception("Invalid name");
		}
		$this->name = $name;
		if (!self::isNameValid($mark)) {
			throw new Exception("Invalid mark");
		}
		$this->mark = $mark;
		if (!self::isDescriptionValid($features)) {
			throw new Exception("Invalid features");
		}
		$this->features = $features;
		if (!self::isDescriptionValid($description)) {
			throw new Exception("Invalid description");
		}
		$this->description = $description;
		$this->image = $image;
	}
	/**
	 * computer image getter
	 * @return string computer's image
	 */
	public function getImage()
	{
		return $this->image;
	}
	/**
	 * computer name getter
	 * @return string computer's name
	 */
	public function getName()
	{
		return $this->name;
	}

	/**
	 * computer description getter
	 * @return string computer's description
	 */
	public function getDescription()
	{
		return $this->description;
	}

	/**
	 * computer mark getter
	 * @return string computer's mark
	 */
	public function getMark()
	{
		return $this->mark;
	}

	/**
	 * computer features getter
	 * @return string computer's features
	 */
	public function getFeatures()
	{
		return $this->features;
	}
	public function setDescription($description)
	{
		if (!self::isDescriptionValid($description)) {
			throw new Exception("Invalid description");
		}
		$this->description = $description;
	}
	public function setName($name)
	{
		if (!self::isNameValid($name)) {
			throw new Exception("Invalid name");
		}
		$this->name = $name;
	}
	public function setMark($mark)
	{
		if (!self::isNameValid($mark)) {
			throw new Exception("Invalid Mark");
		}
		$this->mark = $mark;
	}
	public function setFeatures($features)
	{
		if (!self::isDescriptionValid($features)) {
			throw new Exception("Invalid Features");
		}
		$this->features = $features;
	}
	/**
	 * computer name verification
	 * @return string computer's name
	 */
	public static function isNameValid($name)
	{
		return mb_strlen($name, 'UTF-8') < 25 && $name !== "" && $name !== NULL;
	}


	/**
	 * computer description verification
	 * @return string computer's description
	 */
	public static function isDescriptionValid($description)
	{
		return mb_strlen($description, 'UTF-8') && $description !== "" && $description !== NULL;
	}
}
