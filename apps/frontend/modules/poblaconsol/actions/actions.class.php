<?php

/**
 * poblaconsol actions.
 *
 * @package    autoservicio
 * @subpackage poblaconsol
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class poblaconsolActions extends sfActions {

    public function executeIndex(sfWebRequest $request) {


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

    public function executeGettable(sfWebRequest $request) {


        ///Captura de Valores de Formulario        
        $var_idcliente = $request->getPostParameter('idcliente');
        $var_idcontratante = $request->getPostParameter('idcontratante');
        $var_idanno = $request->getPostParameter('idanno');
        $var_idmes = $request->getPostParameter('idmes');
        $var_idestatus = $request->getPostParameter('idestatus');

        $this->setLayout('layout_none');

        /*
         * creacion del where
         */

        if ($var_idestatus == 'ACT') {
            $var_ttFecha = 'FECING';
        } elseif ($var_idestatus == 'EXC') {
            $var_ttFecha = 'FECEXC';
        } ELSE {
            $var_ttFecha = 'FECING';
        }

        $where = "WHERE  idepol = $var_idcliente ";
        if ($var_idcontratante != '0'):
            $where .= " AND    centro_costo = '$var_idcontratante'";
        endif;
        if ($var_idanno != '0'):
            $where .= " AND    TO_CHAR ($var_ttFecha, 'YYYY') =  $var_idanno  ";
        endif;
        if ($var_idmes != '0'):
            $where .= " AND    TO_CHAR ($var_ttFecha, 'MM') = $var_idmes ";
        endif;
        if ($var_idestatus != '0'):
            $where .= " AND STSASEG = '$var_idestatus' ";
        endif;
        


        /*
         * creacion del query
         */


        $query = "SELECT   0 ID, CODPARENT_CROSS,
                PARENTESCO_CROSS,
                SUM (DECODE (SEXO_PARENTESCO, 'M', TOTAL, 0)) MASCULINO,
                SUM (DECODE (SEXO_PARENTESCO, 'F', TOTAL, 0)) FEMENINO,
                SUM (DECODE (SEXO_PARENTESCO, NULL, TOTAL, 0)) ERROR,
                SUM (DECODE (SEXO_PARENTESCO, 'M', TOTAL, 0))
                + SUM (DECODE (SEXO_PARENTESCO, 'F', TOTAL, 0))
                    TOTAL_MF
        FROM   (SELECT   POBLACION_MVW.CODPARENT,
        CODPARENT_CROSS,
                            PARENTESCO_CROSS,
                            SEXO_PARENTESCO,
                            COUNT (ID) TOTAL
                    FROM   POBLACION_MVW
                    $where        
                GROUP BY   CODPARENT, PARENTESCO_CROSS, SEXO_PARENTESCO, CODPARENT_CROSS
                ORDER BY   CODPARENT)
    GROUP BY   PARENTESCO_CROSS ,CODPARENT_CROSS";

        /*
         * ORDER BY
         */
        $var_orderby = $request->getPostParameter('orderby');
        if ($var_orderby != ''):
            $query = $query . " ORDER BY " . $var_orderby;

        else:
            $query = $query . " ORDER BY CODPARENT_CROSS";
        endif;
