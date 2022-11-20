<?php
//namespace model;


class ComputerStorageStub implements ComputerStorage{

	private $ComputerTab;

	public function __construct(){
		$this->ComputerTab = [
				'macbook-air' => new Computer('M1', 'Apple' , "Ram 8GB" , "trop cher"),
				'Dell-Inspiron' => new Computer('Dell-Inspiron', 'Dell', "Hard Drive", "top dell"),
				'Vivobook' =>new Computer('Vivobook', 'Asus' , "Processor","trop asus"),
			];
	}
	public function getComputerTab(){
		return $this->ComputerTab;
	}

	public function read($id){

		return $this->ComputerTab[$id];
	}

	public function readAll(){
		return $this->ComputerTab;
	}
	public function create(Computer $o){
		return null ;
	}
	public function delete($id){
		return null ;
	}
	public function update($id, Computer $o){
		return null ;
	}
	
}