<?php
   require_once('../modeles/classes/3-Membre.class.php');
   require_once('../modeles/classes/disponibiliteBenevole.class.php');
     if (!ISSET($_SESSION)) 
     session_start(); 
   // if()
    $pageTitle = "La page Login";
    include('header.php');   
    include('navBar.php');
?>
    
<div class="container spacer col-md-6 col-xs-12 col-md-offset-3" style="top:100px .form-group.required .control-label:after {
  content:'*';
  color:red;
}">
    <script src="../ficiers-js/jquery-1.12.1.min.js"></script>
    <div class="panel panel-default">
        <div class="panel-heading">Informations Personnelles</div>
            <div class="panel-body">
                <form method="post" action="../controleurs/Controle_CreateDisponibilite.php">

                        <div class="form-group required <?= (isset($_SESSION['benevole']['inconnue']))?'alert alert-danger':'' ?>">
                        <label class="control-label">Courriel Benevole</label>
                        <input type="text" name="courrielBenevole" class="form-control" value="<?php
                         if(isset($_SESSION['benevole']['actuel'])){$_SESSION['benevole']['actuel']->getCourriel();}
                         elseif(isset($_SESSION['connected'])){if($_SESSION['connected'] == true){echo $_SESSION['courriel'];}} ?>"
                          required>
                        <?= (isset($_SESSION['benevole']['inconnue']))?'<div>ce courriel n\'est pas associer a un benevole</div>':'' ?>
                        </div>
                        <div class="divCheck form-group" id="checkIfDejaEnregistrea">  
                        <label class="control-label">Je n'ai pas de compte</label>                       
                            <input id="checkIfDejaEnregistre" type="checkbox" name="checkIfDejaEnregistre">                              
                        </div> 

                        <div id="dejaEnregistre">
                            <div class="form-group required">
                                <label class="control-label">nom</label>
                                <input type="text" class="form-control" id="nom" name="nom" rows="5" required></textarea>
                            </div>   
                            <div class="form-group required">
                                <label class="control-label">telephone</label>
                                <input type="text" class="form-control" id="telephone" name="telephone" rows="5" required></textarea>
                            </div>     
                        </div>

                        <div class="form-group required">
                            <label class="control-label">Date</label>
                            <input type="date" class="form-control" name="date" rows="5" required></textarea>
                        </div>         

                        <div class="form-group required">
                            <label class="control-label">Debut</label>
                            <input type="time" class="form-control" name="debut" rows="5" required></textarea>
                        </div>      

                        <div class="form-group required">
                            <label class="control-label">Fin</label>
                            <input type="time" class="form-control" name="fin" rows="5" required></textarea>
                        </div>                              

                    <div>
                        <button class="btn btn-info" type="submit">Soumettre</button>
                    </div>                               
                </form>
            </div>
        </div><!--end div panel heading -->
    </div><!--end div panel default -->
</div><!--end div container -->

<div>


<?php
if(isset($_SESSION['benevole']['jourTravailler']))
{
    $timestamp = time();
    $dt = new DateTime("now", new DateTimeZone('AMERICA/NEW_YORK')); //first argument "must" be a string
    $dt->setTimestamp($timestamp); //adjust the object to correct timestamp
    $today = $dt->format('Y-m-d');
     ?>
    <table class="table-bordered">
        <thead>
        <caption>Jour travailler</caption>
            <tr>
                <th> date </th>
                <th> debut </th>
                <th> fin </th>
            </tr>
        </thead>
            <tbody>
            <?php
                foreach($_SESSION['benevole']['jourTravailler'] as $value)
                {
                    $value_obj = new disponibiliteBenevole();
                    $value_obj->loadFromObject($value);

                    echo "<tr>";
                    echo "<td>".$value_obj->getDate()."</td>";
                    echo "<td>".$value_obj->getDebut()."</td>";
                    echo "<td>".$value_obj->getFin()."</td>";
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
    <br>
    <?php
}
if(isset($_SESSION['benevole']['jourATravailler']))
{?>
    <table class="table-bordered">
        <thead>
        <caption>Disponibilite a venir</caption>
            <tr>
                <th> date </th>
                <th> debut </th>
                <th> fin </th>
                <th> travail </th>
            </tr>
        </thead>
            <tbody>
            <?php
                foreach($_SESSION['benevole']['jourATravailler'] as $value)
                {
                    $value_obj = new disponibiliteBenevole();
                    $value_obj->loadFromObject($value);
                    if($value_obj->getDate() >= $today)
                    {
                    echo "<tr>";
                    echo "<td>".$value_obj->getDate()."</td>";
                    echo "<td>".$value_obj->getDebut()."</td>";
                    echo "<td>".$value_obj->getFin()."</td>";
                    echo "<td>".(($value_obj->getAccepter())?"oui":"non")."</td>";
                    echo '</tr>';
                    }
                }
            ?>
        </tbody>
    </table>

    <?php    } ?>
</div>

<script>
   $(document).ready(function()
    {
        $('#dejaEnregistre').hide();
        document.getElementById("nom").required = false;
        document.getElementById("telephone").required = false;

        $('#checkIfDejaEnregistre').on('click', function() 
            {
                $('#dejaEnregistre').toggle(500);
                document.getElementById("nom").required = true;
                document.getElementById("telephone").required = true;
            });			  
    });
</script>

<?php include('footer.php') ?>


