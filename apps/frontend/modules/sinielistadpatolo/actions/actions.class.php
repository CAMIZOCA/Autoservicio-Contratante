<?php

/**
 * sinielistadpatolo actions.
 *
 * @package    aulavirtual
 * @subpackage sinielistadpatolo
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class sinielistadpatoloActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();

        //RS PARA CAMPOS DE BUSQUEDAS
        $cliente = $this->getRequestParameter('cliente');
        //$mes = $this->getRequestParameter('mes');
        $mes = $_POST['mes'];
        $ano = $this->getRequestParameter('ano');
        $tipo_servicio = $this->getRequestParameter('tipo_servicio');
        $contratante = $this->getRequestParameter('contratante');
        $clientes_usu = $this->getUser()->getAttribute('clientes');
        $indicador = $this->getRequestParameter('indicador');
        
        //echo  $contratante;
        //Paginador
        if ($request->getGetParameter('pagina') == ''):
            $val_pagina_ini = 0;
        else:
            $st = $_GET['pagina'] . 0;
        endif;
        $pp = $val_pagina_ini + 10;


        if ($st == '') {
            $st = 0;
        }
        $pp = 10;
        $fin_pp = $st + $pp;


        if (trim($mes) == '') {
            $mes = '-1';
        }

        if (trim($ano) == '') {
            
        }

        if (trim($cliente) == '') {
            
        }
        $es_bisiesto = date('L', $ano);
        //echo $mes;
        switch ($mes) {
            case 'todos':
                $fecha_ini = '01-01-' . $ano;
                $fecha_fin = '31-12-' . $ano;
                $num_dia_mes = '365';
            case '0':
                $fecha_ini = '01-01-' . $ano;
                $fecha_fin = '31-12-' . $ano;
                $num_dia_mes = '365';

                break;
            case '01':
                $fecha_ini = '01-01-' . $ano;
                $fecha_fin = '31-1-' . $ano;
                $num_dia_mes = '31';
                break;
            case '02':
                if (date('L', $ano) == 0) {
                    $fecha_ini = '01-02-' . $ano;
                    $fecha_fin = '29-2-' . $ano;
                    $num_dia_mes = '29';
                } else {
                    $fecha_ini = '01-02-' . $ano;
                    $fecha_fin = '28-02-' . $ano;
                    $num_dia_mes = '28';
                }
                break;
            case '03':
                $fecha_ini = '01-03-' . $ano;
                $fecha_fin = '31-03-' . $ano;
                $num_dia_mes = '31';
                break;
            case '04':
                $fecha_ini = '01-04-' . $ano;
                $fecha_fin = '30-04-' . $ano;
                $num_dia_mes = '30';
                break;
            case '05':
                $fecha_ini = '01-05-' . $ano;
                $fecha_fin = '31-05-' . $ano;
                $num_dia_mes = '31';
                break;
            case '06':
                $fecha_ini = '01-06-' . $ano;
                $fecha_fin = '30-06-' . $ano;
                $num_dia_mes = '30';
                break;
            case '07':
                $fecha_ini = '01-07-' . $ano;
                $fecha_fin = '31-7-' . $ano;
                $num_dia_mes = '31';
                break;
            case '08':
                $fecha_ini = '01-08-' . $ano;
                $fecha_fin = '31-08-' . $ano;
                $num_dia_mes = '31';
                break;
            case '09':
                $fecha_ini = '01-09-' . $ano;
                $fecha_fin = '30-09-' . $ano;
                $num_dia_mes = '30';
                break;
            case '10':
                $fecha_ini = '01-10-' . $ano;
                $fecha_fin = '31-10-' . $ano;
                $num_dia_mes = '31';
                break;
            case '11':
                $fecha_ini = '01-11-' . $ano;
                $fecha_fin = '30-11-' . $ano;
                $num_dia_mes = '30';
                break;
            case '12':
                $fecha_ini = '01-12-' . $ano;
                $fecha_fin = '31-12-' . $ano;
                $num_dia_mes = '31';
                break;
        }

        /* CAMBIAR POR UN SLECT CORRIDO */

        // COMBO CLIENTE
        $q = Doctrine_Query::create()
                ->from('CMB_CLIENTE_MVW  J')
                ->where("idepol IN ($clientes_usu)");
        $this->CMB_CLIENTE_MVW = $q->fetchArray();


        // COMBO CONTRATANTES
        $query = "SELECT CODCTROCOS, DESCTROCOS  FROM CMB_CONTRATANTE_MVW  WHERE 1=1 ";
        if (trim($cliente) != '') {
            $query.=" and IDEPOL='$cliente'";
        }
        $query.="ORDER BY DESCTROCOS ASC";
        $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt2 = $pdo2->prepare($query);
        $stmt2->execute();
        $this->CMB_CONTRATANTE_MVW333 = $stmt2->fetchAll();


        $q = "SELECT CODCTROCOS, DESCTROCOS  FROM CMB_CONTRATANTE_MVW WHERE 1=1 ";
        if (trim($cliente) != '') {
            $q.=" and IDEPOL='$cliente' ";
        }
        $q.=" ORDER BY DESCTROCOS ASC";
        $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt2 = $pdo2->prepare($q);
        $stmt2->execute();
        $this->CMB_CONTRATANTE_MVW = $stmt2->fetchAll();


        // Combo servicio

        $q22 = "SELECT COD_TIPO_DES, TIPO_DES, ID FROM SINIESTRALIDAD_VW  J 
                  WHERE 1=1 ";
        if (trim($cliente) != '') {
            $q22.=" AND IDEPOL ='$cliente' ";
        }
        if (trim($contratante) != '' and trim($contratante) != 'todos') {
            $q22.=" AND CODEXTERNO ='$contratante' ";
        }
        $q22.=" GROUP BY ( COD_TIPO_DES, TIPO_DES, ID) ";
        $q22.=" ORDER BY   TIPO_DES ASC";

        $pdo_ser = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt_ser = $pdo_ser->prepare($q22);
        $stmt_ser->execute();
        $this->CMB_SERVICIO = $stmt_ser->fetchAll();

        // COMBO AÑO GENERAL 
        $q223 = "SELECT to_char(fecocurr, 'yyyy') as anno FROM SINIESTRALIDAD_VW  J 
                    WHERE 1=1 ";
        if (trim($cliente) != '') {
            $q223.=" AND IDEPOL ='$cliente' ";
        }
        if (trim($contratante) != '' and trim($contratante) != 'todos') {
            $q223.=" AND CODEXTERNO ='$contratante' ";
        }
        if (trim($tipo_servicio) != '' and trim($tipo_servicio) != 'todos') {
            $q223.=" AND COD_TIPO_DES ='$tipo_servicio' ";
        }
        $q223.=" GROUP BY to_char(fecocurr, 'yyyy')";

        //echo $q223;

        $pdo_ano = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt_ano = $pdo_ano->prepare($q223);
        $stmt_ano->execute();
        $this->CMB_ANNO_GENERAL3 = $stmt_ano->fetchAll();


        // COMBO MES 
        $q_mes = "SELECT to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno
                  FROM SINIESTRALIDAD_VW  J WHERE 1=1 ";
        if (trim($cliente) != '') {
            $q_mes.=" AND IDEPOL ='$cliente' ";
        }
        if (trim($contratante) != '' and trim($contratante) != 'todos') {
            $q_mes.=" AND CODEXTERNO ='$contratante' ";
        }
        if (trim($tipo_servicio) != '' and trim($tipo_servicio) != 'todos') {
            $q_mes.=" AND COD_TIPO_DES ='$tipo_servicio' ";
        }

        if (trim($ano) != '' and trim($ano) != '-1') {
            $q_mes.=" and to_char(fecocurr,'yyyy') ='$ano' ";
        }

        $q_mes.=" GROUP BY to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')";
        $q_mes.=" order by to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc";

        //echo $q_mes;

        $pdo_mes = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt_mes = $pdo_mes->prepare($q_mes);
        $stmt_mes->execute();
        $this->CMB_MES = $stmt_mes->fetchAll();


        if ($indicador == 1) {
// TABLA GENERAL

            $q1 = " SELECT INITCAP(enfermedad) as enfermedad,  sum(indemnizado) as total, count(enfermedad) AS cantidad, INITCAP(tipo_des) as tipo_des
              FROM SINIESTRALIDAD_VW   J
              WHERE  to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' ";

            if (trim($contratante) != 'todos' and trim($contratante) != '') {
                $q1.=" and codexterno='$contratante'";
            }

            if (trim($tipo_servicio) != 'todos' and trim($tipo_servicio) != '') {
                $q1.=" and cod_tipo_des='$tipo_servicio'";
            }

            $q1.="  group by enfermedad, id, tipo_des ";
            $q1.="  order by enfermedad asc ";

            //echo $q1;

            $pdo_pr = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt_pr = $pdo_pr->prepare($q1);
            $stmt_pr->execute();
            $this->SINIESTRALIDAD_VW_tabla_inicial = $stmt_pr->fetchAll();
            $this->cuantos_tabla_inicial = $stmt_pr->rowCount();
            //echo $stmt_pr->rowCount();
// TABLA GENERAL
            // TABLA PARCIAL

            $q1 = " select * from (SELECT  ROWNUM as num ,A.*  from ( SELECT INITCAP(enfermedad) as enfermedad,  sum(indemnizado) as total, count(enfermedad) AS cantidad, INITCAP(tipo_des) as tipo_des
              FROM SINIESTRALIDAD_VW   J
              WHERE  to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' ";

            if (trim($contratante) != 'todos' and trim($contratante) != '') {
                $q1.=" and codexterno='$contratante'";
            }

            if (trim($tipo_servicio) != 'todos' and trim($tipo_servicio) != '') {
                $q1.=" and cod_tipo_des='$tipo_servicio'";
            }

            $q1.="  group by enfermedad, id, tipo_des ";
            $q1.="  order by enfermedad asc ) A ) where num<=$fin_pp and num>$st";

            //echo $q1;

            $pdo_pr = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt_pr = $pdo_pr->prepare($q1);
            $stmt_pr->execute();
            $this->SINIESTRALIDAD_VW_tabla_parcial = $stmt_pr->fetchAll();
            $cuantos_tabla_inicial_parcial = $stmt_pr->rowCount();

            // TABLA PARCIAL
            // PARA LOS ATENDIDOS

            $q_atend = " SELECT ci_paciente 
                   FROM SINIESTRALIDAD_VW  J 
                   WHERE to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'";

            if (trim($contratante) != 'todos' and trim($contratante) != '') {
                $q_atend.=" and codexterno='$contratante'";
            }

            if (trim($tipo_servicio) != 'todos' and trim($tipo_servicio) != '') {
                $q_atend.=" and cod_tipo_des='$tipo_servicio'";
            }

            $q_atend.="GROUP BY (ci_paciente,id)";

            $pdo_atend = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt_atend = $pdo_atend->prepare($q_atend);
            $stmt_atend->execute();
            $rs_atendidas = $stmt_atend->fetchAll();
            $this->total_per_atendidas = $stmt_atend->rowCount();

            // Número totla de patologia ver si 2 casos son de una misma persona               
             $q_patologia = "SELECT enfermedad
                  FROM SINIESTRALIDAD_VW   J
                  WHERE to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' ";

            if (trim($contratante) != 'todos' and trim($contratante) != '') {
                $q_patologia.=" and codexterno='$contratante'";
            }

            if (trim($tipo_servicio) != 'todos' and trim($tipo_servicio) != '') {
                $q_patologia.=" and cod_tipo_des='$tipo_servicio'";
            }

            $q_patologia.=" GROUP BY (enfermedad,id)";
            // echo  $q_patologia;
            $pdo_patologia = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt_patologia = $pdo_patologia->prepare($q_patologia);
            $stmt_patologia->execute();
            $rs_atendidas = $stmt_patologia->fetchAll();
            $this->num_patologias = $stmt_patologia->rowCount();
        } // if indicador=1  




        $q = Doctrine_Query::create()
                ->select('DISTINCT cod_ben_pago, ben_pago')
                ->from('SINIESTRALIDAD_VW   J')
                ->orderby('ben_pago asc');


        $this->SINIESTRALIDAD_VW_cant_prov = $q->fetchArray();

        $this->cantidad_prov = $q->count();




        $this->fecha_inicial = $fecha_ini;
        $this->fecha_final = $fecha_fin;
        $this->dias_mes = $num_dia_mes;
        $this->mes = $mes;
        $this->ano = $ano;
        $this->contratante = $contratante;
        $this->cliente = $cliente;
        $this->tipo_servicio = $tipo_servicio;
        $this->es_bisiesto = $es_bisiesto;
        $this->indicador = $indicador;
        $this->cuantos_tabla_inicial_parcial = $cuantos_tabla_inicial_parcial;
    }

    public function executeGettable(sfWebRequest $request) {

        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();
        //$this->greetings="Hello World, Symfony is Great :)";  
        //RS PARA CAMPOS DE BUSQUEDAS
        //$this->greetings="Hello World, Symfony is Great :)";  
        //RS PARA CAMPOS DE BUSQUEDAS
        $cliente = $this->getRequestParameter('cliente');
        $mes = $this->getRequestParameter('mes');
        $ano = $this->getRequestParameter('ano');
        $tipo_servicio = $this->getRequestParameter('tipo_servicio');
        $contratante = $this->getRequestParameter('contratante');
        $clientes_usu = $this->getUser()->getAttribute('clientes');
        //echo  $contratante;

        if (trim($ano) == '') {
            //$ano=date('Y');
            //echo "Mila".$ano;
            //$es_bisiesto=date('L',$ano);
        }

        if (trim($cliente) == '') {
            //$cliente=$clientes_usu;
            //$fecha_ini='01/01/'.$ano;
            //$fecha_fin='31/01/'.$ano;
            $mes = '0';
        }
        $es_bisiesto = date('L', $ano);
        switch ($mes) {
            case '0':
                $fecha_ini = '01-01-' . $ano;
                $fecha_fin = '31-12-' . $ano;
                //$fecha_ini='01-1-2011';
                //$fecha_fin='31-12-2011';
                $num_dia_mes = '365';
                /* if($es_bisiesto==0){

                  } */

                break;
            case '01':
                $fecha_ini = '01-01-' . $ano;
                $fecha_fin = '31-01-' . $ano;
                $num_dia_mes = '31';
                break;
            case '02':
                if (date('L', $ano) == 0) {
                    $fecha_ini = '01-02-' . $ano;
                    $fecha_fin = '29-02-' . $ano;
                    $num_dia_mes = '29';
                } else {
                    $fecha_ini = '01-02-' . $ano;
                    $fecha_fin = '28-02-' . $ano;
                    $num_dia_mes = '28';
                }
                break;
            case '03':
                $fecha_ini = '01-03-' . $ano;
                $fecha_fin = '31-03-' . $ano;
                $num_dia_mes = '31';
                break;
            case '04':
                $fecha_ini = '01-04-' . $ano;
                $fecha_fin = '30-04-' . $ano;
                $num_dia_mes = '30';
                break;
            case '05':
                $fecha_ini = '01-05-' . $ano;
                $fecha_fin = '31-05-' . $ano;
                $num_dia_mes = '31';
                break;
            case '06':
                $fecha_ini = '01-06-' . $ano;
                $fecha_fin = '30-06-' . $ano;
                $num_dia_mes = '30';
                break;
            case '07':
                $fecha_ini = '01-07-' . $ano;
                $fecha_fin = '31-07-' . $ano;
                $num_dia_mes = '31';
                break;
            case '08':
                $fecha_ini = '01-08-' . $ano;
                $fecha_fin = '31-08-' . $ano;
                $num_dia_mes = '31';
                break;
            case '09':
                $fecha_ini = '01-09-' . $ano;
                $fecha_fin = '30-09-' . $ano;
                $num_dia_mes = '30';
                break;
            case '10':
                $fecha_ini = '01-10-' . $ano;
                $fecha_fin = '31-10-' . $ano;
                $num_dia_mes = '31';
                break;
            case '11':
                $fecha_ini = '01-11-' . $ano;
                $fecha_fin = '30-11-' . $ano;
                $num_dia_mes = '30';
                break;
            case '12':
                $fecha_ini = '01-12-' . $ano;
                $fecha_fin = '31-12-' . $ano;
                $num_dia_mes = '31';
                break;
        }

        /* CAMBIAR POR UN SLECT CORRIDO */

        $query = "SELECT CODCTROCOS, DESCTROCOS  FROM CMB_CONTRATANTE_MVW ORDER BY DESCTROCOS ASC";

        $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt2 = $pdo2->prepare($query);
        $stmt2->execute();
        $this->CMB_CONTRATANTE_MVW333 = $stmt2->fetchAll();

        $q55 = Doctrine_Query::create()
                ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
                ->groupBy("to_char(fecocurr, 'yyyy')");

        $this->CMB_ANNO_GENERAL = $q55->fetchArray();


        $q = Doctrine_Query::create()
                ->from('CMB_CLIENTE_MVW  J')
                ->where("idepol IN ($clientes_usu)");
        $this->CMB_CLIENTE_MVW = $q->fetchArray();

        $q = Doctrine_Query::create()
                ->from('CMB_CONTRATANTE_MVW  J')
                ->where('idepol = ?', $cliente);

        $this->CMB_CONTRATANTE_MVW = $q->fetchArray();



        $q1 = " SELECT INITCAP(enfermedad) as enfermedad,  sum(indemnizado) as total, count(enfermedad) AS cantidad, INITCAP(tipo_des) as tipo_des
              FROM SINIESTRALIDAD_VW   J
              WHERE  to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' ";

        if ($tipo_servicio != 'todos' or trim($tipo_servicio) != '') {
            $q1.=" and codexterno='$contratante'";
        }

        if ($tipo_servicio != 'todos' or trim($tipo_servicio) != '') {
            $q1.=" and cod_tipo_des='$tipo_servicio'";
        }

        $q1.="  group by enfermedad, id, tipo_des ";
        $q1.="  order by enfermedad asc ";

        $pdo_pr = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt_pr = $pdo_pr->prepare($q1);
        $stmt_pr->execute();
        $this->SINIESTRALIDAD_VW_tabla_inicial = $stmt_pr->fetchAll();
        $this->cuantos_tabla_inicial = $stmt_pr->rowCount();


        // PARA LOS ATENDIDOS

        $q_atend = " SELECT ci_paciente 
                   FROM SINIESTRALIDAD_VW  J 
                   WHERE to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'";

        if ($tipo_servicio != 'todos' or trim($tipo_servicio) != '') {
            $q_atend.=" and codexterno='$contratante'";
        }

        if ($tipo_servicio != 'todos' or trim($tipo_servicio) != '') {
            $q_atend.=" and cod_tipo_des='$tipo_servicio'";
        }

        $q_atend.="GROUP BY (ci_paciente,id)";

        $pdo_atend = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt_atend = $pdo_atend->prepare($q_atend);
        $stmt_atend->execute();
        $rs_atendidas = $stmt_atend->fetchAll();
        $this->total_per_atendidas = $stmt_atend->rowCount();

        // Número totla de patologia ver si 2 casos son de una misma persona               
        $q_patologia = "SELECT enfermedad
                  FROM SINIESTRALIDAD_VW   J
                  WHERE to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' ";
        if ($tipo_servicio != 'todos' or trim($tipo_servicio) != '') {
            $q_patologia.=" and codexterno='$contratante'";
        }

        if ($tipo_servicio != 'todos' or trim($tipo_servicio) != '') {
            $q_patologia.=" and cod_tipo_des='$tipo_servicio'";
        }

        $q_patologia.=" GROUP BY (enfermedad,id)";

        $pdo_patologia = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt_patologia = $pdo_patologia->prepare($q_patologia);
        $stmt_patologia->execute();
        $rs_atendidas = $stmt_patologia->fetchAll();
        $this->num_patologias = $stmt_patologia->rowCount();


       

        $q = Doctrine_Query::create()                
                ->select('DISTINCT cod_tipo_des, tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->orderby('tipo_des asc');


        $this->SINIESTRALIDAD_VW_combo_servicios = $q->fetchArray();

        $q = Doctrine_Query::create()
                ->select('DISTINCT cod_ben_pago, ben_pago')
                ->from('SINIESTRALIDAD_VW   J')
                ->orderby('ben_pago asc');


        $this->SINIESTRALIDAD_VW_cant_prov = $q->fetchArray();

        $this->cantidad_prov = $q->count();

        $q = Doctrine_Query::create()
                ->select("to_char(fecocurr, 'yyyy') as ano")
                ->from("SINIESTRALIDAD_VW   J")
                ->groupBy("to_char(fecocurr, 'yyyy')");
        $this->SINIESTRALIDAD_VW_combo_ano = $q->fetchArray();

        $this->totalcantidad = 0;
        $this->totalmonto = 0;
        $this->total_promedio_casos = 0;
        $this->monto_total = 0;
        $this->totalMasculino = 0;
        $this->totalFemenino = 0;
        $this->totalGrupo = 0;
        $this->fecha_inicial = $fecha_ini;
        $this->fecha_final = $fecha_fin;
        $this->dias_mes = $num_dia_mes;
        $this->mes = $mes;
        $this->ano = $ano;
        $this->contratante = $contratante;
        $this->cliente = $cliente;
        $this->tipo_servicio = $tipo_servicio;
        $this->es_bisiesto = $es_bisiesto;
        $this->cuantos_tabla_inicial = $cuantos_tabla_inicial;
    }

    public function executeSubmit(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod('post'));

        $params = array(
            'cliente' => $request->getParameter('cliente')
        );

        $this->redirect('sinielistadprovee/index?' . http_build_query($params));
    }

}
