<?php

/**
 * poblaevoluc actions.
 *
 * @package    autoservicio
 * @subpackage poblaevoluc
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class poblaevolucActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //$this->forward('default', 'module');
              $this->UserName = $this->getUser()->getGuardUser()->getUsername();
      $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
      $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
      $this->LastName = $this->getUser()->getGuardUser()->getLastName();
      $this->LastName = $this->getUser()->getGuardUser()->getLastName();
      $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();
 /*
         * FIN GUARDAR VARIABLE DE SESSION
         */
        ///Captura de Valores de Formulario        
        $var_idcliente = $request->getGetParameter('idcliente');
        $var_idcontratante = $request->getGetParameter('idcontratante');
        $var_idanno = $request->getGetParameter('idanno');
        $var_idmes = $request->getGetParameter('idmes');
        $var_idestatus = $request->getGetParameter('idestatus');
        //$this->forward('default', 'module');

        //Valores para llenar formularios al retornar
        $this->var_idcliente = $var_idcliente;
        $this->var_idcontratante = $var_idcontratante;
        $this->var_idanno = $var_idanno;
        $this->var_idmes = $var_idmes;
        $this->var_idestatus = $var_idestatus;
        $this->var_cero = '-1';
    }

    public function executeGetcliente(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //ENTE CONTRATANTE - CLIETE
        $q = Doctrine_Query::create()
                ->from('ente_contratante_vw  J');
        $this->ente_contratante_vw = $q->fetchArray();
    }
    public function executeGetcontratante(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //CONTRATANTE - POLIZA
        $varTmp = $this->getRequestParameter('id');
        
        $q = Doctrine_Query::create()
                ->from('CONTRATO_POLIZA_VW  J')
                ->where('id_ente_contratante = ?', $varTmp);
        
        $this->CONTRATO_POLIZA_VW = $q->fetchArray();
    }


    public function executeGettable(sfWebRequest $request) {


        $var_idcliente = $request->getPostParameter('idcliente');
        $var_idcontratante = $request->getPostParameter('idcontratante');
        $var_idanno = $request->getPostParameter('idanno');
        $var_idmes = $request->getPostParameter('idmes');
        $var_idestatus = $request->getPostParameter('idestatus');
        
        
        
/*
 * creacion del where
 */
        if ($var_idestatus != 'EXC'){
            $var_ttFecha = 'FECING';
        } else {
            $var_ttFecha = 'FECEXC';
        }
        
        
            
            
        
        $where = "WHERE  idepol = $var_idcliente ";
        if ($var_idcontratante != '0'):
            $where .= " AND    centro_costo = '$var_idcontratante'";
        endif;
        if ($var_idanno != '0'):
        $where .= " AND    TO_CHAR ($var_ttFecha, 'YYYY') =  $var_idanno  ";
        endif;
        
        $where .= " AND    STSASEG = '$var_idestatus' ";
        $whereTemp = " AND SEXO_PARENTESCO IN ('M','F')";
/*
 * creacion del query
 */

//echo $where;
        
       //print_r($_POST) ;
   $query = "SELECT 
 0 ID, 
 SUM (TOTAL_TITULAR) TOTAL_T, 
 SUM (TOTAL_BENEFICIARIO) TOTAL_B,
 SUM (TOTAL_ASEGURADO) TOTAL_A, 
 IDMES,
 MES, 
 ANNO,
 (SELECT COUNT (PARENTESCO_GENERAL) TOTAL FROM POBLACION_MVW 
                   $where $whereTemp  ) TOTAL_GENERAL
     FROM ( 
         SELECT 
         DECODE (parentesco_general, 'TITULAR', COUNT (PARENTESCO_GENERAL), 0) TOTAL_TITULAR, 
         DECODE (parentesco_general, 'BENEFICARIO', COUNT (PARENTESCO_GENERAL), 0) TOTAL_BENEFICIARIO, 
         COUNT (PARENTESCO_GENERAL) TOTAL_ASEGURADO, 
         TO_CHAR ($var_ttFecha, 'MM') IDMES,       
         TO_CHAR ($var_ttFecha, 'Month') MES, 
         TO_CHAR ($var_ttFecha, 'YYYY') ANNO
         FROM POBLACION_MVW 
                   $where $whereTemp 
         GROUP BY parentesco_general, 
         TO_CHAR ($var_ttFecha, 'MM'),
         TO_CHAR ($var_ttFecha, 'Month'), 
         TO_CHAR ($var_ttFecha, 'YYYY')) 
 GROUP BY
 IDMES,
 MES, 
 ANNO
 ORDER BY
 ANNO";
   //echo $query;
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();   
        $this->POBLACION_EVOLUCION_VW = $stmt->fetchAll();
//        $q = Doctrine_Query::create()
//                ->select('ID, MESNUM, MES, ANNO')
//                ->addSelect('SUM(TOTAL_T) as total_t')
//                ->addSelect('SUM(TOTAL_B) as total_b')
//                ->addSelect('SUM(TOTAL_A) as total_a')
//                ->from('POBLACION_EVOLUCION_MVW  J')
//                ->where('IDEPOL =?',$varidcliente )
//                ->andWhere('CENTRO_COSTO = ?',$varidcontratante)
//                ->andWhere('ANNO = ?',$varidanno)
//                ->andWhere('STSASEG = ?',$varidestatus)
//                //->where('id_ente_contratante = ?', $varTmp)
//                ->groupBy('ID, MESNUM, MES, ANNO')
//                ;
//        
//        $this->POBLACION_EVOLUCION_VW = $q->fetchArray();
        $this->sum_t = 0;
        $this->sum_b = 0;
        $this->sum_a = 0;
        $this->sum_prom = 0;
 
        
    }
    
    
    
    
}
