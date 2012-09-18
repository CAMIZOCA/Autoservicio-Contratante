<?php

/**
 * poblabusgen actions.
 *
 * @package    autoservicio
 * @subpackage poblabusgen
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class poblabusgenActions extends sfActions
{
 /**
  * Executes index action
  *
  * @param sfRequest $request A request object
  */
  public function executeIndex(sfWebRequest $request)
  {
  //  $this->forward('default', 'module');
  }
  
   public function executeGettable(sfWebRequest $request) {


///Captura de Valores de Formulario        

        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();


        /*
         * creacion del where
         */
//        $where = "WHERE  idepol = $var_idcliente ";
//        if ($var_idcontratante != '*'):
//            $where .= " AND    centro_costo = '$var_idcontratante'";
//        endif;
//        if ($var_idanno != '*'):
//            $where .= " AND    TO_CHAR (FECING, 'YYYY') =  $var_idanno  ";
//        endif;
//        if ($var_idmes != '*'):
//            $where .= " AND    TO_CHAR (FECING, 'MM') = $var_idmes ";
//        endif;
//
//        $where .= " AND    STSASEG = '$var_idestatus' ";

        /*
         * creacion del query
         */


echo        $query = "SELECT CEDULA, NOMBRE, SEXO, EDAD, PARENTESCO, FECNAC, DESCTROCOS, FECING, (sysdate-FECING)+1 INCLUSION
FROM POBLACION_MVW
WHERE ROWNUM < 10
";

        /*
         * ORDER BY
         */
//        $var_orderby = $request->getPostParameter('orderby');
//        if ($var_orderby != ''):
//            $query = $query . " ORDER BY " . $var_orderby;
//
//        else:
//            $query = $query . " ORDER BY CODPARENT_CROSS";
//        endif;

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->POBLACION_BUSQUEDA_GENER = $stmt->fetchAll();

        
    }

    public function executeGetcliente(sfWebRequest $request) {
        $cliente = $this->getUser()->getAttribute('clientes');
        //RS PARA CAMPOS DE BUSQUEDAS
        //ENTE CONTRATANTE - CLIETE
        $q = Doctrine_Query::create()
                ->from('CMB_CLIENTE_MVW  J')
                ->where("IDEPOL IN ($cliente)");
        $this->CMB_CLIENTE_MVW = $q->fetchArray();
    }

    public function executeGetcontratante(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //CONTRATANTE - POLIZA
        $varTmp = $this->getRequestParameter('id');

        $q = Doctrine_Query::create()
                ->from('CMB_CONTRATANTE_MVW  J')
                ->where('idepol = ?', $varTmp);

        $this->CMB_CONTRATANTE_MVW = $q->fetchArray();
    }

    public function executeGetanno(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //anno
        $varTmp = $this->getRequestParameter('contratante');

        //Valido si selecciona la opcion de todos
        if ($varTmp == '*'):
            $q = Doctrine_Query::create()
                    ->select('id, anno')
                    ->from('CMB_ANNO_MVW  J')
                    ->groupBy('id, anno');
        else:
            $q = Doctrine_Query::create()
                    ->select('id, anno, centro_costo')
                    ->from('CMB_ANNO_MVW  J')
                    ->where('centro_costo = ?', $varTmp)
                    ->groupBy('id, anno, centro_costo');
        endif;

        $this->CMB_ANNO = $q->fetchArray();
    }

    public function executeGetmes(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //anno
        $varTmp = $this->getRequestParameter('contratante');

        if ($varTmp == '*'):
            $q = Doctrine_Query::create()
                    ->select('id,anno, mes, mesnum')
                    ->from('CMB_ANNO_MVW  J')
                    ->groupBy('id, anno, mes, mesnum')
                    ->orderBy('mes');
        else:
            $q = Doctrine_Query::create()
                    ->select('id,anno, mes, mesnum')
                    ->from('CMB_ANNO_MVW  J')
                    ->where('centro_costo = ?', $varTmp)
                    ->groupBy('id, anno, mes, mesnum')
                    ->orderBy('mes');
        endif;



        $this->CMB_MES = $q->fetchArray();
    }
}
