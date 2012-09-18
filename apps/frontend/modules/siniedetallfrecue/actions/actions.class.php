<?php

/**
 * siniedetallfrecue actions.
 *
 * @package    aulavirtual
 * @subpackage siniedetallfrecue
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class siniedetallfrecueActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
   public function executeIndex(sfWebRequest $request)
  {
    //$this->forward('default', 'module');
  //$this->greetings="Hello World, Symfony is Great :)";  
    //RS PARA CAMPOS DE BUSQUEDAS
        
        //ENTE CONTRATANTE - CLIETE
        $q = Doctrine_Query::create()
                ->from('ente_contratante_vw  J');
                //->where("idepol='293421'");
        $this->ente_contratante_vw  = $q->fetchArray();
        
        //CONTRATANTE - POLIZA
        $q = Doctrine_Query::create()
                ->from('CONTRATO_POLIZA_VW  J');
        $this->CONTRATO_POLIZA_VW  = $q->fetchArray();
        
        //FALTA FECHA
        
        //POBLACION MUESTRADE LISTADO TABLAS
               /* $q = Doctrine_Query::create()
                ->from('POBLACION_CONSOLIDADA_COMP_VW  J');
        
        $this->POBLACION_CONSOLIDADA_VW  = $q->fetchArray();*/
       // $this->monto_total = 0;
        
       // $this->totalMasculino = 0;
       // $this->totalFemenino = 0;
      //  $this->totalGrupo = 0;

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
  $this->redirect('siniereclamtiposervic/index?'.http_build_query($params));
}
}
