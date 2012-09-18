<?php

/**
 * altbamensua actions.
 *
 * @package    autoservicio
 * @subpackage altbamensua
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class altbamensuaActions extends sfActions {

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
    }

    public function executeGettable(sfWebRequest $request) {


///Captura de Valores de Formulario        
        $var_idcliente = $request->getPostParameter('idcliente');
        $var_idcontratante = $request->getPostParameter('idcontratante');
        $var_idanno = $request->getPostParameter('idanno');
        $var_idmes = $request->getPostParameter('idmes');
        $var_idestatus = $request->getPostParameter('idestatus');
        //$this->forward('default', 'module');



        /*
         * creacion del where
         */
        $where = "WHERE  IDEPOL = $var_idcliente ";
        if ($var_idcontratante != '*'):
            $where .= " AND    CODCTROCOS = '$var_idcontratante'";
        endif;
        if ($var_idanno != '*'):
            $where .= " AND    TO_CHAR (FECHA_MOVIMIENTO, 'YYYY') =  $var_idanno  ";
        endif;

        if ($var_idestatus != '*'):
            $where .= " AND    MOVIMIENTO = '$var_idestatus'";
        endif;


        $where2 = $where;
        $where .= " AND ROWNUM <= 10 ";
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
WHERE CONTADOR >= 0 AND CONTADOR <= 10
 
       
";


        //  $query = "SELECT NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD FROM ( SELECT ROWNUM CONTADOR,NUMID, CERTIFICADO, CEDULA, NOMBRE, FECMOV, IDEPOL, PLAZO_ESPERA, SEXO_PARENTESCO, PARENTESCO_CROSS, EDAD FROM ( SELECT NUMIDTIT NUMID, NUMCER CERTIFICADO, CEDULA, NOMBRE, FECHA_MOVIMIENTO FECMOV, IDEPOL, PLAZO_ESPERA, DECODE (CODPARENT, '0001', 'M', '0002', 'F', '0003', 'M', '0004', 'F', '0005', 'M', '0006', 'F', '0007', 'M', '0008', 'F', '0009', 'M', '0010', 'F', '0011', 'M', '0012', 'F', '0013', 'M', '0014', 'F', '0015', 'M', '0016', 'F', '0017', 'M', '0018', 'F', '0021', 'M', '0022', 'F', '0027', 'M', '0028', 'F', '0029', 'M', '0030', 'F', '0031', 'M', '0032', 'F', '0033', 'M', '0034', 'F', '0035', 'M', '0036', 'F', '0037', 'N') SEXO_PARENTESCO, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD FROM altas_bajas_mvw WHERE IDEPOL = 293371 AND CODCTROCOS = 'ALC-01' AND TO_CHAR (FECHA_MOVIMIENTO, 'YYYY') = 2011 AND TO_CHAR (FECHA_MOVIMIENTO, 'MM') = 09 AND 1=1 GROUP BY NUMIDTIT, NUMCER, CEDULA, NOMBRE, FECHA_MOVIMIENTO, IDEPOL, PLAZO_ESPERA, CODPARENT_CROSS, PARENTESCO_CROSS, EDAD , CODPARENT ) ) WHERE CONTADOR >= 0 AND CONTADOR <= 20 ";
        //echo $query;
//exit;
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->ALTA_BAJA_MENSUAL_VW = $stmt->fetchAll();


//echo $where2;
        /*
         * TOTAL DE ALTAS
         */
        $query = "
            SELECT COUNT(*) TOTAL FROM ALTAS_BAJAS_MVW
            $where2 AND MOVIMIENTO = 'A'";
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->TOTAL_ALTA = $stmt->fetchAll();


        /*
         * TOTAL DE BAJAS
         */
        $query = "SELECT COUNT(*) total FROM ALTAS_BAJAS_MVW
            $where2 AND MOVIMIENTO = 'B'";
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->TOTAL_BAJA = $stmt->fetchAll();

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

//        /*
//         * Ejecutar query
//         * para contar los datos
//         * 
//         */
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query2);
        $stmt->execute();
        $recorset = $stmt->fetchAll();
        foreach ($recorset as $row) {
            $this->totalRegistros = $row['TOTAL'];
        }


        $this->monto_total = 0;
        $this->totalMasculino = 0;
        $this->totalFemenino = 0;
        $this->totalGrupo = 0;
    }

}
