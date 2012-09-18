<?php

/**
 * siniedetageneral actions.
 *
 * @package    autoservicio
 * @subpackage siniedetageneral
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class siniedetageneralActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
     $this->UserName = $this->getUser()->getGuardUser()->getUsername();
      $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
      $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
      $this->LastName = $this->getUser()->getGuardUser()->getLastName();
      $this->LastName = $this->getUser()->getGuardUser()->getLastName();
      $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();
   
       $cliente     = $this->getRequestParameter('cliente');
       $mes= $this->getRequestParameter('mes');
      // echo "mes ".$mes;
       $ano    = $this->getRequestParameter('ano');
       $tipo_servicio  = $this->getRequestParameter('tipo_servicio');
       $contratante  = $this->getRequestParameter('contratante');
        $servi_general  = $this->getRequestParameter('servi_general');
       $tipo_lis = $this->getRequestParameter('tipo_lis');      
       $servicio = $this->getRequestParameter('servicio');
       $rif = $this->getRequestParameter('rif');
       $dias_habiles= $this->getRequestParameter('dias_habiles');
       $indicador  = $this->getRequestParameter('indicador');
       
       $st = $this->getRequestParameter('st');
      //echo "Página".$this->getRequestParameter('pagina');
       //Paginador
        if ($request->getGetParameter('pagina') == ''):
            $val_pagina_ini = 0;
        else:
            $st =$request->getGetParameter('pagina'). 0;
        endif;
        $pp = $val_pagina_ini + 10;

         if($st==''){
	 $st = 0;
	 }
	$pp=10;
     $fin_pp=$st + $pp;
       
      // echo  $servicio;
       
       if(trim($ano)==''){
           $ano=date('Y');
       }
       
         if(trim($cliente)==''){
            $cliente='293371';
            $mes='0';
         }
        $es_bisiesto=date('L',$ano); 
          switch ($mes) {
            case '0':
               $fecha_ini='1-1-'.$ano;
               $fecha_fin='31-12-'.$ano;           
                $num_dia_mes='365';
               /* if($es_bisiesto==0){

                }*/

                break;
            case '01':
                $fecha_ini='1-1-'.$ano;
               $fecha_fin='31-1-'.$ano;
               $num_dia_mes='31';
                break;
            case '02':
                if(date('L',$ano)==0){
                    $fecha_ini='1-2-'.$ano;
                    $fecha_fin='29-2-'.$ano;
                    $num_dia_mes='29';
                }
                else{
                    $fecha_ini='1-2-'.$ano;
                    $fecha_fin='28-2-'.$ano;
                    $num_dia_mes='28';
                }
                break;
            case '03':
                $fecha_ini='1-3-'.$ano;
                $fecha_fin='31-3-'.$ano;
                $num_dia_mes='31';
                break;
            case '04':
                $fecha_ini='1-4-'.$ano;
                $fecha_fin='30-4-'.$ano;
                $num_dia_mes='30';
                break;
            case '05':
                $fecha_ini='1-5-'.$ano;
                $fecha_fin='31-5-'.$ano;
                $num_dia_mes='31';
                break;
            case '06':
                $fecha_ini='1-6-'.$ano;
                $fecha_fin='30-6-'.$ano;
                $num_dia_mes='30';
                break;
            case '07':
                $fecha_ini='1-7-'.$ano;
                $fecha_fin='31-7-'.$ano;
                $num_dia_mes='31';
                break;
            case '08':
                $fecha_ini='1-8-'.$ano;
                $fecha_fin='31-8-'.$ano;
                $num_dia_mes='31';
                break;
            case '09':
                $fecha_ini='1-9-'.$ano;
                $fecha_fin='30-9-'.$ano;
                $num_dia_mes='30';
                break;
             case '10':
                $fecha_ini='1-10-'.$ano;
                $fecha_fin='31-10-'.$ano;
                $num_dia_mes='31';
                break;         
             case '11':
                $fecha_ini='1-11-'.$ano;
                $fecha_fin='30-11-'.$ano;
                $num_dia_mes='30';
                break;
            case '12':
                $fecha_ini='1-12-'.$ano;
                $fecha_fin='31-12-'.$ano;
                $num_dia_mes='31';
                break;
        }

        $query = "SELECT  FECOCURR, COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO,
           CI_PACIENTE, INITCAP(PACIENTE) as PACIENTE,INDEMNIZADO as TOTAL,COD_TIPO_DES,INITCAP(TIPO_DES) as TIPO_DES
           FROM SINIESTRALIDAD_VW   J ";
       $query.="where idepol='".$cliente."' ";
       
       if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       }
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
      $query.=" ORDER BY FECOCURR ASC";
      //echo $query;
       
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->SINIESTRALIDAD_VW_tabla_inicial= $stmt->fetchAll();
     $this->cuantos_tabla_inicial =$stmt->rowCount();
     
     

       $query = "select * from (SELECT  ROWNUM as num ,A.*  from (SELECT  FECOCURR, COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO,
           CI_PACIENTE, INITCAP(PACIENTE) as PACIENTE,INDEMNIZADO as TOTAL,COD_TIPO_DES,INITCAP(TIPO_DES) as TIPO_DES
           FROM SINIESTRALIDAD_VW   J ";
       $query.="where idepol='".$cliente."' ";
       
       if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       }
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
      $query.=" ORDER BY FECOCURR ASC) A ) where num<=$fin_pp and num>$st ";
     // echo $query;
       
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->tabla_detalle = $stmt->fetchAll();
     //$this->cuantos_tabla_inicial =$stmt->rowCount();
     //echo cuantos_tabla_inicial;
      //$this->cuantos_tabla_inicial =1;
        
        $q = Doctrine_Query::create()
                ->from('CMB_CLIENTE_MVW  J');
        $this->CMB_CLIENTE_MVW = $q->fetchArray();
        
         $q = Doctrine_Query::create()
                ->from('CMB_CONTRATANTE_MVW  J')
                 ->WHERE("idepol=$cliente");
        $this->CMB_CONTRATANTE_MVW = $q->fetchArray();

        
      
        $q55 = Doctrine_Query::create() 
                 ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
                //->where($valorwhere2)      
                //->where("codexterno=", $varTmp)    
                ->groupBy("to_char(fecocurr, 'yyyy')");
             
           $this->CMB_ANNO_GENERAL = $q55->fetchArray();

 $q = Doctrine_Query::create() 
                /*->select('tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->groupBy('tipo_des, id');*/
                ->select('DISTINCT cod_tipo_des, tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->orderby('tipo_des asc');
        
               
        $this->SINIESTRALIDAD_VW_combo_servicios = $q->fetchArray();
        
      
        
        $this->cantidad_prov=$q->count();
        
         $q = Doctrine_Query::create() 
                
                ->select("to_char(fecocurr, 'yyyy') as ano")
                ->from("SINIESTRALIDAD_VW   J")
                ->groupBy("to_char(fecocurr, 'yyyy')");
         $this->SINIESTRALIDAD_VW_combo_ano = $q->fetchArray();
        
$this->totalGrupo = 0;
$this->fecha_inicial=$fecha_ini;
$this->fecha_final=$fecha_fin;
$this->dias_mes=$num_dia_mes;
$this->mes=$mes;
$this->ano=$ano;
$this->contratante=$contratante;
$this->cliente=$cliente;
$this->tipo_servicio=$tipo_servicio;
$this->es_bisiesto=$es_bisiesto;
$this->servicio=$servicio;
$this->tipo_lis=$tipo_lis;
$this->servi_general=$servi_general;
$this->st=$st;
$this->pp=$pp;
//$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;
//$this->tabla_detalle=$tabla_detalle;

  }
}
