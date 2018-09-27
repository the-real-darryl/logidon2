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

$format   = new Format();

if(isset($_GET['donID']) && is_numeric($_GET['donID']))
{
    $id = intval($_GET['donID']);
    $dao = new DonsDAO();     
    $don = $dao->trouverDonParId($id);

    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone('AMERICA/NEW_YORK')); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    $don->setDtAnnul($dt->format('Y-m-d'));
    $dao->deleteDon($don);

    $message = "Le don a été supprimmé avec succes.";
    $class   = "success";
    $url     = "../vues/TousLesDons.php?email=".$_GET['email'];
    $nomPage = "vos dons.";   
    $format->redirect($message, $class, $url, $nomPage);
}
?>