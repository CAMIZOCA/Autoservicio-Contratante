<?php

/**
 * tralidadincurrvspagado actions.
 *
 * @package    aulavirtual
 * @subpackage tralidadincurrvspagado
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tralidadincurrvspagadoActions extends sfActions {

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

        //$this->greetings="Hello World, Symfony is Great :)";  
        //RS PARA CAMPOS DE BUSQUEDAS
        $cliente = $this->getRequestParameter('cliente');
        $mes = $this->getRequestParameter('mes');
        $ano = $this->getRequestParameter('ano');
        $tipo_servicio = $this->getRequestParameter('tipo_servicio');
        $contratante = $this->getRequestParameter('contratante');
        $indicador = $this->getRequestParameter('indicador');
        $clientes_usu = $this->getUser()->getAttribute('clientes');
        $mes_num = '';
        $num_dia_mes = '';
        $fecha_ini = '';
        $fecha_fin = '';
        

        if (trim($ano) == '') {
            // $ano=date('Y');
            //$es_bisiesto=date('L',$ano);
        }
        if (trim($mes) == '') {
            $mes = '-1';
        }
        if (trim($cliente) == '') {
            //$cliente=$clientes_usu;
            //$fecha_ini='01/01/'.$ano;
            //$fecha_fin='31/01/'.$ano;
            //$mes='0';
        }
        // echo  $mes;
        $es_bisiesto = date('L', $ano);
        switch ($mes) {
            case '0':
                $fecha_ini = '1-1-' . $ano;
                $fecha_fin = '31-12-' . $ano;
                //$fecha_ini='01-1-2011';
                //$fecha_fin='31-12-2011';
                $num_dia_mes = '365';

                $mes_num = '';
                break;
            case '01':
                $fecha_ini = '1-1-' . $ano;
                $fecha_fin = '31-1-' . $ano;
                $num_dia_mes = '31';
                $mes_num = '01';
                break;
            case '02':
                //echo $ano;
                if (((fmod($ano, 4) == 0) and (fmod($ano, 100) != 0)) or (fmod($ano, 400) == 0)) {
                    $fecha_ini = '1-2-' . $ano;
                    $fecha_fin = '29-2-' . $ano;
                    $num_dia_mes = '29';
                    $mes_num = '02';
                } else {
                    $fecha_ini = '1-2-' . $ano;
                    $fecha_fin = '28-2-' . $ano;
                    $num_dia_mes = '28';
                    $mes_num = '02';
                }
                break;
            case '03':
                $fecha_ini = '1-3-' . $ano;
                $fecha_fin = '31-3-' . $ano;
                $num_dia_mes = '31';
                $mes_num = '03';
                break;
            case '04':
                $fecha_ini = '1-4-' . $ano;
                $fecha_fin = '30-4-' . $ano;
                $num_dia_mes = '30';
                $mes_num = '04';
                break;
            case '05':
                $fecha_ini = '1-5-' . $ano;
                $fecha_fin = '31-5-' . $ano;
                $num_dia_mes = '31';
                $mes_num = '05';
                break;
            case '06':
                $fecha_ini = '1-6-' . $ano;
                $fecha_fin = '30-6-' . $ano;
                $num_dia_mes = '30';
                $mes_num = '06';
                break;
            case '07':
                $fecha_ini = '1-7-' . $ano;
                $fecha_fin = '31-7-' . $ano;
                $num_dia_mes = '31';
                $mes_num = '07';
                break;
            case '08':
                $fecha_ini = '1-8-' . $ano;
                $fecha_fin = '31-8-' . $ano;
                $num_dia_mes = '31';
                $mes_num = '08';
                break;
            case '09':
                //echo "mila paso  ";
                $mes_num = '09';
                //echo $mes_num; 
                $fecha_ini = '1-9-' . $ano;
                $fecha_fin = '30-9-' . $ano;
                $num_dia_mes = '30';
                break;
            case '10':
                $fecha_ini = '1-10-' . $ano;
                $fecha_fin = '31-10-' . $ano;
                $num_dia_mes = '31';
                $mes_num = '10';
                break;
            case '11':
                $fecha_ini = '1-11-' . $ano;
                $fecha_fin = '30-11-' . $ano;
                $num_dia_mes = '30';
                $mes_num = '11';
                break;
            case '12':
                $fecha_ini = '1-12-' . $ano;
                $fecha_fin = '31-12-' . $ano;
                $mes_num = '12';
                $num_dia_mes = '31';
                break;
        }

        if (trim($indicador) != '1') {
            //ENTE CONTRATANTE - CLIENTE
            $q = Doctrine_Query::create()
                    ->from('CMB_CLIENTE_MVW  J')
                    ->where("idepol IN ($clientes_usu)");
            $this->CMB_CLIENTE_MVW = $q->fetchArray();


            $query = "SELECT ANOPARAM FROM DISPONIBILIDAD_FONDO_VW  J GROUP BY ANOPARAM ORDER BY ANOPARAM ASC";
            $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt2 = $pdo2->prepare($query);
            //echo $query;
            $stmt2->execute();
            $this->CMB_ANO_GENERAL = $stmt2->fetchAll();

            $query = "SELECT MES, MESPARAM FROM DISPONIBILIDAD_FONDO_VW J GROUP BY MES, MESPARAM ORDER BY MESPARAM ASC";
            $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt2 = $pdo2->prepare($query);
            $stmt2->execute();
            $this->CMB_MES_GENERAL = $stmt2->fetchAll();
        } else {
            //ENTE CONTRATANTE - CLIENTE
            $q = Doctrine_Query::create()
                    ->from('CMB_CLIENTE_MVW  J')
                    ->where("idepol IN ($clientes_usu)");
            $this->CMB_CLIENTE_MVW = $q->fetchArray();


            $query = "SELECT ANOPARAM FROM DISPONIBILIDAD_FONDO_VW J WHERE IDEPOL='$cliente' GROUP BY ANOPARAM ORDER BY ANOPARAM ASC";
            //echo $query;
            $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt2 = $pdo2->prepare($query);
            $stmt2->execute();
            $this->CMB_ANO_GENERAL = $stmt2->fetchAll();

            $query = "SELECT MES, MESPARAM FROM DISPONIBILIDAD_FONDO_VW J WHERE ANOPARAM='$ano' and (incurrido_pend_ant<>0 or incurrido_total<>0 or incurrido_indemnizado<>0) GROUP BY MES, MESPARAM ORDER BY MESPARAM ASC";
            $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt2 = $pdo2->prepare($query);
            $stmt2->execute();
            $this->CMB_MES_GENERAL = $stmt2->fetchAll();
        }


        if (trim($contratante) == '' or trim($contratante) == 'todos') {

            if (trim($mes_num) == 'todos' or trim($mes_num) == '') {


                $q1 = Doctrine_Query::create()
                        ->select('mesparam, anoparam,mes, 
                          SUM(aportes) AS aportes, 
                          SUM(cant_incurridos) AS cant_incurridos, 
                          SUM(costo_promedio) AS costo_promedio, 
                          SUM(disponible_fondo) AS disponible_fondo, 
                          SUM(incurrido_acum) AS incurrido_acum, 
                          SUM(incurrido_indemnizado) AS incurrido_indemnizado,
                          SUM(incurrido_pend_ant) AS incurrido_pend_ant,                       
                          SUM(incurrido_total) AS incurrido_total, 
                          SUM(saldo_anterior) AS saldo_anterior')
                        ->from('DISPONIBILIDAD_FONDO_VW  J')
                        ->where(" (anoparam='$ano'
                        and idepol='$cliente') and (incurrido_pend_ant<>0 or incurrido_total<>0 or incurrido_indemnizado<>0)")
                        ->groupBy('(mesparam,anoparam,mes,id)')
                        ->orderBy('mesparam');

                $this->FONDOS_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial = $q1->count();
            } else {

                $q1 = Doctrine_Query::create()
                        ->select('mesparam, anoparam,mes, 
                          SUM(aportes) AS aportes, 
                          SUM(cant_incurridos) AS cant_incurridos, 
                          SUM(costo_promedio) AS costo_promedio, 
                          SUM(disponible_fondo) AS disponible_fondo, 
                          SUM(incurrido_acum) AS incurrido_acum, 
                          SUM(incurrido_indemnizado) AS incurrido_indemnizado,
                          SUM(incurrido_pend_ant) AS incurrido_pend_ant,                       
                          SUM(incurrido_total) AS incurrido_total, 
                          SUM(saldo_anterior) AS saldo_anterior')
                        ->from('DISPONIBILIDAD_FONDO_VW  J')
                        ->where(" ( anoparam='$ano' and 
                          mesparam='$mes_num'
                        and idepol='$cliente') and (incurrido_pend_ant<>0 or incurrido_total<>0 or incurrido_indemnizado<>0)")
                        ->groupBy('(mesparam,anoparam,mes,id)')
                        ->orderBy('mesparam');

                $this->FONDOS_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial = $q1->count();
            }
        } else {

            if (trim($mes_num) == 'todos' or trim($mes_num) == '') {


                $q1 = Doctrine_Query::create()
                        ->select('mesparam, anoparam,mes,  
                          SUM(aportes) AS aportes, 
                          SUM(cant_incurridos) AS cant_incurridos, 
                          SUM(costo_promedio) AS costo_promedio, 
                          SUM(disponible_fondo) AS disponible_fondo, 
                          SUM(incurrido_acum) AS incurrido_acum, 
                          SUM(incurrido_indemnizado) AS incurrido_indemnizado,
                          SUM(incurrido_pend_ant) AS incurrido_pend_ant,                       
                          SUM(incurrido_total) AS incurrido_total, 
                          SUM(saldo_anterior) AS saldo_anterior')
                        ->from('DISPONIBILIDAD_FONDO_VW  J')
                        ->where(" ( anoparam='$ano'
                        and idepol='$cliente'
                        and cod_externo='$contratante'")
                        ->groupBy('(mesparam,anoparam,mes,id)) and (incurrido_pend_ant<>0 or incurrido_total<>0 or incurrido_indemnizado<>0)')
                        ->orderBy('mesparam');

                $this->FONDOS_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial = $q1->count();
            } else {

                $q1 = Doctrine_Query::create()
                        ->select('mesparam, anoparam,mes,  
                          SUM(aportes) AS aportes, 
                          SUM(cant_incurridos) AS cant_incurridos, 
                          SUM(costo_promedio) AS costo_promedio, 
                          SUM(disponible_fondo) AS disponible_fondo, 
                          SUM(incurrido_acum) AS incurrido_acum, 
                          SUM(incurrido_indemnizado) AS incurrido_indemnizado,
                          SUM(incurrido_pend_ant) AS incurrido_pend_ant,                       
                          SUM(incurrido_total) AS incurrido_total, 
                          SUM(saldo_anterior) AS saldo_anterior')
                        ->from('DISPONIBILIDAD_FONDO_VW  J')
                        ->where("( anoparam='$ano' and 
                          mesparam='$mes_num'
                        and idepol='$cliente'
                        and cod_externo='$contratante') and (incurrido_pend_ant<>0 or incurrido_total<>0 or incurrido_indemnizado<>0)")
                        ->groupBy('(mesparam,anoparam,mes,id)')
                        ->orderBy('mesparam');

                $this->FONDOS_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial = $q1->count();
            }
        }


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
        $this->indicador = $indicador;
        $this->cuantos_tabla_inicial = $cuantos_tabla_inicial;

    }

    public function executeSubmit(sfWebRequest $request) {
        $this->forward404Unless($request->isMethod('post'));

        $params = array(
            'cliente' => $request->getParameter('cliente'),
            'tipo_servicio' => $request->getParameter('tipo_servicio'),
            'contratante' => $request->getParameter('contratante'),
            'ano' => $request->getParameter('ano'),
            'mes' => $request->getParameter('mes')
        );
        
        $this->redirect('siniereclamtiposervic/index?' . http_build_query($params));
    }

}
