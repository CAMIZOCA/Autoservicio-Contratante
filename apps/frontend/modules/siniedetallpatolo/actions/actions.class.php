<?php

/**
 * siniedetallpatolo actions.
 *
 * @package    aulavirtual
 * @subpackage siniedetallpatolo
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class siniedetallpatoloActions extends sfActions
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
       $ano    = $this->getRequestParameter('ano');
       $tipo_servicio  = $this->getRequestParameter('tipo_servicio');
       $contratante  = $this->getRequestParameter('contratante');
       $enfermedad = $this->getRequestParameter('enfermedad');
       $tipo_lis = $this->getRequestParameter('tipo_lis');
       $indicador  = $this->getRequestParameter('indicador');
       $clientes_usu = $this->getUser()->getAttribute('clientes');
       $bus = $this->getUser()->getAttribute('bus');
       $st  = $this->getRequestParameter('st');
       //$clientes_usu = $this->getUser()->getAttribute('clientes');
       
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
           //$ano=date('Y');
           
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
       
        
   $query = " SELECT INITCAP(ENFERMEDAD) as ENFERMEDAD , CI_PACIENTE, INITCAP(PACIENTE) as PACIENTE, INITCAP(PARENTESCO) as PARENTESCO, FECOCURR, INDEMNIZADO, INITCAP(TIPO_DES) as TIPO_DES
           FROM SINIESTRALIDAD_VW   J ";
        $query.="where idepol='".$cliente."' ";
       
       
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       
       
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
        if(trim($enfermedad)!=''){
           $query.=" and INITCAP(enfermedad)='$enfermedad' ";
      
       }
       
      $query.=" ORDER BY fecocurr asc, enfermedad asc";
       
      //echo $query;
      
     $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt = $pdo->prepare($query);
     $stmt->execute();
     $this->SINIESTRALIDAD_VW_tabla_inicial= $stmt->fetchAll();
     $cuantos_tabla_inicial=$stmt->rowCount();
     //echo $cuantos_tabla_inicial;
     
      $query = " select * from (SELECT  ROWNUM as num ,A.*  from (SELECT INITCAP(ENFERMEDAD) as ENFERMEDAD , CI_PACIENTE, INITCAP(PACIENTE) as PACIENTE, INITCAP(PARENTESCO) as PARENTESCO, FECOCURR, INDEMNIZADO, INITCAP(TIPO_DES) as TIPO_DES
           FROM SINIESTRALIDAD_VW   J ";
        $query.="where idepol='".$cliente."' ";
       
       
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       
       
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
        if(trim($enfermedad)!=''){
           $query.=" and INITCAP(enfermedad)='$enfermedad' ";
      
       }
       
      $query.=" ORDER BY fecocurr asc, enfermedad asc) A ) where num<=$fin_pp and num>$st";
       
      //echo $query;
      
     $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt = $pdo->prepare($query);
     $stmt->execute();
     $this->SINIESTRALIDAD_VW_tabla_parcial= $stmt->fetchAll();
     $cuantos_tabla_parcial=$stmt->rowCount();
     
     
        
     $query_atend="SELECT CI_PACIENTE, ENFERMEDAD FROM SINIESTRALIDAD_VW   J WHERE 
                        idepol='$cliente'";
       
       if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query_atend.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       }
       if($contratante!='' and $contratante!='todos'){
           $query_atend.=" and codexterno='$contratante' ";
      
       }
       if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query_atend.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
       if(trim($enfermedad)!=''){
           $query_atend.=" and INITCAP(enfermedad)='$enfermedad' ";
      
       }
       
     
     $query_atend.=" GROUP BY (enfermedad,ci_paciente,id)";
     
    //echo $query_atend;
     
             
     $pdo_aten= Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt_aten = $pdo_aten->prepare($query_atend);
     $stmt_aten->execute();
     $stmt_aten->fetchAll();
     $this->total_per_atendidas = $stmt_aten->rowCount();
     
     
     $query_enfer="SELECT enfermedad FROM SINIESTRALIDAD_VW   J WHERE 
                        idepol='$cliente'";
       
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query_enfer.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       //}
       if($contratante!='' and $contratante!='todos'){
           $query_enfer.=" and codexterno='$contratante' ";
      
       }
       if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query_enfer.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
       if(trim($enfermedad)!=''){
           $query_enfer.=" and INITCAP(enfermedad)='$enfermedad' ";
      
       }
       
     
     //$query_enfer.=" GROUP BY (enfermedad,id)";
     
     //echo $query_enfer;
     
             
     $pdo_enfer= Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt_enfer= $pdo_enfer->prepare($query_enfer);
     $stmt_enfer->execute();
     $stmt_enfer->fetchAll();
     $this->num_patologias = $stmt_enfer->rowCount();
     
     
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
 


$this->fecha_inicial=$fecha_ini;
$this->fecha_final=$fecha_fin;
$this->dias_mes=$num_dia_mes;
$this->mes=$mes;
$this->ano=$ano;
$this->contratante=$contratante;
$this->cliente=$cliente;
$this->tipo_servicio=$tipo_servicio;
$this->es_bisiesto=$es_bisiesto;
$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;
$this->tipo_listado=$tipo_lis;
$this->indicador=$indicador;
$this->bus=$bus;

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
       $enfermedad = $this->getRequestParameter('enfermedad');
       $tipo_lis = $this->getRequestParameter('tipo_lis');
      
       $clientes_usu = $this->getUser()->getAttribute('clientes');
       $bus = $this->getUser()->getAttribute('bus');
       
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
        
        
   $query = " SELECT INITCAP(ENFERMEDAD) as ENFERMEDAD , CI_PACIENTE, INITCAP(PACIENTE) as PACIENTE, INITCAP(PARENTESCO) as PARENTESCO, FECOCURR, INDEMNIZADO, INITCAP(TIPO_DES) as TIPO_DES
           FROM SINIESTRALIDAD_VW   J ";
        $query.="where idepol='".$cliente."' ";
       
       
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       
       
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
        if(trim($enfermedad)!=''){
           $query.=" and INITCAP(enfermedad)='$enfermedad' ";
      
       }
       
      $query.=" ORDER BY fecocurr asc, enfermedad asc";
       
      //echo $query;
      
     $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt = $pdo->prepare($query);
     $stmt->execute();
     $this->SINIESTRALIDAD_VW_tabla_inicial= $stmt->fetchAll();
     $cuantos_tabla_inicial=$stmt->rowCount();
     
     
        
     $query_atend="SELECT CI_PACIENTE, ENFERMEDAD FROM SINIESTRALIDAD_VW   J WHERE 
                        idepol='$cliente'";
       
       if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query_atend.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       }
       if($contratante!='' and $contratante!='todos'){
           $query_atend.=" and codexterno='$contratante' ";
      
       }
       if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query_atend.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
       if(trim($enfermedad)!=''){
           $query_atend.=" and INITCAP(enfermedad)='$enfermedad' ";
      
       }
       
     
     $query_atend.=" GROUP BY (enfermedad,ci_paciente,id)";
     
    //echo $query_atend;
     
             
     $pdo_aten= Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt_aten = $pdo_aten->prepare($query_atend);
     $stmt_aten->execute();
     $stmt_aten->fetchAll();
     $this->total_per_atendidas = $stmt_aten->rowCount();
     
     
     $query_enfer="SELECT enfermedad FROM SINIESTRALIDAD_VW   J WHERE 
                        idepol='$cliente'";
       
       //if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query_enfer.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       //}
       if($contratante!='' and $contratante!='todos'){
           $query_enfer.=" and codexterno='$contratante' ";
      
       }
       if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query_enfer.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
       
       if(trim($enfermedad)!=''){
           $query_enfer.=" and INITCAP(enfermedad)='$enfermedad' ";
      
       }
       
     
     //$query_enfer.=" GROUP BY (enfermedad,id)";
     
     //echo $query_enfer;
     
             
     $pdo_enfer= Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt_enfer= $pdo_enfer->prepare($query_enfer);
     $stmt_enfer->execute();
     $stmt_enfer->fetchAll();
     $this->num_patologias = $stmt_enfer->rowCount();
     
     //echo $num_patologias;
 
     
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
       
        
     




$this->fecha_inicial=$fecha_ini;
$this->fecha_final=$fecha_fin;
$this->dias_mes=$num_dia_mes;
$this->mes=$mes;
$this->ano=$ano;
$this->contratante=$contratante;
$this->cliente=$cliente;
$this->tipo_servicio=$tipo_servicio;
$this->es_bisiesto=$es_bisiesto;
$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;
$this->tipo_lis=$tipo_lis;
$this->bus=$bus;

  }
  
  public function executeSubmit(sfWebRequest $request)
{
  $this->forward404Unless($request->isMethod('post'));
 
  $params = array(
    'cliente'    => $request->getParameter('cliente')      
    
  );
 
  //echo "milaaaaaaaaaaaaaaaa";
  $this->redirect('sinielistadprovee/index?'.http_build_query($params));
}
}
