<?php

/**
 * siniedetalle actions.
 *
 * @package    autoservicio
 * @subpackage siniedetalle
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class siniedetalleActions extends sfActions
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
       $ci_paciente = $this->getRequestParameter('ci_paciente');
       $rif = $this->getRequestParameter('rif');
       $enfermedad = $this->getRequestParameter('enfermedad');
       $clase_lis=$this->getRequestParameter('clase_lis');
       $tipo_lis = $this->getRequestParameter('tipo_lis');
       $indicador = $this->getRequestParameter('indicador');
       $st  = $this->getRequestParameter('st');
       $pagina_ubi  = $this->getRequestParameter('pagina_ubi');
       //$indicador  = $this->getRequestParameter('indicador');
        
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
        //$cliente='293371';
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
       
        
        
        $query = " SELECT COD_BEN_PAGO, INITCAP(BEN_PAGO) as BEN_PAGO, INITCAP(CONTRATANTE) as CONTRATANTE, CI_PACIENTE, PACIENTE, INITCAP(TIPO_DES) as TIPO_DES,INITCAP(PARENTESCO) as PARENTESCO, 
            CI_TITULAR,INITCAP(TITULAR) as TITULAR, RIF, FECOCURR, INDEMNIZADO,  INITCAP(ENFERMEDAD) AS ENFERMEDAD,
            INITCAP(TRATAMIENTO) AS TRATAMIENTO, FACTURADO, INITCAP(COBER_SIN) AS TIPO_PLAN,FECNOTIF 
           FROM SINIESTRALIDAD_VW   J ";
        $query.="where idepol='".$cliente."' ";
       
      // if(($mes!='' and $mes!='todos') or($ano!='' and $ano!='todos') ){
           $query.=" and to_date( to_char(fecocurr, 'dd/mm/yyyy'),'DD/MM/YYYY')>=to_date('$fecha_ini','DD/MM/YYYY')  
           and to_date( to_char(fecocurr, 'dd/mm/yyyy'), 'DD/MM/YYYY')<=to_date('$fecha_fin','DD/MM/YYYY')";
      
       //}
       
       if($contratante!='' and $contratante!='todos'){
           $query.=" and codexterno='$contratante' ";
      
       }
        if($tipo_servicio!='' and $tipo_servicio!='todos'){
           $query.=" and cod_tipo_des='$tipo_servicio' ";
      
       }
        if(trim($ci_paciente)!=''){
           $query.=" and ci_paciente='$ci_paciente' ";
      
       }
       if(trim($rif)!=''){
           $query.=" and rif='$rif' ";
      
       }
       
       if(trim($enfermedad)!=''){
           $query.=" and INITCAP(enfermedad)='$enfermedad' ";
      
       }
      //$query.=" ORDER BY  fecocurr as, cod_tipo_des asc";
       
   //echo $query;
     $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
     $stmt = $pdo->prepare($query);
     $stmt->execute();
     $this->SINIESTRALIDAD_VW_tabla_inicial= $stmt->fetchAll();
     $this->cuantos_tabla_inicial =$stmt->rowCount();
     
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
$this->pagina_ubi=$pagina_ubi;
$this->clase_lis=$clase_lis;
$this->indicador=$indicador;
//$this->cuantos_tabla_inicial=$cuantos_tabla_inicial;
$this->st=$st;
$this->pp=$pp;
     
 
  }
}
