<?php error_reporting(E_ALL & ~E_NOTICE); 
/**
 * tralidadtipossinie actions.
 *
 * @package    aulavirtual
 * @subpackage tralidadtipossinie
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class tralidadtipossinieActions extends sfActions
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
       $tipo_prov  = $this->getRequestParameter('tipo_prov');
       $localidad  = $this->getRequestParameter('localidad');
       $contratante  = $this->getRequestParameter('contratante');
       $indicador  = $this->getRequestParameter('indicador');
       $clientes_usu = $this->getUser()->getAttribute('clientes');
       $indicador  = $this->getRequestParameter('indicador');
       //echo  $contratante;
       
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
      
     // echo "tipo pro".$tipo_prov;
       if(trim($tipo_prov)==''){
         //$tipo_prov='-1';
       
           
       }
       if(trim($localidad)==''){
         // $localidad  ='-1';
       
           
       }
       if(trim($mes)==''){
        $mes='-1';
       
           
       }
       if(trim($ano)==''){
          // $ano=date('Y');
           
           //echo "Mila".$ano;
           //$es_bisiesto=date('L',$ano);
           
       }
       if(trim($ano)==''){
         
           //echo "Mila".$ano;
            // $ano=date('Y');
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
        
        
   /// LOCALIDAD     
     
       $q_localidad = "SELECT CIUDAD, ID FROM SINIESTRALIDAD_VW WHERE CIUDAD<>' ' ";
        if(trim($cliente)!=''){
          $q_localidad.=" and IDEPOL='$cliente' ";  
        }  
         if(trim($contratante)!=''and trim($contratante)!='todos'){
            $q_localidad.=" AND CODEXTERNO ='$contratante' ";   
           }
        $q_localidad.=" GROUP BY CIUDAD,ID ";   
        $q_localidad.=" ORDER BY CIUDAD ASC";
        
        
        $pdo4 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt4 = $pdo4->prepare($q_localidad);
        $stmt4->execute();
        $this->CMB_CIUDAD = $stmt4->fetchAll();
          
        
        
   /// SINIESTRALIDAD CONSOLIDADO
        
        $q_consolidado = "SELECT DISTINCT TIPOPROV FROM SINIESTRALIDAD_VW WHERE TIPOPROV<>' '";
        if(trim($cliente)!=''){
          $q_consolidado.=" and IDEPOL='$cliente' ";  
        }  
         if(trim($contratante)!=''and trim($contratante)!='todos'){
            $q_consolidado.=" AND CODEXTERNO ='$contratante' ";   
           }
           
          if(trim($localidad)!='' and trim($localidad)!='todos' and trim($localidad)!='-1' ){
            $q_consolidado.=" AND CIUDAD='$localidad' ";   
           }  
           
        $q_consolidado.=" ORDER BY TIPOPROV ASC";
        
        $pdo3 = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt3 = $pdo3->prepare($q_consolidado);
        $stmt3->execute();
        $this->CMB_TIPOPROV = $stmt3->fetchAll();
        //echo $q_consolidado;
      
        
// COMBO AÑO GENERAL 
         $q223 ="SELECT to_char(fecocurr, 'yyyy') as anno FROM SINIESTRALIDAD_VW  J 
                    WHERE 1=1 ";           
           if(trim($cliente)!=''){
            $q223.=" AND IDEPOL ='$cliente' ";   
           }
           if(trim($contratante)!='' and trim($contratante)!='todos'){
            $q223.=" AND CODEXTERNO ='$contratante' ";   
           }
           if(trim($localidad)!=''and trim($localidad)!='todos' and trim($localidad)!='-1') {
            $q223.=" AND CIUDAD='$localidad' ";   
           }  
            if(trim($tipo_prov)!=''and trim($tipo_prov)!='todos' and trim($tipo_prov)!='-1'){
            $q223.=" AND TIPOPROV='$tipo_prov' ";   
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
           if(trim($localidad)!=''and trim($localidad)!='todos' and trim($localidad)!='-1'){
            $q_mes.=" AND CIUDAD='$localidad' ";   
           }  
           
           if(trim($tipo_prov)!=''and trim($tipo_prov)!='todos'and trim($tipo_prov)!='-1'){
            $q_mes.=" AND TIPOPROV='$tipo_prov' ";   
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
       
  
       
    
if(trim($cliente)!=''){        
        if($tipo_prov=='todos'or trim($tipo_prov)=='' ){
          
           if(trim($contratante)=='' or trim($contratante)=='todos' ){
            if(trim($localidad)=='' or trim($localidad)=='todos' ){   
                    $q1 = Doctrine_Query::create()
                        ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad) as localidad ')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                and idepol='$cliente'")
                       // ->where("idepol='$cliente'")
                        ->groupBy('ben_pago, cod_ben_pago, ciudad, id');


                   
                    }
                  else{
                           $q1 = Doctrine_Query::create()
                        ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad) as localidad')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                and idepol='$cliente'
                                and ciudad='$localidad'")
                       // ->where("idepol='$cliente'")
                        ->groupBy('ben_pago, cod_ben_pago, ciudad, id');

                 
                  }
                  }  
                else{
            if(trim($localidad)=='' or trim($localidad)=='todos' ){   
                    $q1 = Doctrine_Query::create()
                        ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad) as localidad')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                and idepol='".$cliente."'
                                and codexterno='".$contratante."'")
                       // ->where("idepol='$cliente'")
                        ->groupBy('ben_pago, cod_ben_pago, id');


                   
                    }
                  else{
                           $q1 = Doctrine_Query::create()
                        ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad)as localidad')
                        ->from('SINIESTRALIDAD_VW   J')
                        ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                and idepol='".$cliente."'
                                and ciudad='".$localidad."'
                                and codexterno='".$contratante."'")
                       // ->where("idepol='$cliente'")
                        ->groupBy('ben_pago, cod_ben_pago, ciudad, id');

                        
                  }
                  }  
                  
                    
                }
            else{
            if(trim($contratante)=='' or trim($contratante)=='todos' ){
                    if(trim($localidad)=='' or trim($localidad)=='todos' ){  
                                $q1 = Doctrine_Query::create()
                                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad)as localidad')
                                ->from('SINIESTRALIDAD_VW   J')
                                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                        and idepol='".$cliente."' 
                                        and tipoprov='".$tipo_prov."'")
                               // ->where("idepol='$cliente'")
                                ->groupBy('ben_pago, cod_ben_pago, ciudad, id');
                                //->orderBy('cod_tipo_des asc');
                                //echo $q1;
                 
                        }

                        else{
                            $q1 = Doctrine_Query::create()
                                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad) as localidad')
                                ->from('SINIESTRALIDAD_VW   J')
                                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                        and idepol='".$cliente."' 
                                        and ciudad='".$localidad."'
                                        and tipoprov='".$tipo_prov."'
                                         ")
                               // ->where("idepol='$cliente'")
                                ->groupBy('ben_pago, cod_ben_pago, ciudad, id');
                                //->orderBy('cod_tipo_des asc');
                             
                        }
              }
              else{
              
                if(trim($localidad)=='' or trim($localidad)=='todos' ){  
                                $q1 = Doctrine_Query::create()
                                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad)as localidad')
                                ->from('SINIESTRALIDAD_VW   J')
                                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                        and idepol='".$cliente."' 
                                        and tipoprov='".$tipo_prov."'
                                        and codexterno='".$contratante."'")
                                // ->where("idepol='$cliente'")
                                ->groupBy('ben_pago, cod_ben_pago, ciudad, id');
                                //->orderBy('cod_tipo_des asc');

                           //    $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();              
                             
                        }

                        else{
                            $q1 = Doctrine_Query::create()
                                ->select('cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad) as localidad')
                                ->from('SINIESTRALIDAD_VW   J')
                                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                                        and idepol='".$cliente."' 
                                        and ciudad='".$localidad."'
                                        and tipoprov='".$tipo_prov."'
                                        and codexterno='".$contratante."'")
                               // ->where("idepol='$cliente'")
                                ->groupBy('ben_pago, cod_ben_pago, ciudad, id');
                                //->orderBy('cod_tipo_des asc');
                         
                             
                        }

               
            }
            
        }
     //  echo $q1;
      //$this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
      //$cuantos_tabla_inicial=$q1->count(); 
      // $this->total_proveedores = $q1->count();
       
       
       
        $q223 ="SELECT cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad)as localidad
        FROM SINIESTRALIDAD_VW J WHERE  1=1 and 
      to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('".$fecha_ini."','DD/MM/YYYY') 
        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('".$fecha_fin."','DD/MM/YYYY') 
        and idepol='".$cliente."' ";
       if(trim($contratante)!='' and trim($contratante)!='todos' ){
           $q223.=" and codexterno='".$contratante."'";
       }
        if(trim($localidad)!='' and trim($localidad)!='todos' ){ 
            $q223.=" and ciudad='".$localidad."'";
        }  
        
         if(trim($tipo_prov)!='' and trim($tipo_prov)!='todos' ){ 
            $q223.=" and tipoprov='".$tipo_prov."'";
        } 
       $q223.=" GROUP BY ben_pago, cod_ben_pago, ciudad, id";   
      
         $pdo_tabla = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
           $stmt_tabla = $pdo_tabla->prepare($q223);
           $stmt_tabla->execute();
           $this->SINIESTRALIDAD_VW_tabla_inicial2 = $stmt_tabla->fetchAll();
           $cuantos_tabla_inicial=$stmt_tabla->rowCount();
           $this->total_proveedores=$stmt_tabla->rowCount();
       // echo  $q223;   
           
           
            $q223 ="select * from (SELECT  ROWNUM as num ,A.*  from ( SELECT cod_ben_pago, INITCAP(ben_pago) as ben_pago , sum(indemnizado) as total, count(cod_ben_pago)  AS cantidad, INITCAP(ciudad)as localidad
        FROM SINIESTRALIDAD_VW J WHERE  1=1 and 
      to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('".$fecha_ini."','DD/MM/YYYY') 
        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('".$fecha_fin."','DD/MM/YYYY') 
        and idepol='".$cliente."' ";
       if(trim($contratante)!='' and trim($contratante)!='todos' ){
           $q223.=" and codexterno='".$contratante."'";
       }
        if(trim($localidad)!='' and trim($localidad)!='todos' ){ 
            $q223.=" and ciudad='".$localidad."'";
        }  
        
         if(trim($tipo_prov)!='' and trim($tipo_prov)!='todos' ){ 
            $q223.=" and tipoprov='".$tipo_prov."'";
        } 
       $q223.=" GROUP BY ben_pago, cod_ben_pago, ciudad, id ) A ) where num<=$fin_pp and num>$st";   
      
         $pdo_tabla = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
           $stmt_tabla = $pdo_tabla->prepare($q223);
           $stmt_tabla->execute();
           $this->SINIESTRALIDAD_VW_tabla_inicial = $stmt_tabla->fetchAll();
           //$cuantos_tabla_inicial=$stmt_tabla->rowCount();
           //$this->total_proveedores=$stmt_tabla->rowCount();
         
}
     
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
                ->select('DISTINCT tipoprov')
                ->from('SINIESTRALIDAD_VW   J') 
                ->where("tipoprov<>' '") 
                ->orderby('tipoprov asc');
      
        $this->SINIESTRALIDAD_VW_combo_tipo_prov= $q->fetchArray();
        
        $q = Doctrine_Query::create() 
                /*->select('tipo_des')
                ->from('SINIESTRALIDAD_VW   J')
                ->groupBy('tipo_des, id');*/
                ->select('ciudad,id')
                ->from('SINIESTRALIDAD_VW   J') 
                 ->where("ciudad<>' '")
                ->groupby('ciudad, id')               
                ->orderby('ciudad asc');
        
               
        $this->SINIESTRALIDAD_VW_combo_localidad= $q->fetchArray();
        
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
$this->tipo_prov=$tipo_prov;
//$this->tipo_servicio=$tipo_servicio;
$this->localidad=$localidad;
$this->es_bisiesto=$es_bisiesto;
$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;
$this->indicador=$indicador;

//echo "Localidad".$localidad;

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
