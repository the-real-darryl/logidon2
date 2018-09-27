<?php
//if (!ISSET($_SESSION))		
//    session_start();    

require_once("../modeles/classes/2-Database.class.php");
require_once("../modeles/classes/6-LesDons.class.php");
require_once("../modeles/classes/3-Membre.class.php");
require_once("../modeles/config/MembreDAO.class.php");

class DonsDAO
{
    public function AttibuerEmploye() // utile
		{//  elle retourne l'ID du prochain Employé qui va traiter le Don
			$conn  = Database::getInstance();
			try
			{ 
			$pstmt = $conn->prepare(" SELECT ID, NUM_JETON FROM membre WHERE ACTIF = 1 AND GROUP_ID = 3 OR GROUP_ID = 4 ORDER BY ID ASC");
			$pstmt->execute();
			$rows = $pstmt->fetchAll();
			$id_Emp_actuel = 0;
			$id_Emp_Suivant = 0;
			for($i=0; $i < count($rows);$i++)
				{
					if( $rows[$i]['NUM_JETON'] == 1 )
						{
							if($i != count($rows)-1)
							{
								$id_Emp_actuel  = $rows[$i]['ID'];
								$id_Emp_Suivant = $rows[$i+1]['ID'];				
								break;
							}
							else
							{
								$id_Emp_actuel  = $rows[$i]['ID'];
								$id_Emp_Suivant = $rows[0]['ID'];							
								break;
							}							
						}											
				}
			$res = $conn->prepare( "UPDATE membre SET NUM_JETON = 0 WHERE ID =".$id_Emp_actuel);
			$res->execute();	
			$res = $conn->prepare("UPDATE membre SET NUM_JETON = 1 WHERE ID = ".$id_Emp_Suivant);
			$res->execute();
			$res->closeCursor();
				Database::close();

			}
			catch(Exception $e)
			{
				$conn->rollBack();
				echo "Failed : ". $e->getMessage();
			}		

			return $id_Emp_Suivant;
		}
	 
