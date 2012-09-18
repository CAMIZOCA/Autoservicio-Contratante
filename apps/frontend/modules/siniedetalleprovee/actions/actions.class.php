<?php

/**
 * detalleprovee actions.
 *
 * @package    aulavirtual
 * @subpackage detalleprovee
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class detalleproveeActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
     //$this->greetings="Hello World, Symfony is Great :)";  
    //RS PARA CAMPOS DE BUSQUEDAS
        
  //$this->greetings="Hello World, Symfony is Great :)";  
    //RS PARA CAMPOS DE BUSQUEDAS
       $cliente     = $this->getRequestParameter('cliente');
       $mes    = $this->getRequestParameter('mes');
       $ano    = $this->getRequestParameter('ano');
       $tipo_servicio  = $this->getRequestParameter('tipo_servicio');
       $contratante  = $this->getRequestParameter('contratante');
       //echo  $contratante;
       
       if(trim($ano)==''){
           $ano=date('Y');
           
           //echo "Mila".$ano;
           //$es_bisiesto=date('L',$ano);
           
       }
       
     if(trim($cliente)==''){
        $cliente='293371';
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
                ->from('ente_contratante_vw  J');
                //->where("idepol='$cliente'");
        $this->ente_contratante_vw  = $q->fetchArray();
        
        //CONTRATANTE - POLIZA(CONTRATO)
    
        $q = Doctrine_Query::create()
                ->select(" codctrocos, desctrocos")
                ->from('CONTRATO_POLIZA_VW  J')
                ->where("idepol='$cliente'");
        $this->CONTRATO_POLIZA_VW  = $q->fetchArray();
        
        
     //echo  $q;
        
       /* $q = Doctrine_Query::create()
                ->from('CONTRATO_POLIZA_VW  J')
                ->where("idepol='$cliente'");
        $this->CONTRATO_POLIZA_VW  = $q->fetchArray();*/
        
        if($tipo_servicio=='todos'or trim($tipo_servicio)=='' ){
          
           if(trim($contratante)=='' or trim($contratante)=='todos' ){
            $q1 = Doctrine_Query::create()
                ->select('cod_ben_pago, ben_pago, ci_paciente, paciente, tipo_des, parentesco, fecocurr, indemnizado')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'")
                 ->orderBy('ben_pago asc, fecocurr asc');    
             
               $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial=$q1->count();
             
                $q2 = Doctrine_Query::create()
                ->select('cod_ben_pago, ben_pago')
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
                ->select('cod_ben_pago, ben_pago, ci_paciente, paciente, tipo_des, parentesco, fecocurr, indemnizado')
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
                ->select('cod_ben_pago, ben_pago')
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
                    ->select('cod_ben_pago, ben_pago, ci_paciente, paciente, tipo_des, parentesco, fecocurr, indemnizado')
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
                ->select('cod_ben_pago, ben_pago')
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
                    ->select('cod_ben_pago, ben_pago, ci_paciente, paciente, tipo_des, parentesco, fecocurr, indemnizado')
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
                ->select('cod_ben_pago, ben_pago')
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




$this->monto_total = 0;        
$this->totalMasculino = 0;
$this->totalFemenino = 0;
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
$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;

  }
  
   public function gettable(sfWebRequest $request)
  {
     //$this->greetings="Hello World, Symfony is Great :)";  
    //RS PARA CAMPOS DE BUSQUEDAS
        
  //$this->greetings="Hello World, Symfony is Great :)";  
    //RS PARA CAMPOS DE BUSQUEDAS
       $cliente     = $this->getRequestParameter('cliente');
       $mes    = $this->getRequestParameter('mes');
       $ano    = $this->getRequestParameter('ano');
       $tipo_servicio  = $this->getRequestParameter('tipo_servicio');
       $contratante  = $this->getRequestParameter('contratante');
       //echo  $contratante;
       
       if(trim($ano)==''){
           $ano=date('Y');
           
           //echo "Mila".$ano;
           //$es_bisiesto=date('L',$ano);
           
       }
       
     if(trim($cliente)==''){
        $cliente='293371';
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
                ->from('ente_contratante_vw  J');
                //->where("idepol='$cliente'");
        $this->ente_contratante_vw  = $q->fetchArray();
        
        //CONTRATANTE - POLIZA(CONTRATO)
    
        $q = Doctrine_Query::create()
                ->select(" codctrocos, desctrocos")
                ->from('CONTRATO_POLIZA_VW  J')
                ->where("idepol='$cliente'");
        $this->CONTRATO_POLIZA_VW  = $q->fetchArray();
        
        
     //echo  $q;
        
       /* $q = Doctrine_Query::create()
                ->from('CONTRATO_POLIZA_VW  J')
                ->where("idepol='$cliente'");
        $this->CONTRATO_POLIZA_VW  = $q->fetchArray();*/
        
        if($tipo_servicio=='todos'or trim($tipo_servicio)=='' ){
          
           if(trim($contratante)=='' or trim($contratante)=='todos' ){
            $q1 = Doctrine_Query::create()
                ->select('cod_ben_pago, ben_pago, ci_paciente, paciente, tipo_des, parentesco, fecocurr, indemnizado')
                ->from('SINIESTRALIDAD_VW   J')
                ->where(" to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
                        and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')
                        and idepol='$cliente'")
                 ->orderBy('ben_pago asc, fecocurr asc');    
             
               $this->SINIESTRALIDAD_VW_tabla_inicial = $q1->fetchArray();
                $cuantos_tabla_inicial=$q1->count();
             
                $q2 = Doctrine_Query::create()
                ->select('cod_ben_pago, ben_pago')
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
                ->select('cod_ben_pago, ben_pago, ci_paciente, paciente, tipo_des, parentesco, fecocurr, indemnizado')
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
                ->select('cod_ben_pago, ben_pago')
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
                    ->select('cod_ben_pago, ben_pago, ci_paciente, paciente, tipo_des, parentesco, fecocurr, indemnizado')
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
                ->select('cod_ben_pago, ben_pago')
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
                    ->select('cod_ben_pago, ben_pago, ci_paciente, paciente, tipo_des, parentesco, fecocurr, indemnizado')
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
                ->select('cod_ben_pago, ben_pago')
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




$this->monto_total = 0;        
$this->totalMasculino = 0;
$this->totalFemenino = 0;
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
$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;
//$this->total_casos=$total_casos;
//$this->cantidad_prov=$cantidad_prov;
//$this->variableRecibe = $request->getParameter('cliente');
//$this->temp55 ='';
//$this->mes=$_POST['mes
//$this->form = new BaseForm();
  }
  
  public function executeSubmit(sfWebRequest $request)
{
  $this->forward404Unless($request->isMethod('post'));
 
  $params = array(
    'cliente'    => $request->getParameter('cliente')      
    
  );
 
  //echo "milaaaaaaaaaaaaaaaa";
  $this->redirect('detalleprovee/index?'.http_build_query($params));
}
}