//echo $where;
//exit;
//        echo $query;
//            exit;

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->POBLACION_CONSOLIDADA_VW = $stmt->fetchAll();

        $this->monto_total = 0;
        $this->totalMasculino = 0;
        $this->totalFemenino = 0;
        $this->totalGrupo = 0;
    }

    public function executeGetcliente(sfWebRequest $request) {
        $this->setLayout('layout_none');
        $cliente = $this->getUser()->getAttribute('clientes');
        //RS PARA CAMPOS DE BUSQUEDAS
        //ENTE CONTRATANTE - CLIETE
        $q = Doctrine_Query::create()
                ->from('CMB_CLIENTE_MVW  J')
                ->where("IDEPOL IN ($cliente)");
        $this->CMB_CLIENTE_MVW = $q->fetchArray();
    }

    public function executeGetclientewhere(sfWebRequest $request) {
        $this->setLayout('layout_none');
        $cliente = $this->getUser()->getAttribute('clientes');

        $this->var_idcliente = $request->getGetParameter('id');

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
        $this->setLayout('layout_none');
        $varTmp = $this->getRequestParameter('idepol');
        $this->var_selectDefault = $request->getGetParameter('cmbcontratante');

        $q = Doctrine_Query::create()
                ->from('CMB_CONTRATANTE_MVW  J')
                ->where('idepol = ?', $varTmp);

        $this->CMB_CONTRATANTE_MVW = $q->fetchArray();
        $this->CMB_TOT_CONTRATANTE_MVW = $q->count();
    }

    public function executeGetanno(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //anno
        $this->var_selectDefault = $request->getGetParameter('cmbanno');
        $this->setLayout('layout_none');
        $idcontratante = $this->getRequestParameter('idcontratante');
        $idepol = $this->getRequestParameter('idepol');
        //echo strlen($idcontratante);
        //exit;
        //Valido si selecciona la opcion de todos

        if (strlen($idcontratante) > 1):
            $q = Doctrine_Query::create()
                    ->select('id, anno, centro_costo')
                    ->from('CMB_ANNO_MVW  J')
                    ->where('centro_costo = ?', $idcontratante)
                    ->andWhere('idepol = ?', $idepol)
                    ->groupBy('id, anno, centro_costo');
        else:
            $q = Doctrine_Query::create()
                    ->select('id, anno')
                    ->from('CMB_ANNO_MVW  J')
                    ->where('idepol = ?', $idepol)
                    ->groupBy('id, anno');
        endif;

        $this->CMB_ANNO = $q->fetchArray();
        $this->CMB_TOTAL_ANNO = $q->count();
    }

    public function executeGetmes(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //anno
        $this->setLayout('layout_none');
        $idcontratante = $this->getRequestParameter('idcontratante');
        $idepol = $this->getRequestParameter('idepol');
        $idanno = $this->getRequestParameter('anno');

        $where1 = " 1 = 1 ";

        if ($idepol != "0")
            $where1 .= "AND idepol = $idepol ";

        if ($idcontratante != "0")
            $where1 .= "AND centro_costo = '$idcontratante' ";

        if ($idanno != "0")
            $where1 .= "AND anno = $idanno ";

        $q = Doctrine_Query::create()
                ->select('id,anno, mes, mesnum')
                ->from('CMB_ANNO_MVW  J')
                ->where("$where1")
                ->groupBy('id, anno, mes, mesnum')
                ->orderBy('mes');

        $this->CMB_MES = $q->fetchArray();
        $this->CMB_TOT_MES = $q->count();
    }
    public function executeGetmes2(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //anno
        $this->setLayout('layout_none');
        $idcontratante = $this->getRequestParameter('idcontratante');
        $idepol = $this->getRequestParameter('idepol');
        $idanno = $this->getRequestParameter('anno');
        $idestatus = $this->getRequestParameter('idestatus');

        $where1 = " 1 = 1 ";

        if ($idepol != "0")
            $where1 .= "AND idepol = $idepol ";

        if ($idcontratante != "0")
            $where1 .= "AND centro_costo = '$idcontratante' ";

        if ($idanno != "0")
            $where1 .= "AND anno = $idanno ";

        //if ($idestatus != "0")
        //echo     $where1 .= "AND STSASEG = '$idestatus' ";
        
        //echo $where1;
        $q = Doctrine_Query::create()
                ->select('id, stsaseg')
                ->from('CMB_ANNO_MVW  J')
                ->where("$where1")
                ->groupBy('id, stsaseg');
//print_r($q);
        //exit;
        $this->CMB_MES = $q->fetchArray();
        $this->CMB_TOT_MES = $q->count();
    }
    public function executeGetmes3(sfWebRequest $request) {
        //RS PARA CAMPOS DE BUSQUEDAS
        //anno
        $this->setLayout('layout_none');
        $idcontratante = $this->getRequestParameter('idcontratante');
        $idepol = $this->getRequestParameter('idepol');
        $idanno = $this->getRequestParameter('anno');
        $idestatus = $this->getRequestParameter('cmbstatus');

        $where1 = " 1 = 1 ";

        if ($idepol != "0")
            $where1 .= "AND idepol = $idepol ";

        if ($idcontratante != "0")
            $where1 .= "AND centro_costo = '$idcontratante' ";

        if ($idanno != "0")
            $where1 .= "AND anno = $idanno ";
//echo $idestatus;
        if ($idestatus <> "0")
             $where1 .= " AND stsaseg = '".$idestatus."' ";
        //echo $where1;
        //exit;
        
        //echo 'select id, mes, mesnum from CMB_ANNO_MVW where '.$where1 . ' group by id, mes, mesnum';
        $q = Doctrine_Query::create()
                ->select('id, mes, mesnum')
                ->from('CMB_ANNO_MVW  J')
                ->where("$where1")
                ->groupBy('id, mes, mesnum')
                //->orderBy('mes')
                ;

        $this->CMB_MES = $q->fetchArray();
        $this->CMB_TOT_MES = $q->count();
    }

    public function executeQuickUserBox(sfWebRequest $request) {


        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();
    }

    public function executeReport(sfWebRequest $request) {
        
    }

}
