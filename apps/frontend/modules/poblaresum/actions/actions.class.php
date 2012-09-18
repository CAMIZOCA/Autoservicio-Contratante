<?php

/**
 * poblaresum actions.
 *
 * @package    autoservicio
 * @subpackage poblaresum
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class poblaresumActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        /*
         * CAPTURA DE VALORES
         */
        ///Captura de Valores de Formulario        
        $var_idcliente = $request->getGetParameter('idcliente');
        $var_idcontratante = $request->getGetParameter('idcontratante');
        $var_idanno = $request->getGetParameter('idanno');
        $var_idmes = $request->getGetParameter('idmes');
        $var_idestatus = $request->getGetParameter('idestatus');
        $var_modulo = $request->getGetParameter('mod');


//echo $_GET['mod'];
        IF ($var_modulo == 'POC') {
            $modulo = 'poblaconsol';
            $tituloModulo = 'Población Consolidada';
        } ELSE IF ($_GET['mod'] == 'PEM') {
            $modulo = 'poblaevoluc';
            $tituloModulo = 'Evolución por mes';
        } ELSE IF ($_GET['mod'] == 'PES') {
            $modulo = 'poblarangos';
            $tituloModulo = 'Por rango de edad y sexo';
        } ELSE IF ($_GET['mod'] == 'PEP') {
            $modulo = 'poblarangop';
            $tituloModulo = 'Por rango de edad, parentesco y sexo';
        }

        $this->url_atras = "http://" . $_SERVER['SERVER_NAME'] . "/" . $modulo . "?" . $_SERVER['QUERY_STRING'];
        $this->tituloModulo = $tituloModulo;











        /*
         * creacion del where
         */
        $where = "WHERE  IDEPOL = $var_idcliente ";
        if ($var_idcontratante != '0'):
            $where .= " AND    CENTRO_COSTO = '$var_idcontratante'";
        endif;
        if (trim($var_idanno) != ''):
            if ($var_idanno != '0'):
                $where .= " AND    TO_CHAR (FECING, 'YYYY') =  $var_idanno  ";
            endif;
        endif;
        if (trim($var_idmes) != ''):
            if ($var_idmes != '0'):
                if ($var_idmes != 0):
                    $where .= " AND    TO_CHAR (FECING, 'MM') = $var_idmes ";
                endif;
            endif;
        endif;
        if (trim($var_idmes) != ''):
            if ($var_idmes != '0'):
                if ($var_idmes != 0):
                    // $where .= " AND    TO_CHAR (FECING, 'MM') = $var_idmes ";
                    $where .= " AND    STSASEG = '$var_idestatus' ";
                endif;
            endif;
        endif;
        //$where .= " AND    STSASEG = '$var_idestatus' ";



        $W_RANGO_EDAD = ' ';




        if ($request->getGetParameter('idcodcross') == ''):
            $idcodcross = 0;
        else:
            $idcodcross = $_GET['idcodcross'];
        endif;

        $idrangoedad = $request->getGetParameter('idrangoedad');

        //Paginador
        if ($request->getGetParameter('pagina') == ''):
            $val_pagina_ini = 1;
        else:
            $val_pagina_ini = $_GET['pagina'] . 1;
        endif;

        $val_pagina_fin = $val_pagina_ini + 9;


        /*
         * CONTRUIR WHERE
         */



        if ($idcodcross <> 0):
            $W_CODPARENT_CROSS = " AND CODPARENT_CROSS = 0" . $idcodcross;
        else:
            $W_CODPARENT_CROSS = " AND 1=1";
        endif;

        /*
         * Validar rango de edad para filtro 
         */

        switch ($idrangoedad) {
            case "0-10":
                //echo 'asdasdas';
                //$query = $query . " AND EDAD >= 1 AND EDAD <=10 ";
                $W_RANGO_EDAD = " AND EDAD >= 1 AND EDAD <=10 ";
                break;
            case "11-18":
                //  echo 'asdasdas';
                //$query = $query . " AND EDAD >= 11 AND EDAD <=18 ";
                $W_RANGO_EDAD = " AND EDAD >= 11 AND EDAD <=18 ";
                break;
            case "19-39":
                //$query = $query . " AND EDAD >= 19 AND EDAD <=39 ";
                $W_RANGO_EDAD = " AND EDAD >= 19 AND EDAD <=39 ";
                break;
            case "40-55":
                //$query = $query . " AND EDAD >= 40 AND EDAD <=55 ";
                $W_RANGO_EDAD = " AND EDAD >= 40 AND EDAD <=55 ";
                break;
            case "56-65":
                //$query = $query . " AND EDAD >= 56 AND EDAD <=65 ";
                $W_RANGO_EDAD = " AND EDAD >= 56 AND EDAD <=65 ";
                break;
            case "66-70":
                //$query = $query . " AND EDAD >= 66 AND EDAD <=70 ";
                $W_RANGO_EDAD = " AND EDAD >= 66 AND EDAD <=70 ";
                break;
            case "71-80":
                //$query = $query . " AND EDAD >= 71 AND EDAD <=80 ";
                $W_RANGO_EDAD = " AND EDAD >= 71 AND EDAD <=80 ";
                break;
            case "81-90":
                //$query = $query . " AND EDAD >= 81 AND EDAD <=90 ";
                $W_RANGO_EDAD = " AND EDAD >= 81 AND EDAD <=90 ";
                break;
            case "91-100":
                //$query = $query . " AND EDAD >= 91 AND EDAD <=100 ";
                $W_RANGO_EDAD = " AND EDAD >= 91 AND EDAD <=100 ";
                break;
            case "101":
                //$query = $query . " AND EDAD >= 101 ";
                $W_RANGO_EDAD = " AND EDAD >= 101 ";
                break;
        }
        ;







        /*
         * CREAR QUERY BASE PARA PDF IGUAL QUE EL BASE SIN FILTRO
         */
        $this->sqlpdf = "SELECT CONTADOR, NUMID, CERTIFICADO, CEDULA, NOMBRE, FECING, 
                  IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD 
            FROM (
            SELECT 
                    ROWNUM AS CONTADOR, NUMID, CERTIFICADO, CEDULA, NOMBRE, 
                    FECING, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD
                    FROM POBLACION_MVW                    
                        $where
                        $W_CODPARENT_CROSS
                        $W_RANGO_EDAD) ";


        /*
         * CREAR QUERY BASE
         */
        $query = "SELECT 
                  CONTADOR, NUMID, CERTIFICADO, CEDULA, NOMBRE, FECING, 
                  IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD 
            FROM (
            SELECT 
                    ROWNUM AS CONTADOR, NUMID, CERTIFICADO, CEDULA, NOMBRE, 
                    FECING, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD
                    FROM POBLACION_MVW                    
                        $where
                        $W_CODPARENT_CROSS
                        $W_RANGO_EDAD
                  ) WHERE CONTADOR >= $val_pagina_ini AND CONTADOR <= $val_pagina_fin                      
