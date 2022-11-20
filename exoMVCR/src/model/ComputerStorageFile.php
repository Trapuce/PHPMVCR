<?php
//namespace model;

// use \lib\ComputerFileDB;

class ComputerStorageFile implements ComputerStorage
{
	private $db;

	public function __construct($file)
	{
		$this->db = new ComputerFileDB($file);
	}
	public function reinit()
	{
		// $this->db->deleteAll();
		// $this->db->insert(new Computer('M1', 'Apple', "Ram 8GB", "trop cher"));
		// $this->db->insert(new Computer('Dell-Inspiron', 'Dell', "Hard Drive", "top dell"));
		// $this->db->insert(new Computer('Vivobook', 'Asus', "Processor", "trop asus"));
	}

	/**
	 * Returns an array of the computer's $id, or null if 
	 * the identifier does not match any computer.
	 * @param  string $id
	 * @return array computer information
	 */
	public function read($id)
	{
		if ($this->db->exists($id)) {
			return $this->db->fetch($id);
		} else {
			return null;
		}
	}
	/**
	 * @return array all computers
	 */
	public function readAll()
	{
		return $this->db->fetchAll();
	}
	/**
	 * Insert a new Computer in the database
	 * @param  Computer $c
	 * @return array new Computer
	 */
	public function create(Computer $c)
	{
		return $this->db->insert($c);
	}

	/**
	 * delete a computer
	 * @param  string $id
	 */
	public function delete($id)
	{
		$this->db->delete($id);
	}
	/**
	 * update the computer in the database
	 * @param  string $id
	 * @param  Computer $p
	 * @return boolean true if the computer is modified. False if not
	 */
	public function update($id, Computer $o)
	{
		if ($this->db->exists($id)) {
			$this->db->update($id, $o);
			return true;
		}
		return false;
	}
} ?>
