<?php

/**
 * tralidadservincucasos actions.
 *
 * @package    aulavirtual
 * @subpackage tralidadservincucasos
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tralidadservincucasosActions extends sfActions
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
       $cliente     = $this->getRequestParameter('cliente');
       $mes    = $this->getRequestParameter('mes');
       $ano    = $this->getRequestParameter('ano');
       $tipo_servicio  = $this->getRequestParameter('tipo_servicio');
       $contratante  = $this->getRequestParameter('contratante');
       $indicador  = $this->getRequestParameter('indicador');
       $clientes_usu = $this->getUser()->getAttribute('clientes');    
        $mes_num='';
       $num_dia_mes='';
       $fecha_ini='';
       $fecha_fin='';
       //echo  $contratante;
       if(trim($mes)==''){
           $mes='-1';
           
       }
       if(trim($ano)==''){
          // $ano=date('Y');
           //$es_bisiesto=date('L',$ano);
           
       }
     
       
     if(trim($cliente)==''){
       // $cliente=$clientes_usu;
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
            //echo $ano;
             if (((fmod($ano,4)==0) and (fmod($ano,100)!=0)) or (fmod($ano,400)==0)) {  
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
       
if(trim($indicador)==1){    
        if($tipo_servicio=='todos'or trim($tipo_servicio)=='' ){
          
           if(trim($contratante)=='' or trim($contratante)=='todos' ){
            $q1 = Doctrine_Query::create()
                ->select('cod_tipo_des, tipo_des, sum(indemnizado) as total, count(cod_tipo_des)  AS cantidad')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'")
               // ->where("idepol='$cliente'")
                ->groupBy('tipo_des, cod_tipo_des, id');
            //echo $q1 ;
                //->orderBy('cod_tipo_des asc');
               $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial=$q1->count();
               
               //echo $cuantos_tabla_inicial;
            }
            else{
             
                $q1 = Doctrine_Query::create()
                ->select('cod_tipo_des, tipo_des, sum(indemnizado) as total, count(cod_tipo_des)  AS cantidad')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente' 
                        and codexterno='$contratante'")
               // ->where("idepol='$cliente'")
                ->groupBy('tipo_des, cod_tipo_des, id');
                //->orderBy('cod_tipo_des asc');
               $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
               //echo $q1 ;
                $cuantos_tabla_inicial=$q1->count();
                              
            }
            
        }
        else {
             if(trim($contratante)=='' or trim($contratante)=='todos' ){
                $q1 = Doctrine_Query::create()
                    ->select('cod_tipo_des, tipo_des, sum(indemnizado) as total, count(cod_tipo_des)  AS cantidad')
                    ->from('SINIESTRALIDAD_VW   J')
                    ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'")                 
                    ->groupBy('tipo_des, cod_tipo_des, id');
                    //->orderBy('cod_tipo_des asc');
                 $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                  // echo $q1 ;
                    $cuantos_tabla_inicial=$q1->count();
             }
             else{
                $q1 = Doctrine_Query::create()
                    ->select('cod_tipo_des, tipo_des, sum(indemnizado) as total, count(cod_tipo_des)  AS cantidad')
                    ->from('SINIESTRALIDAD_VW   J')
                    ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                            and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                            and idepol='$cliente' 
                            and cod_tipo_des='$tipo_servicio'
                            and codexterno='$contratante'")                 
                    ->groupBy('tipo_des, cod_tipo_des, id');
                    //->orderBy('cod_tipo_des asc');
                 $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray(); 
                   //echo $q1 ;
                    $cuantos_tabla_inicial=$q1->count();
             }
                 
        }
     
     //   echo $q1;
}  
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
$this->indicador=$indicador;



  }
  
public function executeSubmit(sfWebRequest $request)
{
  $this->forward404Unless($request->isMethod('post'));
 
  $params = array(
    'cliente'    => $request->getParameter('cliente'),
    'tipo_servicio'  => $request->getParameter('tipo_servicio'),
    'contratante'  => $request->getParameter('contratante'),  
    'ano'  => $request->getParameter('ano'),
    'mes'  => $request->getParameter('mes')  
     
  );
 

  //echo "milaaaaaaaaaaaaaaaa";
  $this->redirect('siniereclamtiposervic/index?'.http_build_query($params));
}
}
