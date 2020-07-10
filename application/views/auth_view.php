<div class="wrapper">
    <form method="post" action="/index.php/auth/auth">
        <a href="/"> Назад</a>

        <label for="login">Логин:</label>
        <input id="login" name="auth[login]" type="text" value="<?php if(isset($data)){extract($data); if(isset($auth['login'])) echo $auth['login'];}?>">

        <label for="pass">Пароль:</label>
        <input id="pass" name="auth[password]" type="password" >
   
        <input type="submit" value="отправить" >
    </form>
</div>
<?php if(isset($data)){extract($data); echo $message." ".$passdb." ".$pass;}?>

<!-- .wrapper -->