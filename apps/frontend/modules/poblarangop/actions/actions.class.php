<?php

/**
 * poblarangop actions.
 *
 * @package    autoservicio
 * @subpackage poblarangop
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class poblarangopActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        //$this->forward('default', 'module');
        //RS PARA CAMPOS DE BUSQUEDAS
        //DEFINIR VARIABLES PARA SUMA DE TABLA

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
        $varidcliente = $this->getRequestParameter('idcliente');
        $varidcontratante = $this->getRequestParameter('idcontratante');
        $varidanno = $this->getRequestParameter('idanno');
        $varidestatus = $this->getRequestParameter('idestatus');






        /*
         * creacion del where
         */
        
        if ($var_idestatus != 'EXC'){
            $var_ttFecha = 'FECING';
        } else {
            $var_ttFecha = 'FECEXC';
        }          
        
        $where = "AND  idepol = $varidcliente ";
        if ($varidcontratante != '0'):
            $where .= " AND    centro_costo = '$varidcontratante'";
        endif;
        if ($varidanno != '0'):
            $where .= " AND TO_CHAR ($var_ttFecha, 'YYYY')  =  $varidanno  ";
        endif;
        $where .= " AND    STSASEG = '$varidestatus' ";



        /*
         * GROUP BY
         */

        $groupby = "
            GROUP BY      
            CODPARENT_CROSS,
            Sexo_Parentesco,
            parentesco_cross";
        $orderby = " ORDER BY CODPARENT_CROSS";

       
        
        /*
         * ejecutar consulta
         */

        //Parentescp - Masculino
        $andwhere = " AND Sexo_Parentesco = 'M' ";
        /*
         * QUERY BASE
         */
        $query = "
       SELECT   CODPARENT_CROSS,
                                  parentesco_cross parentesco,
                                  SUM (diez) diez,
                                  SUM (diesyocho) diesyocho,
                                  SUM (treintaynueve) treintaynueve,
                                  SUM (cincuentaycinco) cincuentaycinco,
                                  SUM (sesentaycinco) sesentaycinco,
                                  SUM (setenta) setenta,
                                  SUM (ochenta) ochenta,
                                  SUM (noventa) noventa,
                                  SUM (masnoventa) masnoventa,
                                  SUM (mascien) mascien,
                                  SUM (total) total,
                                  ( (SUM (total) * 100) / (  SELECT   COUNT ( * ) FROM poblacion_mvw where edad >= 0   $where $andwhere ))
                                  porc
       FROM   (  SELECT   0 ID, CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          COUNT ( * ) diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 0 AND 10 $where  $andwhere 
               GROUP BY   CODPARENT_CROSS, parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          COUNT ( * ) diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 11 AND 18 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,  
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          COUNT ( * ) treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 19 AND 39 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,                           
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          COUNT ( * ) cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 40 AND 55 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          COUNT ( * ) sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 56 AND 65 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          COUNT ( * ) setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 66 AND 70 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          COUNT ( * ) ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 71 AND 80 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,                           
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          COUNT ( * ) noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 81 AND 90 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          COUNT ( * ) masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 91 AND 100  $where $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa, 
                          0 masnoventa,
                          COUNT ( * ) mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad >= 101 $where $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
        
        
        ) 
              ";
//echo "SELECT   COUNT ( * ) FROM poblacion_mvw where edad >= 0  $where $andwhere ";
        //echo $query  . $groupby . $orderby;
        
        //echo $query  . $groupby . $orderby . '<br /><br /><br />';
        //exit;
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query . $groupby . $orderby);
        $stmt->execute();
        $this->POBLACION_RANGO_EDAD_SEXO_PARENT_MASC_VW = $stmt->fetchAll();



        //Parentescp - Femenino


        $andwhere = " AND Sexo_Parentesco = 'F' ";
        /*
         * QUERY BASE
         */
        $query = "
       SELECT   CODPARENT_CROSS,
                                  parentesco_cross parentesco,
                                  SUM (diez) diez,
                                  SUM (diesyocho) diesyocho,
                                  SUM (treintaynueve) treintaynueve,
                                  SUM (cincuentaycinco) cincuentaycinco,
                                  SUM (sesentaycinco) sesentaycinco,
                                  SUM (setenta) setenta,
                                  SUM (ochenta) ochenta,
                                  SUM (noventa) noventa,
                                  SUM (masnoventa) masnoventa,
                                  SUM (mascien) mascien,
                                  SUM (total) total,
                                  ( (SUM (total) * 100) / (  SELECT   COUNT ( * ) FROM poblacion_mvw where edad >= 0   $where $andwhere ))
                                  porc
       FROM   (  SELECT   0 ID, CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          COUNT ( * ) diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 0 AND 10 $where  $andwhere 
               GROUP BY   CODPARENT_CROSS, parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          COUNT ( * ) diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 11 AND 18 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,  
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          COUNT ( * ) treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 19 AND 39 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,                           
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          COUNT ( * ) cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 40 AND 55 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          COUNT ( * ) sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 56 AND 65 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          COUNT ( * ) setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 66 AND 70 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          COUNT ( * ) ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 71 AND 80 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,                           
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          COUNT ( * ) noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 81 AND 90 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          COUNT ( * ) masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 91 AND 100  $where $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa, 
                          0 masnoventa,
                          COUNT ( * ) mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad >= 101 $where $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
        
        
        ) 
              ";
