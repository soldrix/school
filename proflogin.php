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
<div class="container">
    <div class="form">
        <label for="name">Name :</label>
        <input type="text" id="name">
        <label for="password">Mot de passe :</label>
        <input type="text" id="password">
        <p id="errorMsg" style="color: red"></p>
    </div>
</div>
<button id="btn">
    connect
</button>
<a href="login.php">Retour</a>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>
<script>
    $('#btn').on('click',function () {
        $.ajax({
            url:'gestion.php',
            type:"POST",
            data:{
                appel:'profLogin',
                name: $('#name').val(),
                password: $('#password').val()
            },
            success:function (datas) {
                if(datas === ""){
                    window.location.href = 'profHome.php';
                }else{
                    $('#errorMsg').html(datas)
                }
            }
        })
    })
</script>
</body>
</html>