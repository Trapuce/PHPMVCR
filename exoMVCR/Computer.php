<?php
/*
 * On indique que les chemins des fichiers qu'on inclut
 * seront relatifs au répertoire src.
 */
set_include_path("./src");

/* Inclusion des classes utilisées dans ce fichier */
require_once("view/View.php");
require_once("Router.php");
require_once("controller/Controller.php");
require_once("model/Computer.php");
require_once("model/ComputerStorage.php");
require_once("model/ComputerStorageStub.php");
require_once("model/ComputerStorageFile.php");
require_once("lib/ComputerFileDB.php");
require_once("model/ComputerBuilder.php");
require_once("model/ComputerStorageMySQL.php");
require_once('/users/traore213/private/mysql_config.php');

// str_replace('\\', '/', $classe)
//  function chargerClasse($classe)
// {
//     require_once str_replace('\\', '/', $classe).'.php'; // On inclut la classe correspondante au paramètre passé.
// }
// spl_autoload_register('chargerClasse');

/*
 * Cette page est simplement le point d'arrivée de l'internaute
 * sur notre site. On se contente de créer un routeur
 * et de lancer son main.
 */
$pdo =new PDO(
    'mysql:host='.$MYSQL_HOST.';dbname='.$MYSQL_DB.';charset=utf8',
     $MYSQL_USER,
     $MYSQL_PASSWORD,
    [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION],
    
);
$router = new Router(new ComputerStorageMySQL($pdo));
$router->main();
?>