//echo $query  . $groupby . $orderby;
//        exit;
     //   echo $query  . $groupby . $orderby . '<br /><br />';
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query  . $groupby . $orderby);
        $stmt->execute();
        $this->POBLACION_RANGO_EDAD_SEXO_PARENT_FEM_VW = $stmt->fetchAll();



        //Parentescp - Total


        
        $andwhere = "AND Sexo_Parentesco IN('M','F')";        
        //$andwhere = "AND Sexo_Parentesco NOT IN('M','F')";
        //$andwhere = "";        
        
        //echo $where . $andwhere;
        
        /*
         * QUERY BASE
         */
     $query = "
       SELECT   CODPARENT_CROSS,
                                  parentesco_cross parentesco,
                                  SUM (diez) diez,
                                  SUM (diesyocho) diesyocho,
                                  SUM (treintaynueve) treintaynueve,
                                  SUM (cincuentaycinco) cincuentaycinco,
                                  SUM (sesentaycinco) sesentaycinco,
                                  SUM (setenta) setenta,
                                  SUM (ochenta) ochenta,
                                  SUM (noventa) noventa,
                                  SUM (masnoventa) masnoventa,
                                  SUM (mascien) mascien,
                                  SUM (total) total,
                                  ( (SUM (total) * 100) / (  SELECT   COUNT ( * ) FROM poblacion_mvw where edad >= 0   $where $andwhere ))
                                  porc
       FROM   (  SELECT   0 ID, CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          COUNT ( * ) diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 0 AND 10 $where  $andwhere 
               GROUP BY   CODPARENT_CROSS, parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          COUNT ( * ) diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 11 AND 18 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,  
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          COUNT ( * ) treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 19 AND 39 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,                           
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          COUNT ( * ) cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 40 AND 55 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          COUNT ( * ) sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 56 AND 65 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          COUNT ( * ) setenta,
                          0 ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 66 AND 70 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          COUNT ( * ) ochenta,
                          0 noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 71 AND 80 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID,                           
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          COUNT ( * ) noventa,
                          0 masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 81 AND 90 $where  $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa,
                          COUNT ( * ) masnoventa,
                          0 mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad BETWEEN 91 AND 100  $where $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
               UNION
                 SELECT   0 ID, 
                          CODPARENT_CROSS,                          
                          parentesco_cross,
                          Sexo_Parentesco,
                          0 diez,
                          0 diesyocho,
                          0 treintaynueve,
                          0 cincuentaycinco,
                          0 sesentaycinco,
                          0 setenta,
                          0 ochenta,
                          0 noventa, 
                          0 masnoventa,
                          COUNT ( * ) mascien,
                          COUNT ( * ) total,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY') ANNO,
                          STSASEG
                   FROM   poblacion_mvw
                  WHERE   edad >= 101 $where $andwhere 
               GROUP BY    
                          CODPARENT_CROSS,
                          parentesco_cross,
                          Sexo_Parentesco,
                          idepol,
                          centro_costo,
                          TO_CHAR ($var_ttFecha, 'YYYY'),
                          STSASEG
        
        
        ) 
              ";

        //echo $query  . $groupby . $orderby;
        
        $sql = "SELECT CODPARENT_CROSS, parentesco, SUM (diez) diez, SUM (diesyocho) diesyocho, SUM (treintaynueve) treintaynueve, SUM (cincuentaycinco) cincuentaycinco, SUM (sesentaycinco) sesentaycinco, SUM (setenta) setenta, SUM (ochenta) ochenta, SUM (noventa) noventa, SUM (masnoventa) masnoventa, 
         SUM (mascien) mascien,SUM (total) total, SUM (porc) as porc 
         FROM (" .$query  . $groupby . $orderby . ")GROUP BY CODPARENT_CROSS,  parentesco  ORDER BY CODPARENT_CROSS";
     ///echo $where. $andwhere   ;
        //exit;        

//        echo $query . $groupby . $orderby;
       // echo $sql . '<br /><br />';
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($sql);
        $stmt->execute();
        $this->POBLACION_RANGO_EDAD_SEXO_PARENT_TOT_VW = $stmt->fetchAll();

        //echo  $query . $where . $andwhere . $groupby .  $orderby        ;
        
        
        
        $var_idcliente = $request->getPostParameter('idcliente');
        $var_idcontratante = $request->getPostParameter('idcontratante');
        $var_idanno = $request->getPostParameter('idanno');
        $var_idmes = $request->getPostParameter('idmes');
        $var_idestatus = $request->getPostParameter('idestatus');
        
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
        
        
        $this->t1 = 0;
        $this->t2 = 0;
        $this->t3 = 0;
        $this->t4 = 0;
        $this->t5 = 0;
        $this->t6 = 0;
        $this->t7 = 0;
        $this->t8 = 0;
        $this->t9 = 0;
        $this->t10 = 0;
        $this->t11 = 0;
    }

}
