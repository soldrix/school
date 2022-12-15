<?php
session_start();
if (!isset($_SESSION['proflogin'])){
    header('Location: login.php');
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
            <li><a href="profHome.php">Home</a></li>
        </div>
        <div class="rightContent">
            <li class="logout"><a href="logout.php">Deconexion</a></li>
        </div>
    </ul>
</nav>
<main>
    <div class="container">
        <h2>Mes entretiens</h2>
        <?php
        $id_user=$_SESSION["proflogin"];
        $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
        $stmt=$pdo->query("SELECT entretiens.id as entId, users.*, entretiens.date,classe.nom as classeNom FROM entretiens inner join users on users.id = entretiens.id_users inner join classe  on classe.id = users.id_classe where id_prof = '$id_user' ORDER by date asc ;");
        $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($stmt) > 0){
            ?>
            <?php
            foreach($stmt as $datas){
                //principal est la classe pour le prof principal
                echo'<div class="itemEnt ">
                    <p style="color: white" class="textEnt">nom:<span id="nom">'.$datas["nom"].'</span> | prenom: <span id="prenom">'.$datas["prenom"].'</span> | classe: <span id="classe">'.$datas["classeNom"].'</span> | <span id="date"> '.$datas["date"].'</span></p>
                       
                    <div class="d-flex">
                        <button class="terminerEnt" data-ent="'.$datas["entId"].'">
                        Terminer
                        </button>
                        <button class="DecalerEnt" data-ent="'.$datas["entId"].'">
                        Decaler
                        </button>
                    </div>
            </div>';
            }?>
            <?php
        }
        ?>
    </div>

</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $(document).ready(function () {
        if($('.itemEnt').length < 1){
            $('.container').append(`
                <h2>Il n'y a plus d'entretiens.</h2>
            `)
        }
    })
    $('.terminerEnt').on('click',function () {
        $.ajax({
            url:'gestion.php',
            type:'post',
            data:{
                appel:'terminerEnt',
                id_Ent:$(this).attr('data-ent')
            },success:function (datas) {
               if (!datas){
                   window.location.reload();
               }else{
                   $('#errorMsg').html(datas)
               }
            }
        })
    })
    $('.DecalerEnt').on('click',function () {
        $.ajax({
            url:'gestion.php',
            type:'post',
            data:{
                appel:'decalerEnt'
            },success:function (datas) {
                if (!datas){
                    window.location.reload();
                }else{
                    $('#errorMsg').html(datas)
                }
            }
        })
    })
</script>
</body>
</html>

