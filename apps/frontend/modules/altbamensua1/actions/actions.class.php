<?php

/**
 * altbamensua actions.
 *
 * @package    autoservicio
 * @subpackage altbamensua
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class altbamensua1Actions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();

        ///Captura de Valores de Formulario        
        $var_idcliente = $request->getGetParameter('cmbcliente');
        $var_idcontratante = $request->getGetParameter('cmbcontratante');
        $var_idanno = $request->getGetParameter('cmbanno');
        $var_idmes = $request->getGetParameter('idmes');
        $var_idestatus = $request->getGetParameter('cmbestatus');
        //$this->forward('default', 'module');



        //Valores para llenar formularios al retornar
        $this->var_idcliente = $var_idcliente;
        $this->var_idcontratante = $var_idcontratante;
        $this->var_idanno = $var_idanno;
        $this->var_idmes = $var_idmes;
        $this->var_idestatus = $var_idestatus;
        $this->var_cero = -1;



        /*
         * creacion del where
         */
        $where = "WHERE  IDEPOL = $var_idcliente ";
        if ($var_idcontratante != '0'):
            $where .= " AND    CODCTROCOS = '$var_idcontratante'";
        endif;
        if ($var_idanno != '0'):
            $where .= " AND    TO_CHAR (FECHA_MOVIMIENTO, 'YYYY') =  $var_idanno  ";
        endif;

        if ($var_idestatus != '0'):
            $where .= " AND    MOVIMIENTO = '$var_idestatus'";
        endif;


        $where2 = $where;
        $where .= " AND ROWNUM <= 10 ";

        //Paginador
        if ($request->getGetParameter('pagina') == ''):
            $val_pagina_ini = 1;
        else:
            $val_pagina_ini = $_GET['pagina'] . 1;
        endif;

        if ($val_pagina_ini < 10) {
            $val_pagina_fin = $val_pagina_ini + 9;
        } else {
            $val_pagina_fin = $val_pagina_ini + 9;
        }

//echo $where2; exit;
        /*
         * creacion del query
         */
        /*
         * CREAR QUERY BASE
         */
        $query = "
                        SELECT CONTADOR,
                NUMID, CERTIFICADO,CONTRATO, CEDULABEN, CEDULATIT, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO,ESTATUS, 
                    PARENTESCO_CROSS, EDAD  
                FROM ( 
                SELECT 
                    ROWNUM CONTADOR,NUMID, CERTIFICADO,CONTRATO, CEDULABEN, CEDULATIT, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO,ESTATUS, 
                    PARENTESCO_CROSS, EDAD 
                FROM ( 
                    SELECT 
                        NUMIDTIT NUMID, NUMCER CERTIFICADO,  idepol  contrato ,CEDULA CEDULABEN, NUMIDTIT CEDULATIT, NOMBRE, FECHA_MOVIMIENTO FECMOV, IDEPOL, PLAZO_ESPERA, DECODE (SUBSTR(MOVIMIENTO, 1, 1), 'B', 'EXCLUIDO', 'A', 'INCLUIDO')  ESTATUS,
                        DECODE (CODPARENT, '0001', 'M', '0002', 'F', '0003', 'M', '0004', 'F', '0005', 'M', '0006', 'F', '0007', 'M', '0008', 'F', '0009', 'M', '0010', 'F', '0011', 'M', '0012', 'F', '0013', 'M', '0014', 'F', '0015', 'M', '0016', 'F', '0017', 'M', '0018', 'F', '0021', 'M', '0022', 'F', '0027', 'M', '0028', 'F', '0029', 'M', '0030', 'F', '0031', 'M', '0032', 'F', '0033', 'M', '0034', 'F', '0035', 'M', '0036', 'F', '0037', 'N') SEXO_PARENTESCO, 
                        CODPARENT_CROSS, PARENTESCO_CROSS, EDAD 
                        FROM altas_bajas_mvw 
                        $where2         
                        GROUP BY NUMIDTIT, NUMCER, CEDULA,NUMIDTIT, NOMBRE, FECHA_MOVIMIENTO, IDEPOL, PLAZO_ESPERA, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD , CODPARENT, MOVIMIENTO, CONTRATANTE 
                        ) 
                    ) 
                WHERE CONTADOR >= $val_pagina_ini AND CONTADOR <= $val_pagina_fin      

       
