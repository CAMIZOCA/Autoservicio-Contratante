<?php 
include_once '../construyer.php';

$usuario=$_SESSION['sistema']->security->get_id_user();
$id_company=$_SESSION['sistema']->security->get_id_company();

$arrayx;
if ($_REQUEST['funcion']=="carta_sol_aval"){
    
  $sql= "SELECT (SELECT CONTACTO.NOMBRE FROM CONTACTO WHERE CONTACTO.ID_CONTACTO = SOLICITUD_CARTA_AVAL.ID_CONTACTO) AS CONTACTO,
          (SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL) ||' '||CLIENTE.IDENTIFICATION FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE) AS TITULAR,
          (SELECT CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ||' '||CLIENTE.IDENTIFICATION  FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = SINIESTRO.ID_BENEFICIARIO) AS BENEFICIARIO,
          POLIZA.CODIGO_POLIZA,
          SOLICITUD_CARTA_AVAL.DIAGNOSTICO AS DX,
          SINIESTRO.CODIGO_SINIESTRO,
          ASEGURADORA.NOMBRE,
          SINIESTRO.FDEC_SINIESTRO,
          SINIESTRO.FDEC_SINIESTRO AS FECHA_OCURRENCIA,
          SOLICITUD_CARTA_AVAL.CONTENIDO_CARTA,
          SOLICITUD_CARTA_AVAL.MONTO,
          SOLICITUD_CARTA_AVAL.OBSERVACIONES,
          SOLICITUD_CARTA_AVAL.RECAUDOS,
          STATUS.DESCRIPCION AS ESTATUS,
          USUARIO.NOMBRE AS USUARIO,
          CONFI_EMPRESA.DIRECCION
          FROM SOLICITUD_CARTA_AVAL
              INNER JOIN SINIESTRO ON SINIESTRO.ID_SINIESTRO = SOLICITUD_CARTA_AVAL.ID_SINIESTRO
              INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
              INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
              INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
              INNER JOIN STATUS ON STATUS.ID_STATUS = SOLICITUD_CARTA_AVAL.ESTADO,
              USUARIO
              INNER JOIN USUARIO_EMPRESA ON USUARIO_EMPRESA.id_usuario = USUARIO.ID_USUARIO
              INNER JOIN CONFI_EMPRESA ON CONFI_EMPRESA.ID_CONFI_EMPRESA = USUARIO_EMPRESA.ID_CONFI_EMPRESA
          WHERE SOLICITUD_CARTA_AVAL.STATUS=1 AND USUARIO.ID_USUARIO=".$usuario." --ID DEL USUARIO DEL SISTEMA
                                 and SOLICITUD_CARTA_AVAL.ID_SOLICITUD_CARTA_AVAL=".$_REQUEST['num']." and SOLICITUD_CARTA_AVAL.ID_CONFI_EMPRESA= ".$id_company;  
     // $inf="carta_sol_aval";    
      // $_SESSION['sistema']->xinv_rep->display_report($sql, $_REQUEST['funcion']);           
 }else if ($_REQUEST['funcion']=="carta_ent_aval"){
  $sql= "SELECT DECODE(POLIZA.TIPO_POLIZA,'COL',(SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL ||CHR(13)||CLIENTE.DIRECCIOND) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_TOMADOR),(SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL||CHR(13)||CLIENTE.DIRECCIOND) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE)) AS DIRIGIDA_A,
              NVL((SELECT CONTACTO.NOMBRE FROM CONTACTO WHERE CONTACTO.ID_CONTACTO = SOLICITUD_CARTA_AVAL.ID_CONTACTO),'') AS CONTACTO,
              DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL) ||' '||CLIENTE.IDENTIFICATION AS TITULAR,
              NVL((SELECT 'BENEFICIARIO: '||CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ||' '||CLIENTE.IDENTIFICATION  FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = SINIESTRO.ID_BENEFICIARIO),'') AS BENEFICIARIO,
              SINIESTRO.CODIGO_SINIESTRO,
              ASEGURADORA.NOMBRE,
              SINIESTRO.FDEC_SINIESTRO,
              SINIESTRO.FDEC_SINIESTRO AS FECHA_OCURRENCIA,
              ENTREGA_CARTA_AVAL.CONTENIDO_CARTA,
              ENTREGA_CARTA_AVAL.MONTO,
              ENTREGA_CARTA_AVAL.NUMERO_CARTA_AVAL,
              ENTREGA_CARTA_AVAL.OBSERVACION,
              STATUS.DESCRIPCION AS ESTATUS,
              USUARIO.NOMBRE AS USUARIO,
              CONFI_EMPRESA.DIRECCION
           FROM ENTREGA_CARTA_AVAL
              INNER JOIN SOLICITUD_CARTA_AVAL ON SOLICITUD_CARTA_AVAL.ID_SOLICITUD_CARTA_AVAL = ENTREGA_CARTA_AVAL.ID_SOLICITUD_CARTA_AVAL
              INNER JOIN SINIESTRO ON SINIESTRO.ID_SINIESTRO = SOLICITUD_CARTA_AVAL.ID_SINIESTRO
              INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
              INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
              INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
              INNER JOIN STATUS ON STATUS.ID_STATUS = ENTREGA_CARTA_AVAL.ESTADO
              INNER JOIN CLIENTE ON CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE,
              USUARIO
              INNER JOIN USUARIO_EMPRESA ON USUARIO_EMPRESA.id_usuario = USUARIO.ID_USUARIO
              INNER JOIN CONFI_EMPRESA ON CONFI_EMPRESA.ID_CONFI_EMPRESA = USUARIO_EMPRESA.ID_CONFI_EMPRESA
            WHERE ENTREGA_CARTA_AVAL.STATUS=1 AND USUARIO.ID_USUARIO =".$usuario." 
               and ENTREGA_CARTA_AVAL.ID_ENTREGA_CARTA_AVAL=".$_REQUEST['num']." and ENTREGA_CARTA_AVAL.ID_CONFI_EMPRESA= ".$id_company; 
                
                     
    }
    else if ($_REQUEST['funcion']=="carta_sol_remb"){
         $sql= "SELECT (SELECT CONTACTO.NOMBRE FROM CONTACTO WHERE CONTACTO.ID_CONTACTO = SOLICITUD_REEMBOLSO.ID_CONTACTO) AS CONTACTO,
                  (SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL) ||' '||CLIENTE.IDENTIFICATION FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE) AS TITULAR,
                  (SELECT 'BENEFICIARIO: '|| CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ||' '||CLIENTE.IDENTIFICATION  FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = SINIESTRO.ID_BENEFICIARIO) AS BENEFICIARIO,
                  POLIZA.CODIGO_POLIZA,
                  ASEGURADORA.NOMBRE AS ASEGURADORA,
                  SINIESTRO.FDEC_SINIESTRO AS FECHA_OCURRENCIA,
                  SOLICITUD_REEMBOLSO.DIAGNOSTICO AS DX,
                  SOLICITUD_REEMBOLSO.CONTENIDO_CARTA,
                  SOLICITUD_REEMBOLSO.MONTO,
                  SOLICITUD_REEMBOLSO.RECAUDOS,
                  SOLICITUD_REEMBOLSO.OBSERVACIONES,
                  STATUS.DESCRIPCION AS ESTATUS,
                  USUARIO.NOMBRE AS USUARIO,
                  CONFI_EMPRESA.DIRECCION
                  FROM SOLICITUD_REEMBOLSO
                      INNER JOIN SINIESTRO ON SINIESTRO.ID_SINIESTRO = SOLICITUD_REEMBOLSO.ID_SINIESTRO
                      INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                      INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON STATUS.ID_STATUS = SOLICITUD_REEMBOLSO.ESTADO,
                      USUARIO
                      INNER JOIN USUARIO_EMPRESA ON USUARIO_EMPRESA.id_usuario = USUARIO.ID_USUARIO
                      INNER JOIN CONFI_EMPRESA ON CONFI_EMPRESA.ID_CONFI_EMPRESA = USUARIO_EMPRESA.ID_CONFI_EMPRESA
                  WHERE SOLICITUD_REEMBOLSO.STATUS=1 AND USUARIO.ID_USUARIO=".$usuario." --ID DEL USUARIO DEL SISTEMA 
                        and SOLICITUD_REEMBOLSO.ID_SOLICITUD_REEMBOLSO=".$_REQUEST['num']." and SOLICITUD_REEMBOLSO.ID_CONFI_EMPRESA= ".$id_company; 
                  
        
    }
    else if ($_REQUEST['funcion']=="carta_ent_cheque_indiv"){
        $sql="SELECT DECODE(POLIZA.TIPO_POLIZA,'COL',(SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL ||CHR(13)||CLIENTE.DIRECCIOND) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_TOMADOR),(SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL||CHR(13)||CLIENTE.DIRECCIOND) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE)) AS DIRIGIDA_A,
                  NVL((SELECT CONTACTO.NOMBRE FROM CONTACTO WHERE CONTACTO.ID_CONTACTO = SOLICITUD_REEMBOLSO.ID_CONTACTO),'') AS CONTACTO,
                  DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL) ||' '||CLIENTE.IDENTIFICATION AS TITULAR,
                  NVL((SELECT CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ||' '||CLIENTE.IDENTIFICATION  FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = SINIESTRO.ID_BENEFICIARIO),'') AS BENEFICIARIO,
                  SINIESTRO.CODIGO_SINIESTRO,
                  ASEGURADORA.NOMBRE,
                  SINIESTRO.FDEC_SINIESTRO,
                  SINIESTRO.FDEC_SINIESTRO AS FECHA_OCURRENCIA,
                  ENTREGA_REEMBOLSO.CONTENIDO_CARTA,
                  ENTREGA_REEMBOLSO.MONTO,
                  ENTREGA_REEMBOLSO.NUMERO_REEMBOLSO as CHEQUE,
                  ENTREGA_REEMBOLSO.OBSERVACION AS OBSERVACION,
                  STATUS.DESCRIPCION AS ESTATUS,
                  USUARIO.NOMBRE AS USUARIO,
                  CONFI_EMPRESA.DIRECCION
                  FROM ENTREGA_REEMBOLSO
                      INNER JOIN SOLICITUD_REEMBOLSO ON SOLICITUD_REEMBOLSO.ID_SOLICITUD_REEMBOLSO = ENTREGA_REEMBOLSO.ID_SOLICITUD_REEMBOLSO
                      INNER JOIN SINIESTRO ON SINIESTRO.ID_SINIESTRO = SOLICITUD_REEMBOLSO.ID_SINIESTRO
                      INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                      INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON STATUS.ID_STATUS = ENTREGA_REEMBOLSO.ESTADO
                      INNER JOIN CLIENTE ON CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE,
                      USUARIO
                      INNER JOIN USUARIO_EMPRESA ON USUARIO_EMPRESA.id_usuario = USUARIO.ID_USUARIO
                      INNER JOIN CONFI_EMPRESA ON CONFI_EMPRESA.ID_CONFI_EMPRESA = USUARIO_EMPRESA.ID_CONFI_EMPRESA
                 WHERE ENTREGA_REEMBOLSO.STATUS=1 AND USUARIO.ID_USUARIO=".$usuario."
                        and ENTREGA_REEMBOLSO.ID_ENTREGA_REEMBOLSO=".$_REQUEST['num']." and ENTREGA_REEMBOLSO.ID_CONFI_EMPRESA= ".$id_company; 
         
        
    }
    
        else if ($_REQUEST['funcion']=="carta_ent_fin"){
         $sql= "SELECT MAX(FINANCIAMIENTO.ID_FINANCIAMIENTO) AS FINANCIAMIENTO,
                   (SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.razon_social) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_TOMADOR) AS TOMADOR,
                   MAX(CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ||' '|| CLIENTE.IDENTIFICATION) AS TITULAR,
                   MAX(FINANCIAMIENTO.codigo_financiamiento) AS CONTRATO_FINANCIAMIENTO,
                   LTRIM(MAX(TO_CHAR(FINANCIAMIENTO.inical,'99,999,999,999.99'))) AS INICIAL,
                   LTRIM(MAX(TO_CHAR(FINANCIAMIENTO.cuotas,'99,999,999,999'))) AS GIROS,
                   LTRIM(MAX(TO_CHAR(FINANCIAMIENTO.MONTO_CUOTA,'99,999,999,999.99'))) AS MONTO_CUOTA,
                   LTRIM(MAX(TO_CHAR(FINANCIAMIENTO.FPAGO_INICIAL,'DD'))) AS DIA,
                   MAX(ASEGURADORA.NOMBRE) AS ASEGURADORA,
                   MAX(FINANCIADOR.NOMBRE) AS FINANCIADORA,
                   MAX(POLIZA.CODIGO_POLIZA) AS POLIZA,
                   MAX(CONTACTO.NOMBRE) AS CONTACTO,
                   MAX(USUARIO.NOMBRE) AS USUARIO_SISTEMA,
                   MAX(CONFI_EMPRESA.DIRECCION) AS PIE_DE_PAGINA
                  FROM FINANCIAMIENTO
                      LEFT JOIN CONTACTO ON CONTACTO.ID_CONTACTO = FINANCIAMIENTO.ID_CONTACTO
                      INNER JOIN RECIBO ON RECIBO.ID_FINANCIAMIENTO = FINANCIAMIENTO.ID_FINANCIAMIENTO
                      INNER JOIN POLIZA ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA = POLIZA.ID_POLIZA
                      INNER JOIN CLIENTE ON CLIENTE.ID_CLIENTE = FINANCIAMIENTO.ID_TITULAR
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      LEFT JOIN FINANCIADOR  ON ASEGURADORA.ID_FINANCIADOR = FINANCIADOR.ID_FINANCIADOR,
                      USUARIO
                      INNER JOIN USUARIO_EMPRESA ON USUARIO_EMPRESA.ID_USUARIO = USUARIO.ID_USUARIO
                      INNER JOIN CONFI_EMPRESA ON CONFI_EMPRESA.ID_CONFI_EMPRESA = USUARIO_EMPRESA.ID_CONFI_EMPRESA
                  WHERE FINANCIAMIENTO.STATUS=1 AND USUARIO.ID_USUARIO=".$usuario."--ID DEL USUARIO DEL SISTEMA
                        AND   FINANCIAMIENTO.ID_FINANCIAMIENTO= ".$_REQUEST['num']." AND   FINANCIAMIENTO.ID_CONFI_EMPRESA= ".$id_company."
                GROUP BY POLIZA_TOMADOR.ID_POLIZA,POLIZA_TOMADOR.ID_TOMADOR";
        
    }
    
    /* else if ($_REQUEST['funcion']=="resumen_poliza_recibo"){
         $sql= "SELECT POLIZA.CODIGO_POLIZA,
                   TO_CHAR(POLIZA.VIGENCIA_DESDE,'DD/MM/YYYY') ||' al '|| TO_CHAR(POLIZA.VIGENCIA_HASTA,'DD/MM/YYYY') AS VIGENCIA_POLIZA,
                   CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS AS TITULAR,
                   CLIENTE.DIRECCIOND,
                   CLIENTE.TELEFONOS AS TELEFONO_TITULAR,
                   ASEGURADORA.NOMBRE AS ASEGURADORA,
                   PRODUCTOR.NOMBRE AS PRODUCTOR,
                   AREA.NOMBRE AS RAMO,
                   EJECUTIVO.NOMBRE AS EJECUTIVO,
                   NVL(GRUPO_ASEGURADO.NOMBRE,'') AS GRUPO,
                   RECIBO.CODIGO_RECIBO,
                   TO_CHAR(RECIBO.FDESDE,'DD/MM/YYYY') ||' al '|| TO_CHAR(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA_RECIBO,
                   RECIBO.FEMISION,
                   RECIBO.FRECEPCION,
                   RECIBO.PRIMA,
                   TIPO_RECIBO.NOMBRE AS TIPO_RECIBO,
                   RECIBO.OBSERVACIONES,
                   STATUS.DESCRIPCION AS ESTATUS,
                   NVL(FORMA_PAGO.NOMBRE,'') AS FORMA_PAGO,
                   CONFI_EMPRESA.RAZON_SOCIAL,
                   CONFI_EMPRESA.RIF,
                   CONFI_EMPRESA.TELEFONOS,
                   CONFI_EMPRESA.REGISTRO_SUPERINTENDENCIA,
                   POLIZA.ID_PLAN
              FROM RECIBO
                INNER JOIN POLIZA ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                INNER JOIN STATUS ON STATUS.ID_STATUS = RECIBO.ESTADO
                INNER JOIN CLIENTE ON CLIENTE.ID_CLIENTE = RECIBO.ID_TITULAR
                INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                INNER JOIN PRODUCTOR ON PRODUCTOR.ID_PRODUCTOR = POLIZA.ID_PRODUCTOR
                INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                INNER JOIN AREA ON AREA.ID_AREA = RAMO.ID_AREA
                INNER JOIN EJECUTIVO ON EJECUTIVO.ID_EJECUTIVO = POLIZA.ID_EJECUTIVO
                LEFT JOIN GRUPO_ASEGURADO ON GRUPO_ASEGURADO.ID_GRUPO_ASEGURADO = CLIENTE.ID_GRUPO_ASEGURADO
                LEFT JOIN FORMA_PAGO ON FORMA_PAGO.ID_FORMA_PAGO = RECIBO.FORMA_PAGO
                LEFT JOIN TIPO_RECIBO ON TIPO_RECIBO.ID_TIPO_RECIBO = RECIBO.TIPO_RECIBO,
                USUARIO
                INNER JOIN USUARIO_EMPRESA ON USUARIO_EMPRESA.id_usuario = USUARIO.ID_USUARIO
                INNER JOIN CONFI_EMPRESA ON CONFI_EMPRESA.ID_CONFI_EMPRESA = USUARIO_EMPRESA.ID_CONFI_EMPRESA
              WHERE RECIBO.STATUS=1 AND USUARIO.ID_USUARIO=".$usuario." 
                     and RECIBO.ID_RECIBO=".$_REQUEST['num']." and RECIBO.ID_CONFI_EMPRESA=".$id_company;
        
    }*/
       else if ($_REQUEST['funcion']=="carta_rech"){
         
        
        $sql="SELECT DECODE(POLIZA.TIPO_POLIZA,'COL',(SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL ||CHR(13)||CLIENTE.DIRECCIOND) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_TOMADOR),(SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL||CHR(13)||CLIENTE.DIRECCIOND) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE)) AS DIRIGIDA_A,
                   (SELECT CONTACTO.NOMBRE FROM CONTACTO WHERE CONTACTO.ID_CONTACTO = SOLICITUD_CARTA_AVAL.ID_CONTACTO) AS CONTACTO,
                   DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL) ||' '||CLIENTE.IDENTIFICATION AS TITULAR,
                   (SELECT 'BENEFICIARIO: '||CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ||' '||CLIENTE.IDENTIFICATION  FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = SINIESTRO.ID_BENEFICIARIO) AS BENEFICIARIO,
                   SINIESTRO.CODIGO_SINIESTRO,
                   POLIZA.CODIGO_POLIZA,
                   SOLICITUD_CARTA_AVAL.DIAGNOSTICO,
                   ASEGURADORA.NOMBRE AS NOMBRE_ASEGURADORA,
                   SINIESTRO.CODIGO_SINIESTRO AS SINIESTRO,
                   SINIESTRO.FDEC_SINIESTRO,
                   SINIESTRO.FDEC_SINIESTRO AS FECHA_OCURRENCIA,
                   ENTREGA_CARTA_AVAL.CONTENIDO_CARTA,
                   ENTREGA_CARTA_AVAL.MONTO,
                   ENTREGA_CARTA_AVAL.OBSERVACION,
                   STATUS.DESCRIPCION AS ESTATUS,
                   USUARIO.NOMBRE AS USUARIO,
                   CONFI_EMPRESA.DIRECCION AS PIE_PAGINA
                FROM ENTREGA_CARTA_AVAL
                     INNER JOIN SOLICITUD_CARTA_AVAL ON SOLICITUD_CARTA_AVAL.ID_SOLICITUD_CARTA_AVAL = ENTREGA_CARTA_AVAL.ID_SOLICITUD_CARTA_AVAL
                     INNER JOIN SINIESTRO ON SINIESTRO.ID_SINIESTRO = SOLICITUD_CARTA_AVAL.ID_SINIESTRO
                     INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                     INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                     INNER JOIN CLIENTE ON CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                     INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                     INNER JOIN STATUS ON STATUS.ID_STATUS = ENTREGA_CARTA_AVAL.ESTADO,
                     USUARIO
                     INNER JOIN USUARIO_EMPRESA ON USUARIO_EMPRESA.id_usuario = USUARIO.ID_USUARIO 
                     INNER JOIN CONFI_EMPRESA ON CONFI_EMPRESA.ID_CONFI_EMPRESA = USUARIO_EMPRESA.ID_CONFI_EMPRESA
                 WHERE ENTREGA_CARTA_AVAL.STATUS = 1 AND USUARIO.ID_USUARIO=".$usuario."
                       AND ENTREGA_CARTA_AVAL.ESTADO = 20 
                       AND ENTREGA_CARTA_AVAL.ID_ENTREGA_CARTA_AVAL=".$_REQUEST['num']." and ENTREGA_CARTA_AVAL.ID_CONFI_EMPRESA= ".$id_company;
                     //  echo $sql;
    }
        else if ($_REQUEST['funcion']=="carta_rech_remb"){
         
        
        $sql="SELECT DECODE(POLIZA.TIPO_POLIZA,'COL',(SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL ||CHR(13)||CLIENTE.DIRECCIOND) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_TOMADOR),(SELECT DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL||CHR(13)||CLIENTE.DIRECCIOND) FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE)) AS DIRIGIDA_A,
                   (SELECT CONTACTO.NOMBRE FROM CONTACTO WHERE CONTACTO.ID_CONTACTO = SOLICITUD_REEMBOLSO.ID_CONTACTO) AS CONTACTO,
                   DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS,CLIENTE.RAZON_SOCIAL) ||' '||CLIENTE.IDENTIFICATION AS TITULAR,
                   (SELECT 'Beneficiario: '|| CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ||' '||CLIENTE.IDENTIFICATION  FROM CLIENTE WHERE CLIENTE.ID_CLIENTE = SINIESTRO.ID_BENEFICIARIO) AS BENEFICIARIO,
                   SINIESTRO.CODIGO_SINIESTRO,
                   POLIZA.CODIGO_POLIZA,
                   SOLICITUD_REEMBOLSO.DIAGNOSTICO,
                   ASEGURADORA.NOMBRE AS NOMBRE_ASEGURADORA,
                   SINIESTRO.FDEC_SINIESTRO,
                   SINIESTRO.FDEC_SINIESTRO AS FECHA_OCURRENCIA,
                   ENTREGA_REEMBOLSO.CONTENIDO_CARTA,
                   ENTREGA_REEMBOLSO.MONTO,
                   ENTREGA_REEMBOLSO.MOTIVO,
                   ENTREGA_REEMBOLSO.OBSERVACION,
                   STATUS.DESCRIPCION AS ESTATUS,
                   USUARIO.NOMBRE AS USUARIO,
                   CONFI_EMPRESA.DIRECCION AS PIE_PAGINA
                FROM ENTREGA_REEMBOLSO
                     INNER JOIN SOLICITUD_REEMBOLSO ON SOLICITUD_REEMBOLSO.ID_SOLICITUD_REEMBOLSO = ENTREGA_REEMBOLSO.ID_SOLICITUD_REEMBOLSO
                     INNER JOIN SINIESTRO ON SINIESTRO.ID_SINIESTRO = SOLICITUD_REEMBOLSO.ID_SINIESTRO
                     INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                     INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                     INNER JOIN CLIENTE ON CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                     INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                     INNER JOIN STATUS ON STATUS.ID_STATUS = ENTREGA_REEMBOLSO.ESTADO,
                     USUARIO
                     INNER JOIN USUARIO_EMPRESA ON USUARIO_EMPRESA.id_usuario = USUARIO.ID_USUARIO
                     INNER JOIN CONFI_EMPRESA ON CONFI_EMPRESA.ID_CONFI_EMPRESA = USUARIO_EMPRESA.ID_CONFI_EMPRESA
                 WHERE ENTREGA_REEMBOLSO.STATUS = 1 AND USUARIO.ID_USUARIO=".$usuario."
                        AND ENTREGA_REEMBOLSO.ID_ENTREGA_REEMBOLSO= ".$_REQUEST['num']."
                        AND ENTREGA_REEMBOLSO.ESTADO = 20  and ENTREGA_REEMBOLSO.ID_CONFI_EMPRESA= ".$id_company;
                     //  echo $sql;
    }
    else if ($_REQUEST['funcion']=="report_orden_reparacion"){
         
        
        $sql="SELECT ORDEN_REPARACION.DANNOS,
                ORDEN_REPARACION.OBSERVACIONES,
                ORDEN_REPARACION.CODIGO_ORDEN,
                ORDEN_REPARACION.TOTAL_ORDEN,
                SINIESTRO.CODIGO_SINIESTRO,
                SINIESTRO.FECHA_SINIESTRO,
                POLIZA.CODIGO_POLIZA,
                POLIZA_TOMADOR.SUMA_ASEGURADA,
                CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS AS TITULAR,
                ASEGURADORA.NOMBRE AS ASEGURADORA,
                AUTOMOVIL.marca,
                AUTOMOVIL.modelo,
                AUTOMOVIL.placa,
                AUTOMOVIL.anno,
                AUTOMOVIL.color
                FROM ORDEN_REPARACION
                INNER JOIN SINIESTRO ON SINIESTRO.ID_SINIESTRO = ORDEN_REPARACION.ID_SINIESTRO
                INNER JOIN POLIZA_TOMADOR ON  POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                INNER JOIN CLIENTE ON CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                INNER JOIN POLIZA_AUTOMOVIL ON POLIZA_AUTOMOVIL.ID_POLIZA_AUTOMOVIL = SINIESTRO.ID_POLIZA_AUTOMOVIL
                INNER JOIN AUTOMOVIL ON AUTOMOVIL.ID_AUTOMOVIL = POLIZA_AUTOMOVIL.ID_AUTOMOVIL
            WHERE ORDEN_REPARACION.STATUS = 1 AND
                  ORDEN_REPARACION.ID_ORDEN_REPARACION=".$_REQUEST['num']." and ORDEN_REPARACION.ID_CONFI_EMPRESA= ".$id_company;
                     echo $sql;
    }
     else if ($_REQUEST['funcion']=="resumen_poliza_recibo_1" || $_REQUEST['funcion']=="resumen_poliza_recibo_col" || $_REQUEST['funcion']=="resumen_poliza_recibo_cert"){
        $sql="SELECT distinct P.ID_POLIZA AS ID_POLIZA,
                   P.CODIGO_POLIZA AS CODIGO_POLIZA,
                   TO_CHAR(P.VIGENCIA_DESDE,'DD/MM/YYYY') ||' al '|| TO_CHAR(P.VIGENCIA_HASTA,'DD/MM/YYYY') AS VIGENCIA_POLIZA,
                   S.DESCRIPCION AS ESTATUS_POLIZA,
                   C.NOMBRES||' '|| C.APELLIDOS AS NOMBRE_TITULAR,
                   C.DIRECCIOND AS  DIRECCION_TITULAR,
                   C.IDENTIFICATION AS CEDULARIF,
                   C.TELEFONOS AS TELEFONOS_TITULAR,
                   (SELECT DECODE(P.TIPO_POLIZA,'COL',C.RAZON_SOCIAL,C.NOMBRES||' '||C.APELLIDOS) 
                   FROM CLIENTE C WHERE C.ID_CLIENTE=PT.ID_TOMADOR ) AS TOMADOR,
                   A.NOMBRE AS ASEGURADORA,
                   PROD.NOMBRE AS PRODUCTOR,
                   E.NOMBRE AS NOMBRE_EJECUTIVO,
                   AR.NOMBRE AS RAMO,
                   (DECODE (P.ID_TIPO_SUSCRIPCION,'','INDIVIDUAL',(SELECT TS.DESCRIPCION FROM TIPO_SUSCRIPCION TS WHERE TS.ID_TIPO_SUSCRIPCION = P.ID_TIPO_SUSCRIPCION))) as descripcion
                  FROM POLIZA P
                        INNER JOIN STATUS S ON P.ESTADO= S.ID_STATUS
                        INNER JOIN POLIZA_TOMADOR PT ON PT.ID_POLIZA=P.ID_POLIZA
                        INNER JOIN PRODUCTOR PROD ON P.ID_PRODUCTOR=PROD.ID_PRODUCTOR
                        INNER JOIN ASEGURADORA A ON A.ID_ASEGURADORA=P.ID_ASEGURADORA";
                  if    ($_REQUEST['funcion']=="resumen_poliza_recibo_col"){
                       $sql.= " INNER JOIN CLIENTE C ON C.ID_CLIENTE=PT.ID_TOMADOR ";
                  }   
                  else {
                       $sql.= " INNER JOIN CLIENTE C ON C.ID_CLIENTE=PT.ID_CLIENTE ";          
                  }
               
                   
                      $sql.= "INNER JOIN EJECUTIVO E ON E.ID_EJECUTIVO=P.ID_EJECUTIVO
                        INNER JOIN PLAN PL ON PL.ID_PLAN=P.ID_PLAN
                        INNER JOIN RAMO RA ON RA.ID_RAMO= PL.ID_RAMO
                        INNER JOIN AREA AR ON AR.ID_AREA= RA.ID_AREA
                         
                  WHERE P.ID_POLIZA= ".$_REQUEST['num']. " AND PT.STATUS=1";
                  
                if ($_REQUEST['funcion']=="resumen_poliza_recibo_cert"){
                     $sql.=" AND C.IDENTIFICATION='".$_REQUEST['cedula']."'";  
                  }
                //echo $sql;
     }
     
      else if ($_REQUEST['funcion']=="modelo_solicitud_poliza"){
            $sql="SELECT distinct
                P.ID_POLIZA AS ID_POLIZA,
                P.CODIGO_POLIZA AS CODIGO_POLIZA,
                TO_CHAR(P.VIGENCIA_DESDE,'DD/MM/YYYY') ||' al '|| TO_CHAR(P.VIGENCIA_HASTA,'DD/MM/YYYY') AS VIGENCIA_POLIZA,
                S.DESCRIPCION AS ESTATUS_POLIZA,
                C.NOMBRES||' '|| C.APELLIDOS AS NOMBRE_TITULAR,
                C.DIRECCIOND AS  DIRECCION_TITULAR,
                C.IDENTIFICATION AS CEDULARIF,
                C.TELEFONOS AS TELEFONOS_TITULAR,
                (SELECT DECODE(P.TIPO_POLIZA,'IND',C.NOMBRES||' '||C.APELLIDOS,C.RAZON_SOCIAL)
                   FROM CLIENTE C WHERE C.ID_CLIENTE=PT.ID_TOMADOR ) AS TOMADOR,
                     A.NOMBRE AS ASEGURADORA,
                     PROD.NOMBRE AS PRODUCTOR,
                     E.NOMBRE AS NOMBRE_EJECUTIVO,
                     AR.NOMBRE AS RAMO,
                        (DECODE (P.ID_TIPO_SUSCRIPCION,'','INDIVIDUAL',(SELECT TS.DESCRIPCION FROM TIPO_SUSCRIPCION TS WHERE TS.ID_TIPO_SUSCRIPCION = P.ID_TIPO_SUSCRIPCION))) as descripcion
                FROM POLIZA P
                INNER JOIN STATUS S ON P.ESTADO= S.ID_STATUS
                INNER JOIN POLIZA_TOMADOR PT ON PT.ID_POLIZA=P.ID_POLIZA
                INNER JOIN PRODUCTOR PROD ON P.ID_PRODUCTOR=PROD.ID_PRODUCTOR
                INNER JOIN ASEGURADORA A ON A.ID_ASEGURADORA=P.ID_ASEGURADORA
                INNER JOIN CLIENTE C ON C.ID_CLIENTE=PT.ID_CLIENTE
                INNER JOIN EJECUTIVO E ON E.ID_EJECUTIVO=P.ID_EJECUTIVO
                INNER JOIN PLAN PL ON PL.ID_PLAN=P.ID_PLAN
                INNER JOIN RAMO RA ON RA.ID_RAMO= PL.ID_RAMO
                INNER JOIN AREA AR ON AR.ID_AREA= RA.ID_AREA              
                WHERE P.ID_POLIZA= ".$_REQUEST['num']. " AND PT.STATUS=1";
    
     }
     
    
    else if ($_REQUEST['funcion']=="carta_aum_sum_aseg"){
            $sql="select ajustepoliza.id_ajuste_poliza as idpoliza,
                       ajustepoliza.id_titular as idtitular,
                       titular.nombres as pre_nametitular,
                       titular.apellidos as last_nametitular,
                       ajustepoliza.id_tomador,
                       automovil.marca,
                       automovil.modelo,
                       automovil.anno,
                       automovil.color,
                       ajustepoliza.placa_actual,
                       contacto.nombre as nameContact,
                       poliza.codigo_poliza as codigoPoliza,
                       aseguradora.nombre as nameAseguradora,
                       ajustepoliza.observaciones,
                       ltrim(to_char(ajustepoliza.prima_asegurada,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = '',.''')) AS prima_asegurada
                  from AJUSTE_POLIZA ajustepoliza,
                       cliente titular,
                       automovil,
                       poliza,
                       aseguradora,
                       contactado,
                       contacto
                 where titular.id_cliente = ajustepoliza.id_titular
                       and automovil.id_automovil = ajustepoliza.id_automovil
                       and poliza.id_poliza = ajustepoliza.id_poliza
                       and aseguradora.id_aseguradora = poliza.id_aseguradora
                       and aseguradora.id_aseguradora = contactado.id_aseguradora
                       and contacto.id_contacto = contactado.id_contacto
                       and ajustepoliza.id_ajuste_poliza =".$_REQUEST['num']." 
                       and rownum <=1";
    
     }
     
      else if ($_REQUEST['funcion']=="carta_camb_plac"){
            $sql="select ajustepoliza.id_ajuste_poliza as idpoliza,
                       ajustepoliza.id_titular as idtitular,
                       titular.nombres as pre_nametitular,
                       titular.apellidos as last_nametitular,
                       ajustepoliza.id_tomador,
                       automovil.marca,
                       automovil.modelo,
                       automovil.anno,
                       automovil.color,
                       ajustepoliza.placa_actual,
                       ajustepoliza.placa_nueva,
                       contacto.nombre as nameContact,
                       poliza.codigo_poliza as codigoPoliza,
                       aseguradora.nombre as nameAseguradora
                  from AJUSTE_POLIZA ajustepoliza,
                       cliente titular,
                       automovil,
                       poliza,
                       aseguradora,
                       contactado,
                       contacto
                 where titular.id_cliente = ajustepoliza.id_titular
                       and automovil.id_automovil = ajustepoliza.id_automovil
                       and poliza.id_poliza = ajustepoliza.id_poliza
                       and aseguradora.id_aseguradora = poliza.id_aseguradora
                       and aseguradora.id_aseguradora = contactado.id_aseguradora
                       and contacto.id_contacto = contactado.id_contacto
                       and ajustepoliza.id_ajuste_poliza =".$_REQUEST['num']."
                       and rownum <=1
                       order by idpoliza"; //--Jose Luis indico que solo se va mostrar el primer registro que consiga de contacto
    
     }
      
     
    if ($_REQUEST['funcion']=="carta_sol_aval" || $_REQUEST['funcion']=="carta_ent_aval" || $_REQUEST['funcion']=="carta_sol_remb" 
    || $_REQUEST['funcion']=="carta_ent_cheque_indiv" || $_REQUEST['funcion']=="carta_ent_fin" || $_REQUEST['funcion']=="resumen_poliza_recibo" || $_REQUEST['funcion']=="carta_rech" 
    || $_REQUEST['funcion']=="carta_rech_remb" || $_REQUEST['funcion']=="report_orden_reparacion" || $_REQUEST['funcion']=="resumen_poliza_recibo_1" || $_REQUEST['funcion']=="modelo_solicitud_poliza" || $_REQUEST['funcion']=="resumen_poliza_recibo_col"
    || $_REQUEST['funcion']=="resumen_poliza_recibo_cert" || $_REQUEST['funcion']=="carta_aum_sum_aseg" || $_REQUEST['funcion']=="carta_camb_plac"){
      // echo $sql;
      $_SESSION['sistema']->xinv_rep->display_report($sql, $_REQUEST['funcion']);     
    }
    else if ($_REQUEST['funcion']=="report_listasegurados"){
         $arrayx = explode(',',$_REQUEST['param']);
         $tc=$arrayx[0];
         $st=$arrayx[8];
        
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         if ($arrayx[8]=='ANULADO'){
           $st ="INACTIVO";
         }
          if ($arrayx[0]==''){
           $tc="";
           $arrayx[0]="Todos los tipos de Cliente";
         }
         $sql= "SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
                    CLIENTE.IDENTIFICATION AS CLIENTE_IDENTIFICATION,
                    POLIZA.CODIGO_POLIZA AS COD_POLIZA,
                    RECIBO.CODIGO_RECIBO AS RECIBO,
                    RECIBO.PRIMA AS PRIMA,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    PLAN.NOMBRE AS NOMBRE_PLAN,
                    CLIENTE.TELEFONOS AS CLIENTE_TELEFONOS,
                    POLIZA.VIGENCIA_HASTA AS VIG_HASTA,
                    CLIENTE.DIRECCIOND AS CLIE_DIRECCION,
                    GRUPO_ASEGURADO.NOMBRE AS ASEGURADO_NOMBRE,
                    EJECUTIVO.NOMBRE AS EJEC_NOMBRE,
                    TO_CHAR(POLIZA.VIGENCIA_HASTA, 'MONTH') as MES
                    FROM
                    POLIZA
                    INNER JOIN RECIBO ON RECIBO.ID_POLIZA = POLIZA.ID_POLIZA
                    INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA = POLIZA.ID_POLIZA
                    INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                    LEFT JOIN GRUPO_ASEGURADO ON CLIENTE.ID_GRUPO_ASEGURADO = GRUPO_ASEGURADO.ID_GRUPO_ASEGURADO
                    INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                    INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                     INNER JOIN STATUS ON STATUS.ID_STATUS = CLIENTE.STATUS
                    WHERE
                    UPPER (CLIENTE.TIPO) LIKE '%".strtoupper($tc)."%'
                    AND  UPPER (STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%'
                    AND  CLIENTE.id_confi_empresa= '".$id_company. "'
                   ORDER BY
                    CLIENTE.NOMBRES,
                    POLIZA.VIGENCIA_HASTA,
                    POLIZA.STATUS";
        
        
    }
   

      
    else if ($_REQUEST['funcion']=="report_poliramo"){
         $arrayx = explode(',',$_REQUEST['param']);
         $ram=$arrayx[7];
         $aseg=$arrayx[4];
         $st=$arrayx[8];

         if ($arrayx[7]=='Todos los Ramos'){
            $ram="";
         }
         if ($arrayx[4]=='Todas las Aseguradoras'){
            $aseg="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= "SELECT
            DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
            POLIZA.CODIGO_POLIZA AS POLIZA_CODIGO_POLIZA,
            RECIBO.CODIGO_RECIBO AS RECIBO_CODIGO_RECIBO,
            PLAN.NOMBRE AS RAMO_NOMBRE,
            POLIZA_TOMADOR.PRIMA_ASEGURADA AS POLIZA_TOMADOR_PRIMA_ASEGURADA,
            EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE,
            POLIZA.VIGENCIA_HASTA AS POLIZA_VIGENCIA_HASTA,
            ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
            STATUS.DESCRIPCION
            FROM
            POLIZA
            INNER JOIN RECIBO ON RECIBO.ID_POLIZA = POLIZA.ID_POLIZA
            INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
            INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
            INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
            INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
            INNER JOIN PLAN ON POLIZA.ID_PLAN = PLAN.ID_PLAN
            INNER JOIN RAMO ON PLAN.ID_RAMO = RAMO.ID_RAMO
            INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.ESTADO
            WHERE
               POLIZA.VIGENCIA_HASTA BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy') 
               AND UPPER(ASEGURADORA.NOMBRE) LIKE '%".strtoupper($as)."%'
               AND UPPER(PLAN.NOMBRE) LIKE '%".strtoupper($ram)."%'
               AND UPPER(STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%' and POLIZA.id_confi_empresa= '".$id_company. "'
            ORDER BY
            PLAN.NOMBRE,
            CLIENTE.NOMBRES,
            POLIZA.VIGENCIA_HASTA,
            ASEGURADORA.NOMBRE,
            POLIZA.STATUS";
                  
    }
    else if ($_REQUEST['funcion']=="report_listaejecutivos"){
         $arrayx = explode(',',$_REQUEST['param']);
         $ej=$arrayx[5];
         $st=$arrayx[8];
         if($arrayx[5]=='Todos los Ejecutivos'){
            $ej="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         if ($arrayx[8]=='ANULADO'){
           $st ="INACTIVO";
         }
         $sql= "SELECT
                 EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE,
                 EJECUTIVO.TELEFONOS AS EJECUTIVO_TELEFONOS,
                 EJECUTIVO.DIRECCIOND AS EJECUTIVO_DIRECCIOND,
                 EJECUTIVO.DIRECCIONC AS EJECUTIVO_DIRECCIONC,
                 DECODE(STATUS.DESCRIPCION,'INACTIVO','ANULADO',STATUS.DESCRIPCION) AS STATUS_DESCRIPCION
            FROM
                 EJECUTIVO EJECUTIVO INNER JOIN STATUS STATUS ON EJECUTIVO.STATUS = STATUS.ID_STATUS
            
            WHERE
               UPPER (EJECUTIVO.NOMBRE) LIKE '%".strtoupper($ej)."%'
               AND  UPPER (STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%' AND EJECUTIVO.id_confi_empresa= '".$id_company. "'
            ORDER BY
            EJECUTIVO_NOMBRE";
       
    }
    else if ($_REQUEST['funcion']=="report_aseggrupoyasegejecutivo" ){ //quiere decir que se va utilizar para asegurados por ejecutivos 
         $arrayx = explode(',',$_REQUEST['param']);
         $ej=$arrayx[5];
         $st=$arrayx[8];
         $mes= $arrayx[1];
         $tc= $arrayx[0];
         $gr=$arrayx[6];
         
         
         if ($arrayx[1]=='Todos los Meses'){
           $mes ="";
         }
         if ($arrayx[0]==""){
           $tc ="";
           $arrayx[0]="Todos los Tipos de Cliente"; 
         }
       
       if ($arrayx[11]=='Asegurados Por Ejecutivo'){
            
            if($arrayx[5]=='Todos los Ejecutivos'){
                $ej="";
             }
            $arrayx[6]="";
            $whereorder=" WHERE
                            upper (EJECUTIVO.NOMBRE) LIKE '%".strtoupper($ej)."%'
                            AND upper (CLIENTE.TIPO) LIKE '%".strtoupper($tc)."%'
                            AND TO_CHAR(POLIZA.VIGENCIA_HASTA, 'MONTH') LIKE'%".strtoupper($mes)."%' 
                            AND EJECUTIVO.id_confi_empresa= '".$id_company. "'
                            
                            ORDER BY
                            EJECUTIVO.NOMBRE"; 
           
             
      }
      else if ($arrayx[11] == 'Asegurados Por Grupo'){
        
         if($arrayx[6]=='Todos los Grupos Asegurados'){
            $gr="";
         }
        
            $arrayx[5]="";
          
            $whereorder=" WHERE
                            upper (GRUPO_ASEGURADO.NOMBRE) LIKE '%".strtoupper($gr)."%'
                            AND upper (CLIENTE.TIPO) LIKE '%".strtoupper($tc)."%'
                            AND TO_CHAR(POLIZA.VIGENCIA_HASTA, 'MONTH') LIKE'%".strtoupper($mes)."%' 
                            AND GRUPO_ASEGURADO.id_confi_empresa= '".$id_company. "'
                           ORDER BY
                            GRUPO_ASEGURADO.NOMBRE ";
                           
        
      }
      
      $sql= "SELECT
                        DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
                        CLIENTE.IDENTIFICATION AS CLIENTE_IDENTIFICATION,
                        POLIZA.CODIGO_POLIZA AS COD_POLIZA,
                        PLAN.NOMBRE AS RAMO_TIPO_NOMBRE,
                        CLIENTE.TELEFONOS AS CLIENTE_TELEFONOS,
                        POLIZA.VIGENCIA_HASTA AS VIG_HASTA,
                        CLIENTE.DIRECCIOND AS CLIE_DIRECCION,
                        GRUPO_ASEGURADO.NOMBRE AS ASEGURADO_NOMBRE,
                        GRUPO_ASEGURADO.ID_GRUPO_ASEGURADO AS ID_GRUPO_ASEGU,
                        EJECUTIVO.ID_EJECUTIVO AS EJECUTIVO,
                        EJECUTIVO.NOMBRE AS EJEC_NOMBRE,
                        TO_CHAR(POLIZA.VIGENCIA_HASTA, 'MONTH')
                        FROM
                        POLIZA
                        INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA = POLIZA.ID_POLIZA
                        INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                        --INNER JOIN GRUPO_ASEGURADO ON CLIENTE.ID_GRUPO_ASEGURADO = GRUPO_ASEGURADO.ID_GRUPO_ASEGURADO
                        INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                        INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                       	LEFT JOIN GRUPO_ASEGURADO ON CLIENTE.ID_GRUPO_ASEGURADO = GRUPO_ASEGURADO.ID_GRUPO_ASEGURADO
                        INNER JOIN RAMO ON RAMO.ID_RAMO=PLAN.ID_RAMO ". $whereorder;
          echo $sql; 
            
    }
     else if ($_REQUEST['funcion']=="report_solicpolizas"){
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $st=$arrayx[8];
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
      
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         $est="18";
         /*$sql= "SELECT
                     DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
                     SOLICITUD_POLIZA.ID_SOLICITUD_POLIZA AS SOLICITUD_POLIZA_ID_SOLICITUD_,
                     ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                     STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                     EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE,
                     PLAN.NOMBRE AS RAMO_NOMBRE,
                     SOLICITUD_POLIZA.FECHA_ENVIO AS SOLICITUD_POLIZA_FECHA_ENVIO,
                     SOLICITUD_POLIZA.FECHA_CREACION AS SOLICITUD_POLIZA_FECHA_CREACIO
                FROM
                     SOLICITUD_POLIZA
                     INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA= SOLICITUD_POLIZA.ID_ASEGURADORA
                     INNER JOIN EJECUTIVO ON SOLICITUD_POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                     INNER JOIN CLIENTE ON SOLICITUD_POLIZA.ID_CLIENTE = CLIENTE.ID_CLIENTE
                     INNER JOIN PLAN ON PLAN.ID_PLAN = SOLICITUD_POLIZA.ID_PLAN
                     INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                     INNER JOIN STATUS STATUS ON SOLICITUD_POLIZA.ESTADO = STATUS.ID_STATUS
                WHERE
                   SOLICITUD_POLIZA.FECHA_CREACION BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                   AND upper(ASEGURADORA.NOMBRE) LIKE '%".strtoupper($as)."%'
                   AND upper(STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%'
                   AND SOLICITUD_POLIZA.id_confi_empresa= '".$id_company. "'
                ORDER BY
                SOLICITUD_POLIZA.FECHA_CREACION,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION";
                AND POLIZA.FECHA_CREACION BETWEEN  
                POLIZA.ESTADO = 18
                AND upper(ASEGURADORA.NOMBRE) LIKE '%%'
                AND upper(STATUS.DESCRIPCION) LIKE '%%'
                AND POLIZA.ID_CONFI_EMPRESA= '1'
                
                */
                
                $sql="SELECT
                            POLIZA.ID_POLIZA AS SOL_POLIZA_ID_SOLICITUD,
                            TOMADORES_VIEW.TOMADORES,
                            TOMADORES_VIEW.IDENTIFICATION,
                            --TITULARES_VIEW.TITULARES,
                            --TITULARES_VIEW.IDENTIFICATION,
                            ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                            EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE,
                            PLAN.NOMBRE AS RAMO_NOMBRE,                   
                            POLIZA.FECHA_CREACION AS SOL_POLIZA_FECHA_CREACIO,
                            STATUS.DESCRIPCION
                        FROM
                        POLIZA
                            INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                            INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                            INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                            INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                            INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.ESTADO
                            INNER JOIN TITULARES_VIEW ON TITULARES_VIEW.ID_POLIZA = POLIZA.ID_POLIZA
                            INNER JOIN TOMADORES_VIEW ON TOMADORES_VIEW.ID_POLIZA = POLIZA.ID_POLIZA
                        WHERE
                            POLIZA.ESTADO = '".$est."'
                            AND POLIZA.FECHA_CREACION BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                            AND UPPER(ASEGURADORA.NOMBRE) LIKE '%".strtoupper($as)."%'
                            AND UPPER(STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%'";
           //echo $sql;
    }
    else if ($_REQUEST['funcion']=="report_poliasegurado"){
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $ra=$arrayx[7];
         $st=$arrayx[8];
         $be= $arrayx[3];
         if($arrayx[3]=='Todos los Asegurados'){
            $be="";
         }
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[7]=='Todos los Ramos'){
           $ra ="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         $sql= "SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
                    POLIZA.CODIGO_POLIZA AS POLIZA_CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO AS RECIBO_CODIGO_RECIBO,
                    PLAN.NOMBRE AS RAMO_NOMBRE,
                    POLIZA_TOMADOR.PRIMA_ASEGURADA AS POLIZA_TOMADOR_PRIMA_ASEGURADA,
                    EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE,
                    POLIZA.VIGENCIA_HASTA AS POLIZA_VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                    STATUS.DESCRIPCION
                    FROM
                    POLIZA
                    INNER JOIN RECIBO ON RECIBO.ID_POLIZA = POLIZA.ID_POLIZA
                    INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                    INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                    INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                    INNER JOIN PLAN ON POLIZA.ID_PLAN = PLAN.ID_PLAN
                    INNER JOIN RAMO ON PLAN.ID_RAMO = RAMO.ID_RAMO
                    INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.STATUS
                    WHERE
                       upper(CLIENTE.NOMBRES||' ' ||CLIENTE.APELLIDOS) LIKE '%".strtoupper($be)."%'
                       AND POLIZA.VIGENCIA_HASTA BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy') 
                       AND UPPER(ASEGURADORA.NOMBRE) LIKE '%".strtoupper($as)."%'
                       AND UPPER(PLAN.NOMBRE) LIKE '%".strtoupper($ra)."%'
                       AND UPPER(STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%'
                       AND POLIZA.id_confi_empresa= '".$id_company. "'
                    ORDER BY
                    CLIENTE.NOMBRES,
                    POLIZA.VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE,
                    PLAN.NOMBRE,
                    POLIZA.STATUS";
     }
    
      else if ($_REQUEST['funcion']=="report_poliaseguradora"){
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $ra=$arrayx[7];
         $st=$arrayx[8];
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[7]=='Todos los Ramos'){
           $ra ="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         $sql= "SELECT
                     DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
                    POLIZA.CODIGO_POLIZA AS POLIZA_CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO AS RECIBO_CODIGO_RECIBO,
                    PLAN.NOMBRE AS RAMO_NOMBRE,
                    POLIZA_TOMADOR.PRIMA_ASEGURADA AS POLIZA_TOMADOR_PRIMA_ASEGURADA,
                    EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE,
                    POLIZA.VIGENCIA_HASTA AS POLIZA_VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                    STATUS.DESCRIPCION
                    FROM
                    POLIZA
                    INNER JOIN RECIBO ON RECIBO.ID_POLIZA = POLIZA.ID_POLIZA
                    INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                    INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                    INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                    INNER JOIN PLAN ON POLIZA.ID_PLAN = PLAN.ID_PLAN
                    INNER JOIN RAMO ON PLAN.ID_RAMO = RAMO.ID_RAMO
                    INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.STATUS
                    WHERE
                       POLIZA.VIGENCIA_HASTA BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy') 
                       AND UPPER(ASEGURADORA.NOMBRE) LIKE '%".strtoupper($as)."%'
                       AND UPPER(PLAN.NOMBRE) LIKE '%".strtoupper($ra)."%'
                       AND UPPER(STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%'
                       AND POLIZA.id_confi_empresa= '".$id_company. "'
                    ORDER BY
                    ASEGURADORA.NOMBRE,
                    CLIENTE.NOMBRES,
                    POLIZA.VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE,
                    PLAN.NOMBRE,
                    POLIZA.STATUS";
     }
         else if ($_REQUEST['funcion']=="report_poligrupoasegurado"){
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $ra=$arrayx[7];
         $st=$arrayx[8];
         $ga=$arrayx[6];
         if($arrayx[6]=='Todos los Grupos Asegurados'){
            $ga="";
         }
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[7]=='Todos los Ramos'){
           $ra ="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= "SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
                    POLIZA.CODIGO_POLIZA AS POLIZA_CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO AS RECIBO_CODIGO_RECIBO,
                    PLAN.NOMBRE AS RAMO_NOMBRE,
                    POLIZA_TOMADOR.PRIMA_ASEGURADA AS POLIZA_TOMADOR_PRIMA_ASEGURADA,
                    EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE,
                    POLIZA.VIGENCIA_HASTA AS POLIZA_VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                    STATUS.DESCRIPCION,
                    NVL(GRUPO_ASEGURADO.NOMBRE,'') AS GRUPO_ASEGURADO
                    FROM
                    POLIZA
                    INNER JOIN RECIBO ON RECIBO.ID_POLIZA = POLIZA.ID_POLIZA
                    INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                    INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                    INNER JOIN GRUPO_ASEGURADO ON GRUPO_ASEGURADO.ID_GRUPO_ASEGURADO = CLIENTE.ID_GRUPO_ASEGURADO
                    INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                    INNER JOIN PLAN ON POLIZA.ID_PLAN = PLAN.ID_PLAN
                    INNER JOIN RAMO ON PLAN.ID_RAMO = RAMO.ID_RAMO
                    INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.STATUS
                    WHERE
                       UPPER(GRUPO_ASEGURADO.NOMBRE) LIKE '%".strtoupper($ga)."%'
                       AND POLIZA.VIGENCIA_HASTA BETWEEN to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy') 
                       AND UPPER(ASEGURADORA.NOMBRE) LIKE '%".strtoupper($as)."%'
                       AND UPPER(PLAN.NOMBRE) LIKE '%".strtoupper($ra)."%'
                       AND UPPER(STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%'
                       AND POLIZA.id_confi_empresa= '".$id_company. "'
                    ORDER BY
                    GRUPO_ASEGURADO.NOMBRE,
                    CLIENTE.NOMBRES,
                    POLIZA.VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE,
                    PLAN.NOMBRE,
                    POLIZA.STATUS";
        
     }
     else if ($_REQUEST['funcion']=="report_polejecutivo"){
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $ra=$arrayx[7];
         $st=$arrayx[8];
         $ej=$arrayx[5];
         if($arrayx[5]=='Todos los Ejecutivos'){
            $ej="";
         }
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[7]=='Todos los Ramos'){
           $ra ="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= "SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
                    POLIZA.CODIGO_POLIZA AS POLIZA_CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO AS RECIBO_CODIGO_RECIBO,
                    PLAN.NOMBRE AS RAMO_NOMBRE,
                    POLIZA_TOMADOR.PRIMA_ASEGURADA AS POLIZA_TOMADOR_PRIMA_ASEGURADA,
                    EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE,
                    POLIZA.VIGENCIA_HASTA AS POLIZA_VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                    STATUS.DESCRIPCION
                    FROM
                    POLIZA
                    INNER JOIN RECIBO ON RECIBO.ID_POLIZA = POLIZA.ID_POLIZA
                    INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                    INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                    INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                    INNER JOIN PLAN ON POLIZA.ID_PLAN = PLAN.ID_PLAN
                    INNER JOIN RAMO ON PLAN.ID_RAMO = RAMO.ID_RAMO
                    INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.STATUS
                    WHERE
                       UPPER (EJECUTIVO.NOMBRE) LIKE '%".strtoupper($ej)."%'
                       and POLIZA.VIGENCIA_HASTA BETWEEN to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                       AND UPPER(ASEGURADORA.NOMBRE) LIKE '%".strtoupper($as)."%'
                       AND UPPER(PLAN.NOMBRE) LIKE '%".strtoupper($ra)."%'
                       AND UPPER(STATUS.DESCRIPCION) LIKE '%".strtoupper($st)."%'
                       AND POLIZA.id_confi_empresa= '".$id_company. "'
                    ORDER BY
                    EJECUTIVO.NOMBRE,
                    CLIENTE.NOMBRES,
                    POLIZA.VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE,
                    PLAN.NOMBRE,
                    POLIZA.STATUS";
                    //echo $sql;
        
     }
      else if ($_REQUEST['funcion']=="report_vehflota"){
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $st=$arrayx[8];
         $be=$arrayx[3];
         $pl=$arrayx[2];
          
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if($arrayx[3]=='Todos los Asegurados'){
            $be="";
         }
         
        if($arrayx[2]==''){
          
          $arrayx[2]="Todos los Nros De Poliza";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= "SELECT POLIZA.VIGENCIA_HASTA   AS POLIZA_VIGENCIA_HASTA,
                   POLIZA_TOMADOR.SUMA_ASEGURADA  AS POLIZA_TOMADOR_SUMA_ASEGURADA,
                   POLIZA_TOMADOR.CERTIFICADO     AS POLIZA_TOMADOR_CERTIFICADO,
                   POLIZA_TOMADOR.PRIMA_ASEGURADA AS POLIZA_TOMADOR_PRIMA_ASEGURADA,
                   CLIENTE.NOMBRES||' '||CLIENTE.APELLIDOS   AS CLIENTE_NOMBRES,
                   AUTOMOVIL.MARCA   AS AUTOMOVIL_MARCA,
                   AUTOMOVIL.MODELO  AS AUTOMOVIL_MODELO,
                   AUTOMOVIL.PLACA   AS AUTOMOVIL_PLACA,
                   AUTOMOVIL.ANNO    AS AUTOMOVIL_ANNO,
                   RECIBO.CODIGO_RECIBO AS CODIGO_RECIBO,
                   POLIZA.CODIGO_POLIZA,
                   STATUS.DESCRIPCION
              FROM  POLIZA
            INNER JOIN RECIBO ON RECIBO.ID_POLIZA = POLIZA.ID_POLIZA
            INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
            INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
            INNER JOIN POLIZA_AUTOMOVIL ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = POLIZA_AUTOMOVIL.ID_POLIZA_TOMADOR
            INNER JOIN AUTOMOVIL ON POLIZA_AUTOMOVIL.ID_AUTOMOVIL = AUTOMOVIL.ID_AUTOMOVIL
            INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA= ASEGURADORA.ID_ASEGURADORA
            INNER JOIN STATUS  ON  STATUS.ID_STATUS= POLIZA.ESTADO
            INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
            INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
            INNER JOIN AREA ON AREA.ID_AREA = RAMO.ID_AREA
            WHERE upper(POLIZA.TIPO_POLIZA) = upper('COL')
               AND AREA.NOMBRE='AUTOMOVIL'
               AND POLIZA.CODIGO_POLIZA LIKE '%".$pl."%' 
               AND upper(CLIENTE.NOMBRES) LIKE '%".$be."%'
               AND POLIZA.VIGENCIA_HASTA BETWEEN to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
               AND ASEGURADORA.NOMBRE LIKE '%".$as."%'
               AND STATUS.DESCRIPCION LIKE '%".$st."%' 
               AND POLIZA.id_confi_empresa= '".$id_company. "'
            ORDER BY
                CLIENTE.NOMBRES";
               //   echo $sql;
        
     }  
       
     
 
      else if ($_REQUEST['funcion']=="report_renov_men"){
        
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $st=$arrayx[8];
         
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if($arrayx[3]=='Todos los Asegurados'){
            $be="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= "SELECT
                     DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)AS CLIENTE_NOMBRES,
                     ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                     POLIZA.CODIGO_POLIZA AS POLIZA_CODIGO_POLIZA,
                     RECIBO.CODIGO_RECIBO AS RECIBO_CODIGO_RECIBO,
                     POLIZA.RENOVABLE AS POLIZA_RENOVABLE,
                     PLAN.NOMBRE AS RAMO_TIPO_NOMBRE,
                      STATUS.DESCRIPCION,
                     TO_CHAR(POLIZA.VIGENCIA_DESDE,'DD/MM/YYYY') ||' al '|| TO_CHAR(POLIZA.VIGENCIA_HASTA,'DD/MM/YYYY') AS VIGENCIA
                FROM
                     POLIZA
                     INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                     INNER JOIN RECIBO ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                     INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA = POLIZA.ID_POLIZA
                     INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                     INNER JOIN PLAN ON POLIZA.ID_POLIZA = PLAN.ID_PLAN
                     INNER JOIN STATUS ON STATUS.ID_STATUS = RECIBO.ESTADO
                WHERE UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%' 
                    AND POLIZA.VIGENCIA_HASTA BETWEEN to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND RECIBO.TIPO_RECIBO = '1' 
                    AND RECIBO.id_confi_empresa= '".$id_company. "'
                ORDER BY POLIZA.VIGENCIA_HASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                PLAN.NOMBRE";
              
            
        
     }   
     else if ($_REQUEST['funcion']=="report_list_renov_aseg"){
        
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $st=$arrayx[8];
         $be=$arrayx[3];
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if($arrayx[3]=='Todos los Asegurados'){
            $be="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= " SELECT
                     DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL) AS CLIENTE_NOMBRES,
                     ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                     POLIZA.CODIGO_POLIZA AS POLIZA_CODIGO_POLIZA,
                     RECIBO.CODIGO_RECIBO AS RECIBO_CODIGO_RECIBO,
                     POLIZA.RENOVABLE AS POLIZA_RENOVABLE,
                     PLAN.NOMBRE AS RAMO_TIPO_NOMBRE,
                     STATUS.DESCRIPCION,
                     TO_CHAR(POLIZA.VIGENCIA_DESDE,'DD/MM/YYYY') ||' al '|| TO_CHAR(POLIZA.VIGENCIA_HASTA,'DD/MM/YYYY') AS VIGENCIA
                FROM
                     POLIZA
                     INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                     INNER JOIN RECIBO ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                     INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA = POLIZA.ID_POLIZA
                     INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                     INNER JOIN PLAN ON POLIZA.ID_POLIZA = PLAN.ID_PLAN
                     INNER JOIN STATUS ON STATUS.ID_STATUS = RECIBO.ESTADO
                WHERE POLIZA.STATUS=1
                    AND RECIBO.TIPO_RECIBO = '1' 
                    AND CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS LIKE '%".$be."%'
                    AND POLIZA.VIGENCIA_HASTA BETWEEN to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%' 
                    AND RECIBO.id_confi_empresa= '".$id_company. "'                    
                ORDER BY CLIENTE.NOMBRES,POLIZA.VIGENCIA_HASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                PLAN.NOMBRE";
              
            
        
     }  
    else if ($_REQUEST['funcion']=="report_list_renov_ejec"){
        
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $st=$arrayx[8];
        
         $ej=$arrayx[5];
         if($arrayx[5]=='Todos los Ejecutivos'){
            $ej="";
         }
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= "SELECT EJECUTIVO.NOMBRE AS NOMBRE_EJECUTIVO,
                 CLIENTE.NOMBRES||' '||CLIENTE.APELLIDOS AS CLIENTE_NOMBRES,
                 ASEGURADORA.NOMBRE AS ASEGURADORA_NOMBRE,
                 POLIZA.CODIGO_POLIZA AS POLIZA_CODIGO_POLIZA,
                 RECIBO.CODIGO_RECIBO AS RECIBO_CODIGO_RECIBO,
                 POLIZA.RENOVABLE AS POLIZA_RENOVABLE,
                 PLAN.NOMBRE AS RAMO_TIPO_NOMBRE,
                 STATUS.DESCRIPCION,
                 TO_CHAR(POLIZA.VIGENCIA_DESDE,'DD/MM/YYYY') ||' al '|| TO_CHAR(POLIZA.VIGENCIA_HASTA,'DD/MM/YYYY') AS VIGENCIA
            FROM
                 POLIZA
                 INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                 INNER JOIN EJECUTIVO ON  EJECUTIVO.ID_EJECUTIVO =  POLIZA.ID_EJECUTIVO
                 INNER JOIN RECIBO ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                 INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA = POLIZA.ID_POLIZA
                 INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                 INNER JOIN PLAN ON POLIZA.ID_POLIZA = PLAN.ID_PLAN
                 INNER JOIN STATUS ON STATUS.ID_STATUS = RECIBO.ESTADO
            WHERE POLIZA.STATUS=1
                AND RECIBO.TIPO_RECIBO = '1'
                AND EJECUTIVO.NOMBRE LIKE '%".$ej."%'
                AND POLIZA.VIGENCIA_HASTA BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                AND ASEGURADORA.NOMBRE like '%".$as."%' 
                AND RECIBO.id_confi_empresa= '".$id_company. "'      
            ORDER BY EJECUTIVO.NOMBRE,POLIZA.VIGENCIA_HASTA,
            ASEGURADORA.NOMBRE,
            STATUS.DESCRIPCION,
            PLAN.NOMBRE ";
              
            
        
     }  
       else if ($_REQUEST['funcion']=="report_recibo_periodo"){
        
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $st=$arrayx[8];
        
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= " SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL) AS ASEGURADO,
                    POLIZA.CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO,
                    RAMO.NOMBRE AS RAMO,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                    to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA
                    FROM RECIBO
                      INNER JOIN POLIZA  ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                WHERE
                
                    RECIBO.FHASTA BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%' 
                    and RECIBO.ESTADO=12  
                    AND RECIBO.id_confi_empresa= '".$id_company. "'      
                ORDER BY RECIBO.FHASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                RAMO.NOMBRE";
          
     }
     else if ($_REQUEST['funcion']=="report_recibo_cob_periodo"){
        
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $st=$arrayx[8];
        
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= " SELECT
                   DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL) AS ASEGURADO,
                    POLIZA.CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO,
                    RAMO.NOMBRE AS RAMO,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                    to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA
                    FROM RECIBO
                      INNER JOIN POLIZA  ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                WHERE
                    RECIBO.FHASTA BETWEEN   to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%'
                    AND RECIBO.status = 1
                    and RECIBO.ESTADO=5
                    AND RECIBO.id_confi_empresa= '".$id_company. "'        
                ORDER BY RECIBO.FHASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                RAMO.NOMBRE";
        
     }
          else if ($_REQUEST['funcion']=="report_recibo_cob_periodo"){
        
         $arrayx = explode(',',$_REQUEST['param']);
         $as=$arrayx[4];
         $st=$arrayx[8];
        
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
         
         $sql= " SELECT
                   DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL) AS ASEGURADO,
                    POLIZA.CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO,
                    RAMO.NOMBRE AS RAMO,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                    to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA
                    FROM RECIBO
                      INNER JOIN POLIZA  ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                WHERE
                    RECIBO.FHASTA BETWEEN   to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%'
                    AND RECIBO.status = 1
                    and RECIBO.ESTADO=5  
                    AND RECIBO.id_confi_empresa= '".$id_company. "'      
                ORDER BY RECIBO.FHASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                RAMO.NOMBRE";
        
     }   
    else if ($_REQUEST['funcion']=="report_recibo_pen_aseg"){
        
         $arrayx = explode(',',$_REQUEST['param']);
      
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         $be= $arrayx [3];
  
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
        if ($arrayx[3]=='Todos los Asegurados'){
           $be ="";
         }
         
         $sql= " SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL) AS ASEGURADO,
                    POLIZA.CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO,
                    RAMO.NOMBRE AS RAMO,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                    to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA
                    FROM RECIBO
                      INNER JOIN POLIZA  ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                WHERE
                   RECIBO.FHASTA BETWEEN   to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%'
                    AND UPPER (CLIENTE.NOMBRES||' '||CLIENTE.APELLIDOS) like '%".strtoupper($be)."%'
                    AND RECIBO.status = 1
                    and RECIBO.ESTADO=12 
                      AND RECIBO.id_confi_empresa= '".$id_company. "'      
                ORDER BY CLIENTE.NOMBRES,
                RECIBO.FHASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                RAMO.NOMBRE";
       // $arrayx[4]=str_replace($arrayx[4],"% ",",");
     }    
         else if ($_REQUEST['funcion']=="report_recibo_cob_aeg"){
        
         $arrayx = explode(',',$_REQUEST['param']);
      
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         $be= $arrayx [3];
  
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
        if ($arrayx[3]=='Todos los Asegurados'){
           $be ="";
         }
         
         $sql= " SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS , CLIENTE.RAZON_SOCIAL) AS ASEGURADO,
                    POLIZA.CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO,
                    RAMO.NOMBRE AS RAMO,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                    to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA
                    FROM RECIBO
                      INNER JOIN POLIZA  ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                WHERE
                   RECIBO.FHASTA BETWEEN   to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%'
                    AND UPPER (CLIENTE.NOMBRES||' '||CLIENTE.APELLIDOS) like '%".strtoupper($be)."%'
                    AND RECIBO.status = 1
                    and RECIBO.ESTADO=12 
                      AND RECIBO.id_confi_empresa= '".$id_company. "'      
                ORDER BY CLIENTE.NOMBRES,
                RECIBO.FHASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                RAMO.NOMBRE";
       // $arrayx[4]=str_replace($arrayx[4],"% ",",");
     }     
        else if ($_REQUEST['funcion']=="report_recibo_pen_aseg"){
        
         $arrayx = explode(',',$_REQUEST['param']);
      
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         $be= $arrayx [3];
  
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
        if ($arrayx[3]=='Todos los Asegurados'){
           $be ="";
         }
         
         $sql= " SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL) AS ASEGURADO,
                    POLIZA.CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO,
                    RAMO.NOMBRE AS RAMO,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                    to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA
                    FROM RECIBO
                      INNER JOIN POLIZA  ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                WHERE
                   RECIBO.FHASTA BETWEEN   to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%'
                    AND UPPER (CLIENTE.NOMBRES||' '||CLIENTE.APELLIDOS) like '%".strtoupper($be)."%'
                    AND RECIBO.status = 1
                    and RECIBO.ESTADO=12 
                      AND RECIBO.id_confi_empresa= '".$id_company. "'      
                ORDER BY CLIENTE.NOMBRES,
                RECIBO.FHASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                RAMO.NOMBRE";
       // $arrayx[4]=str_replace($arrayx[4],"% ",",");
     }    
    else if ($_REQUEST['funcion']=="report_recibo_cob_aeg"){
        
         $arrayx = explode(',',$_REQUEST['param']);
      
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         $be= $arrayx [3];
  
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
        if ($arrayx[3]=='Todos los Asegurados'){
           $be ="";
         }
         
         $sql= " SELECT
                   DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL) AS ASEGURADO,
                    POLIZA.CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO,
                    RAMO.NOMBRE AS RAMO,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                    to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA
                    FROM RECIBO
                      INNER JOIN POLIZA  ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                WHERE
                    RECIBO.FHASTA BETWEEN   to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                    AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                    AND ASEGURADORA.NOMBRE like '%".$as."%'
                    AND UPPER (CLIENTE.NOMBRES||' '||CLIENTE.APELLIDOS) like '%".strtoupper($be)."%'
                    AND RECIBO.status = 1
                    AND RECIBO.ESTADO = 5 
                      AND RECIBO.id_confi_empresa= '".$id_company. "'      
                ORDER BY CLIENTE.NOMBRES,
                RECIBO.FHASTA,
                ASEGURADORA.NOMBRE,
                STATUS.DESCRIPCION,
                RAMO.NOMBRE";
       // $arrayx[4]=str_replace($arrayx[4],"% ",",");
     }      
     else if ($_REQUEST['funcion']=="report_recibo_pen_ejec"){
        
         $arrayx = explode(',',$_REQUEST['param']);
      
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         $ej=$arrayx[5];
         
         if($arrayx[5]=='Todos los Ejecutivos'){
            $ej="";
         }
  
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
      
         
         $sql= "SELECT
                    DECODE (CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL)  AS ASEGURADO,
                    POLIZA.CODIGO_POLIZA,
                    RECIBO.CODIGO_RECIBO,
                    RAMO.NOMBRE AS RAMO,
                    ASEGURADORA.NOMBRE AS ASEGURADORA,
                    STATUS.DESCRIPCION AS STATUS_DESCRIPCION,
                    to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY') AS VIGENCIA,
                    EJECUTIVO.NOMBRE AS EJECUTIVO_NOMBRE
                    FROM RECIBO
                      INNER JOIN POLIZA  ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                      INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN ASEGURADORA ON POLIZA.ID_ASEGURADORA = ASEGURADORA.ID_ASEGURADORA
                      INNER JOIN STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                      INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    WHERE
                        RECIBO.FHASTA BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                        AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                        AND ASEGURADORA.NOMBRE like '%".$as."%'
                        AND UPPER (EJECUTIVO.NOMBRE) like '%".strtoupper($ej)."%'
                        AND RECIBO.status = 1
                        and RECIBO.ESTADO=12 
                          AND RECIBO.id_confi_empresa= '".$id_company. "'      
                    ORDER BY EJECUTIVO.NOMBRE,
                    RECIBO.FHASTA,
                    ASEGURADORA.NOMBRE,
                    STATUS.DESCRIPCION,
                    RAMO.NOMBRE";
       
     }    
    else if ($_REQUEST['funcion']=="report_recibo_cob_ejec"){
        
         $arrayx = explode(',',$_REQUEST['param']);
      
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         
         $ej=$arrayx[5];
         if($arrayx[5]=='Todos los Ejecutivos'){
            $ej="";
         }
  
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
    
         
         $sql= "SELECT * FROM
                    (SELECT MAX(DECODE(CLIENTE.TIPO,'CLN',CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS ,CLIENTE.RAZON_SOCIAL))  AS ASEGURADO,
                    MAX(POLIZA.CODIGO_POLIZA) AS CODIGO_POLIZA,
                    MAX(RECIBO.CODIGO_RECIBO) AS CODIGO_RECIBO,
                    MAX(RECIBO.PRIMA) AS MONTO_PRIMA,
                    MAX(RAMO.NOMBRE) AS RAMO_NOMBRE,
                    MAX(ASEGURADORA.NOMBRE) AS ASEGURADORA_NOMBRE,
                    MAX(to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY')) AS VIGENCIA,
                    MAX(STATUS.DESCRIPCION) AS ESTATUS,
                    MAX(RECIBO.FHASTA) AS FHASTA,
                    MAX(EJECUTIVO.NOMBRE)  AS EJECUTIVO_NOMBRE
                    FROM RECIBO
                      INNER JOIN POLIZA ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA = POLIZA.ID_POLIZA
                      INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                      INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA= POLIZA.ID_ASEGURADORA
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN STATUS STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                      INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    WHERE
                       RECIBO.FHASTA BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                         AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                        AND ASEGURADORA.NOMBRE like '%".$as."%'
                        AND EJECUTIVO.NOMBRE like '%".$ej."%'
                        AND RECIBO.status = 1
                          AND RECIBO.id_confi_empresa= '".$id_company. "'      
                        group by RECIBO.ID_POLIZA,POLIZA_TOMADOR.ID_TOMADOR,POLIZA_TOMADOR.ID_CLIENTE)
                    ORDER BY FHASTA,
                    ASEGURADORA_NOMBRE,
                    ESTATUS,
                    RAMO_NOMBRE";
       // $arrayx[4]=str_replace($arrayx[4],"% ",",");
     }  
         else if ($_REQUEST['funcion']=="report_prim_cob_pen"){
        
         $arrayx = explode(',',$_REQUEST['param']);
      
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         
         $ej=$arrayx[5];
         if($arrayx[5]=='Todos los Ejecutivos'){
            $ej="";
         }
  
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
    
         
         $sql= "SELECT * FROM
                    (SELECT MAX(CLIENTE.NOMBRES||' '||CLIENTE.APELLIDOS) AS CLIENTE_NOMBRES,
                    MAX(POLIZA.CODIGO_POLIZA) AS POLIZA_CODIGO_POLIZA,
                    MAX(RECIBO.CODIGO_RECIBO) AS CODIGO_RECIBO,
                    MAX(RECIBO.PRIMA) AS MONTO_PRIMA,
                    MAX(RAMO.NOMBRE) AS RAMO_NOMBRE,
                    MAX(ASEGURADORA.NOMBRE) AS ASEGURADORA_NOMBRE,
                    MAX(to_char(RECIBO.FDESDE,'DD/MM/YYYY') || ' - ' || to_char(RECIBO.FHASTA,'DD/MM/YYYY')) AS VIGENCIA,
                    MAX(STATUS.DESCRIPCION) AS ESTATUS,
                    MAX(RECIBO.FHASTA) AS FHASTA,
                    MAX(EJECUTIVO.NOMBRE)  AS EJECUTIVO_NOMBRE
                    FROM RECIBO
                      INNER JOIN POLIZA ON POLIZA.ID_POLIZA = RECIBO.ID_POLIZA
                      INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA = POLIZA.ID_POLIZA
                      INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                      INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA= POLIZA.ID_ASEGURADORA
                      INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                      INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                      INNER JOIN STATUS STATUS ON RECIBO.ESTADO = STATUS.ID_STATUS
                      INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    WHERE
                       RECIBO.FHASTA BETWEEN to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                        AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                        AND ASEGURADORA.NOMBRE like '%".$as."%'
                        AND RECIBO.status = 1
                        AND RECIBO.id_confi_empresa= '".$id_company. "'      
                        group by RECIBO.ID_POLIZA,POLIZA_TOMADOR.ID_TOMADOR,POLIZA_TOMADOR.ID_CLIENTE)
                    ORDER BY FHASTA,
                    ASEGURADORA_NOMBRE,
                    ESTATUS,
                    RAMO_NOMBRE";
       
     } 
      else if ($_REQUEST['funcion']=="report_sinasegurado"){
        
         $arrayx = explode(',',$_REQUEST['param']);
      
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         
         $be= $arrayx [3];
        
         if ($arrayx[3]=='Todos los Asegurados'){
           $be ="";
         }
  
         if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
    
         
         $sql= "SELECT
                    max(CLIENTE.NOMBRES || ' ' || CLIENTE.APELLIDOS) AS CLIENTE_NOMBRES,
                    max(POLIZA.CODIGO_POLIZA) AS POLIZA_CODIGO_POLIZA,
                    count(CLIENTE.NOMBRES) as Nro_Siniestros,
                    max(RAMO.NOMBRE) AS RAMO_NOMBRE,
                    max(ltrim(to_char(SINIESTRO.MONTO_CANCELADO,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = ''.,'''))) AS SINIESTRO_MONTO_CANCELADO,
                    max(ASEGURADORA.NOMBRE) AS ASEGURADORA_NOMBRE,
                    MAX(STATUS.DESCRIPCION) AS ESTATUS,
                    MAX(to_char(POLIZA.VIGENCIA_DESDE,'DD/MM/YYYY') || ' - ' || to_char(POLIZA.VIGENCIA_HASTA,'DD/MM/YYYY')) AS VIGENCIA
                    FROM
                    SINIESTRO
                    INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                    INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                    INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                    INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                    INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                    INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                    INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.STATUS
                    WHERE
                       UPPER (CLIENTE.NOMBRES||' '||CLIENTE.APELLIDOS) like '%".strtoupper($be)."%'
                       AND SINIESTRO.fecha_siniestro BETWEEN to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                       AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                       AND ASEGURADORA.NOMBRE like '%".($as)."%'
                       AND SINIESTRO.id_confi_empresa= '".$id_company. "' 
                    GROUP BY CLIENTE.ID_CLIENTE,CLIENTE.NOMBRES,POLIZA_TOMADOR.ID_POLIZA_TOMADOR,
                            POLIZA.VIGENCIA_HASTA,ASEGURADORA.NOMBRE,STATUS.DESCRIPCION,RAMO.NOMBRE
                    ORDER BY
                    CLIENTE.NOMBRES,
                    ASEGURADORA.NOMBRE,
                    POLIZA.VIGENCIA_HASTA,
                    STATUS.DESCRIPCION,
                    RAMO.NOMBRE";
       
     } 
    else if ($_REQUEST['funcion']=="report_sincompania"){
        
         $arrayx = explode(',',$_REQUEST['param']);
         
         $as=$arrayx[4];
         
         $st=$arrayx[8];
         
        if($arrayx[4]=='Todas las Aseguradoras'){
            $as="";
         }
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
    
         
         $sql= "SELECT
                    max(CLIENTE.NOMBRES || ' ' || CLIENTE.APELLIDOS) AS CLIENTE_NOMBRES,
                    max(POLIZA.CODIGO_POLIZA) AS POLIZA_CODIGO_POLIZA,
                    count(CLIENTE.NOMBRES) as Nro_Siniestros,
                    max(RAMO.NOMBRE) AS RAMO_NOMBRE,
                   max(ltrim(to_char(SINIESTRO.MONTO_CANCELADO,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = ''.,'''))) AS SINIESTRO_MONTO_CANCELADO,
                    max(ASEGURADORA.NOMBRE) AS ASEGURADORA_NOMBRE,
                    MAX(STATUS.DESCRIPCION) AS ESTATUS,
                    MAX(to_char(POLIZA.VIGENCIA_DESDE,'DD/MM/YYYY') || ' - ' || to_char(POLIZA.VIGENCIA_HASTA,'DD/MM/YYYY')) AS VIGENCIA
                    FROM
                    SINIESTRO
                    INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                    INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                    INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                    INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                    INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                    INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                    INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.STATUS
                    WHERE
                       SINIESTRO.fecha_siniestro BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                       AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                       AND ASEGURADORA.NOMBRE like '%".($as)."%'
                       AND SINIESTRO.id_confi_empresa= '".$id_company. "' 
                    GROUP BY CLIENTE.ID_CLIENTE,CLIENTE.NOMBRES,POLIZA_TOMADOR.ID_POLIZA_TOMADOR,ASEGURADORA.NOMBRE,
                             POLIZA.VIGENCIA_HASTA,ASEGURADORA.NOMBRE,STATUS.DESCRIPCION,RAMO.NOMBRE
                    ORDER BY
                    ASEGURADORA.NOMBRE,
                    POLIZA.VIGENCIA_HASTA,
                    STATUS.DESCRIPCION";
                    
     } 
     else if ($_REQUEST['funcion']=="report_sinramo"){
        
         $arrayx = explode(',',$_REQUEST['param']);
         
        $st=$arrayx[8];
         
        $ra= $arrayx[7];
        
        if ($arrayx[7]=='Todos los Ramos'){
           $ra ="";
         } 
       
         if ($arrayx[8]=='Todos los Estatus'){
           $st ="";
         }
    
         
         $sql= "SELECT
                    max(CLIENTE.NOMBRES || ' ' || CLIENTE.APELLIDOS) AS CLIENTE_NOMBRES,
                    max(POLIZA.CODIGO_POLIZA) AS POLIZA_CODIGO_POLIZA,
                    count(CLIENTE.NOMBRES) as Nro_Siniestros,
                    max(PLAN.NOMBRE) AS RAMO_NOMBRE,
                   max(ltrim(to_char(SINIESTRO.MONTO_CANCELADO,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = ''.,'''))) AS SINIESTRO_MONTO_CANCELADO,
                    max(ASEGURADORA.NOMBRE) AS ASEGURADORA_NOMBRE,
                    MAX(STATUS.DESCRIPCION) AS ESTATUS,
                    MAX(to_char(POLIZA.VIGENCIA_DESDE,'DD/MM/YYYY') || ' - ' || to_char(POLIZA.VIGENCIA_HASTA,'DD/MM/YYYY')) AS VIGENCIA
                    FROM
                    SINIESTRO
                    INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                    INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                    INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                    INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                    INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                    INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                    INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.STATUS
                    WHERE
                        SINIESTRO.fecha_siniestro BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                       AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                       AND PLAN.NOMBRE LIKE '%".$ra."%'
                       AND SINIESTRO.id_confi_empresa= '".$id_company. "'
                    GROUP BY CLIENTE.ID_CLIENTE,CLIENTE.NOMBRES,POLIZA_TOMADOR.ID_POLIZA_TOMADOR,RAMO.NOMBRE,
                             POLIZA.VIGENCIA_HASTA,ASEGURADORA.NOMBRE,STATUS.DESCRIPCION,plan.NOMBRE
                    ORDER BY
                        PLAN.NOMBRE,
                        POLIZA.VIGENCIA_HASTA,
                        ASEGURADORA.NOMBRE,
                        STATUS.DESCRIPCION";
                    
     } 
      else if ($_REQUEST['funcion']=="report_sinejecutivo"){
        
            $arrayx = explode(',',$_REQUEST['param']);
         
            $st=$arrayx[8];
            $as= $arrayx[4];
            $ej=$arrayx[5];
            
             if($arrayx[5]=='Todos los Ejecutivos'){
                $ej="";
             }
                
             if ($arrayx[8]=='Todos los Estatus'){
               $st ="";
             }
             if($arrayx[4]=='Todas las Aseguradoras'){
                $as="";
             }
         
         $sql= "SELECT
                    max(CLIENTE.NOMBRES || ' ' || CLIENTE.APELLIDOS) AS CLIENTE_NOMBRES,
                    max(POLIZA.CODIGO_POLIZA) AS POLIZA_CODIGO_POLIZA,
                    count(CLIENTE.NOMBRES) as Nro_Siniestros,
                    max(PLAN.NOMBRE) AS RAMO_NOMBRE,
                    max(ltrim(to_char(SINIESTRO.MONTO_CANCELADO,'999G999G999G999D99','NLS_NUMERIC_CHARACTERS = ''.,'''))) AS SINIESTRO_MONTO_CANCELADO,
                    max(ASEGURADORA.NOMBRE) AS ASEGURADORA_NOMBRE,
                    MAX(STATUS.DESCRIPCION) AS ESTATUS,
                    MAX(to_char(POLIZA.VIGENCIA_DESDE,'DD/MM/YYYY') || ' - ' || to_char(POLIZA.VIGENCIA_HASTA,'DD/MM/YYYY')) AS VIGENCIA,
                    max(EJECUTIVO.NOMBRE) AS EJECUTIVO_NOMBRE
                    FROM
                    SINIESTRO
                    INNER JOIN POLIZA_TOMADOR ON POLIZA_TOMADOR.ID_POLIZA_TOMADOR = SINIESTRO.ID_POLIZA_TOMADOR
                    INNER JOIN POLIZA ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                    INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                    INNER JOIN CLIENTE ON  CLIENTE.ID_CLIENTE = POLIZA_TOMADOR.ID_CLIENTE
                    INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                    INNER JOIN RAMO ON RAMO.ID_RAMO = PLAN.ID_RAMO
                    INNER JOIN ASEGURADORA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                    INNER JOIN STATUS ON STATUS.ID_STATUS = POLIZA.STATUS
                    WHERE
                       SINIESTRO.fecha_siniestro BETWEEN  to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                       AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%' 
                       AND ASEGURADORA.NOMBRE like '%".($as)."%'
                       AND EJECUTIVO.NOMBRE LIKE '%".$ej."%'
                       AND SINIESTRO.id_confi_empresa= '".$id_company. "'
                    GROUP BY CLIENTE.ID_CLIENTE,CLIENTE.NOMBRES,POLIZA_TOMADOR.ID_POLIZA_TOMADOR,EJECUTIVO.NOMBRE,
                            POLIZA.VIGENCIA_HASTA,ASEGURADORA.NOMBRE,STATUS.DESCRIPCION,RAMO.NOMBRE
                    ORDER BY
                    EJECUTIVO.NOMBRE,
                    POLIZA.VIGENCIA_HASTA,
                    ASEGURADORA.NOMBRE,
                    STATUS.DESCRIPCION,
                    RAMO.NOMBRE";
                    
     }     
    else if ($_REQUEST['funcion']=="report_financiamientos"){
        
            $arrayx = explode(',',$_REQUEST['param']);
         
            $st=$arrayx[8];
            $as= $arrayx[4];
            $be= $arrayx [3];
        
             if ($arrayx[3]=='Todos los Asegurados'){
               $be ="";
             } 
             if ($arrayx[8]=='Todos los Estatus'){
               $st ="";
             }
             if($arrayx[4]=='Todas las Aseguradoras'){
                $as="";
             }
         
         $sql= "SELECT
                     MAX(CLIENTE.NOMBRES ||' '||CLIENTE.APELLIDOS) AS CLIENTE_NOMBRES,
                     MAX(POLIZA.CODIGO_POLIZA) AS POLIZA_CODIGO_POLIZA,
                     MAX(FINANCIAMIENTO.CODIGO_FINANCIAMIENTO) AS FINANCIAMIENTO_CODIGO_FINANCIA,
                     MAX(EJECUTIVO.NOMBRE) AS EJECUTIVO_NOMBRE,
                     NVL((select count(id_giro_financiamiento) from giro_financiamiento where estado=12 and giro_financiamiento.id_financiamiento=financiamiento.id_financiamiento group by id_financiamiento),0) as GIROS_PENDIENTES,
                     MAX(ASEGURADORA.NOMBRE) AS ASEGURADORA_NOMBRE
                FROM
                     ASEGURADORA
                     INNER JOIN POLIZA ON ASEGURADORA.ID_ASEGURADORA = POLIZA.ID_ASEGURADORA
                     INNER JOIN POLIZA_TOMADOR ON POLIZA.ID_POLIZA = POLIZA_TOMADOR.ID_POLIZA
                     INNER JOIN EJECUTIVO ON POLIZA.ID_EJECUTIVO = EJECUTIVO.ID_EJECUTIVO
                     INNER JOIN CLIENTE ON POLIZA_TOMADOR.ID_CLIENTE = CLIENTE.ID_CLIENTE
                     INNER JOIN RECIBO ON RECIBO.id_poliza = POLIZA.id_poliza
                     INNER JOIN FINANCIAMIENTO ON FINANCIAMIENTO.id_financiamiento = RECIBO.id_financiamiento
                     INNER JOIN GIRO_FINANCIAMIENTO ON GIRO_FINANCIAMIENTO.id_financiamiento = FINANCIAMIENTO.id_financiamiento
                     INNER JOIN STATUS ON STATUS.id_status = FINANCIAMIENTO.estado
                     INNER JOIN PLAN ON PLAN.ID_PLAN = POLIZA.ID_PLAN
                     INNER JOIN RAMO ON RAMO.ID_RAMO=PLAN.ID_RAMO
                  WHERE
                     CLIENTE.identification LIKE '%".$be."%' 
                   AND FINANCIAMIENTO.ffinanciamiento BETWEEN to_date('".$arrayx[9]."','dd/mm/yyyy') and to_date('".$arrayx[10]."','dd/mm/yyyy')
                   AND ASEGURADORA.NOMBRE like '%".($as)."%'
                   AND UPPER (STATUS.DESCRIPCION) like '%".strtoupper($st)."%'
                    AND FINANCIAMIENTO.id_confi_empresa= '".$id_company. "'
                GROUP BY CLIENTE.ID_CLIENTE,financiamiento.id_financiamiento,ASEGURADORA.ID_ASEGURADORA
                ORDER BY ASEGURADORA.ID_ASEGURADORA";
                    
     }     
 //echo $sql; 
 if ($_REQUEST['funcion']=="report_poliramo" ||
       $_REQUEST['funcion']=="report_listaejecutivos" ||
       $_REQUEST['funcion']=="report_aseggrupoyasegejecutivo" ||
       $_REQUEST['funcion']=="report_poliaseguradora" ||
       $_REQUEST['funcion']=="report_solicpolizas" ||
       $_REQUEST['funcion']=="report_poliasegurado" ||
       $_REQUEST['funcion']=="report_poligrupoasegurado" ||
       $_REQUEST['funcion']=="report_polejecutivo" ||
       $_REQUEST['funcion']=="report_listasegurados" ||
       $_REQUEST['funcion']=="report_renov_men" ||
       $_REQUEST['funcion']=="report_vehflota" ||
       $_REQUEST['funcion']=="report_list_renov_aseg" ||
       $_REQUEST['funcion']=="report_list_renov_ejec" ||
       $_REQUEST['funcion']=="report_recibo_periodo" ||
       $_REQUEST['funcion']=="report_recibo_cob_periodo" ||
       $_REQUEST['funcion']=="report_recibo_pen_aseg" ||
       $_REQUEST['funcion']=="report_recibo_cob_aeg" ||
       $_REQUEST['funcion']=="report_recibo_pen_ejec" ||
       $_REQUEST['funcion']=="report_recibo_cob_ejec" ||
       $_REQUEST['funcion']=="report_prim_cob_pen" ||
       $_REQUEST['funcion']=="report_sinasegurado" ||
       $_REQUEST['funcion']=="report_sincompania" ||
       $_REQUEST['funcion']=="report_sinramo" ||
       $_REQUEST['funcion']=="report_sinejecutivo" ||
       $_REQUEST['funcion']=="report_financiamientos"){
              //echo $sql;
              $_SESSION['sistema']->xinv_rep->display_report($sql, $_REQUEST['funcion'],$arrayx);  
    }
?>