	public function createDon1($donateurID,$emp_id,$catDon,$nom,$DescDon,$qtt,$modeLivr,$montantDon,$dtPrm,$img,$compID=null)
		{ // pour inserer un Don dans la BDD
		  // l'ID du prochain employé qui va le traiter, sera donné dans Controle_CreateDon.php
			try
			{
				$conn  = Database::getInstance();
				$pstmt = $conn->prepare("INSERT INTO don (MEMBRE_ID,ID_COMPAGNIE,EMPLOYE_ID, CATEGORIE_ID,NOM,DESCRIPTION,QUANTITE,MODE_LIVRAISON,MONTANT,DATE_PROMESSE,DATE_PROMISE,PHOTO)
										VALUES (:zdonateurID,:zcompId,:emp, :zcatDon,:znom,:zdesc,:zqtt,:zmodeLivr,:zmont,now(),:zdtPrm,:zimg) ");
				$reponse = $pstmt ->execute(array('zdonateurID' => $donateurID ,
												  'zcompId' => $compID,
										          'emp' => $emp_id,
												  'zcatDon' => $catDon, 
												  'znom' => $nom, 
												  'zdesc' => $DescDon, 
												  'zqtt' => $qtt, 
												  'zmodeLivr' => $modeLivr, 
												  'zmont' => $montantDon, 
												  'zdtPrm' => $dtPrm, 
												  'zimg' =>$img));
				return $reponse;

			}
			catch(PDOException $e)
			{
				throw $e;
			}
		}		

	public function traiterImage($nom) // utile
	    {// pour traiter l'image envoyee par le donateur
		   $file_name = $_FILES[$nom]['name'];                   // nom de l'image envoye
		   $fichierTemp = $_FILES[$nom]['tmp_name'];             // le nom du dossier temporaire
           $div = explode('.', $file_name);
           $file_ext = strtolower(end($div));
           $nomImage = substr(md5(time()), 0, 10).'.'.$file_ext; // le nom de l'image qui sera stocke          
		   move_uploaded_file($fichierTemp, '../uploads/'.$nomImage);		   
		   return $nomImage;
		}
		
	public function getTot_Dons() // utile
		{ // cette fonction retourne le nombre des Dons pour l'afficher dans la PageAdmin
			$db = Database::getInstance();
	
			$pstmt = $db->prepare(" SELECT * FROM don ");
			$pstmt->execute();		
			$count = $pstmt->rowCount();								
			$pstmt->closeCursor();
			Database::close();
			return $count;;
		}	

	public function get_Somme_Dons() // utile
		{ //cette fonction retourne le montant totale des dons pour l'afficher dans la PageAdmin
			$db = Database::getInstance();			
			$pstmt = $db->prepare(" select SUM(MONTANT) AS total FROM don ");
			$pstmt->execute();
			$laSomme = 0;
			$row = $pstmt->Fetch(PDO::FETCH_ASSOC);
			$laSomme = $row['total'];		
			return $laSomme;
		}
	
	public function trouverDonsDonateur($courriel, $id) // utile 
		{ // trouver un don specifique qui appartient a un donateur
			$req = "SELECT don.*, membre.courriel FROM don JOIN membre ON membre.ID=don.MEMBRE_ID WHERE membre.courriel= ? AND don.ID = ? ";
			try 
		       {
					$conn = Database::getInstance();			
					$res = $conn->prepare($req);
					$res->execute(array($courriel, $id));
					$rows = $res->fetch();		  
					$res->closeCursor();
					Database::close();
			        return $rows;//return un tableau de 1 dimension
				}catch (PDOException $e)
			    {
					print "Error!: " . $e->getMessage() . "<br/>";
					return $rows;
		        }	
		}

	public function lesDonsDunDonateur($courriel) // utile
	    { // rechercher les dons donnés par un donateur(appellée dans vues/TousLesDons.php)
			$req = "SELECT don.ID,don.NOM, don.DESCRIPTION,don.QUANTITE,don.DATE_PROMESSE,don.DATE_PROMISE,don.DATE_ANNULATION,don.DATE_REFUS,don.DATE_RECU  FROM don JOIN membre ON membre.ID=don.MEMBRE_ID WHERE membre.courriel= ?";
			try 
				{
					$conn = Database::getInstance();			
					$res = $conn->prepare($req);
					$res->execute(array($courriel));
					$rows = $res->fetchAll();		  
					$res->closeCursor();
					Database::close();
					return $rows;//return un tableau de 1 dimension
				}catch (PDOException $e)
				{
					print "Error!: " . $e->getMessage() . "<br/>";
					return $rows;
				}	
	    }

	public function deleteDon($x) // utile
	    {// supprimmer un don de la BDD(appwllée dans Controle_DeleteDon.php)			
			try
			{
				$db = Database::getInstance();
	        	$pstmt = $db->prepare("UPDATE don SET DATE_ANNULATION = :d WHERE ID = :x");
		        $pstmt->execute(array( ':d' => $x->getDtAnnul(), ':x' => $x->getID()));
			}
			catch(PDOException $e)
			{
				throw $e;
			}
		}	
		
	public function updateDon1($nomDon,$DescDon,$qttDon,$catDon,$ModeLivr,$montantDon,$datePrm,$img,$IdDon) 
		{
			$db = Database::getInstance();			
		
			$stmt= $db->prepare("UPDATE don SET NOM = ?, DESCRIPTION = ?, QUANTITE = ?, CATEGORIE_ID = ?, MODE_LIVRAISON = ?, MONTANT = ?, DATE_PROMISE = ?, PHOTO = ?  WHERE ID = ?");
			$stmt->execute(array($nomDon,$DescDon,$qttDon,$catDon,$ModeLivr,$montantDon,$datePrm,$img,$IdDon));
			$stmt->closeCursor();
			Database::close();			
		}
    public function updateDon($nomDon,$DescDon,$qttDon,$catDon,$ModeLivr,$montantDon,$datePromise,$img,$IdDon) 
		{
			
			$request = "UPDATE don SET CATEGORIE_ID = ".$catDon.", NOM = '".$nomDon."',DESCRIPTION = '".$DescDon."', QUANTITE = ".$qttDon.", MODE_LIVRAISON = '".$ModeLivr."', MONTANT = ".$montantDon.", DATE_PROMISE = '".$datePromise."', PHOTO = '".$img."' WHERE don.ID = ".$IdDon;
			try
			{
				$conn = Database::getInstance();
				return $conn->exec($request);
			}
			catch(PDOException $e)
			{
				throw $e;
			}			
		}

		public function trouverDonsEmploye($idEmploye)
		{
			$cnx = Database::getInstance();
			try {
			$liste = Array();//new Liste();
		
			$pstmt = $cnx->prepare("SELECT * FROM don WHERE EMPLOYE_ID = :x  
				and DATE_ANNULATION IS NULL and `DATE_ACCEPTATION` IS NULL AND `DATE_RECU` IS NULL AND `DATE_REFUS` IS NULL ");
			$res = $pstmt->execute(array(':x' => $idEmploye));
			$res = $pstmt->fetchAll	(PDO::FETCH_OBJ);
		    foreach($res as $row) {
				$c = new LesDons();
				$c->loadFromObject($row);
				array_push($liste, $c); //$liste->add($c);
		    }
			$pstmt->closeCursor();
			Database::close();
			return $liste;
			} catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				return $liste;
			}	
		}	
		
		public function trouverDonParId($id){
			$cnx = Database::getInstance();
			try {		
				$pstmt = $cnx->prepare("SELECT * FROM don where ID = :x");
				$res = $pstmt->execute(array(':x' => $id));
				$res = $pstmt->fetch(PDO::FETCH_OBJ);
				if ($res){
					$c = new LesDons();
					$c->loadFromObject($res);
					$pstmt->closeCursor();
					Database::close();
					return $c;
				}
			} catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				return NULL;
			}	

		}	

