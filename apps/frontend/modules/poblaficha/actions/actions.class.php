<?php

/**
 * poblaficha actions.
 *
 * @package    autoservicio
 * @subpackage poblaficha
 * @author     Marvin Baptista
 * @version    SVN: $Id: actions.class.php 23810 2009-11-12 11:07:44Z Kris.Wallsmith $
 */
class poblafichaActions extends sfActions {

    /**
     * Executes index action
     *
     * @param sfRequest $request A request object
     */
    public function executeIndex(sfWebRequest $request) {
        // $this->forward('default', 'module');

        $this->UserName = $this->getUser()->getGuardUser()->getUsername();
        $this->CreatedAt = $this->getUser()->getGuardUser()->getCreatedAt();
        $this->FirstName = $this->getUser()->getGuardUser()->getFirstName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastName = $this->getUser()->getGuardUser()->getLastName();
        $this->LastLogin = $this->getUser()->getGuardUser()->getLastLogin();


        $varidcliente = $request->getParameter('idcliente');
        $varidcontratante = $request->getParameter('idcontratante');
        $varIdCertificado = $request->getParameter('idcertificado');

        $var_modulo = $request->getGetParameter('mod');
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
        }ELSE IF ($_GET['mod'] == 'EVO') {
            $modulo = 'altbaevoluc';
            $tituloModulo = 'Evolución';
        }ELSE IF ($_GET['mod'] == 'MEN') {
            $modulo = 'altbamensua1';
            $tituloModulo = 'Mensualizadas';
        }

        $this->url_atras="http://".$_SERVER['SERVER_NAME']."/poblaresum?".$_SERVER['QUERY_STRING'];
        
        IF ($_GET['mod'] == 'EVO') {
            $this->url_atras="http://".$_SERVER['SERVER_NAME']."/altbaevoluc/list?".$_SERVER['QUERY_STRING'];
        }
        
        
        
        $this->url_atras_mod = "http://" . $_SERVER['SERVER_NAME'] . "/" . $modulo . "?" . $_SERVER['QUERY_STRING'];
        $this->tituloModulo = $tituloModulo;
        

        if ($varidcontratante != '0'):
            $whereCentroCosto1 = "WHERE CENTRO_COSTO = '$varidcontratante'";
            $whereCentroCosto2 = "AND POBLA.centro_costo  = '$varidcontratante'";
        else:
            $whereCentroCosto1 = "";
            $whereCentroCosto2 = "";
        endif;




        $query = "
      SELECT CERTIFICADO, NUMID, NOMBRE, CEDULA, VIGENCIADESDE, VIGENCIAHASTA, PARENTESCO_CROSS, IDEPOL, centro_costo
FROM(
select 
pobla.CERTIFICADO,
pobla.NUMID,
pobla.nombre,
pobla.tipoid || pobla.numid || pobla.dvid as cedula,
cober.fecinivigpol as VIGENCIADESDE,
cober.fecfinvigpol as VIGENCIAHASTA, 
 parentesco_cross,
 pobla.IDEPOL ,
 pobla.centro_costo
 from poblacion_mvw pobla left join coberturas_mvw cober on pobla.ideaseg=cober.ideaseg
 where POBLA.CODPARENT IN (1,2)  
     AND POBLA.CERTIFICADO = $varIdCertificado
 ) 
  $whereCentroCosto1
 GROUP BY CERTIFICADO, NUMID, NOMBRE, CEDULA, VIGENCIADESDE, VIGENCIAHASTA, parentesco_cross, IDEPOL, centro_costo
 ORDER BY NOMBRE

      
      
      ";
$query;

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->registros = $stmt->fetchAll();




        $query = "
SELECT NOMBRE, CEDULA,CODPARENT_CROSS, PARENTESCO_CROSS, FECNAC, SEXO, FECING, CERTIFICADO, EDAD FROM (
select
 pobla.CODPARENT_CROSS,  
 pobla.nombre,pobla.tipoid || pobla.numid || pobla.dvid as cedula,
 parentesco_cross,
 fecnac,
 sexo,
 fecing ,
 CERTIFICADO,
 EDAD
from poblacion_mvw pobla 
 where POBLA.CERTIFICADO = $varIdCertificado     
        $whereCentroCosto2
order by pobla.ideaseg
)
GROUP BY NOMBRE, CEDULA,CODPARENT_CROSS, PARENTESCO_CROSS, FECNAC, SEXO, FECING, CERTIFICADO, EDAD
ORDER BY CODPARENT_CROSS, NOMBRE
";

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->registros2 = $stmt->fetchAll();




        $query = "SELECT NOMBRE, CODPARENT_CROSS, PARENTESCO_CROSS, CENTRO_COSTO, CODPLAN, CODRAMO, SUMAASEGMONEDA, DEDUCIBLE 
FROM (
select   
pobla.nombre,
pobla.CODPARENT_CROSS,  
pobla.parentesco_cross,
centro_costo,
pobla.codplan,
pobla.codramo,
cob.sumaasegmoneda,
cob.deducible 
from coberturas_mvw cob
inner join poblacion_mvw pobla on cob.ideaseg = pobla.ideaseg
where POBLA.CERTIFICADO = $varIdCertificado
             $whereCentroCosto2
order by cob.ideaseg)
GROUP BY NOMBRE, CODPARENT_CROSS, PARENTESCO_CROSS, CENTRO_COSTO, CODPLAN, CODRAMO,  SUMAASEGMONEDA, DEDUCIBLE
ORDER BY CODPARENT_CROSS, NOMBRE";

        $pdo = Doctrine_Manager::getInstance()->getCurrentConnection()->getDbh();
        $stmt = $pdo->prepare($query);
        $stmt->execute();
        $this->registros3 = $stmt->fetchAll();
    }

}
