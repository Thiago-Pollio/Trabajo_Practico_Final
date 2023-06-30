<?php

include_once "BaseDatos.php";
include_once "empresa.php";
include_once "pasajero.php";
include_once "responsable.php";
include_once "viaje.php";

$objEmpresa = new Empresa ();
$objResponsable = new Responsable();
$objViaje = new Viaje();
$objPasajero = new Pasajero();

$salir = false;

while ($salir == false) {
    $menu= "Menú de opciones: \n" .
        "1) Ingresar empresa \n".
        "2) Modificar datos  de la empresa \n" .
        "3) Eliminar empresa \n".
        "4) Ingresar responsable \n".
        "5) Modificar datos del responsable \n".
        "6) Eliminar Responsable \n".
        "7) Ingresar viaje \n" .
        "8) Modificar datos del viaje \n" .
        "9) Eliminar viaje \n" .
        "10) Agregar pasajero \n" .
        "11) Modificar datos del pasajero \n" .
        "12) Eliminar pasajero \n" . 
        "13) Ver datos \n" . 
        "14) Salir \n"; 
        echo $menu;
        echo "Ingrese una opcion: ";
        $opcion = trim(fgets(STDIN));
        

        switch ($opcion) {

            case 1: // Ingresar empresa
                
                echo "Ingrese el nombre de la empresa: ";
                $nombreE = trim(fgets(STDIN));
                echo "Ingrese la direccion de la empresa: ";
                $direccionE = trim(fgets(STDIN));

                $objEmpresa->setEnombre($nombreE);
                $objEmpresa->setEdireccion($direccionE);

                $respuesta = $objEmpresa->Insertar();

                if ($respuesta) {
                    echo "\nLa empresa fue ingresada en la BD\n";
                    echo "\n";
                } else {
                    echo $objEmpresa->getMensajeOperacion();
                }

                break;
                
            case 2: // Modificar datos  de la empresa

                // -------------------- Se listan las empresas para que elija el usuario --------------------
                echo "Lista de empresas: \n";
                $eListar = $objEmpresa-> Listar();
                $texto = "";
                $countE = count($eListar);

                for ($i=0; $i < $countE; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $eListar [$i]."\n";
                }

                echo "_____________________________________". "\n";
                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo " Empresas: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------


                echo "Ingrese el ID de la empresa que quiere modificar: \n";

                $idMod = trim(fgets(STDIN));
                echo "Ingrese el nuevo nombre de la empresa: ";
                $nuevoNombreE = trim(fgets(STDIN));
                echo "Ingrese la nueva direccion de la empresa: ";
                $nuevaDireccionE = trim(fgets(STDIN));
                

                $existeEmpresa = $objEmpresa->Buscar($idMod);

                if ($existeEmpresa == true) {
                    $objEmpresa->setEnombre($nuevoNombreE);
                    $objEmpresa->setEdireccion($nuevaDireccionE);
                    $respuesta = $objEmpresa->Modificar();

                    if ($respuesta) {
                        echo "\nLa empresa fue modificada. \n";
                    } else {
                        echo $objEmpresa->getMensajeOperacion();
                    }
                } else {
                    echo "No existe una empresa con ese ID. \n";
                }

                
    
                break;
            case 3: // Eliminar empresa

                // -------------------- Se listan las empresas para que elija el usuario --------------------

                echo "Lista de empresas: \n";
                $eListar = $objEmpresa-> Listar();
                $texto = "";
                $countE = count($eListar);

                for ($i=0; $i < $countE; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $eListar [$i]."\n";
                }

                echo "_____________________________________". "\n";
                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo " Empresas: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------

                echo "Ingrese el ID de la empresa que quiere eliminar: \n";
                
                $idEmpresa = trim(fgets(STDIN));

                $existeEmpresa = $objEmpresa->Buscar($idEmpresa);
                
                if ($existeEmpresa == true) {

                    $listarViajes = $objViaje->Listar();
                    $c = count($listarViajes);
                    $empresaOcupada = 0;

                    for ($i=0; $i < $c; $i++) { 
                        $unViaje =$listarViajes[$i];
                        $empresaDelViaje = $unViaje->getObjEmpresa();
                            
                        if ($empresaDelViaje == $idEmpresa) {
                                
                            $empresaOcupada ++;
                                
                        }
                    }

                    if ($empresaOcupada == 0) {
                        
                        $respuesta = $objEmpresa->eliminar();

                        if ($respuesta) {
                            echo "\nLa empresa fue eliminada de la BD\n";
                        } else {
                            echo $objEmpresa->getMensajeOperacion();
                        }  
                    } else {
                        echo "\nLa empresa tiene asignada un viaje, no se puede eliminar.\n";
                    }

                    
                } else {
                    echo "No existe una empresa con ese ID. \n";
                }

                break;
            case 4: // Ingresar responsable

                echo "Ingrese el numero de licencia del responsable: \n";
                $numeroLR = trim(fgets(STDIN));
                echo "Ingrese el nombre del responsable: \n";
                $nombreR = trim(fgets(STDIN));
                echo "Ingrese el apellido del responsable: \n";
                $apellidoR = trim(fgets(STDIN));

                $objResponsable->setRnumerolicencia($numeroLR);
                $objResponsable->setRnombre($nombreR);
                $objResponsable->setRapellido($apellidoR);

                $respuesta = $objResponsable->Insertar();

                if ($respuesta) {
                    echo "\nEl responsable fue ingresado en la BD\n";
                } else {
                    echo $objResponsable->getMensajeOperacion();
                }
    
                
                    
                break;
            case 5: // Modificar datos  del responsable

                // -------------------- Se listan los responsables para que elija el usuario --------------------

                $responsableListar = $objResponsable-> Listar();
                echo "Lista de responsables: \n";
                $texto = "";
                $countResponsables = count($responsableListar);

                for ($i=0; $i < $countResponsables; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $responsableListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════════╗";
                echo "\n";
                echo " Responsables: \n";
                echo "╚══════════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------

                echo "Ingrese el numero de empleado del responsable que quiere modificar: \n";
                $nroEMod = trim(fgets(STDIN));
                echo "Ingrese el nuevo numero de licencia: \n";
                $nuevoNL = trim(fgets(STDIN));
                echo "Ingrese el nuevo nombre del responsable: \n";
                $nuevoNombreR = trim(fgets(STDIN));
                echo "Ingrese el nuevo apellido del responsable: \n";
                $nuevoApellidoR = trim(fgets(STDIN));

                $existeResponsable = $objResponsable->Buscar($nroEMod);

                if ($existeResponsable == true) {

                    $objResponsable->setRnumerolicencia($nuevoNL);
                    $objResponsable->setRnombre($nuevoNombreR);
                    $objResponsable->setRapellido($nuevoApellidoR);

                    $respuesta = $objResponsable->Modificar();

                    if ($respuesta) {
                        echo "\nEl responsable fue modificado. \n";
                    } else {
                        echo $objResponsable->getMensajeOperacion();
                    }
                } else {
                    echo "No existe un responsable con ese numero de empleado. \n";
                }
                
                break;
            case 6: // Eliminar responsable

                // -------------------- Se listan los responsables para que elija el usuario --------------------

                $responsableListar = $objResponsable-> Listar();
                echo "Lista de responsables: \n";
                $texto = "";
                $countResponsables = count($responsableListar);

                for ($i=0; $i < $countResponsables; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $responsableListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════════╗";
                echo "\n";
                echo " Responsables: \n";
                echo "╚══════════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------

                echo "Ingrese el numero de empleado del responsable que quiere eliminar: \n";
                
                $numeroDeEmpleadoEliminar = trim(fgets(STDIN));

                $existeResponsable = $objResponsable->Buscar($numeroDeEmpleadoEliminar);

                if ($existeResponsable == true) {

                    $listarViajes = $objViaje->Listar();
                    $c = count($listarViajes);
                    $responsableOcupado = 0;

                    for ($i=0; $i < $c; $i++) { 
                        $unViaje =$listarViajes[$i];
                        $responsableDelViaje = $unViaje->getObjEmpleado();
                            
                        if ($responsableDelViaje == $numeroDeEmpleadoEliminar) {
                                
                            $responsableOcupado ++;
                                
                        }
                    }

                    if ($responsableOcupado == 0) {
                        
                        $respuesta = $objResponsable->eliminar();
                        
                        if ($respuesta) {
                            echo "\nEl responsable fue eliminado de la BD\n";
                        } else {
                            echo $objResponsable->getMensajeOperacion();
                        }
                    } else {
                        echo "\nLa empresa tiene asignada un viaje, no se puede eliminar.\n";
                    }

                } else {
                    echo "No existe un responsable con ese numero de empleado. \n";
                }
                
                break;
            case 7: // Ingresar viaje

                echo "Ingrese el destino del viaje: \n";
                $destinoViaje = trim(fgets(STDIN));
                echo "Ingrese la cantidad máxima de pasajeros del viaje: \n";
                $cantMaxPasajeros = trim(fgets(STDIN));

                // -------------------- Se listan las empresas para que elija el usuario --------------------
                
                echo "Lista de empresas: \n";
                $eListar = $objEmpresa-> Listar();
                $texto = "";
                $countE = count($eListar);

                for ($i=0; $i < $countE; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $eListar [$i]."\n";
                }

                echo "_____________________________________". "\n";
                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo " Empresas: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------

                echo "Ingrese el ID de la empresa que elija: \n";

                $idEmpresaViaje = trim(fgets(STDIN));


                $buscarEmpresa = $objEmpresa->Buscar($idEmpresaViaje);
                if ($buscarEmpresa) {

                    // -------------------- Se listan los responsables para que elija el usuario --------------------

                    $responsableListar = $objResponsable-> Listar();
                    echo "Lista de responsables: \n";
                    $texto = "";
                    $countResponsables = count($responsableListar);

                    for ($i=0; $i < $countResponsables; $i++) { 
                        $texto = $texto .  $i + 1 . ") ". $responsableListar [$i]."\n";
                    }

                    echo "\n";
                    echo "╔══════════════╗";
                    echo "\n";
                    echo " Responsables: \n";
                    echo "╚══════════════╝\n";
                    echo "\n" ;
                    echo $texto . "\n";
                    echo "_____________________________________". "\n";

                    // ----------------------------------------

                    echo "Ingrese el numero de responsable del responsable que elija: \n";
                    $nroEmpleadoResponsableViaje = trim(fgets(STDIN));

                    $buscarResponsable = $objResponsable->Buscar($nroEmpleadoResponsableViaje);

                    if ($buscarResponsable) {
                        echo "Ingrese el importe del viaje: ";
                        $importeViaje = trim(fgets(STDIN));

                        $objViaje->setVdestino($destinoViaje);
                        $objViaje->setVcantmaxpasajeros($cantMaxPasajeros);
                        $objViaje->setObjEmpresa($objEmpresa);
                        $objViaje->setObjEmpleado($objResponsable);
                        $objViaje->setVimporte($importeViaje);

                        $respuesta = $objViaje->Insertar();

                        if ($respuesta) {
                            echo "\nEl viaje fue ingresado en la BD\n";
                        } else {
                            echo $objViaje->getMensajeOperacion();
                        }
                    } else {
                        echo "\n El numero de empleado del responsable no existe, elija un ID valido de la lista. \n";
                    }

                    
                } else {
                    echo "\n El ID de la empresa no existe, elija un ID valido de la lista. \n";
                }

                break;
            case 8: // Modificar datos del viaje

                // -------------------- Se listan los viajes para que elija el usuario --------------------

                $viajeListar = $objViaje-> Listar();
                $texto = "";
                $countViajes = count($viajeListar);

                for ($i=0; $i < $countViajes; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $viajeListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo "  Viajes: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------
                
                echo "Ingrese el ID del viaje que quiere modificar: \n";
                $viajeIDMod = trim(fgets(STDIN));
                echo "Ingrese el nuevo destino del viaje: \n";
                $destinoViajeN = trim(fgets(STDIN));
                echo "Ingrese la nueva cantidad máxima de pasajeros del viaje: \n";
                $cantMaxPasajerosN = trim(fgets(STDIN));

                // -------------------- Se listan las empresas para que elija el usuario --------------------

                $eListar = $objEmpresa-> Listar();
                $texto = "";
                $countE = count($eListar);

                for ($i=0; $i < $countE; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $eListar [$i]."\n";
                }

                echo "_____________________________________". "\n";
                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo " Empresas: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------

                echo "\n Ingrese el ID de la empresa que elija: \n";
                $idEmpresaViajeN = trim(fgets(STDIN));

                // -------------------- Se listan los responsables para que elija el usuario --------------------

                $responsableListar = $objResponsable-> Listar();
                
                $texto = "";
                $countResponsables = count($responsableListar);

                for ($i=0; $i < $countResponsables; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $responsableListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════════╗";
                echo "\n";
                echo " Responsables: \n";
                echo "╚══════════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------

                echo "\n Ingrese el numero de responsable del responsable que elija: \n";
                $nroEmpleadoResponsableViajeN = trim(fgets(STDIN));
                echo "Ingrese el nuevo importe del viaje: \n";
                $importeViajeN = trim(fgets(STDIN));

                $existeViaje = $objViaje->Buscar($viajeIDMod);
                $buscarEmpresa = $objEmpresa->Buscar($idEmpresaViajeN);
                $buscarResponsable = $objResponsable->Buscar($nroEmpleadoResponsableViajeN);

                if ($existeViaje == true) {

                    if ($buscarEmpresa && $buscarResponsable) {

                        $objViaje->setVdestino($destinoViajeN);
                        $objViaje->setVcantmaxpasajeros($cantMaxPasajerosN);
                        $objViaje->setObjEmpresa($objEmpresa);
                        $objViaje->setObjEmpleado($objResponsable);
                        $objViaje->setVimporte($importeViajeN);

                        $respuesta = $objViaje->Modificar();

                        if ($respuesta) {
                            echo "\nEl viaje fue modificado. \n";
                        } else {
                            echo $objViaje->getMensajeOperacion();
                        }
                        
                    } else {
                        
                        echo "No existe una empresa con ese ID (".$idEmpresaViajeN . ") \n
                        y/o no existe un responsable con ese numero de empleado (". $nroEmpleadoResponsableViajeN . ")\n";
                    }
                } else {
                    echo "No existe un viaje con el ID " . $viajeIDMod ." . \n";
                }
                
                break;
            case 9: // Eliminar viaje

                // -------------------- Se listan los viajes para que elija el usuario --------------------
        
                $viajeListar = $objViaje-> Listar();
                $texto = "";
                $countViajes = count($viajeListar);

                for ($i=0; $i < $countViajes; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $viajeListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo "  Viajes: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------
                
                echo "Ingrese el ID del viaje que quiere eliminar: ";
                $IDViajeEliminar = trim(fgets(STDIN));

                $existeViaje = $objViaje->Buscar($IDViajeEliminar);

                if ($existeViaje == true) {

                    $listarPasajeros = $objPasajero->Listar();
                    $c = count($listarPasajeros);
                    $pasajeroOcupa = 0;

                    for ($i=0; $i < $c; $i++) { 
                        $unPasajero =$listarPasajeros[$i];
                        $viajePasajero = $unPasajero->getIdviaje();
                            
                        if ($viajePasajero == $IDViajeEliminar) {
                                
                            $pasajeroOcupa ++;
                                
                        }
                    }

                    if ($pasajeroOcupa == 0) {
                        
                        $respuesta = $objViaje->eliminar();

                        if ($respuesta) {
                            echo "\nEl viaje fue eliminado de la BD\n";
                        } else {
                            echo $objViaje->getMensajeOperacion();
                        }  
                    } else {
                        echo "\nEl viaje tiene asignada un pasajero, no se puede eliminar.\n";
                    }

                } else {
                    echo "No existe un viaje con ese ID. \n";
                }
                break;
            case 10: // Agregar pasajero

                echo "Ingrese el documento del pasajero: ";
                $dniPasajero = trim(fgets(STDIN));
                echo "Ingrese el nombre del pasajero: ";
                $nombrePasajero = trim(fgets(STDIN));
                echo "Ingrese el apellido del pasajero: ";
                $apellidoPasajero = trim(fgets(STDIN));
                echo "Ingrese el telefono del pasajero: ";
                $telefonoPasajero = trim(fgets(STDIN));

                // -------------------- Se listan los viajes para que elija el usuario --------------------

                $viajeListar = $objViaje-> Listar();
                $texto = "";
                $countViajes = count($viajeListar);

                for ($i=0; $i < $countViajes; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $viajeListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo "  Viajes: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------


                echo "Ingrese el ID del viaje: ";
                $IDViajePasajero = trim(fgets(STDIN));
                $buscarViaje = $objViaje->Buscar($IDViajePasajero);
                if ($buscarViaje) {
                    $maximo = $objViaje->getVcantmaxpasajeros();
                    $listarPasajerosViaje = $objPasajero->Listar();
                    $c = count($listarPasajerosViaje);

                    if ($c > 0) {
                        $ocupado = 0;

                        for ($i=0; $i < $c; $i++) { 
                            $unPasajero =$listarPasajerosViaje[$i];
                            $viajeDelPasajero = $unPasajero->getIdviaje();
                            
                            if ($viajeDelPasajero == $IDViajePasajero) {
                                
                                $ocupado ++;
                                
                            }
                        }
                        if ($ocupado >= $maximo) {
                            echo "El viaje " . $IDViajePasajero ." ya está completo.";
                        } else {
                            $objPasajero->setPdocumento($dniPasajero);
                            $objPasajero->setPnombre($nombrePasajero);
                            $objPasajero->setPapellido($apellidoPasajero);
                            $objPasajero->setPtelefono($telefonoPasajero);
                            $objPasajero->setIdviaje($IDViajePasajero);
                            $respuesta = $objPasajero->Insertar();
    
                            if ($respuesta) {
                                echo "\nEl pasajero fue ingresado en la BD\n";
                            } else {
                                echo $objPasajero->getMensajeOperacion();
                            }
                            
                        }
                    } else {
                        $objPasajero->setPdocumento($dniPasajero);
                        $objPasajero->setPnombre($nombrePasajero);
                        $objPasajero->setPapellido($apellidoPasajero);
                        $objPasajero->setPtelefono($telefonoPasajero);
                        $objPasajero->setIdviaje($IDViajePasajero);
                        $respuesta = $objPasajero->Insertar();

                        if ($respuesta) {
                            echo "\nEl pasajero fue ingresado en la BD\n";
                        } else {
                            echo $objPasajero->getMensajeOperacion();
                        }
                    }
                    
                } else {
                    echo "No existe ese viaje";
                }
                        
                break;
            case 11: // Modificar datos del pasajero

                // -------------------- Se listan los pasajeros para que elija el usuario --------------------

                $pasajeroListar = $objPasajero-> Listar();

                $texto = "";
                $countPasajeros = count($pasajeroListar);

                for ($i=0; $i < $countPasajeros; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $pasajeroListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo " Pasajeros: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";
                echo "\n";

                // ----------------------------------------


                echo "Ingrese el numero de documento del pasajero a modificar: ";
                $dniMod = trim(fgets(STDIN));
                echo "Ingrese el nuevo nombre del pasajero: ";
                $nombrePasajeroN = trim(fgets(STDIN));
                echo "Ingrese el nuevo apellido del pasajero: ";
                $apellidoPasajeroN = trim(fgets(STDIN));
                echo "Ingrese el nuevo telefono del pasajero: ";
                $telefonoPasajeroN = trim(fgets(STDIN));

                // -------------------- Se listan los viajes para que elija el usuario --------------------

                $viajeListar = $objViaje-> Listar();

                $texto = "";
                $countViajes = count($viajeListar);

                for ($i=0; $i < $countViajes; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $viajeListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo "  Viajes: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------


                echo "Ingrese el nuevo ID del viaje: ";
                $IDViajePasajeroN = trim(fgets(STDIN));

                $existePasajero = $objPasajero->Buscar($dniMod);

                if ($existePasajero == true) {
                    
                    $objPasajero->setPnombre($nombrePasajeroN);
                    $objPasajero->setPapellido($apellidoPasajeroN);
                    $objPasajero->setPtelefono($telefonoPasajeroN);
                    $objPasajero->setIdviaje($IDViajePasajeroN);
                    
                    $respuesta = $objPasajero->Modificar();

                    if ($respuesta) {
                        echo "\nEl pasajero fue modificada. \n";
                    } else {
                        echo $objPasajero->getMensajeOperacion();
                    }
                } else {
                    echo "No existe un pasajero con ese numero de documento. \n";
                }
                        
                break;
            case 12: // Eliminar pasajero

                // -------------------- Se listan los pasajeros para que elija el usuario --------------------

                $pasajeroListar = $objPasajero-> Listar();
                $texto = "";
                $countPasajeros = count($pasajeroListar);

                for ($i=0; $i < $countPasajeros; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $pasajeroListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo " Pasajeros: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";
                echo "\n";

                // ----------------------------------------
                
                echo "Ingrese el numero de documento del pasajero a eliminar: ";
                $nroDocumento = trim(fgets(STDIN));

                $existePasajero = $objPasajero->Buscar($nroDocumento);

                if ($existePasajero == true) {

                    $respuesta = $objPasajero->eliminar();

                    if ($respuesta) {
                        echo "\nEl pasajero fue eliminado de la BD\n";
                    } else {
                        echo $objEmpresa->getMensajeOperacion();
                    }  
                } else {
                    echo "No existe un pasajero con ese numero de documento. \n";
                }
                        
                break;
            case 13: // Mostrar datos
                
                $empresaListar = $objEmpresa-> Listar();
                $responsableListar = $objResponsable-> Listar();
                $viajeListar = $objViaje-> Listar();
                $pasajeroListar = $objPasajero-> Listar();

                // ----------------------------------------mostrar arreglo de empresas----------------------------------------

                $texto = "";
                $countEmpresas = count($empresaListar);

                for ($i=0; $i < $countEmpresas; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $empresaListar [$i]."\n";
                }

                echo "_____________________________________". "\n";
                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo " Empresas: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                
                

                // ----------------------------------------mostrar arreglo de responsables----------------------------------------

                $texto = "";
                $countResponsables = count($responsableListar);

                for ($i=0; $i < $countResponsables; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $responsableListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════════╗";
                echo "\n";
                echo " Responsables: \n";
                echo "╚══════════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------mostrar arreglo de viajes----------------------------------------

                $texto = "";
                $countViajes = count($viajeListar);

                for ($i=0; $i < $countViajes; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $viajeListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo "  Viajes: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";

                // ----------------------------------------mostrar arreglo de pasajeros----------------------------------------

                $texto = "";
                $countPasajeros = count($pasajeroListar);

                for ($i=0; $i < $countPasajeros; $i++) { 
                    $texto = $texto .  $i + 1 . ") ". $pasajeroListar [$i]."\n";
                }

                echo "\n";
                echo "╔══════════╗";
                echo "\n";
                echo " Pasajeros: \n";
                echo "╚══════════╝\n";
                echo "\n" ;
                echo $texto . "\n";
                echo "_____________________________________". "\n";
                echo "\n";

                    
                break;
            case 14: // Salir
                $salir = true;
                        
                break;
    }
}