";
        $sql_pdf = "SELECT CONTADOR,NUMID, CERTIFICADO,CONTRATO, CEDULABEN, CEDULATIT, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO,ESTATUS, PARENTESCO_CROSS, EDAD  FROM ( SELECT ROWNUM CONTADOR,NUMID, CERTIFICADO,CONTRATO, CEDULABEN, CEDULATIT, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO,ESTATUS, PARENTESCO_CROSS, EDAD FROM ( SELECT NUMIDTIT NUMID, NUMCER CERTIFICADO,  idepol  contrato ,CEDULA CEDULABEN, NUMIDTIT CEDULATIT, NOMBRE, FECHA_MOVIMIENTO FECMOV, IDEPOL, PLAZO_ESPERA, DECODE (SUBSTR(MOVIMIENTO, 1, 1), 'B', 'EXCLUIDO', 'A', 'INCLUIDO')  ESTATUS, DECODE (CODPARENT, '0001', 'M', '0002', 'F', '0003', 'M', '0004', 'F', '0005', 'M', '0006', 'F', '0007', 'M', '0008', 'F', '0009', 'M', '0010', 'F', '0011', 'M', '0012', 'F', '0013', 'M', '0014', 'F', '0015', 'M', '0016', 'F', '0017', 'M', '0018', 'F', '0021', 'M', '0022', 'F', '0027', 'M', '0028', 'F', '0029', 'M', '0030', 'F', '0031', 'M', '0032', 'F', '0033', 'M', '0034', 'F', '0035', 'M', '0036', 'F', '0037', 'N') SEXO_PARENTESCO,  CODPARENT_CROSS, PARENTESCO_CROSS, EDAD FROM altas_bajas_mvw $where2 GROUP BY NUMIDTIT, NUMCER, CEDULA,NUMIDTIT, NOMBRE, FECHA_MOVIMIENTO, IDEPOL, PLAZO_ESPERA, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD , CODPARENT, MOVIMIENTO, CONTRATANTE ) ) ";

//echo 'ALTA Y BAJAS MENSUALAL--->'.$query;
        //  $query = "SELECT NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD FROM ( SELECT ROWNUM CONTADOR,NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD FROM ( SELECT NUMIDTIT NUMID, NUMCER CERTIFICADO, CEDULA, NOMBRE, FECHA_MOVIMIENTO FECMOV, IDEPOL, PLAZO_ESPERA, DECODE (CODPARENT, '0001', 'M', '0002', 'F', '0003', 'M', '0004', 'F', '0005', 'M', '0006', 'F', '0007', 'M', '0008', 'F', '0009', 'M', '0010', 'F', '0011', 'M', '0012', 'F', '0013', 'M', '0014', 'F', '0015', 'M', '0016', 'F', '0017', 'M', '0018', 'F', '0021', 'M', '0022', 'F', '0027', 'M', '0028', 'F', '0029', 'M', '0030', 'F', '0031', 'M', '0032', 'F', '0033', 'M', '0034', 'F', '0035', 'M', '0036', 'F', '0037', 'N') SEXO_PARENTESCO, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD FROM altas_bajas_mvw WHERE IDEPOL = 293371 AND CODCTROCOS = 'ALC-01' AND TO_CHAR (FECHA_MOVIMIENTO, 'YYYY') = 2011 AND TO_CHAR (FECHA_MOVIMIENTO, 'MM') = 09 AND 1=1 GROUP BY NUMIDTIT, NUMCER, CEDULA, NOMBRE, FECHA_MOVIMIENTO, IDEPOL, PLAZO_ESPERA, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD , CODPARENT ) ) WHERE CONTADOR >= 0 AND CONTADOR <= 20 ";
        //echo $query;
//exit;


        if ($var_idcliente != '') {
            $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $this->ALTA_BAJA_MENSUAL_VW = $stmt->fetchAll();
        }

