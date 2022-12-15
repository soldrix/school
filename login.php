<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<?php
$pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
$stmt=$pdo->query("SELECT users.*,classe.nom as classeNom FROM classe inner join users on classe.id = users.id_classe;");
$stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<?php
if(count($stmt) > 0){
?>
<label for="user">Élève :</label>
<select id="user">
    <?php
    foreach($stmt as $datas){
        echo '<option value="'.$datas["id"].'">'.$datas["nom"].' '.$datas['prenom'].' '.$datas['classeNom'].'</option>';
    }
    ?>
</select>
<?php } ?>
<button id="btn">
 connect
</button>
<a href="proflogin.php">Professeur ? Connecter vous ici.</a>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

<script>
    $('#btn').on('click',function () {
        $.ajax({
            url:'gestion.php',
            type:"POST",
            data:{
                appel:'connection',
                id_users: $('#user').val()
            },
            success:function () {
                window.location.href = 'index.php';
            }
        })
    })
</script>
</body>
</html>