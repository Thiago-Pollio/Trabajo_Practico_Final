<?php

class Pasajero
{
   private $pdocumento; //clave 
   private $pnombre;
   private $papellido;
   private $ptelefono;
   private $idviaje;
   private $mensajeOperacion;

   public function getPdocumento(){
        return $this->pdocumento;
   }

   public function getPnombre(){
        return $this->pnombre;
   }

   public function getPapellido(){
        return $this->papellido;
   }

   public function getPtelefono(){
        return $this->ptelefono;
   }

   public function getIdviaje(){
        return $this->idviaje;
   }

   public function getMensajeOperacion () {
        return $this->mensajeOperacion;
   }

   public function setPdocumento($pdocumento){
        $this->pdocumento = $pdocumento;
   }

   public function setPnombre($pnombre){
        $this->pnombre = $pnombre;
   }

   public function setPapellido($papellido){
        $this->papellido = $papellido;
   }

   public function setPtelefono($ptelefono){
        $this->ptelefono = $ptelefono;
   }

   public function setIdviaje($idviaje){
        $this->idviaje = $idviaje;
   }

   public function setMensajeOperacion ($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
   }

   public function __construct() {
    $this->pdocumento = "";
    $this->pnombre = "";
    $this->papellido = "";
    $this->ptelefono = "";
    $this->idviaje = "";
   }

   public function Cargar ($pdocumento, $pnombre, $papellido, $ptelefono, $idviaje) {
     $this->setPdocumento($pdocumento);
     $this->setPnombre($pnombre);
     $this->setPapellido($papellido);
     $this->setPtelefono($ptelefono);
     $this->setIdviaje($idviaje);
   }

   //FUNCION INSERTAR PASAJERO

   public function Insertar (){
    $baseDeDatos = new BaseDatos();
    $resp = false;
    $documento = $this->getPdocumento();
    $nombre = $this->getPnombre();
    $apellido = $this->getPapellido();
    $telefono = $this->getPtelefono();
    $id = $this->getIdviaje();


    $consultaInsertar = "INSERT INTO pasajero(pdocumento, pnombre, papellido, ptelefono, idviaje)
                        VALUES ('$documento', '$nombre', '$apellido', '$telefono', '$id')";
    if ($baseDeDatos->Iniciar()) {
        if ($baseDeDatos->Ejecutar($consultaInsertar)) {
            $resp = true;
        } else {
            $this->setMensajeOperacion($baseDeDatos->getError());
        }
    } else {
        $this->setMensajeOperacion($baseDeDatos->getError());
    }
    return $resp;
    }

    // FUNCION LISTAR PASAJEROS

    public function Listar ($condicion = "") {
        $arregloPasajeros = null;
        $baseDeDatos = new BaseDatos();
        $consultaPasajeros = "Select * from pasajero";

        if ($condicion != "") {
            $consultaPasajeros = $consultaPasajeros . 'where' . $condicion;
        }

        $consultaPasajeros .= " order by pdocumento ";

        if ($baseDeDatos->Iniciar()) {
            if ($baseDeDatos->Ejecutar($consultaPasajeros)) {
                $arregloPasajeros = [];
                while ($row2 = $baseDeDatos->Registro()) {
                    $pdocumento = $row2 ['pdocumento'];
                    $pnombre = $row2 ['pnombre'];
                    $papellido = $row2 ['papellido'];
                    $ptelefono = $row2 ['ptelefono'];
                    $idviaje = $row2 ['idviaje'];

                    $objPasajero = new Pasajero();
                    $objPasajero->Cargar($pdocumento, $pnombre, $papellido, $ptelefono, $idviaje);
                    array_push($arregloPasajeros, $objPasajero);
                }
            } else {
                $this->setMensajeOperacion($baseDeDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDeDatos->getError());
        }

        return $arregloPasajeros;
    }

    // FUNCION BUSCAR PASAJERO

    public function Buscar ($dni) {
        $baseDeDatos = new BaseDatos();
        $consultaPasajeros = "Select * from pasajero where pdocumento=".$dni;
        $resp = false;

        if ($baseDeDatos->Iniciar()) {
            if ($baseDeDatos->Ejecutar($consultaPasajeros)) {
                if ($row2 = $baseDeDatos->Registro()) {
                    
                    $this->Cargar($dni, $row2 ['pnombre'], $row2 ['papellido'], $row2 ['ptelefono'], $row2 ['idviaje']);


                    /*$this->setPdocumento($dni);
                    $this->setPnombre();
                    $this->setPapellido();
                    $this->setPtelefono();
                    $this->setIdviaje();*/
                    $resp = true;
                }
            } else {
                $this->setMensajeOperacion($baseDeDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDeDatos->getError());
        }

        return $resp;
    }

    // FUNCION MODIFICAR PASAJERO

    public function Modificar () { 
        $resp = false;
        $baseDeDatos = new BaseDatos();
        $consultaModificar = "UPDATE pasajero SET pnombre='".$this->getPnombre()."',papellido='".$this->getPapellido()."',ptelefono='".$this->getPtelefono()."',idviaje='".$this->getIdviaje().
                            "' WHERE pdocumento=". $this->getPdocumento();
        if ($baseDeDatos->Iniciar()) {
            if ($baseDeDatos->Ejecutar($consultaModificar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($baseDeDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDeDatos->getError());
        }
                    
        return $resp;
    }

    // FUNCION ELIMINAR EMPRESA

    public function eliminar () {
        $resp = false;
        $baseDeDatos = new BaseDatos();
        if ($baseDeDatos->Iniciar()) {
            $consultaBorrar ="DELETE FROM pasajero WHERE pdocumento=".$this->getPdocumento();
            if ($baseDeDatos->Ejecutar($consultaBorrar)) {
                $resp = true;
            } else {
                $this->setMensajeOperacion($baseDeDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDeDatos->getError());
        }
                    
        return $resp;

    }

    public function __toString()
    {
        return "\n Documento: " . $this->getPdocumento().
        "\n Nombre: " . $this->getPnombre().
        "\n Apellido: " . $this->getPapellido().
        "\n Telefono: " . $this->getPtelefono().
        "\n ID Viaje: " . $this->getIdviaje();
    }
}
