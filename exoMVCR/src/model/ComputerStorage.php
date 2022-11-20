<?php
//namespace model;


interface ComputerStorage{

	public function read($id);
	public function readAll();
	public function create(Computer $o);
	public function delete($id);
	public function update($id, Computer $o);
}