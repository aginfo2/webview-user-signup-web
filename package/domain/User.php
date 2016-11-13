<?php

class User
{
    const SEPARATOR = '_sds654s65d46s_';

    public $email;
    public $password;
    public $image;



    public function initFromPost()
    {
        $this->initFromArray( $_POST );
    }

    public function initFromGet()
    {
        $this->initFromArray( $_GET );
    }

    private function initFromArray( $data )
    {
        $this->email = $data['in-email'];
        $this->password = $data['in-password'];

        $this->image = new Image();
        $this->image->initFromFiles();
    }

    public function save()
    {
        $file = fopen('../../data/data.txt', 'a');
        fwrite( $file, $this->email . self::SEPARATOR );
        fwrite( $file, sha1($this->password) . self::SEPARATOR );
        fclose( $file );

        $this->image->save();

        $this->saveClose();
    }

    private function saveClose()
    {
        $file = fopen('../../data/data.txt', 'a');
        fwrite( $file, "\n" ); /* O VERDADEIRO CLOSE NESSA LÓGICA DE NEGÓCIO É UMA NOVA QUEBRA DE LINHA */
        fclose( $file );
    }

    public function retrieveData()
    {
        $lines = file('../data/data.txt');

        foreach( $lines as $line ){
            $data = explode( self::SEPARATOR, $line );

            /*
             * SE A LINHA EM ANÁLISE TIVER O MESMO EMAIL É ONDE SE ENCONTRAM OS
             * DADOS DO USUÁRIO, INSIRA OS NECESSÁRIOS NO OBJETO IMAGE E FINALIZA
             * A EXECUÇÃO DO MÉTODO.
            */
            //exit( $data[0].' --> '.$this->email );
            if( strcmp( $data[0], $this->email ) == 0 ){
                $this->image->retrieveData( $data[2] );
                break;
            }
        }
    }
}