		public function accepterDon($id){
			$cnx = Database::getInstance();
			try {		
				$pstmt = $cnx->prepare("UPDATE `don` SET `DATE_ACCEPTATION`= now() WHERE ID = :x");
				$res = $pstmt->execute(array(':x' => $id));
				return $res;
			} catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				return NULL;
			}	
		}

		public function refuserDon($id){
			$cnx = Database::getInstance();
			try {		
				$pstmt = $cnx->prepare("UPDATE `don` SET `DATE_REFUS`= now() WHERE ID = :x");
				$res = $pstmt->execute(array(':x' => $id));
				return $res;
			} catch (PDOException $e) {
				print "Error!: " . $e->getMessage() . "<br/>";
				return NULL;
			}	
		}

		public function modifyDon($x)
		{

			try
			{
				$db = Database::getInstance();			
		
				$stmt= $db->prepare("UPDATE don SET 
				NOM = :nom ,
				DESCRIPTION = :description ,
				 QUANTITE = :quantite,
				MODE_LIVRAISON = :mode_livraison,
				 MONTANT = :montant,
				  DATE_PROMESSE = :date_promesse,
				   DATE_PROMISE = :date_promise,
				DATE_ANNULATION = :date_annulation,
				 DATE_ACCEPTATION = :date_acceptation,
				  DATE_RECU = :date_recu,
				   DATE_REFUS = :date_refus,
				 PHOTO = :photo  WHERE ID = :id");

				$stmt->execute(array(':nom' => $x->getNomDon(),
				':description' => $x->getDESC_Don() ,
				':quantite' => $x->getQuantite(),
				':mode_livraison' => $x->getModeLivr(), 
				':montant' => $x->getMontantDon(),
				 ':date_promesse' => $x->getDtPromesse(),
				 ':date_promise' => $x->getDtPromise(),
				 ':date_annulation' => $x->getDtAnnul(),
				  ':date_acceptation' => $x->getDtAccept(), 
				  ':date_recu' => $x->getDtRecpt(),
				  ':date_refus' => $x->getDtRefu(),
				   ':photo' => $x->getPhoto(),
				   ':id' => $x->getID())
				);

				
				$stmt->closeCursor();
				Database::close();	
			}
			catch(PDOException $e)
			{
				throw $e;
			}			
		}
}

?>