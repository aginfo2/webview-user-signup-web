<?php
    include_once('../package/domain/Image.php');
    include_once('../package/domain/User.php');

    $user = new User();
    $user->initFromGet();
    $user->retrieveData();

?>
<!DOCTYPE html>
<html lang="pt-br">
    <head>
        <?php
            include_once('header.php');
        ?>
    </head>
    <body>
        <?php
            include_once('top.php');
        ?>



        <div class="box-congratulations">
            <h1>
                Parabéns, cadastro realizado!
            </h1>

            <img src="<?php echo $user->image->getImageSrc(); ?>">

            <p>
                Olá <b><?php echo $user->email; ?></b>, seu cadastro foi realizado com sucesso, agora somente falta
                a confirmação do email para que seu acesso seja liberado.
            </p>
            <p>
                É um prazer saber que você agora faz parte da comunidade
                <span>WebView User Sign Up</span>.
            </p>
        </div>



        <?php
            include_once('copyright.php');
        ?>
    </body>
</html>