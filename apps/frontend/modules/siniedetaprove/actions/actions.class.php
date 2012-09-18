<?php

/**
 * siniedetaprove actions.
 *
 * @package    autoservicio
 * @subpackage siniedetaprove
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class siniedetaproveActions extends sfActions
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
      
     //$this->greetings="Hello World, Symfony is Great :)";  
    //RS PARA CAMPOS DE BUSQUEDAS
        
  //$this->greetings="Hello World, Symfony is Great :)";  
    //RS PARA CAMPOS DE BUSQUEDAS
       $cliente     = $this->getRequestParameter('cliente');
       $mes    = $this->getRequestParameter('mes');
       //echo "mes MIla".$mes."<br />";
       $ano    = $this->getRequestParameter('ano');
       $tipo_servicio  = $this->getRequestParameter('tipo_servicio');
       $contratante  = $this->getRequestParameter('contratante');
       $rif = $this->getRequestParameter('rif');
       $tipo_listado = $this->getRequestParameter('tipo_lis');
       $indicador  = $this->getRequestParameter('indicador');
       $st  = $this->getRequestParameter('st');
       $clientes_usu = $this->getUser()->getAttribute('clientes');
       $pagina_ubi = $this->getRequestParameter('pagina_ubi');
       //echo "pag ubi".$pagina_ubi;
        //Paginador
        if ($request->getGetParameter('pagina') == ''):
            $val_pagina_ini = 0;
        else:
            $st = $_GET['pagina'] . 0;
        endif;
        $pp = $val_pagina_ini + 10;


      
       if($st==''){
	 $st = 0;
	 }
	$pp=10;
     $fin_pp=$st + $pp;
      
     
     if(trim($mes)==''){
          $mes='-1';
       }
       
       
       
         
	
       //echo  $contratante;
       
       if(trim($ano)==''){
           $ano='-1';
           
           //echo "Mila".$ano;
           //$es_bisiesto=date('L',$ano);
           
       }
       
     if(trim($cliente)==''){
        //$cliente=$clientes_usu;
        //$fecha_ini='01/01/'.$ano;
        //$fecha_fin='31/01/'.$ano;
        //$mes='0';
        
     }
       $es_bisiesto=date('L',$ano); 
      switch ($mes) {
        case '0':
           $fecha_ini='1-1-'.$ano;
           $fecha_fin='31-12-'.$ano;
            //$fecha_ini='01-1-2011';
            //$fecha_fin='31-12-2011';
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
       
     // COMBO CLIENTE
      $q = Doctrine_Query::create()
            ->from('CMB_CLIENTE_MVW  J')
            ->where("idepol IN ($clientes_usu)"); 
        $this->CMB_CLIENTE_MVW = $q->fetchArray(); 
        
    
        // COMBO CONTRATANTES
        $query = "SELECT CODCTROCOS, DESCTROCOS  FROM CMB_CONTRATANTE_MVW  WHERE 1=1 ";
        if(trim($cliente)!=''){
          $query.=" and IDEPOL='$cliente'";  
        }     
        $query.="ORDER BY DESCTROCOS ASC";
        $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt2 = $pdo2->prepare($query);
        $stmt2->execute();
        $this->CMB_CONTRATANTE_MVW333 = $stmt2->fetchAll();
        
        
         $q = "SELECT CODCTROCOS, DESCTROCOS  FROM CMB_CONTRATANTE_MVW WHERE 1=1 ";
        if(trim($cliente)!=''){
          $q.=" and IDEPOL='$cliente' ";  
        }     
        $q.=" ORDER BY DESCTROCOS ASC";
        $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt2 = $pdo2->prepare($q);
        $stmt2->execute();
        $this->CMB_CONTRATANTE_MVW = $stmt2->fetchAll();
        
        
    // Combo servicio
      
         $q22 ="SELECT COD_TIPO_DES, TIPO_DES, ID FROM SINIESTRALIDAD_VW  J 
                  WHERE 1=1 ";           
           if(trim($cliente)!=''){
            $q22.=" AND IDEPOL ='$cliente' ";   
           }
           if(trim($contratante)!=''and trim($contratante)!='todos'){
            $q22.=" AND CODEXTERNO ='$contratante' ";   
           }           
           $q22.=" GROUP BY ( COD_TIPO_DES, TIPO_DES, ID) ";
           $q22.=" ORDER BY   TIPO_DES ASC";
           
           $pdo_ser = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
           $stmt_ser = $pdo_ser->prepare($q22);
           $stmt_ser->execute();
           $this->CMB_SERVICIO= $stmt_ser->fetchAll();
          
 // COMBO AÑO GENERAL 
         $q223 ="SELECT to_char(fecocurr, 'yyyy') as anno FROM SINIESTRALIDAD_VW  J 
                    WHERE 1=1 ";           
           if(trim($cliente)!=''){
            $q223.=" AND IDEPOL ='$cliente' ";   
           }
           if(trim($contratante)!='' and trim($contratante)!='todos'){
            $q223.=" AND CODEXTERNO ='$contratante' ";   
           }
           if(trim($tipo_servicio)!=''and trim($tipo_servicio)!='todos'){
            $q223.=" AND COD_TIPO_DES ='$tipo_servicio' ";   
           }
           $q223.=" GROUP BY to_char(fecocurr, 'yyyy')";
          
         //echo $q223;
           
           $pdo_ano = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
           $stmt_ano = $pdo_ano->prepare($q223);
           $stmt_ano->execute();
           $this->CMB_ANNO_GENERAL3= $stmt_ano->fetchAll();
          
        
 // COMBO MES 
           $q_mes ="SELECT to_char(FECOCURR,'mm') as mes, to_char(FECOCURR,'yyyy') as anno
                  FROM SINIESTRALIDAD_VW  J WHERE 1=1 ";           
           if(trim($cliente)!=''){
            $q_mes.=" AND IDEPOL ='$cliente' ";   
           }
           if(trim($contratante)!='' and trim($contratante)!='todos'){
            $q_mes.=" AND CODEXTERNO ='$contratante' ";   
           }
           if(trim($tipo_servicio)!='' and trim($tipo_servicio)!='todos'){
            $q_mes.=" AND COD_TIPO_DES ='$tipo_servicio' ";   
           }
           
           if(trim($ano)!='' and trim($ano)!='-1'){
            $q_mes.=" and to_char(fecocurr,'yyyy') ='$ano' ";   
           }
           
           $q_mes.=" GROUP BY to_char(fecocurr,'mm'),to_char(fecocurr,'yyyy')";
           $q_mes.=" order by to_char(FECOCURR,'yyyy') asc, to_char(FECOCURR,'mm') asc";
           
          //echo $q_mes;
           
          $pdo_mes = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
           $stmt_mes = $pdo_mes->prepare($q_mes);
           $stmt_mes->execute();
           $this->CMB_MES= $stmt_mes->fetchAll(); 
       
        
        $query = " SELECT COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO, CI_PACIENTE, INITCAP(PACIENTE) as PACIENTE, INITCAP(TIPO_DES) as TIPO_DES, INITCAP(PARENTESCO) as PARENTESCO, RIF, FECOCURR, INDEMNIZADO
           FROM SINIESTRALIDAD_VW   J ";
        $query.="where idepol='".$cliente."' ";
       
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
      // }
       
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
        if(trim($rif)!=''){
           $query.=" and rif='$rif' ";
      
       }
       
      $query.=" ORDER BY ben_pago asc, fecocurr asc ";
       
     //echo $query;
     $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt = $pdo->prepare($query);
     $stmt->execute();
     $this->SINIESTRALIDAD_VW_tabla_inicial= $stmt->fetchAll();
     $this->cuantos_tabla_inicial =$stmt->rowCount();
     
     
          $query = " select * from (SELECT  ROWNUM as num ,A.*  from (SELECT COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO, CI_PACIENTE, INITCAP(PACIENTE) as PACIENTE, INITCAP(TIPO_DES) as TIPO_DES, INITCAP(PARENTESCO) as PARENTESCO, RIF, FECOCURR, INDEMNIZADO
           FROM SINIESTRALIDAD_VW   J ";
        $query.="where idepol='".$cliente."' ";
       
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
      // }
       
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
        if(trim($rif)!=''){
           $query.=" and rif='$rif' ";
      
       }
       
      $query.=" ORDER BY ben_pago asc, fecocurr asc ) A ) where num<=$fin_pp and num>$st";
       
    // echo $query;
     $pdo11 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt11 = $pdo11->prepare($query);
     $stmt11->execute();
     $this->SINIESTRALIDAD_VW_tabla_parcial= $stmt11->fetchAll();
     $this->cuantos_tabla_parcial =$stmt11->rowCount();
     
 $query_proveedores="SELECT COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO from SINIESTRALIDAD_VW J
                         where  idepol='$cliente' ";
     
         
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query_proveedores.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       //}
       if($contratante!='' and $contratante!='todos'){
           $query_proveedores.=" and codexterno='$contratante' ";
      
       }
       if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query_proveedores.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
         if(trim($rif)!=''){
           $query_proveedores.=" and rif='$rif' ";
      
       }
       
     
       $query_proveedores.=" GROUP BY ben_pago, cod_ben_pago, id ";
     // echo $query_proveedores;
       $pdo_prov = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
       $stmt_prov = $pdo_prov->prepare($query_proveedores);
       $stmt_prov->execute();
       $stmt_prov->fetchAll();
       $this->total_proveedores = $stmt_prov->rowCount();
       
       
       
     
     $query_atend="SELECT CI_PACIENTE FROM SINIESTRALIDAD_VW   J WHERE idepol='$cliente'";
       
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query_atend.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       //}
       if($contratante!='' and $contratante!='todos'){
           $query_atend.=" and codexterno='$contratante' ";
      
       }
       if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query_atend.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
       if(trim($rif)!=''){
           $query_atend.=" and rif='$rif' ";
      
       }
       
     
     $query_atend.=" GROUP BY (ci_paciente,id)";
     
     //echo $query_atend;
     
             
     $pdo_aten= Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt_aten = $pdo_aten->prepare($query_atend);
     $stmt_aten->execute();
     $stmt_aten->fetchAll();
     $this->total_per_atendidas = $stmt_aten->rowCount();
    // echo"atendidaas".$total_per_atendidas;

     
        $q = Doctrine_Query::create() 
                /*->select('tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->groupBy('tipo_des, id');*/
                ->select('DISTINCT cod_tipo_des, tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->orderby('tipo_des asc');
        
               
        $this->SINIESTRALIDAD_VW_combo_servicios = $q->fetchArray();
        
        $q = Doctrine_Query::create() 
                /*->select('tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->groupBy('tipo_des, id');*/
                ->select('DISTINCT cod_ben_pago, ben_pago')
                ->from('SINIESTRALIDAD_VW   J')
                ->orderby('ben_pago asc');
        
               
        $this->SINIESTRALIDAD_VW_cant_prov = $q->fetchArray();
        
        $this->cantidad_prov=$q->count();
        
         $q = Doctrine_Query::create() 
                
                ->select("to_char(fecocurr, 'yyyy') as ano")
                ->from("SINIESTRALIDAD_VW   J")
                ->groupBy("to_char(fecocurr, 'yyyy')");
         $this->SINIESTRALIDAD_VW_combo_ano = $q->fetchArray();
       
        //$this->$year_a=date('Y',time());
       

        //FALTA FECHA
        
        //POBLACION MUESTRADE LISTADO TABLAS
               /* $q = Doctrine_Query::create()
                ->from('POBLACION_CONSOLIDADA_COMP_VW  J');
        
        $this->POBLACION_CONSOLIDADA_VW  = $q->fetchArray();*/
        

//$this->dia_=0;





$this->fecha_inicial=$fecha_ini;
$this->fecha_final=$fecha_fin;
$this->dias_mes=$num_dia_mes;
$this->mes=$mes;
$this->ano=$ano;
$this->contratante=$contratante;
$this->cliente=$cliente;
$this->tipo_servicio=$tipo_servicio;
$this->es_bisiesto=$es_bisiesto;
$this->rif=$rif;
$this->tipo_listado=$tipo_listado;
$this->indicador=$indicador;
//$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;
$this->st=$st;
$this->pp=$pp;
$this->pagina_ubi=$pagina_ubi;
  }
   
  
  public function executeGettable(sfWebRequest $request)
  {
      
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
       $cliente     = $this->getRequestParameter('cliente');
       $mes    = $this->getRequestParameter('mes');
       $ano    = $this->getRequestParameter('ano');
       $tipo_servicio  = $this->getRequestParameter('tipo_servicio');
       $contratante  = $this->getRequestParameter('contratante');
       $rif = $this->getRequestParameter('rif');
       $tipo_lis = $this->getRequestParameter('tipo_lis');
       $st  = $this->getRequestParameter('st');
       $clientes_usu = $this->getUser()->getAttribute('clientes');
       
        if($st!=0) {
	   $st  =$st;
           $pp=$st +10;

	 } else {
	    $st = 0;
            $pp=10;

	 }
         
	
       //echo  $contratante;
       
       if(trim($ano)==''){
           $ano=date('Y');
           
           //echo "Mila".$ano;
           //$es_bisiesto=date('L',$ano);
           
       }
       
     if(trim($cliente)==''){
        //$cliente=$clientes_usu;
        //$fecha_ini='01/01/'.$ano;
        //$fecha_fin='31/01/'.$ano;
        $mes='0';
        
     }
       $es_bisiesto=date('L',$ano); 
      switch ($mes) {
        case '0':
           $fecha_ini='1-1-'.$ano;
           $fecha_fin='31-12-'.$ano;
            //$fecha_ini='01-1-2011';
            //$fecha_fin='31-12-2011';
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
       
        //ENTE CONTRATANTE - CLIETE
        $q = Doctrine_Query::create()
                ->from('CMB_CLIENTE_MVW  J')
                ->where("idepol IN ($clientes_usu)");
        $this->ente_contratante_vw  = $q->fetchArray();
        
        //CONTRATANTE - POLIZA(CONTRATO)
    
        $q = Doctrine_Query::create()
                ->select(" codctrocos, desctrocos")
                ->from('CMB_CONTRATANTE_MVW  J')
                ->where("idepol='$cliente'");
        $this->CONTRATO_POLIZA_VW  = $q->fetchArray();
        
          $query = "SELECT CODCTROCOS, DESCTROCOS  FROM CMB_CONTRATANTE_MVW ORDER BY DESCTROCOS ASC";
        
        $pdo2 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt2 = $pdo2->prepare($query);
        $stmt2->execute();
        $this->CMB_CONTRATANTE_MVW333 = $stmt2->fetchAll();
        
         $q55 = Doctrine_Query::create()                 
                 ->select("to_char(fecocurr, 'yyyy') as anno")
                ->from("SINIESTRALIDAD_VW   J")
                //->where($valorwhere2)      
                //->where("codexterno=", $varTmp)    
                ->groupBy("to_char(fecocurr, 'yyyy')");
             
           $this->CMB_ANNO_GENERAL = $q55->fetchArray();
        //ENTE CONTRATANTE - CLIETE
    
        $q = Doctrine_Query::create()
                ->from('CMB_CLIENTE_MVW  J')
                ->where("idepol IN ($clientes_usu)");
        $this->CMB_CLIENTE_MVW  = $q->fetchArray();
        
        //CONTRATANTE - POLIZA(CONTRATO)
    
        $q = Doctrine_Query::create()
                ->select(" codctrocos, desctrocos")
                ->from('CMB_CONTRATANTE_MVW  J')
                ->where("idepol='$cliente'");
        $this->CMB_CONTRATANTE_MVW  = $q->fetchArray();
        
        
        
        
        $query = " SELECT COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO, CI_PACIENTE, INITCAP(PACIENTE) as PACIENTE, INITCAP(TIPO_DES) as TIPO_DES, INITCAP(PARENTESCO) as PARENTESCO, RIF, FECOCURR, INDEMNIZADO
           FROM SINIESTRALIDAD_VW   J ";
        $query.="where idepol='".$cliente."' ";
       
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
      // }
       
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
        if(trim($rif)!=''){
           $query.=" and rif='$rif' ";
      
       }
       
      $query.=" ORDER BY ben_pago asc, fecocurr asc ";
       
     // echo $query;
     $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt = $pdo->prepare($query);
     $stmt->execute();
     $this->SINIESTRALIDAD_VW_tabla_inicial= $stmt->fetchAll();
     $this->cuantos_tabla_inicial =$stmt->rowCount();
     
     
 $query_proveedores="SELECT COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO from SINIESTRALIDAD_VW J
                         where  idepol='$cliente' ";
     
         
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query_proveedores.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       //}
       if($contratante!='' and $contratante!='todos'){
           $query_proveedores.=" and codexterno='$contratante' ";
      
       }
       if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query_proveedores.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
         if(trim($rif)!=''){
           $query_proveedores.=" and rif='$rif' ";
      
       }
       
     
       $query_proveedores.=" GROUP BY ben_pago, cod_ben_pago, id ";
     // echo $query_proveedores;
       $pdo_prov = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
       $stmt_prov = $pdo_prov->prepare($query_proveedores);
       $stmt_prov->execute();
       $stmt_prov->fetchAll();
       $this->total_proveedores = $stmt_prov->rowCount();
       
       
       
     
     $query_atend="SELECT CI_PACIENTE FROM SINIESTRALIDAD_VW   J WHERE idepol='$cliente'";
       
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query_atend.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       //}
       if($contratante!='' and $contratante!='todos'){
           $query_atend.=" and codexterno='$contratante' ";
      
       }
       if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query_atend.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
       if(trim($rif)!=''){
           $query_atend.=" and rif='$rif' ";
      
       }
       
     
     $query_atend.=" GROUP BY (ci_paciente,id)";
     
     //echo $query_atend;
     
             
     $pdo_aten= Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt_aten = $pdo_aten->prepare($query_atend);
     $stmt_aten->execute();
     $stmt_aten->fetchAll();
     $this->total_per_atendidas = $stmt_aten->rowCount();
    // echo"atendidaas".$total_per_atendidas;
   
        
      /*  if($tipo_servicio=='todos'or trim($tipo_servicio)=='' ){
          
           if(trim($contratante)=='' or trim($contratante)=='todos' ){
            $q1 = Doctrine_Query::create()
                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, INITCAP(tipo_des) as tipo_des, INITCAP(parentesco) as parentesco, fecocurr, indemnizado')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'")
                 ->orderBy('ben_pago asc, fecocurr asc');    
             
               $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial=$q1->count();
                
                
                
           $query=" SELECT cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, 
INITCAP(tipo_des) as tipo_des,
 INITCAP(parentesco) as parentesco, 
fecocurr, indemnizado
FROM
(
SELECT cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, 
INITCAP(tipo_des) as tipo_des,
 INITCAP(parentesco) as parentesco, 
fecocurr, indemnizado, ROWNUM r
FROM
(SELECT cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, 
INITCAP(tipo_des) as tipo_des,
 INITCAP(parentesco) as parentesco, 
fecocurr, indemnizado FROM SINIESTRALIDAD_VW J WHERE to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('1-1-2011','DD/MM/YYYY') 
and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('31-12-2011','DD/MM/YYYY') 
and idepol='293371' ORDER BY ben_pago asc, fecocurr asc ) 

where ROWNUM <= 5

)
WHERE r >= 2";
           $con = Doctrine_Manager::getInstance()->connection();
 
	//ejecutamos la consulta
	$stii = $con->execute($query);
	 
	//recuperamos las tuplas de resultados
	$this->SINIESTRALIDAD_VW_tabla_inicial2 = $stii->fetchAll();
       // echo $stii->rowCount();
       
        //$this->cuantos_mila = $stii->count();
      
               /*  $q1 = Doctrine_Query::create()
                ->select(" SELECT cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, 
INITCAP(tipo_des) as tipo_des,
 INITCAP(parentesco) as parentesco, 
fecocurr, indemnizado
FROM
(
SELECT cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, 
INITCAP(tipo_des) as tipo_des,
 INITCAP(parentesco) as parentesco, 
fecocurr, indemnizado, ROWNUM r
FROM
(SELECT cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, 
INITCAP(tipo_des) as tipo_des,
 INITCAP(parentesco) as parentesco, 
fecocurr, indemnizado FROM SINIESTRALIDAD_VW J WHERE to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('1-1-2011','DD/MM/YYYY') 
and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('31-12-2011','DD/MM/YYYY') 
and idepol='293371' ORDER BY ben_pago asc, fecocurr asc ) 

where ROWNUM <= 5

)
WHERE r >= 2");
 
                
                 $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                 echo $q1;*/
           
                 
            /*    $q2 = Doctrine_Query::create()
                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'")
                // ->orderBy('ben_pago asc, fecocurr asc')
                 ->groupBy('ben_pago, cod_ben_pago, id');
                $q2->fetchArray();
                $this->total_proveedores = $q2->count();
                
                
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
             
             
                
            }
            else{
             
                $q1 = Doctrine_Query::create()
                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, INITCAP(tipo_des) as tipo_des, INITCAP(parentesco) as parentesco, fecocurr, indemnizado')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' 
                        and codexterno='$contratante'")
                ->orderBy('ben_pago asc');
               // ->where("idepol='$cliente'")
                //->groupBy('ben_pago, cod_ben_pago, id');
                //->orderBy('cod_tipo_des asc');
               $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
               //echo $q1 ;
                $cuantos_tabla_inicial=$q1->count();
                
                $q2 = Doctrine_Query::create()
                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago')
                ->from('SINIESTRALIDAD_VW   J')
               ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' 
                        and codexterno='$contratante'")
                 ->groupBy('ben_pago, cod_ben_pago, id');
                $q2->fetchArray();
                $this->total_proveedores = $q2->count();
                
                
                // presonas atendidas a ver si 2 casos son de una misma persona                
                $q2 = Doctrine_Query::create()
                ->select('ci_paciente')
                ->from('SINIESTRALIDAD_VW   J')
                 ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' 
                        and codexterno='$contratante'")
                ->groupBy('(ci_paciente,id)');
                $q2->fetchArray();
                $this->total_per_atendidas = $q2->count();
            }
            
        }
        else {
             if(trim($contratante)=='' or trim($contratante)=='todos' ){
                $q1 = Doctrine_Query::create()
                    ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, INITCAP(tipo_des) as tipo_des, INITCAP(parentesco) as parentesco, fecocurr, indemnizado')
                    ->from('SINIESTRALIDAD_VW   J')
                    ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'") 
                       ->orderBy('ben_pago asc');
                    //->groupBy('ben_pago, cod_ben_pago, id');
                    //->orderBy('cod_tipo_des asc');
                 $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                  // echo $q1 ;
                    $cuantos_tabla_inicial=$q1->count();
                    
                    $q2 = Doctrine_Query::create()
                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'") 
                 ->groupBy('ben_pago, cod_ben_pago, id');
                $q2->fetchArray();
                $this->total_proveedores = $q2->count();
                
                
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
                    
             }
             else{
                $q1 = Doctrine_Query::create()
                    ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago, ci_paciente, paciente, INITCAP(tipo_des) as tipo_des, INITCAP(parentesco) as parentesco, fecocurr, indemnizado')
                    ->from('SINIESTRALIDAD_VW   J')
                    ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'
                            and codexterno='$contratante'")
                         ->orderBy('ben_pago asc');
                    //->groupBy('cod_ben_pago, ben_pago, id');
                    //->orderBy('cod_tipo_des asc');
                 $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray(); 
                   //echo $q1 ;
                    $cuantos_tabla_inicial=$q1->count();
                    //$total_casos= $q1->fetchOne('total_casos');
                    
                    $q2 = Doctrine_Query::create()
                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'
                            and codexterno='$contratante'")
                 ->groupBy('ben_pago, cod_ben_pago, id');
                $q2->fetchArray();
                $this->total_proveedores = $q2->count();
                
                
                $q2 = Doctrine_Query::create()
                ->select('ci_paciente')
                ->from('SINIESTRALIDAD_VW   J')
                 ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'
                            and codexterno='$contratante'")
                ->groupBy('(ci_paciente,id)');
                $q2->fetchArray();
                $this->total_per_atendidas = $q2->count();
                
                
             }
                 
        }*/
       
     
        $q = Doctrine_Query::create() 
                /*->select('tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->groupBy('tipo_des, id');*/
                ->select('DISTINCT cod_tipo_des, tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->orderby('tipo_des asc');
        
               
        $this->SINIESTRALIDAD_VW_combo_servicios = $q->fetchArray();
        
        $q = Doctrine_Query::create() 
                /*->select('tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->groupBy('tipo_des, id');*/
                ->select('DISTINCT cod_ben_pago, ben_pago')
                ->from('SINIESTRALIDAD_VW   J')
                ->orderby('ben_pago asc');
        
               
        $this->SINIESTRALIDAD_VW_cant_prov = $q->fetchArray();
        
        $this->cantidad_prov=$q->count();
        
         $q = Doctrine_Query::create() 
                
                ->select("to_char(fecocurr, 'yyyy') as ano")
                ->from("SINIESTRALIDAD_VW   J")
                ->groupBy("to_char(fecocurr, 'yyyy')");
         $this->SINIESTRALIDAD_VW_combo_ano = $q->fetchArray();
       
        //$this->$year_a=date('Y',time());
       
        
        $this->totalcantidad=0;
        $this->totalmonto=0;
        $this->total_promedio_casos=0;
        //FALTA FECHA
        
        //POBLACION MUESTRADE LISTADO TABLAS
               /* $q = Doctrine_Query::create()
                ->from('POBLACION_CONSOLIDADA_COMP_VW  J');
        
        $this->POBLACION_CONSOLIDADA_VW  = $q->fetchArray();*/
        

//$this->dia_=0;





$this->fecha_inicial=$fecha_ini;
$this->fecha_final=$fecha_fin;
$this->dias_mes=$num_dia_mes;
$this->mes=$mes;
$this->ano=$ano;
$this->contratante=$contratante;
$this->cliente=$cliente;
$this->tipo_servicio=$tipo_servicio;
$this->es_bisiesto=$es_bisiesto;
$this->rif=$rif;
$this->tipo_lis=$tipo_lis;
//$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;
$this->st=$st;
$this->pp=$pp;

  }
  
  public function executeSubmit(sfWebRequest $request)
{
  $this->forward404Unless($request->isMethod('post'));
 
  $params = array(
    'cliente'    => $request->getParameter('cliente')      
    
  );
 
  
  $this->redirect('detalleprovee/index?'.http_build_query($params));
}
}
