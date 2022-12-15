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
        <h2>Créer une salle</h2>
        <div class="form">
            <div class="itemForm">
                <label for="name">Nom</label>
                <input type="text" id="name">
            </div>
            <button id="btn" >
                click
            </button>
        </div>



    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $('#btn').on('click',function () {
        $.ajax({
            type:'post',
            url:'gestion.php',
            data:{
                appel:'createSalle',
                nom: $('#name').val(),
            },
            success:function () {
                $('#name').val('')
            }
        })
    })
</script>
</body>
</html>