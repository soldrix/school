<?php
session_start();
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
            <li><a href="index.php">Home</a></li>
            <li><a href="user.php">élève</a></li>
        </div>
        <div class="rightContent">
            <li class="logout"><a href="logout.php">Deconexion</a></li>
        </div>
    </ul>
</nav>
<main>
    <div id="errorMsg">

    </div>
    <div class="container">

        <?php
        $id_user=$_SESSION["login"];
        $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
        $stmt=$pdo->query("SELECT entretiens.id as entId, prof.* FROM entretiens inner join prof on prof.id = entretiens.id_prof where id_users = '$id_user' ;");
        $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($stmt) > 0){
        ?>
            <?php
            foreach($stmt as $datas){
                //principal est la classe pour le prof principal
                $pp = (intval($datas['pp']) === 1) ? ' principal': '';
                echo'<div class="itemEnt'.$pp.' " >
                    <p style="color: white">nom: '.$datas["civiliter"].' '.$datas["name"].' bureau:'.$datas["bureau"].' salle:'.$datas["salle"].' matière:'.$datas["mat"] .'</p>
                    <button class="AnnulEnt" data-ent="'.$datas["entId"].'">
                         Annuler           
                    </button>
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
        if($('.AnnulEnt').length < 1){
            $('.container').append(`
                                <h2>Il n'y a plus d'entretiens.</h2>
                            `)
        }
    })
    $('.AnnulEnt').on('click',function () {
        $.ajax({
            url:'gestion.php',
            type:'post',
            data:{
                appel:'delEnt',
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
</script>
</body>
</html>
