<?php

class ComputerStorageMySQL implements ComputerStorage{

    private $bdd;

    public function __construct($pdo){
        try{
            $this->bdd =$pdo  ;
        }catch(Exception $e){
            throw new Exception("not yet implemented");

        }
    }

    public function read($id){
        $query = "SELECt * FROM computer WHERE id=:id";
        $statement = $this->bdd->prepare($query);
        $statement->execute([
            ":id" => $id
        ]);
        $data = $statement->fetch();
        return $data ;

	}

	public function readAll(){
        $query = "SELECT * FROM computer";
        $statement= $this->bdd->prepare($query);
        $statement->execute();
        $data =  $statement->fetchAll();
        return $data ;
	}
	public function create(Computer $c){
        $params = [
            ":name" => $c->getName(),
            ":mark" => $c->getMark(),
            ":features" => $c->getFeatures(),
            ":description" => $c->getDescription(),
            ":image"=>$c->getImage()['tmp_name']
          ];
        $query = "INSERT INTO computer(name , mark , features , description , image)  VALUES(:name , :mark , :features , :description, :image)";
        $statement =$this->bdd->prepare($query);
        $statement->execute($params);
        return $this->bdd->lastInsertId();

	}
	public function delete($id){
        $query = "DELETE FROM computer WHERE id=:id";
        $statement = $this->bdd->prepare($query);
        $statement->execute([":id"=> $id]);

	}
	public function update($id, Computer $c){
         $statement = self::read($id);
         if($statement == null){
            return false ;
         }else{
            $params = [
                ":name" => $c->getName(),
                ":mark" => $c->getMark(),
                ":features" => $c->getFeatures(),
                ":description" => $c->getDescription(),
                ":id" =>$id,
                ":image"=>$c->getImage()[0]
            ];
            $req = $this->bdd->prepare('UPDATE computer SET name = :name,
                mark = :mark , features =:features , description =:description ,image =:image  WHERE id = :id');
            
            $req->execute($params);
            return true ;
         }
	}
}
