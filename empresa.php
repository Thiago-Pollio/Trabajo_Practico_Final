<?php 

class Empresa
{
    private $idempresa; // clave // auto increment
    private $enombre;
    private $edireccion;
    private $mensajeOperacion;

    public function getIdempresa () {
        return $this->idempresa;
    }

    public function getEnombre () {
        return $this->enombre;
    }

    public function getEdireccion () {
        return $this->edireccion;
    }

    public function getMensajeOperacion () {
        return $this->mensajeOperacion;
    }

    public function setIdempresa ($idempresa) {
        $this->idempresa = $idempresa;
    }

    public function setEnombre ($enombre) {
        $this->enombre = $enombre;
    }

    public function setEdireccion ($edireccion) {
        $this->edireccion = $edireccion;
    }

    public function setMensajeOperacion ($mensajeOperacion) {
        $this->mensajeOperacion = $mensajeOperacion;
    }

    public function __construct() {
        $this->idempresa = "";
        $this->enombre = "";
        $this->edireccion = "";
    }

    public function Cargar ($idempresa, $enombre, $edireccion) {
        $this->setIdempresa($idempresa);
        $this->setEnombre($enombre);
        $this->setEdireccion($edireccion);
    }

    //FUNCION INSERTAR EMPRESA

    public function Insertar (){
        $baseDeDatos = new BaseDatos();
        $resp = false;
        $nombre = $this->getEnombre();
        $direccion = $this->getEdireccion();

        $consultaInsertar = "INSERT INTO empresa(enombre, edireccion)
                            VALUES ('$nombre' , '$direccion')";
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

    // FUNCION LISTAR EMPRESAS

    public function Listar ($condicion = "") {
        $arregloEmpresas = null;
        $baseDeDatos = new BaseDatos();
        $consultaEmpresas = "Select * from empresa";

        if ($condicion != "") {
            $consultaEmpresas = $consultaEmpresas . 'where' . $condicion;
        }

        $consultaEmpresas .= " order by idempresa ";

        if ($baseDeDatos->Iniciar()) {
            if ($baseDeDatos->Ejecutar($consultaEmpresas)) {
                $arregloEmpresas = [];
                while ($row2 = $baseDeDatos->Registro()) {
                    $idempresa = $row2 ['idempresa'];
                    $enombre = $row2 ['enombre'];
                    $edireccion = $row2 ['edireccion'];

                    $objEmpresa = new Empresa();
                    $objEmpresa->Cargar($idempresa, $enombre, $edireccion);
                    array_push($arregloEmpresas, $objEmpresa);
                }
            } else {
                $this->setMensajeOperacion($baseDeDatos->getError());
            }
        } else {
            $this->setMensajeOperacion($baseDeDatos->getError());
        }

        return $arregloEmpresas;
    }

    // FUNCION BUSCAR EMPRESA

    public function Buscar ($id) {
        $baseDeDatos = new BaseDatos();
        $consultaEmpresas = "Select * from empresa where idempresa=".$id;
        $resp = false;

        if ($baseDeDatos->Iniciar()) {
            if ($baseDeDatos->Ejecutar($consultaEmpresas)) {
                if ($row2 = $baseDeDatos->Registro()) {

                    // usar cargar

                    $this->Cargar($id, $row2 ['enombre'], $row2 ['edireccion']);
                    /*$this->setIdempresa($id);
                    $this->setEnombre($row2 ['enombre']);
                    $this->setEdireccion($row2 ['edireccion']);*/
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

    // FUNCION MODIFICAR EMPRESA

    public function Modificar () { 
        $resp = false;
        $baseDeDatos = new BaseDatos();
        $consultaModificar = "UPDATE empresa SET enombre='".$this->getEnombre()."',edireccion='".$this->getEdireccion().
                             "' WHERE idempresa=". $this->getIdempresa();
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
        $ide = $this->getIdempresa();
        if ($baseDeDatos->Iniciar()) {
            $consultaBorrar ="DELETE FROM empresa WHERE idempresa=$ide";
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
        return "\n ID Empresa: " . $this->getIdempresa().
        "\n Nombre: " . $this->getEnombre().
        "\n Direccion: " . $this->getEdireccion();
    }

    
    
}
