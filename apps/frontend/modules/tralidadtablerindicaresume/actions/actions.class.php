<?php

/**
 * tralidadtablerindicaresume actions.
 *
 * @package    aulavirtual
 * @subpackage tralidadtablerindicaresume
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tralidadtablerindicaresumeActions extends sfActions {

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
        if(!$cliente)
        $cliente = 0;
        
        $mes = $this->getRequestParameter('mes');
        $ano = $this->getRequestParameter('ano');
        $tipo_servicio = $this->getRequestParameter('tipo_servicio');
        $contratante = $this->getRequestParameter('contratante');
        $tipo_reporte = $this->getRequestParameter('tr');
        $indicador = $this->getRequestParameter('indicador');
        $clientes_usu = $this->getUser()->getAttribute('clientes');

        if (trim($contratante) == '') {
            $contratante = 'todos';
        }
        if (trim($ano) == '') {
            $ano = date('Y');
        }

        if (trim($cliente) == '') {
            $mes = '0';
        }
        $mes = '0';
        $es_bisiesto = date('L', $ano);
        switch ($mes) {
            case '0':
                $fecha_ini = '1-1-' . $ano;
                $fecha_fin = '31-12-' . $ano;
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
                
                $mes_num = '09';
                
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
            
            $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt2 = $pdo2->prepare($query);
            $stmt2->execute();
            $this->CMB_ANO_GENERAL = $stmt2->fetchAll();

            $query = "SELECT MES, MESPARAM FROM DISPONIBILIDAD_FONDO_VW J WHERE ANOPARAM='$ano' GROUP BY MES, MESPARAM ORDER BY MESPARAM ASC";
            $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt2 = $pdo2->prepare($query);
            $stmt2->execute();
            $this->CMB_MES_GENERAL = $stmt2->fetchAll();
        }





        if (trim($contratante) == '' or trim($contratante) == 'todos') {

            if (trim($mes_num) == 'todos' or trim($mes_num) == '') {


      $q1 = Doctrine_Query::create()
                        ->select('mesparam, anoparam,mes, 
                          count(mesparam) as casos,
                          SUM(aportes) AS aportes, 
                          SUM(cant_incurridos) AS cant_incurridos, 
                          SUM(costo_promedio) AS costo_promedio, 
                          SUM(disponible_fondo) AS disponible_fondo, 
                          SUM(incurrido_acum) AS incurrido_acum, 
                          SUM(incurrido_indemnizado) AS incurrido_indemnizado,
                          SUM(incurrido_pend_ant) AS incurrido_pend_ant,                       
                          SUM(incurrido_total) AS incurrido_total, 
                          SUM(saldo_anterior) AS saldo_anterior,
                          SUM(ahorro) AS ahorro,
                          SUM(monto_rendido) AS monto_rendido,
                          SUM(honorarios_hmo) AS honorarios_hmo,
                          SUM(incurrido_acum_teo) AS estimado_teorico'
                        )
                        ->from('DISPONIBILIDAD_FONDO_VW  J')
                        ->where(" anoparam='$ano' and  1=1 
                        and idepol='$cliente'")
                        ->groupBy('(mesparam,anoparam,mes,id)')
                        ->orderBy('mesparam');

                $this->FONDOS_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial = $q1->count();  
    


             
            } else {

             $q1 = Doctrine_Query::create()
                        ->select('mesparam, anoparam,mes,
                          count(mesparam) as casos,
                          SUM(aportes) AS aportes, 
                          SUM(cant_incurridos) AS cant_incurridos, 
                          SUM(costo_promedio) AS costo_promedio, 
                          SUM(disponible_fondo) AS disponible_fondo, 
                          SUM(incurrido_acum) AS incurrido_acum, 
                          SUM(incurrido_indemnizado) AS incurrido_indemnizado,
                          SUM(incurrido_pend_ant) AS incurrido_pend_ant,                       
                          SUM(incurrido_total) AS incurrido_total, 
                          SUM(saldo_anterior) AS saldo_anterior,
                          SUM(ahorro) AS ahorro,
                          SUM(monto_rendido) AS monto_rendido,
                          SUM(honorarios_hmo) AS honorarios_hmo,
                          SUM(incurrido_acum_teo) AS estimado_teorico')
                        ->from('DISPONIBILIDAD_FONDO_VW  J')
                        ->where(" anoparam='$ano' and 
                          mesparam='$mes_num'
                        and idepol='$cliente'")
                        ->groupBy('(mesparam,anoparam,mes,id)')
                        ->orderBy('mesparam');

                $this->FONDOS_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial = $q1->count();
            }
        } else {

            if (trim($mes_num) == 'todos' or trim($mes_num) == '') {


                    $q1 = Doctrine_Query::create()
                        ->select('mesparam, anoparam,mes,
                          count(mesparam) as casos,
                          SUM(aportes) AS aportes, 
                          SUM(cant_incurridos) AS cant_incurridos, 
                          SUM(costo_promedio) AS costo_promedio, 
                          SUM(disponible_fondo) AS disponible_fondo, 
                          SUM(incurrido_acum) AS incurrido_acum, 
                          SUM(incurrido_indemnizado) AS incurrido_indemnizado,
                          SUM(incurrido_pend_ant) AS incurrido_pend_ant,                       
                          SUM(incurrido_total) AS incurrido_total, 
                          SUM(saldo_anterior) AS saldo_anterior,
                          SUM(ahorro) AS ahorro,
                          SUM(monto_rendido) AS monto_rendido,
                          SUM(honorarios_hmo) AS honorarios_hmo,
                          SUM(incurrido_acum_teo) AS estimado_teorico')
                        ->from('DISPONIBILIDAD_FONDO_VW  J')
                        ->where(" anoparam='$ano'
                        and idepol='$cliente'
                        and cod_externo='$contratante'")
                        ->groupBy('(mesparam,anoparam,mes,id)')
                        ->orderBy('mesparam');

                $this->FONDOS_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial = $q1->count();
            } else {

                    $q1 = Doctrine_Query::create()
                        ->select('mesparam, anoparam,mes,
                          count(mesparam) as casos,
                          SUM(aportes) AS aportes, 
                          SUM(cant_incurridos) AS cant_incurridos, 
                          SUM(costo_promedio) AS costo_promedio, 
                          SUM(disponible_fondo) AS disponible_fondo, 
                          SUM(incurrido_acum) AS incurrido_acum, 
                          SUM(incurrido_indemnizado) AS incurrido_indemnizado,
                          SUM(incurrido_pend_ant) AS incurrido_pend_ant,                       
                          SUM(incurrido_total) AS incurrido_total, 
                          SUM(saldo_anterior) AS saldo_anterior,
                           SUM(ahorro) AS ahorro,
                          SUM(monto_rendido) AS monto_rendido,
                          SUM(honorarios_hmo) AS honorarios_hmo,
                          SUM(incurrido_acum_teo) AS estimado_teorico')
                        ->from('DISPONIBILIDAD_FONDO_VW  J')
                        ->where(" anoparam='$ano' and
                          mesparam='$mes_num'
                        and idepol='$cliente'
                        and cod_externo='$contratante'")
                        ->groupBy('(mesparam,anoparam,mes,id)')
                        ->orderBy('mesparam');

                $this->FONDOS_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial = $q1->count();
            }
        }

        

        if ($tipo_servicio == 'todos' or trim($tipo_servicio) == '') {

            if (trim($contratante) == '' or trim($contratante) == 'todos') {
                    $q1 = Doctrine_Query::create()
                        ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'")
                        // ->where("idepol='$cliente'")
                        ->groupBy('ben_pago, cod_ben_pago, id');

                $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                //$cuantos_tabla_inicial=$q1->count(); 
                $this->total_proveedores = $q1->count();


                // presonas atendidas a ver si 2 casos son de una misma persona

                    $q2 = Doctrine_Query::create()
                        ->select('ci_paciente')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'")
                        // ->where("idepol='$cliente'")
                        ->groupBy('(ci_paciente,id)');
                $q2->fetchArray();
                $this->total_per_atendidas = $q2->count();
                
            } else {

                    $q1 = Doctrine_Query::create()
                        ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' 
                        and codexterno='$contratante'")
                        // ->where("idepol='$cliente'")
                        ->groupBy('ben_pago, cod_ben_pago, id');
                //->orderBy('cod_tipo_des asc');

                $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                //$cuantos_tabla_inicial=$q1->count();              
                $this->total_proveedores = $q1->count();


                // presonas atendidas a ver si 2 casos son de una misma persona               
                $q2 = Doctrine_Query::create()
                        ->select('ci_paciente')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' 
                        and codexterno='$contratante'")
                        // ->where("idepol='$cliente'")
                        ->groupBy('(ci_paciente,id)');

                $q2->fetchArray();
                $this->total_per_atendidas = $q2->count();
            }
        } else {
            if (trim($contratante) == '' or trim($contratante) == 'todos') {
                    $q1 = Doctrine_Query::create()
                        ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'")
                        ->groupBy('ben_pago, cod_ben_pago, id');
                //->orderBy('cod_tipo_des asc');
                $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                
                //$cuantos_tabla_inicial=$q1->count();
                $this->total_proveedores = $q1->count();

                // presonas atendidas a ver si 2 casos son de una misma persona               
                $q2 = Doctrine_Query::create()
                        ->select('ci_paciente')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'")
                        ->groupBy('(ci_paciente,id)');

                $q2->fetchArray();
                $this->total_per_atendidas = $q2->count();
            } else {
                    $q1 = Doctrine_Query::create()
                        ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'
                            and codexterno='$contratante'")
                        ->groupBy('ben_pago, cod_ben_pago, id');
                //->orderBy('cod_tipo_des asc');
                $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                
                // $cuantos_tabla_inicial=$q1->count();                
                $this->total_proveedores = $q1->count();


                // presonas atendidas a ver si 2 casos son de una misma persona               
                    $q2 = Doctrine_Query::create()
                        ->select('ci_paciente, id')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'
                            and codexterno='$contratante'")
                        ->groupBy('(ci_paciente, id)');


                $q2->fetchArray();
                $this->total_per_atendidas = $q2->count();
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
