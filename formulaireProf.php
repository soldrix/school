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
                <label for="civiliter">Civiliter :</label>
                <select id="civiliter">
                    <option value="Mr">Mr</option>
                    <option value="Mme">Mme</option>
                </select>
            </div>
            <div class="itemForm">
                <label for="name">Nom</label>
                <input type="text" id="name">
            </div>
            <div class="itemForm">
                <label for="mat">Matère :</label>
                <select id="mat">
                    <option value="math">math</option>
                </select>
            </div>
            <div class="itemForm">
                <label for="bureau">Numéro du bureau :</label>
                <select id="bureau">
                    <?php
                    for ($i=0; 4 > $i;$i++){
                        echo '<option value="'.($i+1).'">'.($i+1).'</option>';
                    }
                    ?>
                </select>
            </div>
            <div class="itemForm">
                <label for="">Salle :</label>
                <?php
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $stmt=$pdo->query("SELECT * FROM salle;");
                $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($stmt) > 0){
                ?>
                <select  id="salle">
                    <?php
                    foreach($stmt as $datas){
                        echo '<option value="'.$datas["id"].'">'.$datas["nom"].'</option>';
                    }
                    ?>
                </select>
                <?php }else{
                    echo '<p>Aucune Salle, veuillez créer une salle.</p>';
                }?>
            </div>
            <div class="itemForm">
                <label for="">Classe :</label>
                <?php
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $stmt=$pdo->query("SELECT * FROM classe;");
                $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($stmt) > 0){
                    ?>
                    <select  id="classe">
                        <?php
                        foreach($stmt as $datas){
                            echo '<option value="'.$datas["id"].'">'.$datas["nom"].'</option>';
                        }
                        ?>
                    </select>
                <?php }else{
                    echo '<p>Aucune Classe, veuillez créer une Classe.</p>';
                }?>
            </div>
            <div class="itemForm">
                <label for="pp">professeur principal</label>
                <input id="pp" type="checkbox">
            </div>
            <div class="itemForm">
                <label for="password">Mot de passe:</label>
                <input id="password" type="password">
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
        let ppVal = ($('#pp').prop('checked') === true) ? 1 : 0;
        $.ajax({
            type:'post',
            url:'gestion.php',
            data:{
                appel:'CreateProf',
                name: $('#name').val(),
                bureau: $('#bureau').val(),
                salle:$('#salle').val(),
                classe:$('#classe').val(),
                mat:$('#mat').val(),
                pp: ppVal,
                password: $('#password').val(),
                civiliter: $('#civiliter').val()
            },
            success:function () {
                $('input').val('')
            }
        })
    })
</script>
</body>
</html>


