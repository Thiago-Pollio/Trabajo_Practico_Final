<?php

class Viaje
{
    private $idviaje; // clave // auto increment
    private $vdestino;
    private $vcantmaxpasajeros;
    private $objEmpresa;
    private $objEmpleado;
    private $vimporte;
    private $mensajeOperacion;


    public function getIdviaje(){
        return $this->idviaje;
    }

    public function getVdestino(){
        return $this->vdestino;
    }

    public function getVcantmaxpasajeros(){
        return $this->vcantmaxpasajeros;
    }

    public function getObjEmpresa(){
        return $this->objEmpresa;
    }

    public function getObjEmpleado(){
        return $this->objEmpleado;
    }

    public function getVimporte(){
        return $this->vimporte;
    }

    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
    }

    public function setIdviaje($idviaje){
        $this->idviaje = $idviaje;
    }

    public function setVdestino($vdestino){
        $this->vdestino = $vdestino;
    }

    public function setVcantmaxpasajeros($vcantmaxpasajeros){
        $this->vcantmaxpasajeros = $vcantmaxpasajeros;
    }

    public function setObjEmpresa($objEmpresa){
        $this->objEmpresa = $objEmpresa;
    }

    public function setObjEmpleado($objEmpleado){
        $this->objEmpleado = $objEmpleado;
    }

    public function setVimporte($vimporte){
        $this->vimporte = $vimporte;
    }

    public function setMensajeOperacion ($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function __construct() {
        $this->idviaje = "";
        $this->vdestino = "";
        $this->vcantmaxpasajeros = "";
        $this->objEmpresa = "";
        $this->objEmpleado = "";
        $this->vimporte = "";
       }
    
       public function Cargar ($idviaje, $vdestino, $vcantmaxpasajeros, $objEmpresa, $objEmpleado, $vimporte) {
         $this->setIdviaje($idviaje);
         $this->setVdestino($vdestino);
         $this->setVcantmaxpasajeros($vcantmaxpasajeros);
         $this->setObjEmpresa($objEmpresa);
         $this->setObjEmpleado($objEmpleado);
         $this->setVimporte($vimporte);
       }
    
       //FUNCION INSERTAR VIAJE
    
       public function Insertar (){
        $baseDeDatos = new BaseDatos();
        $resp = false;
        $destino =$this->getVdestino();
        $cantMaxPasajeros = $this->getVcantmaxpasajeros();
        $idE = $this->getObjEmpresa()->getIdempresa();
        $nroEmpleado = $this->getObjEmpleado()->getRnumeroempleado();
        $importe = $this->getVimporte();
    
        $consultaInsertar = "INSERT INTO viaje(vdestino, vcantmaxpasajeros, idempresa, rnumeroempleado, vimporte)
                            VALUES ('$destino', '$cantMaxPasajeros', '$idE', '$nroEmpleado', '$importe')";
        if ($baseDeDatos->Iniciar()) {
            if ($id = $baseDeDatos->devuelveIDInsercion($consultaInsertar)) {
                $this->setIdviaje($id);
                $resp = true;
            } else {
                $this->setMensajeOperacion($baseDeDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDeDatos->getError());
        }
        return $resp;
        }
    
        // FUNCION LISTAR VIAJES
    
        public function Listar ($condicion = "") {
            $arregloViajes = null;
            $baseDeDatos = new BaseDatos();
            $consultaViajes = "Select * from viaje";
    
            if ($condicion != "") {
                $consultaViajes = $consultaViajes . 'where' . $condicion;
            }
    
            $consultaViajes .= " order by idviaje ";
    
            if ($baseDeDatos->Iniciar()) {
                if ($baseDeDatos->Ejecutar($consultaViajes)) {
                    $arregloViajes = [];
                    while ($row2 = $baseDeDatos->Registro()) {
                        $idviaje = $row2 ['idviaje'];
                        $vdestino = $row2 ['vdestino'];
                        $vcantmaxpasajeros = $row2 ['vcantmaxpasajeros'];
                        $objEmpresa = $row2 ['idempresa'];
                        $objEmpleado = $row2 ['rnumeroempleado'];
                        $vimporte = $row2 ['vimporte'];
    
                        $objViaje = new Viaje();
                        $objViaje->Cargar($idviaje, $vdestino, $vcantmaxpasajeros, $objEmpresa, $objEmpleado, $vimporte);
                        array_push($arregloViajes, $objViaje);
                    }
                } else {
                    $this->setMensajeOperacion($baseDeDatos->getError());
                }
            } else {
                $this->setMensajeOperacion($baseDeDatos->getError());
            }
    
            return $arregloViajes;
        }
    
        // FUNCION BUSCAR VIAJE
    
        public function Buscar ($id) {
            $baseDeDatos = new BaseDatos();
            $consultaViajes = "Select * from viaje where idviaje=".$id;
            $resp = false;
    
            if ($baseDeDatos->Iniciar()) {
                if ($baseDeDatos->Ejecutar($consultaViajes)) {
                    if ($row2 = $baseDeDatos->Registro()) {

                        $objetoEmpresa = new Empresa();
                        $objetoEmpresa->Buscar($row2 ['idempresa']);

                        $objetoResponsable = new Responsable();
                        $objetoResponsable->Buscar($row2 ['rnumeroempleado']);

                        $this->Cargar($id, $row2 ['vdestino'], $row2 ['vcantmaxpasajeros'], $objetoEmpresa, $objetoResponsable, $row2 ['vimporte']);
                        
                        
                        /*$this->setIdviaje($id);
                        $this->setVdestino();
                        $this->setVcantmaxpasajeros();
                        $this->setObjEmpresa();
                        $this->setObjEmpleado();
                        $this->setVimporte();*/
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
    
        // FUNCION MODIFICAR VIAJE
    
        public function Modificar () { 
            $resp = false;
            $baseDeDatos = new BaseDatos();
            $idMod = $this->getObjEmpresa()->getIdempresa();
            $nroEmpleadoMod = $this->getObjEmpleado()->getRnumeroempleado();
            $consultaModificar = "UPDATE viaje SET vdestino='".$this->getVdestino()."',vcantmaxpasajeros='".$this->getVcantmaxpasajeros()."',idempresa='".$idMod."',rnumeroempleado='".$nroEmpleadoMod."',vimporte='".$this->getVimporte().
                                "' WHERE idviaje=". $this->getIdviaje();
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
    
        // FUNCION ELIMINAR VIAJE
    
        public function eliminar () {
            $resp = false;
            $baseDeDatos = new BaseDatos();
            if ($baseDeDatos->Iniciar()) {
                $consultaBorrar ="DELETE FROM viaje WHERE idviaje=".$this->getIdviaje();
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
            return "\n ID Viaje: " . $this->getIdviaje().
            "\n Destino: " . $this->getVdestino().
            "\n Cantidad máxima de pasajeros: " . $this->getVcantmaxpasajeros().
            "\n ID Empresa: " . $this->getObjEmpresa().
            "\n Numero de Empleado: " . $this->getObjEmpleado().
            "\n Importe: " . $this->getVimporte();

        }

}
