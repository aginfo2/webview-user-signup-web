<?php
    /*
     * VERIFICANDO SE O CÓDIGO DE SUPORTE PARA APIs
     * ABAIXO DA API 19 ESTÁ SENDO UTILIZADO - OBTENDO
     * A IMAGEM, NESSE CASO
     * */
    $imageSrc = isset($_POST['image']) ? $_POST['image'] : '../img/default.png';
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

        <form id="form-sign-up" method="post" action="../package/ctrl/CtrlUser.php" enctype="multipart/form-data">
            <div class="box-img">
                <img src="<?php echo $imageSrc; ?>" width="150" height="150">
                <input type="file" id="in-img" name="in-img">

                <a class="bt-load" href="#" title="Escolher imagem">
                    <span class="bg"></span>
                    <span class="label">
                        Escolher imagem
                    </span>
                </a>

                <a href="#" title="Remover" class="bt-remove">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                </a>

                <div class="box-loading">
                    <div class="fade"></div>
                    <div class="label">
                        Carregando...
                    </div>
                </div>
            </div>

            <input type="email" id="in-email" name="in-email" placeholder="Email">
            <input type="password" id="in-password" name="in-password" placeholder="Senha">
            <input type="hidden" id="in-method" name="in-method" value="form-sign-up">

            <button id="in-submit" type="submit" title="Cadastrar">
                Cadastrar
            </button>
        </form>

        <?php
            include_once('copyright.php');
        ?>

        <script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
        <script type="text/javascript">

            var isAndroid = false;
            try{
                isAndroid = Android != undefined
            }
            catch(e){}


            /* BOX-IMG BOTÃO QUE RETORNA A IMAGEM PADRÃO - REMOVER IMAGEM CARREGADA */
            $('div.box-img a.bt-remove').click(function( e ){
                e.preventDefault();
                $(this).siblings('img').prop('src', '../img/default.png');
                $(this).hide();
            });

            /* MUDANDO O MODO DE TRABALHO DO LINK DA BOX-IMG PARA ATIVAR O INPUT FILE */
            $('div.box-img a.bt-load').click(function( e ){
                e.preventDefault();
                showHideLoadingBox( true );

                if( isAndroid ){
                    Android.callGallery();
                }
                else{
                    $(this).siblings('input[type=file]').trigger('click');
                }
            });

            /* OUVINDO MUDANÇAS DE VALOR NO INPUT FILE */
            $('div.box-img input[type=file]').change(function(){
                var $handle = $(this);
                var reader = new FileReader();

                showHideLoadingBox( false );
                reader.onload = function(e){
                    /* VERIFICA SE FOI REALMENTE UMA IMAGEM CARREGADA, CASO NÃO, ABORTO PROCESSAMENTO */
                    if( e.target.result.indexOf('data:image/') == -1 ){
                        $handle.siblings('a.bt-remove').trigger('click'); /* VOLTA COM A IMAGEM PADRÃO */
                        return;
                    }

                    loadImageSrc( e.target.result );
                };
                reader.readAsDataURL(this.files[0]);
            });

            /* ENVIANDO DADOS PELO ANDROID */
            $('#in-submit').click(function (e) {
                var $handle = $(this);

                if( $handle.prop('title').indexOf('Enviando...') > -1 ){
                    e.preventDefault();
                    return;
                }

                $handle.prop('title', 'Enviando...').html('Enviando...');
                if( isAndroid ) {
                    e.preventDefault();
                    Android.sendForm(
                        $('#in-method').val(),
                        $('#in-email').val(),
                        $('#in-password').val());
                }
            });




            function showHideLoadingBox( status ){
                if( status ){
                    $('div.box-loading').stop().show('fast');
                }
                else{
                    $('div.box-loading').stop().hide('fast');
                }
            }

            function loadImageSrc( imagePath ){
                showHideLoadingBox( false ); /* NEEDED BECAUSE OF ANDROID */

                /* UMA IMAGEM FOI ESCOLHIDA, COLOQUE-A NA TAG IMG DO FORMULÁRIO */
                $('div.box-img img').prop('src', imagePath);
                $('div.box-img a.bt-remove').show();
            }

            function loadSignUpDonePage( signUpDonePage ){
                window.location = signUpDonePage;
            }
        </script>
    </body>
</html>