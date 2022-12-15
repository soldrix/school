<?php
session_start();
switch ($_POST['appel']){
    case 'CreateProf' :
        try {
            if(isset($_POST['name'],$_POST['mat'],$_POST['salle'],$_POST['classe'],$_POST['bureau'],$_POST['pp'],$_POST['password'],$_POST['civiliter'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $data=[
                    'name'=>$_POST['name'],
                    'salle'=>$_POST['salle'],
                    'id_classe'=>$_POST['classe'],
                    'bureau'=>$_POST['bureau'],
                    'mat'  => $_POST['mat'],
                    'pp'  => $_POST['pp'],
                    'password' => hash('sha256', $_POST['password']),
                    'civiliter' => $_POST['civiliter']
                ];
                $sql="INSERT INTO prof(name,salle,bureau,mat,pp,password,id_classe,civiliter)VALUES(:name,:salle,:bureau,:mat,:pp,:password,:id_classe,:civiliter)";
                $stmt=$pdo->prepare($sql);
                $stmt->execute($data);
            } else {
                throw new Exception( 'Les champs ne peuvent pas être vide.');
            }
        }catch (Exception $e){
                echo $e->getMessage();
        }
    break;
    case 'createClasse':
        try {
            if(isset($_POST['nom'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $data=[
                    'nom'=>$_POST['nom'],
                ];
                $sql="INSERT INTO classe(nom)VALUES(:nom)";
                $stmt=$pdo->prepare($sql);
                $stmt->execute($data);
            } else {
                throw new Exception( 'Le champ ne peuvent pas être vide.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'createSalle':
        try {
            if(isset($_POST['nom'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $data=[
                    'nom'=>$_POST['nom'],
                ];
                $sql="INSERT INTO salle(nom)VALUES(:nom)";
                $stmt=$pdo->prepare($sql);
                $stmt->execute($data);
            } else {
                throw new Exception( 'Le champ ne peuvent pas être vide.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'CreateEntertiens':
        try {
            if(isset($_POST['date'],$_POST['id_prof'],$_POST['id_users'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $id = $_POST['id_prof'];
                $stmt=$pdo->query("SELECT * FROM entretiens where id_prof = '$id' order by date desc limit 1");
                $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($stmt) > 0){
                    foreach ($stmt as $datas){
                        $currentDate = strtotime($datas["date"]);
                        $futureDate = $currentDate+(60*5);
                        $date = date("Y-m-d H:i:s",$futureDate);
                    }
                }else{
                    $datemin =date('Y-m-d');
                    $datemin = date('Y-m-d H:i:s',mktime(18,00,00,date('m'),date('d'),date('Y')));
                    $date = date("Y-m-d H:i:s");
                    $currentDate = strtotime($date);
                    $futureDate = $currentDate+(60*5);
                    $formatDate =  date("Y-m-d H:i:s",$futureDate);
                    $date = ($date > $datemin) ? $formatDate : $datemin;
                }
                $data=[
                    'date'=>$date,
                    'id_prof'=>$_POST['id_prof'],
                    'id_users'=>$_POST['id_users']
                ];
                $sql="INSERT INTO entretiens(date,id_prof,id_users)VALUES(:date,:id_prof,:id_users)";
                $stmt=$pdo->prepare($sql);
                $stmt->execute($data);
            } else {
                throw new Exception( 'Le champ ne peuvent pas être vide.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'CreateUser':
        try {
            if(isset($_POST['nom'],$_POST['prenom'],$_POST['id_classe'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $data=[
                    'nom'=>$_POST['nom'],
                    'prenom'=>$_POST['prenom'],
                    'id_classe'=>$_POST['id_classe']
                ];
                $sql="INSERT INTO users(nom,prenom,id_classe)VALUES(:nom,:prenom,:id_classe)";
                $stmt=$pdo->prepare($sql);
                $stmt->execute($data);
            } else {
                throw new Exception( 'Le champ ne peut pas être vide.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'connection':
        try {
            if(isset($_POST['id_users'])){

                $_SESSION['login'] = $_POST['id_users'];

            }else{
                throw new Exception( 'Le site est inaccessible pour le moment.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'delEnt':
        try {
            if(isset($_POST['id_Ent'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $id = $_POST['id_Ent'];
                $sql="delete from  entretiens where id = "."$id";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
            } else {
                throw new Exception( 'L\' entretiens n\'a pas pu être supprimer.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'AdminConnect':
        try {
            if(isset($_POST['name'],$_POST['password'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $password = $_POST['password'];
                $name = $_POST['name'];
                $stmt=$pdo->query("SELECT * FROM admin where password = '$password' and name = '$name' ;");
                $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($stmt) > 0){
                    foreach ($stmt as $datas){
                        $_SESSION['adminlogin'] = $datas['id'];
                    }
                }else{
                    throw new Exception( 'Le mot de passe ou l\'utilisateur est invalide.');
                }
            }else{
                throw new Exception( 'Les champs ne peuvent pas être vide.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'profLogin':
        try {
            if(isset($_POST['name'],$_POST['password'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $password = hash('sha256', $_POST['password']);
                $name = $_POST['name'];
                $stmt=$pdo->query("SELECT * FROM prof where password = '$password' and name = '$name' ;");
                $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
                if(count($stmt) > 0){
                    foreach ($stmt as $datas){
                        $_SESSION['proflogin'] = $datas['id'];
                    }
                }else{
                    throw new Exception( 'Le mot de passe ou l\'utilisateur est invalide.');
                }
            }else{
                throw new Exception( 'Les champs ne peuvent pas être vide.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'terminerEnt':
        try {
            if(isset($_POST['id_Ent'])){
                $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
                $id = $_POST['id_Ent'];
                $sql="delete from  entretiens where id = "."$id";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
            } else {
                throw new Exception( 'L\' entretiens n\'a pas pu être terminer.');
            }
        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
    case 'decalerEnt':
        try {
            $pdo = new PDO("mysql:host=localhost:3306;dbname=rpp", 'root', 'root');
            $id = $_SESSION['proflogin'];
            $stmt=$pdo->query("SELECT * FROM entretiens where id_prof = '$id'");
            $stmt =  $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($stmt as $datas){
                $id = $datas['id'];
                $currentDate = strtotime($datas['date']);
                $futureDate = $currentDate+(60*5);
                $formatDate = date("Y-m-d H:i:s", $futureDate);
                $sql="update entretiens set date = '$formatDate' where id = '$id'";
                $stmt=$pdo->prepare($sql);
                $stmt->execute();
            }

        }catch (Exception $e){
            echo $e->getMessage();
        }
    break;
}