";
//echo $query;
        //*
        // CONSULTA PARA CONTADOR DEL PAGINADOR
        //*//
        $query2 = "
                SELECT TOTAL FROM ( 
                SELECT COUNT(NUMID) total 
                FROM POBLACION_MVW 
                  $where
                    $W_CODPARENT_CROSS
                    $W_RANGO_EDAD
                )
        ";

//echo $query;

        /*
         * Ejecutar query
         * para llenar los datos
         * 
         */

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();







        /*
         * Ejecutar query
         * para contar los datos
         * 
         */
        //   echo $query2;
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query2);
        $stmt->execute();
        $recorset = $stmt->fetchAll();
        foreach ($recorset as $row) {
            $this->totalRegistros = $row['TOTAL'];
        }





        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();
    }

    public function executeListpdf(sfWebRequest $request) {
        $this->setLayout('layout_none');

        $this->sql_pdf = $request->getPostParameter('sql_pdf');

           $query = $this->sql_pdf;
        //exit;


        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();
    }
    public function executeListexcel(sfWebRequest $request) {
        $this->setLayout('layout_none');

        $this->sql_pdf = $request->getPostParameter('sql_pdf');

           $query = $this->sql_pdf;
        //exit;


        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();
        
        $this->getResponse()->setContentType('application/msexcel');
        $this->getResponse()->addHttpMeta('content-disposition: ', 'attachment; filename="excel.xls"', true);
    }
    public function executeListprint(sfWebRequest $request) {
        $this->setLayout('layout_none');

        $this->sql_pdf = $request->getPostParameter('sql_print');

           $query = $this->sql_pdf;
        //exit;


        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();
    }

}
