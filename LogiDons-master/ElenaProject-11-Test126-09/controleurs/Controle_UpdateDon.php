<?php

require_once('../modeles/config/DonsDAO.class.php');
require_once('../modeles/config/Format.php');

$pageTitle = "";   
include('../vues/header.php');
?>
<style>
        body{
            
            background:url(../images/marbre.jpg) no-repeat center center fixed;
            -webkit-background-size:cover;
            -moz-background-size:cover;
            -o-background-size:cover;
            background-size:cover;  
            }
</style>
<?php
include('../vues/navBar.php'); 
$donDao = new DonsDAO();
    // verifier si la methode d'envoi est faite par le formulaire
    if($_SERVER['REQUEST_METHOD'] == 'POST')
    { 
        // recuperation des donnees envoyees par le formulaire
        $format     = new Format();
        $IdDon      = $format->validation($_POST['IdDon']);       // id du don

        $dao = new donsDAO();
        $newDon = $dao->trouverDonParId($IdDon);
        if($newDon->getDtAnnul() == null)
        {
            $nomDon     = $format->validation($_POST['nomDon']);      // nom du don
            $newDon->setNomDon($nomDon);

            $DescDon    = $format->validation($_POST['DescDon']);     // description du don
            $newDon->setDESC_Don($DescDon);

            $qttDon     = $format->validation($_POST['qttDon']);      // la quantite du don
            $newDon->setQuantite($qttDon);

            $catDon     = $format->validation($_POST['catDon']);      //la categorie du don
            $newDon->setCatDon($catDon);
            
            $ModeLivr   = $format->validation($_POST['ModeLivr']);    //le mode de livraison
            $newDon->setModeLivr($ModeLivr);

            $montantDon = $format->validation($_POST['montantDon']);  //le montant du don
            $newDon->setMontantDon($montantDon);

            $datePromise= $format->validation($_POST['datePrm']);     //la date promise
            $newDon->setDtPromise($datePromise);
            $timestamp = time();
            $dt = new DateTime("now", new DateTimeZone('AMERICA/NEW_YORK')); //first argument "must" be a string
            $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
            $newDon->setDtPromesse($dt->format('Y-m-d'));

            $newDon->setDtRefu(null);
            $newDon->setDtAccept(null);
            

            

            //verifier est-ce qu'il a change la photo ou pas
            $img = "";
            if($_FILES['imgNew']['name'] == '')
            {
                // juste garder l'ancien nom de la photo
                $img = $format->validation($_POST['imgOld']);
            }
            else
            {
                $img = $format->validation($_FILES['imgNew']['name']);    // nom de l'image envoyée
                // supprimmer l'ancienne photo et envoyer la nouvelle photo dans le dossier Upload
                $oldPhoto = "../uploads/".$_POST['imgOld'];
                unlink($oldPhoto);
            // $nom = 'imgNew';
                $img = $donDao->traiterImage('imgNew');
            }

            $newDon->setPhoto($img);

            if ($catDon == "ameublement")       {$catDon = 1;}
            elseif ($catDon == "monnaie")       {$catDon = 2;}
            elseif ($catDon == "electroniques") {$catDon = 3;}else { $catDon = 4; }

            $newDon->setCatDon($catDon);

            $donDao = new DonsDAO();            
            $donDao->modifyDon($newDon);


            $message = "Les modifications ont étés effectuées avec succes.";
            $class   = "success";
            $url     = "../vues/TousLesDons.php?email=".$_POST['email'];
            $nomPage = "la page de vos dons";   
            $format->redirect($message, $class, $url, $nomPage);  
        }
    }
    else // si la methode d'envoi n'est pas POST
    {
        $message = "Veuillez vous connectez par le formulaire.";
        $class   = "danger";
        $url     = "../index.php";
        $nomPage = "la page d'Accueil";   
        $format->redirect($message, $class, $url, $nomPage); 
    }       
 
?>
