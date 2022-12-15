<?php
session_start();
if (!isset($_SESSION['adminlogin'])){
    header('Location: error404.php');
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<nav>
    <ul>
        <div class="leftContent">
            <li><a href="formulaireEntretiens.php">Entretiens</a></li>
            <li><a href="formulaireClasse.php">Classse</a></li>
            <li><a href="formulaireProf.php">Professeur</a></li>
            <li><a href="formulaireSalle.php">Salle</a></li>
            <li><a href="formulaireUsers.php">Utilisateur</a></li>
        </div>
        <div class="rightContent">
            <li class="logout"><a href="logout.php">Deconexion</a></li>
        </div>
    </ul>
</nav>
<main>
    <div class="container">
        <div class="form">
            <div class="itemForm">
                <label for="nom">Nom :</label>
                <input type="text" id="nom">
            </div>
            <div class="itemForm">
                <label for="prenom">Prenom :</label>
                <input type="text" id="prenom">
            </div>
            <div class="itemForm">
                <label for="classe">Classe :</label>
                <?php
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $stmt=$pdo->query("SELECT * FROM classe");
                $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($stmt) > 0){
                ?>
                <select id="classe">
                   <?php
                       foreach($stmt as $datas){
                           echo '<option value="'.$datas["id"].'">'.$datas["nom"].'</option>';
                       }
                   ?>
                </select>
                <?php }else{
                    echo '<p>Aucune Classe, veuillez créer une Classe.</p>';
                } ?>
            </div>
        </div>


        <button id="btn" style="float: right;display: flex">
            click
        </button>
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $('#btn').on('click',function () {

        $.ajax({
            type:'post',
            url:'gestion.php',
            data:{
                appel:'CreateUser',
                nom: $('#nom').val(),
                prenom: $('#prenom').val(),
                id_classe:$('#classe').val()
            }
        })
    })
</script>
</body>
</html>


