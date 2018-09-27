<?php
require_once('../modeles/classes/3-Membre.class.php');
require_once('../modeles/config/MembreDAO.class.php');
require_once('../modeles/classes/disponibiliteBenevole.class.php');
require_once('../modeles/config/DisponibiliteBenevoleDAO.class.php');

 if (!ISSET($_SESSION)) 
 session_start(); 
 $temp = MembreDAO::findMembreByEmail($_POST['courrielBenevole']);
if($temp != null && $temp->getGroupId() == 4)//ce numero est bien celui dun benevole
{
    if(isset($_SESSION['benevole']['inconnue'])) unset($_SESSION['benevole']['inconnue']);
    $_SESSION['benevole']['actuel'] = $temp;
    //insertion
    $disponibiliteBenevole = new DisponibiliteBenevole();
    $disponibiliteBenevole->setFkBenevole($_SESSION['benevole']['actuel']->getid());
    $disponibiliteBenevole->setDebut($_POST['debut']);
    $disponibiliteBenevole->setFin($_POST['fin']);
    $disponibiliteBenevole->setDate($_POST['date']);
    DisponibiliteBenevoleDAO::create($disponibiliteBenevole);
    $_SESSION['benevole']['jourTravailler'] = DisponibiliteBenevoleDAO::findJourTravailler($_SESSION['benevole']['actuel']);
    $_SESSION['benevole']['jourATravailler'] = DisponibiliteBenevoleDAO::findJourATravailler($_SESSION['benevole']['actuel']);
}
else//error message
{
    $nouveau = new Membre();
    $nouveau->setNom($_POST['nom']);
    $nouveau->setCourriel($_POST['courrielBenevole']);
   $nouveau->setTel($_POST['telephone']);

    $membreDAO = new MembreDAO();

    
    $membreDAO->create($nouveau);

    $_SESSION['benevole']['actuel'] = $nouveau;
    //insertion
    $disponibiliteBenevole = new DisponibiliteBenevole();
    $disponibiliteBenevole->setFkBenevole($_SESSION['benevole']['actuel']->getid());
    $disponibiliteBenevole->setDebut($_POST['debut']);
    $disponibiliteBenevole->setFin($_POST['fin']);
    $disponibiliteBenevole->setDate($_POST['date']);
    DisponibiliteBenevoleDAO::create($disponibiliteBenevole);
    $_SESSION['benevole']['jourTravailler'] = DisponibiliteBenevoleDAO::findJourTravailler($_SESSION['benevole']['actuel']);
    $_SESSION['benevole']['jourATravailler'] = DisponibiliteBenevoleDAO::findJourATravailler($_SESSION['benevole']['actuel']);
}
header('Location: ../vues/OffrirDisponibilite.php');
exit();
?>