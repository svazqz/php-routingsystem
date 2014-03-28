<?php
class templateDriver extends driverBase{
    private static $type = 'html';
    private static $content = null;
    private static $data = array();

    public static function setContent($content = null) {
        if( $content === null )
            return false;
        self::$content = $content;
    }

    public static function setData($k = null, $d = null) {
        if($k === null)
            return false;
        self::$data[$k] = $d;
    }

    public static function getData($k = null) {
        if( $k === null )
            return self::$data;
        return isset(self::$data[$k]) ? self::$data[$k] : null;
    }
    
    public static function render($content = false, $data = null, $template = 'index') {
        if( $data )
            self::setData("content", $data);
        
        templateDriver::setContent($content ? $content : configDriver::defaultContent());
        
        if( file_exists("../app/templates/".$template.".template.php") ) 
            include("../app/templates/".$template.".template.php");
        else
            die("No existe el template especificado");
    }
    
    public static function content(){
        self::renderSection(self::$content);
    }
    
    public static function renderRaw($sect = null, $data = null){
	self::renderSection($sect, $data);
    }
    
    public static function renderSection($sect = null, $data = null, $overwrite = true){
	$section = "../app/templates";
        $key = null;
	foreach (explode('.', $sect) as $value) {
            $section = $section . "/" . $value;
            $key = $value;
	}
        if( $data !== null ) {
            if( !$overwrite ) {
                $i = 2;
                while(isset(self::$data[$key]))
                    $key = $key.$i++;
            }
            self::setData($key, $data);
        }
        if( file_exists($section.".php") ) 
            $section = $section.".php";
        elseif (file_exists($section.".template.php"))
            $section = $section.".template.php";
        else
            die("No existe la sección especificada");
        include($section);
    }
    
}
