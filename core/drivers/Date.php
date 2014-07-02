<?php
/***************************************************
 * @package: manipulación de fechas
 * @version: class.fechador.php 1.1
 * @author cazaresluis.com
 */

/*
 * En Esta Versión se agregó un validador de fechas
 * en formato dd-mm-yyyy / yyyy-mm-dd
 */

class Date extends Driver\Base
{
    /**
     * Para dar salida a la fecha ya armada
     * @var string
     * @example '00-00-000'
     */
    private $fechaCompleta;

    /**
     *
     * Representa el día en número entero 01-31
     * @var integer
     * @example 01
     */
    public $dia;

    /**
     *
     * Representa el mes en numero entero 01 - 12
     * @var integer
     * @example 05
     */
    public $mes;

    /**
     *
     * Representa el año en formato 0000
     * @var integer
     * @example 2011
     */
    public $anio;

    /**
     *
     * Representa el día de la semana del 1-7
     * @var integer
     * @example 1
     */
    public $diaSemana;

    /**
     *
     * Identifica la zona horaria
     * @var String
     */
    public $zonaHoraria;

    /**
     *
     * Determina si se agrega horas minutos y segundos a la fehca resultante
     * @var boolean
     */
    public $horas;

    /**
     *
     * Sirve para ver que tipo de fecha se va a manejar
     * @var string
     * @example 'convSQL', 'ConvTXT'
     *
     */
    public $accion;

    /**
     *
     * Indica el idioma a convertir la fecha
     * @var string
     * @example 'ES' 'EN'
     */
    public $lenguaje;

    /**
     *
     * Lista de meses en español
     * @var array - string
     *
     */
    private $mesEs = array();

    /**
     *
     * Lista de días de la semana en español
     * @var array - string
     *
     */
    private $diaEs = array();

    /**
     *
     * Desplegador de errores
     * @var string
     */
    public  $errores;

    /*
     * Métodos
     */

    /**
     *
     * Incializamos los valores por default de la clase
     */
    public function __construct()
    {    
        // Inicializamos la zona horaria
        $this->zonaHoraria = 'America/Mexico_City';
        $this->horas = false;

        // idioma inicial
        $this->lenguaje='ES';

        // Tipo de conversión de la fecha
        $this->accion = 'ConvTXT';

        // arreglos de día y mes en español
        $this->mesEs = array('','Enero','Febrero','Marzo','Abril','Mayo','Junio','Julio','Agosto','Septiembre','Octubre','Noviembre','Diciembre');
        $this->diaEs = array('','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo');

        // valores día mes y año por separado
        $this->dia = date('d');
        $this->mes = date('n');
        $this->anio = date('Y');
        $this->diaSemana = date('N');

    }

    // Metodos de la versión 1.0
    public function fechar()
    {
        // Establecemos la zona horaria
        date_default_timezone_set($this->zonaHoraria);

        // Verificamos el tipo de fechador que se va a utilizar
        if($this->accion == 'convSQL')
        {
            // Verificamos el lenguaje
            if($this->lenguaje == 'EN')
                $this->fechaCompleta = date('Y-m-d');
            else
                $this-> fechaCompleta = date('d-m-Y');
        }
        elseif($this->accion == 'ConvTXT')
        {
            // Verificamos el lenguaje
            if($this->lenguaje == 'EN')
            {
                // Armamos la fecha en lenguaje Inglés
                $this-> fechaCompleta = date('l jS of F Y');
            }    
            else
                // Armamos la fecha en lenguaje Español
                $this-> fechaCompleta = $this->diaEs[$this->diaSemana] . ' '. $this->dia .' de ' . $this->mesEs[$this->mes] .' de ' . $this->anio;
        }
        else
            $this->errores = 'Faltan parametros por definir';

        // Verificamos si se agregan los datos de horas minutos y segundos
        if($this->horas == true)
            $this->fechaCompleta .= ' ' . date('h:i:s A');

        return $this->fechaCompleta;

    }

    // METODOS DE LA VERSION 1.1
    // Validar una fecha dada
    public function validarFecha($formato="dmy",$fech="")
    {
        if($fech == '')
            $fech = $this->fechar();

        $separadores= array("/","."," ");
        $fech = str_replace($separadores,'-', $fech);

        $fech_array= explode('-',$fech);

        // checkdate(mes,dia,año)
        // fech_array dmy (1,0,2)
        if($formato=="dmy") {
            return checkdate($fech_array[1],$fech_array[0],$fech_array[2]);
        } elseif ($formato=="ymd") {
            return checkdate($fech_array[1],$fech_array[2],$fech_array[0]);
        } else {
            return checkdate($fech_array[0],$fech_array[1],$fech_array[2]);
        }

    }

    // DETERMINA LOS DÍAS TRANSCURRIDOS ENTRE DOS FECHAS DADAS
    public function operaFechas($formato="dmy",$fechA="",$fechB="")
    {
        // verificamos las propiedades necesarias para poder ejecutar este método
        if($this->accion == 'ConvTXT')
        {
            $this->accion = 'convSQL';
        }    

        // Verificamos que exista valor en las fechas
         if($fechA == '' || $fechB == '')
         {
             $fechA = $this->fechar();
             $fechB = $this->fechar();
         }

        // Validamos que las fechas dadas sean reales
        // Si alguna de las dos no lo es, regresamos el valor 00
        if(!$this->validarFecha($formato,$fechA) || !$this->validarFecha($formato,$fechB))
        {
            return '00';
        }
        else
        {
            // Convertimos a marca de tiempo las fechas
            $separadores= array("/","."," ");
            $fechA = str_replace($separadores,'-', $fechA);
            $fechB = str_replace($separadores,'-', $fechB);

            // Separamos las fechas para crear su marca de tiempo
            $array_fechaA=explode("-",$fechA);
            $array_fechaB=explode("-",$fechB);

            // Verificamos que las fecha limite sea anterior a la fecha incial
            if($formato == 'dmy')
            {
                // Calculamos la marca de tiempo
                // calculo timestamp de las dos fechas
                // 1=mm, 0=dd, 2=aaaa
                $marca_fechaA = mktime(0,0,0,$array_fechaA[1],$array_fechaA[0],$array_fechaA[2]);
                $marca_fechaB = mktime(0,0,0,$array_fechaB[1],$array_fechaB[0],$array_fechaB[2]);
            }
            elseif($formato == 'ymd')
            {
                // Calculamos la marca de tiempo
                // calculo timestamp de las dos fechas
                // 1=mm, 2=dd, 0=aaaa
                $marca_fechaA = mktime(0,0,0,$array_fechaA[1],$array_fechaA[2],$array_fechaA[0]);
                $marca_fechaB = mktime(0,0,0,$array_fechaB[1],$array_fechaB[2],$array_fechaB[0]);
            }

            //resto a una fecha la otra
            $segundos_diferencia = $marca_fechaA - $marca_fechaB;

            //convierto segundos en días
            $dias_diferencia = $segundos_diferencia / (60 * 60 * 24);

            //obtengo el valor absoulto de los días (quito el posible signo negativo)
            $dias_diferencia = abs($dias_diferencia);

            //quito los decimales a los días de diferencia
            $dias_diferencia = floor($dias_diferencia);

            return $dias_diferencia;
        }

    }

}

