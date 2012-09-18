<?php

/**
 * maindashboard actions.
 *
 * @package    autoservicio
 * @subpackage maindashboard
 * @author     Your name here
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class maindashboardActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {

        $IdUserName = $this->getUser()->getGuardUser()->getId();
        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();
        

        if (in_array("ADMINISTRADOR", $this->getUser()->getCredentials())) {
            $this->perfil = "ADMINISTRADOR";
            $this->idperfil = 3;
        } elseif (in_array("HMOSEGURIDAD", $this->getUser()->getCredentials())) {
            $this->perfil = "HMOSEGURIDAD";
            $this->idperfil = 4;
        } elseif (in_array("HMOSUPERUSUARIO", $this->getUser()->getCredentials())) {
            $this->perfil = "HMOSUPERUSUARIO";
            $this->idperfil = 5;
        } elseif (in_array("HMOVENTAS", $this->getUser()->getCredentials())) {
            $this->perfil = "HMOVENTAS";
            $this->idperfil = 6;
        } elseif (in_array("CNE", $this->getUser()->getCredentials())) {
            $this->perfil = "CNE";
            $this->idperfil = 7;
        } elseif (in_array("ALCALDIACCS", $this->getUser()->getCredentials())) {
            $this->perfil = "ALCALDIACCS";
            $this->idperfil = 8;
        } else {
            $this->perfil = "ANONIMO";
            $this->idperfil = 0;
        }



        /*
         * DEFINIR VALORES DE SESSION PARA INFORMACION DEL CLIENTE PERMITIDO PARA 
         * CONSULTAR ASOCIADO AL USUARIO
         */
        /*
         * GUARDAR VARIABLE DE SESSION
         */
        $query1 = "SELECT * FROM R_CLIENTE_USUARIO WHERE IDPERM IN ($this->idperfil)";
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query1);
        $stmt->execute();
        $users = $stmt->fetchAll();
        //print_r($users);
        $var_reg_session_client = 0;
        foreach ($users as $group) {
            $var_reg_session_client = $var_reg_session_client . ',' . $group['IDEPOL'];
        }
        $this->getUser()->setAttribute('clientes', $var_reg_session_client);

        /*
         * FIN GUARDAR VARIABLE DE SESSION
         */



$cliente = $this->getUser()->getAttribute('clientes');

        $query = "
                SELECT FONDO_MVW.NUMERO_POLIZA, ENTE.DESCRIPCION AS NOMBRE, 
                to_char(FONDO_MVW.FECHA_INICIO_CONTRATO,'dd-mm-yyyy hh:ss:mm') as FECHA_INICIO_CONTRATO,
                to_char(FONDO_MVW.FECHA_FIN_CONTRATO,'dd-mm-yyyy hh:ss:mm') FECHA_FIN_CONTRATO, 
                FONDO_MVW.CODIGO_CLIENTE, 
                FONDO_MVW.IDEPOL, 
                ltrim(to_char(SUM(FONDO_MVW.SALDO_ANTERIOR),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) SALDO_ANTERIOR,
                ltrim(to_char(SUM(FONDO_MVW.APORTES),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) APORTES, 
                ltrim(to_char(SUM(FONDO_MVW.CANT_INCURRIDOS),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) CANT_INCURRIDOS,
                ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_TOTAL_TEO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) INCURRIDO_TOTAL_TEO,
                ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_ACUM_TEO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) INCURRIDO_ACUM_TEO,
                ltrim(to_char(SUM(FONDO_MVW.COSTO_PROMEDIO_TEO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) COSTO_PROMEDIO_TEO,
                ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_TOTAL_ACT),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) INCURRIDO_TOTAL_ACT,
                ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_ACUM_ACT),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) INCURRIDO_ACUM_ACT,
                ltrim(to_char(SUM(FONDO_MVW.COSTO_PROMEDIO_ACT),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) COSTO_PROMEDIO_ACT,
                ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_PEND_ANT),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) INCURRIDO_PEND_ANT,
                ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_INDEMNIZADO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) INCURRIDO_INDEMNIZADO,
                ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_INDEMNIZADO_TEO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) INCURRIDO_INDEMNIZADO_TEO,
                ltrim(to_char(SUM(FONDO_MVW.DISPONIBLE_FONDO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) DISPONIBLE_FONDO,
                ltrim(to_char(SUM(FONDO_MVW.TOTAL_FACTURADO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) TOTAL_FACTURADO,
                ltrim(to_char(SUM(FONDO_MVW.TOTAL_AMPARADO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) TOTAL_AMPARADO,
                ltrim(to_char(SUM(FONDO_MVW.TOTAL_NOAMPARADO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) TOTAL_NOAMPARADO,
                ltrim(to_char(SUM(FONDO_MVW.TOTAL_PAGADO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) TOTAL_PAGADO,
                ltrim(to_char(SUM(FONDO_MVW.TOTAL_PAGADO_ACUM),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) TOTAL_PAGADO_ACUM,
                ltrim(to_char(SUM(FONDO_MVW.AHORRO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) AHORRO,
                ltrim(to_char(SUM(FONDO_MVW.MONTO_RENDIDO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) MONTO_RENDIDO,
                ltrim(to_char(SUM(FONDO_MVW.HONORARIOS_HMO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) HONORARIOS_HMO,
ltrim(to_char(SUM(FONDO_MVW.APORTES) - SUM(FONDO_MVW.INCURRIDO_TOTAL_TEO),'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) DATOSFONDO_TOTAL,
ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_INDEMNIZADO_TEO) -  SUM(FONDO_MVW.INCURRIDO_INDEMNIZADO) ,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) AHORROTECNICO_TOTAL,
ltrim(to_char(SUM(FONDO_MVW.TOTAL_FACTURADO) - SUM(FONDO_MVW.TOTAL_PAGADO_ACUM) ,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.'''))  AHORFINAN_ADMINIS,
ltrim(to_char((SUM(FONDO_MVW.TOTAL_FACTURADO) - SUM(FONDO_MVW.TOTAL_PAGADO_ACUM))  +   (SUM(FONDO_MVW.TOTAL_FACTURADO) - SUM(FONDO_MVW.TOTAL_PAGADO_ACUM)) ,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) AHORFINAN_TECNADMI,
ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_INDEMNIZADO) - SUM(FONDO_MVW.TOTAL_PAGADO) ,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) SINIES_PENDAUDI,
ltrim(to_char(SUM(FONDO_MVW.INCURRIDO_ACUM_ACT) + SUM(FONDO_MVW.INCURRIDO_INDEMNIZADO) ,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) SINIES_PENDPAGAR
                FROM FONDO_MVW  
                INNER JOIN ENTE_CONTRATANTE_VW ENTE ON ENTE.IDEPOL=FONDO_MVW.IDEPOL 
                WHERE FONDO_MVW.IDEPOL IN ($cliente)
                GROUP BY FONDO_MVW.ID,      
                FONDO_MVW.CODIGO_CLIENTE, 
                FONDO_MVW.FECHA_INICIO_CONTRATO, 
                FONDO_MVW.IDEPOL, 
                FONDO_MVW.FECHA_FIN_CONTRATO, 
                FONDO_MVW.NUMERO_POLIZA, ENTE.DESCRIPCION,
                FECHA_INICIO_CONTRATO 
";
//echo $query;
        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->recordset = $stmt->fetchAll();
        //print_r($this->recordset);
    }

}
