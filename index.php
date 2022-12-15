<?php
require 'header.php';

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
            <li><a href="listattente.php">Mes entretiens</a></li>
        </div>
        <div class="rightContent">
            <li class="logout"><a href="logout.php">Deconexion</a></li>
        </div>
    </ul>
</nav>
<main>
    <div class="container">
        <?php
        $id_user=$_SESSION["login"];
        $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
        $stmt=$pdo->query("SELECT name,id,mat,pp,id_classe,civiliter FROM prof where id_classe = '$id_user' ;");
        $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
        if(count($stmt) > 0){
        ?>
                <h2>Ajouter des entretiens</h2>
        <div class="selectProf">
            <?php
                foreach($stmt as $datas){
            echo'<div class="itemProf" data-prof="'.$datas["id"].'">
                <input type="checkbox" class="profSelect">
                    <p style="color: white">nom: '.$datas["civiliter"].' '.$datas["name"].' | matière:'.$datas['mat']. '</p>
            </div>';
            }?>
            <p id="errorMsg" style="color:red">

            </p>
            <button id="validEnt">
                Valider
            </button>
        </div>
       <?php }?>
    </div>
</main>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $('#validEnt').on('click',function () {
        for (let i = 0; i < $('.profSelect').length ; i++) {
            if ($('.profSelect').eq(i).prop('checked') === true){
                $.ajax({
                    url:'gestion.php',
                    type:'post',
                    data:{
                        appel : 'CreateEntertiens',
                        id_prof :$('.profSelect').eq(i).parent().attr('data-prof'),
                        date: '<?= date("Y-m-d H:i:s")?>',
                        id_users:'<?= $id_user?>'
                    },
                    success:function (datas) {
                        if (!datas){
                            window.location.href = 'listattente.php';
                        }else{
                            $('#errorMsg').html(datas);
                        }
                    }
                })
            }
        }

    })
</script>
</body>
</html>

