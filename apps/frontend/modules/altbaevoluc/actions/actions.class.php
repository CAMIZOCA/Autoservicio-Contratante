<?php

/**
 * altbaevoluc actions.
 *
 * @package    autoservicio
 * @subpackage altbaevoluc
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class altbaevolucActions extends sfActions {

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

    public function executeList(sfWebRequest $request) {

        /*
         * CAPTURA DE VALORES
         */
        ///Captura de Valores de Formulario        
        $var_idcliente = $request->getGetParameter('idcliente');
        $var_idcontratante = $request->getGetParameter('idcontratante');
        $var_idanno = $request->getGetParameter('idanno');
        $var_idmes = $request->getGetParameter('idmes');
        $var_idestatus = $request->getGetParameter('idestatus');
                
        


        /*
         * creacion del where
         */
        $where = "WHERE  IDEPOL = $var_idcliente ";
        if ($var_idcontratante != '0'):
            $where .= " AND    CODCTROCOS = '$var_idcontratante'";
        endif;
        if (trim($var_idanno) != ''):
            if ($var_idanno != '0'):
                $where .= " AND    TO_CHAR (FECHA_MOVIMIENTO, 'YYYY') =  $var_idanno  ";
            endif;
        endif;
        if (trim($var_idmes) != ''):
            if ($var_idmes != '0'):
                if ($var_idmes != 0):
                    $where .= " AND    TO_CHAR (FECHA_MOVIMIENTO, 'MM') = $var_idmes ";
                endif;
            endif;
        endif;
        if (trim($var_idmes) != ''):
           // echo $var_idmes;
            if ($var_idmes != '0'):
                if ($var_idmes != 0):                   
                    //$where .= " AND    STSASEG = '$var_idestatus' ";
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
        
        if($val_pagina_ini < 10){
        $val_pagina_fin = $val_pagina_ini + 9;
        }else{
            $val_pagina_fin = $val_pagina_ini + 9;
        }
            


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
         * CREAR pdf
         */
        $sql_pdf = "SELECT  CONTADOR,
    NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, 
    SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD 
FROM (
    SELECT
        ROWNUM CONTADOR,NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, 
        SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD  FROM (
            SELECT 
                NUMIDTIT NUMID, 
                NUMCER CERTIFICADO,
                CEDULA, 
                NOMBRE, 
                FECHA_MOVIMIENTO FECMOV,
                IDEPOL, 
                PLAZO_ESPERA, 
                DECODE (CODPARENT, '0001', 'M', '0002', 'F', '0003', 'M', '0004', 'F', '0005', 'M', '0006', 'F', '0007', 
                'M', '0008', 'F', '0009', 'M', '0010', 'F', '0011', 'M', '0012', 'F', '0013', 'M', '0014', 'F', '0015', 
                'M', '0016', 'F', '0017', 'M', '0018', 'F', '0021', 'M', '0022', 'F', '0027', 'M', '0028', 'F', '0029', 
                'M', '0030', 'F', '0031', 'M', '0032', 'F', '0033', 'M', '0034', 'F', '0035', 'M', '0036', 'F', '0037', 'N') 
                SEXO_PARENTESCO, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD 
                FROM altas_bajas_mvw   
                        $where
                        $W_CODPARENT_CROSS
                        $W_RANGO_EDAD
          GROUP BY
                NUMIDTIT, 
                NUMCER,
                CEDULA, 
                NOMBRE, 
                FECHA_MOVIMIENTO,
                IDEPOL, 
                PLAZO_ESPERA,  
                CODPARENT_CROSS, PARENTESCO_CROSS, EDAD ,
                CODPARENT
    ) 
 ) 
  
";


        /*
         * CREAR QUERY BASE
         */
        $query = "SELECT  CONTADOR,
    NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, 
    SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD 
FROM (
    SELECT
        ROWNUM CONTADOR,NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, 
        SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD  FROM (
            SELECT 
                NUMIDTIT NUMID, 
                NUMCER CERTIFICADO,
                CEDULA, 
                NOMBRE, 
                FECHA_MOVIMIENTO FECMOV,
                IDEPOL, 
                PLAZO_ESPERA, 
                DECODE (CODPARENT, '0001', 'M', '0002', 'F', '0003', 'M', '0004', 'F', '0005', 'M', '0006', 'F', '0007', 
                'M', '0008', 'F', '0009', 'M', '0010', 'F', '0011', 'M', '0012', 'F', '0013', 'M', '0014', 'F', '0015', 
                'M', '0016', 'F', '0017', 'M', '0018', 'F', '0021', 'M', '0022', 'F', '0027', 'M', '0028', 'F', '0029', 
                'M', '0030', 'F', '0031', 'M', '0032', 'F', '0033', 'M', '0034', 'F', '0035', 'M', '0036', 'F', '0037', 'N') 
                SEXO_PARENTESCO, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD 
                FROM altas_bajas_mvw                 
                        $where
                        $W_CODPARENT_CROSS
                        $W_RANGO_EDAD
        GROUP BY
                NUMIDTIT, 
                NUMCER,
                CEDULA, 
                NOMBRE, 
                FECHA_MOVIMIENTO,
                IDEPOL, 
                PLAZO_ESPERA,  
                CODPARENT_CROSS, PARENTESCO_CROSS, EDAD ,
                CODPARENT
    ) 
 ) 
                   WHERE CONTADOR >= $val_pagina_ini AND CONTADOR <= $val_pagina_fin      
       
