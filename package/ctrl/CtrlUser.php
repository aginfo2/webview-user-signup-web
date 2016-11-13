<?php
    include_once('../domain/Image.php');
    include_once('../domain/User.php');


    /* VERIFICANDO SE OS DADOS VIERAM DO FORMULÁRIO DE CADASTRO DE USUÁRIO */
    if( strcasecmp($_POST['in-method'], 'form-sign-up') == 0 ){

        $user = new User();
        $user->initFromPost();
        $user->save();

        if( isset($_POST['in-is-android']) ){
            echo 'http://192.168.25.221:8888/webview-user-signup/view/congratulations.php?in-email='.$user->email;
        }
        else{
            header('Location: ../../view/congratulations.php?in-email='.$user->email);
        }
    }