//echo $where2;
 /*
         * TOTAL DE ALTAS
         */
        if ($var_idcliente != '') {
            
            $query ="
                    SELECT 
                    count(*) total
                    FROM ( 
                        SELECT 
                            movimiento, 
                            decode(TRIM(Movimiento),'A') TOTAL 
                            FROM altas_bajas_mvw t 
                        $where2   AND TRIM(Movimiento) = 'A'         
                        group by cedula,numcer,movimiento 
                    ) 
                    group by  TRIM(Movimiento)                 
            ";
            //$query = " SELECT sum(count(*)) total FROM ALTAS_BAJAS_MVW
            //$where2 AND MOVIMIENTO = 'A' GROUP BY NUMIDTIT, NUMCER, CEDULA, NOMBRE, FECHA_MOVIMIENTO, IDEPOL, PLAZO_ESPERA, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD , CODPARENT, MOVIMIENTO, CONTRATANTE";
            $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $this->TOTAL_ALTA = $stmt->fetchAll();
//echo '<br /> <br /> <br /> TOTAL DE ALTAS--->'.$query;
        }

        /*
         * TOTAL DE BAJAS
         */
        if ($var_idcliente != '') {
            //$query = "SELECT sum(count(*)) total FROM ALTAS_BAJAS_MVW
            //$where2 AND MOVIMIENTO = 'B' GROUP BY NUMIDTIT, NUMCER, CEDULA, NOMBRE, FECHA_MOVIMIENTO, IDEPOL, PLAZO_ESPERA, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD , CODPARENT, MOVIMIENTO, CONTRATANTE";
            $query ="
                    SELECT 
                    count(*) total
                    FROM ( 
                        SELECT 
                            movimiento, 
                            decode(TRIM(Movimiento),'B') TOTAL 
                            FROM altas_bajas_mvw t 
                        $where2  AND TRIM(Movimiento) = 'B'      
                        group by cedula,numcer,movimiento 
                    ) 
                    group by  TRIM(Movimiento)                 
            ";
            $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $this->TOTAL_BAJA = $stmt->fetchAll();
            $query_bajas = $query;
        }
        
        
        
        
///echo '<br /> <br /> <br /> TOTAL DE BAJAS-->'.$query;
        //*
        // CONSULTA PARA CONTADOR DEL PAGINADOR
        //*//
        $query2 = "
                SELECT count(*) TOTAL FROM ( SELECT ROWNUM CONTADOR,NUMID, CERTIFICADO,CONTRATO, CEDULABEN, CEDULATIT, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO,ESTATUS, PARENTESCO_CROSS, EDAD FROM ( SELECT NUMIDTIT NUMID, NUMCER CERTIFICADO, idepol contrato ,CEDULA CEDULABEN, NUMIDTIT CEDULATIT, NOMBRE, FECHA_MOVIMIENTO FECMOV, IDEPOL, PLAZO_ESPERA, DECODE (SUBSTR(MOVIMIENTO, 1, 1), 'B', 'EXCLUIDO', 'A', 'INCLUIDO') ESTATUS, DECODE (CODPARENT, '0001', 'M', '0002', 'F', '0003', 'M', '0004', 'F', '0005', 'M', '0006', 'F', '0007', 'M', '0008', 'F', '0009', 'M', '0010', 'F', '0011', 'M', '0012', 'F', '0013', 'M', '0014', 'F', '0015', 'M', '0016', 'F', '0017', 'M', '0018', 'F', '0021', 'M', '0022', 'F', '0027', 'M', '0028', 'F', '0029', 'M', '0030', 'F', '0031', 'M', '0032', 'F', '0033', 'M', '0034', 'F', '0035', 'M', '0036', 'F', '0037', 'N') SEXO_PARENTESCO, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD FROM altas_bajas_mvw
                  $where2
            GROUP BY NUMIDTIT, NUMCER, CEDULA,NUMIDTIT, NOMBRE, FECHA_MOVIMIENTO, IDEPOL, PLAZO_ESPERA, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD , CODPARENT, MOVIMIENTO, CONTRATANTE ) ) 
        ";
        //echo $query2;
        //exit;


        /*
         * Ejecutar query
         * para contar los datos
         * 
         */
        if ($var_idcliente != '') {
            $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
            $stmt = $pdo->prepare($query2);
            $stmt->execute();
            $recorset = $stmt->fetchAll();
            foreach ($recorset as $row) {
                $this->totalRegistros = $row['TOTAL'];
            }
        }

        $this->sql_pdf = $sql_pdf;
        $this->monto_total = 0;
        $this->totalMasculino = 0;
        $this->totalFemenino = 0;
        $this->totalGrupo = 0;
    }

    public function executeListpdf(sfWebRequest $request) {
        $this->setLayout('layout_none');
        $this->sql_pdf = $request->getPostParameter('sql_pdf');

        $query = $this->sql_pdf;

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();
    }
    public function executeListexcel(sfWebRequest $request) {
        $this->setLayout('layout_none');
        $this->sql_pdf = $request->getPostParameter('sql_pdf');

        $query = $this->sql_pdf;

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();
        
        $this->getResponse()->setContentType('application/msexcel');
        $this->getResponse()->addHttpMeta('content-disposition: ', 'attachment; filename="excel.xls"', true);
    }
    public function executeListprint(sfWebRequest $request) {
        $this->setLayout('layout_none');
        $this->sql_pdf = $request->getPostParameter('sql_pdf');


        $query = $this->sql_pdf;

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();

        $this->registros = $stmt->fetchAll();
    }

}
