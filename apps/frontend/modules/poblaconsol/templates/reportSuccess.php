<?php 
//include_once 'ORACLE_bd.php';
//include_once '../constantes.php';
include_once('http://localhost:8080/JavaBridge/java/Java.inc');
//include_once('C:/xampp/htdocs/php-jru/php-jru.php');

//class inv_rep{
//    private $conex;
//
//
//	public function __construct($conec = NULL){
//		  $this->conex = $conec;
//        }
    
 function display_report($sql,$nombreRep){
 
         $handle = @opendir($this->jrDirLib);
         	try{
         	 
                $Conexion=new java("org.altic.jasperReports.JdbcConnection");
    			//Driver java
    			$Conexion->setDriver("oracle.jdbc.driver.OracleDriver");
    			//Conexion a la Base de Datos
    			$Conexion->setConnectString(stringConex);
    			//Usuario
    			$Conexion->setUser(user);
    			//Password
		      	$Conexion->setPassword(password);
         	  
                 $conn =$Conexion->getConnection();
                 $parameters = new java ("java.util.HashMap");
                 $parameters->put("phola","Hola Mundo!!!");

                   
                   $JasperDesign = new Java ('net.sf.jasperreports.engine.design.JasperDesign');
        			$JRDesignQuery = new Java ('net.sf.jasperreports.engine.design.JRDesignQuery');
        			
        			$JRXmlLoader =  new Java ('net.sf.jasperreports.engine.xml.JRXmlLoader');
        			$JasperDesign = $JRXmlLoader->load(dirInforme.$nombreRep.".jrxml"); 
        			
        			$JRDesignQuery->setText($sql);
        			$JasperDesign->setQuery ($JRDesignQuery);  
                    $JasperCompileManager =  new Java ('net.sf.jasperreports.engine.JasperCompileManager');
        			$Reporte=$JasperCompileManager->compileReport($JasperDesign);
        			
        			$JspCompil=new	JavaClass('net.sf.jasperreports.engine.JasperFillManager');
        			$Imprime=$JspCompil->fillReport($Reporte,$parameters,$conn);
        		
        			//Exportacion del reporte
        			$JspExport=new	JavaClass('net.sf.jasperreports.engine.JasperExportManager');
        			$JspExport->exportReportToPdfFile($Imprime,dirInformePdf.$nombreRep.date("_d_m_y").".pdf");
        			if(file_exists(dirInformePdf.$nombreRep.date("_d_m_y").".pdf"))
        			{
        			    //echo ("entre if");
                       ob_end_clean();
        				header('Content-Type:application/pdf');
           	            header('Contentdisposition:attachment;filename="'.$nombreRep.date("_d_m_y").'.pdf"');
        				header('Content-Transfer-Enconding:binary');
        				header('Content-Length: '.filesize(dirInformePdf.$nombreRep.date("_d_m_y").".pdf"));
          				header('Pragma:no-cache');
           				header('Cache-Control:mustrevalidate,
          				post-check=0,pre-check=0');
        				header('Expires:0');
           				set_time_limit(0);
        				readfile(dirInformePdf.$nombreRep.date("_d_m_y").".pdf") or die("Ocurrio un Problema");
        			}
        			         
         	  
         	}catch (JavaException $ex){
        			$trace = new
        			Java('java.io.ByteArrayOutputStream');
        			$ex->printStackTrace(new Java('java.io.PrintStream', $trace));
        			print nl2br("java stack trace: $trace\n");
        			return false;
        		}
    }   
        
//}
display_report('select * from fondo_mvw','prueba');
?>