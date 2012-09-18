<?php

/**
 * poblarangos actions.
 *
 * @package    autoservicio
 * @subpackage poblarangos
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class poblarangosActions extends sfActions {

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
        $where .= " and edad >= 0 ";


        /*
         * creacion del query
         */


        //print_r($_POST) ;
        $query = " SELECT       0 ID,
              EDAD,
              STSASEG,        
              SUM (MASCULINO) MASCULINO,
              SUM (FEMENINO) FEMENINO,
              SUM (MASCULINO) + SUM (FEMENINO) TOTAL,
              SUM (ERROR) ERROR
       FROM   (  SELECT   EDAD,
                          STSASEG,
                          ANNO,
                          SUM (DECODE (Sexo_Parentesco, 'M', TOTAL, 0)) MASCULINO,
                          SUM (DECODE (Sexo_Parentesco, 'F', TOTAL, 0)) FEMENINO,
                          SUM (DECODE (SEXO_PARENTESCO, NULL, TOTAL, 0)) ERROR
                   FROM   (  SELECT   STSASEG,
                                      TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                                      COUNT ( * ) AS TOTAL,
                                      Sexo_Parentesco,
                                      CASE
                                         WHEN (edad >= 0 AND edad <= 10)
                                         THEN
                                            ' 0-10'
                                         WHEN (edad > 10 AND edad <= 18)
                                         THEN
                                            ' 11-18'
                                         WHEN (edad > 18 AND edad <= 39)
                                         THEN
                                            ' 19-39'
                                         WHEN (edad > 39 AND edad <= 55)
                                         THEN
                                            ' 40-55'
                                         WHEN (edad > 55 AND edad <= 65)
                                         THEN
                                            ' 56-65'
                                         WHEN (edad > 65 AND edad <= 70)
                                         THEN
                                            ' 66-70'
                                         WHEN (edad > 70 AND edad <= 80)
                                         THEN
                                            ' 71-80'
                                         WHEN (edad > 80 AND edad <= 90)
                                         THEN
                                            ' 81-90'
                                         WHEN (edad > 90 AND edad <= 100)
                                         THEN
                                            ' 91-100'
                                         WHEN (edad >= 101)
                                         THEN
                                            '101-Más'
                                      END
                                         AS edad
                               FROM   poblacion_mvw t
                   $where 
                   AND    Sexo_Parentesco IN ('M', 'F')
                           GROUP BY   edad,
                                      IDEPOL,
                                      CENTRO_COSTO,
                                      STSASEG,
                                      TO_CHAR ($var_ttFecha, 'YYYY'),
                                      Sexo_Parentesco)
               GROUP BY   EDAD, 
                          STSASEG,
                          ANNO,
                          Sexo_Parentesco)
   GROUP BY   EDAD,
              STSASEG
   ";


        /*
         * ORDER BY
         */
        $var_orderby = $request->getPostParameter('orderby');

        if ($var_orderby != ''):
            $query = $query . " ORDER BY " . $var_orderby;

        else:
            $query = $query . " ORDER BY EDAD";
        endif;


        //exit;
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->POBLACION_RAN_EDA_SEX_MVW = $stmt->fetchAll();

        /*
         * creacion del where
         */
        $where = "WHERE  idepol = $var_idcliente ";
        if ($var_idcontratante != '0'):
            $where .= " AND    centro_costo = '$var_idcontratante'";
        endif;
        if ($var_idanno != '0'):
            $where .= " AND    TO_CHAR ($var_ttFecha, 'YYYY') =  $var_idanno  ";
        endif;

        $where .= " AND    STSASEG = '$var_idestatus' ";

        /*
         * consulta para mostrar error si hay registros que no se muestran
         */
        $queryError = "
                    SELECT SUM(ERROR) AS ERROR FROM(
                    SELECT count(*) as error from poblacion_mvw $where AND edad is null
                    UNION 
                    SELECT count(*) as error from poblacion_mvw $where AND edad < 0
                    )  ";

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($queryError);
        $stmt->execute();
        $this->POBLACION_error = $stmt->fetchAll();


        $this->sum_t = 0;
        $this->sum_b = 0;
        $this->sum_a = 0;
    }

}
