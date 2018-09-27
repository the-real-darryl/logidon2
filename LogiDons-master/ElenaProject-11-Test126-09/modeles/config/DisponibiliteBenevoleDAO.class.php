<?php
require_once("../modeles/classes/2-Database.class.php");
require_once("../modeles/classes/DisponibiliteBenevole.class.php");
require_once("../modeles/classes/3-Membre.class.php");

class DisponibiliteBenevoleDAO
{
    private function __construct() {}
        
    public static function create($x)
    {
        $db = Database::getInstance();
		$pstmt = $db->prepare("INSERT INTO disponibilitebenevole (FKBENEVOLE,DATE,DEBUT,FIN,ACCEPTER,NOTE) 
		                                  VALUES (:fkbenevole,:date,:debut,:fin,:accepter,:note)");	
		try
		{
			$DisponibiliteBenevoleResult =  $pstmt->execute(array(':fkbenevole' => $x->getFkBenevole(),
											':date' => $x->getDate(),
											':debut' => $x->getdebut(),
											':fin' => $x->getFin(),
											':accepter' => $x->getAccepter(),
											':note' => $x->getNote(),							
											));
			
			return $DisponibiliteBenevoleResult;
		}
		catch(PDOException $e)
		{
			throw $e;
		}
    }

    public static function findJourTravailler($x)
    {
        $db = Database::getInstance();
		$pstmt = $db->prepare("SELECT * FROM disponibilitebenevole WHERE FKBENEVOLE = :x and TRAITER = TRUE AND ACCEPTER = TRUE");
        $pstmt->execute(array(':x' => $x->getid()));

        $d = $pstmt->fetchAll(PDO::FETCH_OBJ);;
        $pstmt->closeCursor();
		Database::close();
        return $d;
	}
	
	public static function findJourATravailler($x)
    {
        $db = Database::getInstance();
		$pstmt = $db->prepare("SELECT * FROM disponibilitebenevole WHERE FKBENEVOLE = :x AND TRAITER = FALSE");
        $pstmt->execute(array(':x' => $x->getid()));

        $d = $pstmt->fetchAll(PDO::FETCH_OBJ);;
        $pstmt->closeCursor();
		Database::close();
        return $d;
    }
}