";
$query = "SELECT CONTADOR, 
    NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, 
    SEXO_PARENTESCO,  PARENTESCO_CROSS, EDAD 
 FROM 
 ( SELECT ROWNUM CONTADOR,NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, 
    SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD, numidben  FROM  ( 
            SELECT numidben, max(NUMIDTIT) NUMID, max(NUMCER) CERTIFICADO, max(CEDULA) cedula, max(NOMBRE) nombre, max(FECHA_MOVIMIENTO) FECMOV,
max(IDEPOL) idepol, max(PLAZO_ESPERA) PLAZO_ESPERA,max(sexo_parentesco) sexo_parentesco,max(CODPARENT_CROSS) CODPARENT_CROSS,
  max(PARENTESCO_CROSS)PARENTESCO_CROSS, max(EDAD) edad 
  FROM altas_bajas_mvw 
  $where
                        $W_CODPARENT_CROSS
                        $W_RANGO_EDAD
  GROUP BY numidben, cedula,TO_CHAR (Fecha_Movimiento, 'MM'),TO_CHAR (Fecha_Movimiento, 'Month'), movimiento,TO_CHAR (Fecha_Movimiento,'YYYY') ) ) 
  WHERE CONTADOR >= $val_pagina_ini AND CONTADOR <= $val_pagina_fin
";
       // echo $query;
      //exit;  
        //*
        // CONSULTA PARA CONTADOR DEL PAGINADOR
        //*//
       $query2 = "
                SELECT COUNT(*) TOTAL FROM ( SELECT ROWNUM CONTADOR,NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD, numidben FROM ( SELECT numidben, max(NUMIDTIT) NUMID, max(NUMCER) CERTIFICADO, max(CEDULA) cedula, max(NOMBRE) nombre, max(FECHA_MOVIMIENTO) FECMOV, max(IDEPOL) idepol, max(PLAZO_ESPERA) PLAZO_ESPERA,max(sexo_parentesco) sexo_parentesco,max(CODPARENT_CROSS) CODPARENT_CROSS, max(PARENTESCO_CROSS)PARENTESCO_CROSS, max(EDAD) edad FROM altas_bajas_mvw
                  $where
                    $W_CODPARENT_CROSS
                    $W_RANGO_EDAD
GROUP BY numidben, cedula,TO_CHAR (Fecha_Movimiento, 'MM'),TO_CHAR (Fecha_Movimiento, 'Month'), movimiento,TO_CHAR (Fecha_Movimiento,'YYYY') ) )
               
        ";

//echo $query2;
//exit;

        /*
         * Ejecutar query
         * para llenar los datos
         * 
         */

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();

//
//        /*
//         * Ejecutar query
//         * para contar los datos
//         * 
//         */
//        //   echo $query2;
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query2);
        $stmt->execute();
        $recorset = $stmt->fetchAll();
        foreach ($recorset as $row) {
            $this->totalRegistros = $row['TOTAL'];
        }

        $this->sql_pdf = $sql_pdf;
        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();
    }

    public function executeGettable(sfWebRequest $request) {

        ///Captura de Valores de Formulario        
        $var_idcliente = $request->getPostParameter('idcliente');
        $var_idcontratante = $request->getPostParameter('idcontratante');
        $var_idanno = $request->getPostParameter('idanno');
        $var_idestatus = $request->getPostParameter('idestatus');



        /*
         * creacion del where
         */
        $where = "WHERE  idepol = $var_idcliente ";
        if ($var_idcontratante != '0'):
            $where .= " AND    CODCTROCOS = '$var_idcontratante'";
        endif;
        if ($var_idanno != '0'):
            $where .= " AND    TO_CHAR (Fecha_Movimiento, 'YYYY') =  $var_idanno  ";
        endif;


        /*
         * creacion del query
         */


        //print_r($_POST);
        //echo $where;
        //http://autoservicio/frontend_dev.php/altbaevoluc/list?idcliente=293397&idcontratante=0001&idanno=2012&idmes=03&idestatus=*&idcodcross=0&idrangoedad=0&pagina=1578
        $query = "
                select IDMES, MES,sum(total) total,sum(altas) altas, sum(Bajas) Bajas, anno 
                from ( SELECT IDMES, MES,Anno,count(*) total, CASE WHEN TRIM(Movimiento)='A' THEN count(*) else 0 END as altas
                , CASE WHEN TRIM(Movimiento)='B' THEN count(*) else 0 END as Bajas 
                FROM (

                select cedula,TO_CHAR (Fecha_Movimiento, 'MM') IDMES, TO_CHAR (Fecha_Movimiento, 'Month') MES
                , movimiento, decode(TRIM(Movimiento),'A',COUNT(*), 'B',COUNT(*)) TOTAL,TO_CHAR (Fecha_Movimiento,'YYYY') as Anno 
                from altas_bajas_mvw t 

                $where                
                group by cedula,numcer,TO_CHAR (Fecha_Movimiento, 'MM'),TO_CHAR (Fecha_Movimiento, 'Month'),movimiento,TO_CHAR (Fecha_Movimiento,'YYYY') 

                ) 
                group by Anno,IDMES, mes,TRIM(Movimiento) ) 
                group by Anno,IDMES, mes order by IDMES ASC
            ";
        //echo $query;
        //exit;
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->altbaevoluc = $stmt->fetchAll();
        $this->totalALTAS = 0;
        $this->totalBAJAS = 0;
        $this->total = 0;
    }
    public function executeListpdf(sfWebRequest $request) {
        $this->setLayout('layout_none');
        $this->sql_pdf = $request->getPostParameter('sql_pdf');

        $query = $this->sql_pdf ;
        


        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();
    }
}
