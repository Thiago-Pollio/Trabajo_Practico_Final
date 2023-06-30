<?php

class Responsable
{
    private $rnumeroempleado; // clave // auto increment
    private $rnumerolicencia;
    private $rnombre;
    private $rapellido;
    private $mensajeOperacion;

    public function getRnumeroempleado(){
        return $this->rnumeroempleado;
    }

    public function getRnumerolicencia(){
        return $this->rnumerolicencia;
    }

    public function getRnombre(){
        return $this->rnombre;
    }

    public function getRapellido(){
        return $this->rapellido;
    }

    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
    }

    public function setRnumeroempleado($rnumeroempleado){
        $this->rnumeroempleado = $rnumeroempleado;
    }

    public function setRnumerolicencia($rnumerolicencia){
        $this->rnumerolicencia = $rnumerolicencia;
    }

    public function setRnombre($rnombre){
        $this->rnombre = $rnombre;
    }

    public function setRapellido($rapellido){
        $this->rapellido = $rapellido;
    }

    public function setMensajeOperacion ($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function __construct() {
        $this->rnumeroempleado = "";
        $this->rnumerolicencia = "";
        $this->rnombre = "";
        $this->rapellido = "";
       }
    
       public function Cargar ($rnumeroempleado, $rnumerolicencia, $rnombre, $rapellido) {
         $this->setRnumeroempleado($rnumeroempleado);
         $this->setRnumerolicencia($rnumerolicencia);
         $this->setRnombre($rnombre);
         $this->setRapellido($rapellido);
       }
    
       //FUNCION INSERTAR RESPONSABLE
    
       public function Insertar (){
        $baseDeDatos = new BaseDatos();
        $resp = false;
        $nroLicencia = $this->getRnumerolicencia();
        $nombreR = $this->getRnombre();
        $apellidoR = $this->getRapellido();
    
        $consultaInsertar = "INSERT INTO responsable(rnumerolicencia, rnombre, rapellido)
                            VALUES ('$nroLicencia', '$nombreR', '$apellidoR')";
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
    
        // FUNCION LISTAR RESPONSABLES
    
        public function Listar ($condicion = "") {
            $arregloResponsables = null;
            $baseDeDatos = new BaseDatos();
            $consultaResponsables = "Select * from responsable";
    
            if ($condicion != "") {
                $consultaResponsables = $consultaResponsables . 'where' . $condicion;
            }
    
            $consultaResponsables .= " order by rnumeroempleado ";
    
            if ($baseDeDatos->Iniciar()) {
                if ($baseDeDatos->Ejecutar($consultaResponsables)) {
                    $arregloResponsables = [];
                    while ($row2 = $baseDeDatos->Registro()) {
                        $rnumeroempleado = $row2 ['rnumeroempleado'];
                        $rnumerolicencia = $row2 ['rnumerolicencia'];
                        $rnombre = $row2 ['rnombre'];
                        $rapellido = $row2 ['rapellido'];
    
                        $objResponsable = new Responsable();
                        $objResponsable->Cargar($rnumeroempleado, $rnumerolicencia, $rnombre, $rapellido);
                        array_push($arregloResponsables, $objResponsable);
                    }
                } else {
                    $this->setMensajeOperacion($baseDeDatos->getError());
                }
            } else {
                $this->setMensajeOperacion($baseDeDatos->getError());
            }
    
            return $arregloResponsables;
        }
    
        // FUNCION BUSCAR RESPONSABLE
    
        public function Buscar ($nroEmpleado) {
            $baseDeDatos = new BaseDatos();
            $consultaResponsables = "Select * from responsable where rnumeroempleado=".$nroEmpleado;
            $resp = false;
    
            if ($baseDeDatos->Iniciar()) {
                if ($baseDeDatos->Ejecutar($consultaResponsables)) {
                    if ($row2 = $baseDeDatos->Registro()) {

                        $this->Cargar($nroEmpleado, $row2 ['rnumerolicencia'], $row2 ['rnombre'], $row2 ['rapellido']);
                        
                        /*$this->setRnumeroempleado($nroEmpleado);
                        $this->setRnumerolicencia();
                        $this->setRnombre();
                        $this->setRapellido();*/

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
    
        // FUNCION MODIFICAR RESPONSABLE
    
        public function Modificar () { 
            $resp = false;
            $baseDeDatos = new BaseDatos();
            $consultaModificar = "UPDATE responsable SET rnumerolicencia='".$this->getRnumerolicencia()."',rnombre='".$this->getRnombre()."',rapellido='".$this->getRapellido().
                                "' WHERE rnumeroempleado=". $this->getRnumeroempleado();
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
    
        // FUNCION ELIMINAR RESPONSABLE
    
        public function eliminar () {
            $resp = false;
            $baseDeDatos = new BaseDatos();
            $nroE = $this->getRnumeroempleado();
            if ($baseDeDatos->Iniciar()) {
                $consultaBorrar ="DELETE FROM responsable WHERE rnumeroempleado=$nroE";
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
            return "\n Numero de empleado: " . $this->getRnumeroempleado().
            "\n Numero de licencia: " . $this->getRnumerolicencia().
            "\n Nombre: " . $this->getRnombre().
            "\n Apellido: " . $this->getRapellido();
        }
    
    
}
