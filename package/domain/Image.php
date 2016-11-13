<?php

class Image
{
    const SEPARATOR = '_sdkjvbsdkjvsdvs5_';

    public $tmpName;
    public $randomName;
    public $originalName;
    public $size;
    public $mime;



    public function initFromFiles()
    {
        $this->tmpName = $_FILES['in-img']['tmp_name'];
        $this->originalName = $_FILES['in-img']['name'];
        $this->size = $_FILES['in-img']['size'];
        $this->mime = $_FILES['in-img']['type'];

        $this->generateRandomName();
    }

    private function generateRandomName(){
        $this->randomName = sha1( microtime() );
        $this->randomName .= '.' . $this->getType();
    }

    private function getType()
    {
        $type = explode('.', $this->originalName);
        $type = $type[ count($type) - 1 ];
        return $type;
    }

    private function saveInFolder()
    {
        copy( $this->tmpName, '../../img/'.$this->randomName );
    }

    public function save()
    {
        $file = fopen('../../data/data.txt', 'a');
        fwrite( $file, $this->randomName . self::SEPARATOR );
        fwrite( $file, $this->originalName . self::SEPARATOR );
        fwrite( $file, $this->size . self::SEPARATOR );
        fwrite( $file, $this->mime . self::SEPARATOR );
        fclose( $file );

        $this->saveInFolder();
    }

    public function retrieveData( $data )
    {
        $data = explode( self::SEPARATOR, $data );
        $this->randomName = $data[0];
        $this->originalName = $data[1];
        $this->size = $data[2];
        $this->mime = $data[3];
    }

    public function getImageSrc()
    {
        return( '../img/' . $this->randomName );
    }
}