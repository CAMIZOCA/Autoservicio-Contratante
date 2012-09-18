// JavaScript Document

function getDataServer(url, vars){
     var xml = null;
     try{
         xml = new ActiveXObject("Microsoft.XMLHTTP");
     }catch(expeption){
         xml = new XMLHttpRequest();
     }
     xml.open("GET",url + vars, false);
     xml.send(null);
     if(xml.status == 404) alert("Url no valida");
     return xml.responseText;
}

function fecha_incio_fin(cliente,contratante,tipo_ser,anno,mes){
    var error = getDataServer("/js/servidor_fec_in_fin.php","?cliente="+cliente+"&contratante="+contratante+"&tipo_ser="+tipo_ser+"&anno="+anno+"&mes="+mes);
    var new_text = error.split('/');

    if(error){
       
       document.form1.inicio.value=new_text[0];
       document.form1.fin.value=new_text[1];
       document.form1.dias_habiles.value=new_text[2];
       document.form1.dias_mes.value=new_text[3];
  
    }else{
        alert(new_text);
       
    }
    
}


function Tipo_proveedor(cliente,contratante,ciudad){
    var error = getDataServer("/js/tipo_proveedor.php","?cliente="+cliente+"&contratante="+contratante+"&ciudad="+ciudad+"");
      var new_text = error.split('/');
      var n = document.forms.form1.tipo_prov.length;

  //alert(a);
  
  for (var i=0; i<n;++i){      
      document.forms.form1.tipo_prov.remove(document.forms.form1.tipo_prov.options[i]);//eliminar lineas del 2do combo...
  }
   
   document.forms.form1.tipo_prov[0]= new Option(" - Seleccione una opción - ",'-1'); 
   document.forms.form1.tipo_prov[1]= new Option("Todos",'todos');

    if(error){
        //alert(new_text.length);
        j=1;
        for (i=0; i<new_text.length-1; i++)
        { j++
          myvar = new_text[i];
          document.forms.form1.tipo_prov[j]= new Option(myvar,myvar);
        }
       //document.write(error);
       
    }
    document.forms.form1.tipo_prov.disabled=false;
}

function ano_consolidado(cliente,contratante,ciudad,tipo_pro){
    var error = getDataServer("/js/ano_consolidado.php","?cliente="+cliente+"&contratante="+contratante+"&ciudad="+ciudad+"&tipo_pro="+tipo_pro+"");
    var new_text = error.split('/');
    var n = document.forms.form1.ano.length;

 //alert(error);
  
  for (var i=0; i<n;++i){      
      document.forms.form1.ano.remove(document.forms.form1.ano.options[i]);//eliminar lineas del 2do combo...
  }
   
   document.forms.form1.ano[0]= new Option(" - Seleccione una opción - ",'-1');  

    if(error){
        //alert(new_text.length);
        j=0;
        for (i=0; i<new_text.length-1; i++)
        { j++
          myvar = new_text[i];
          if(myvar!=' '){
          document.forms.form1.ano[j]= new Option(myvar,myvar);
          }
        }
       //document.write(error);
       
    }
    document.forms.form1.ano.disabled=false;
    
}

function mes_consolidado(cliente,contratante,ciudad,tipo_pro,ano){
    var error = getDataServer("/js/mes_consolidado.php","?cliente="+cliente+"&contratante="+contratante+"&ciudad="+ciudad+"&tipo_pro="+tipo_pro+"&ano="+ano+"");
    var new_text =error.split('/');
    var n = document.forms.form1.mes.length;
    var valor_option='';
    var aux='';
  //alert(error);
  
  for (var i=0; i<n;++i){      
      document.forms.form1.mes.remove(document.forms.form1.mes.options[i]);//eliminar lineas del 2do combo...
  }
   
   document.forms.form1.mes[0]= new Option(" - Seleccione una opción - ",'-1');  
   document.forms.form1.mes[1]= new Option(" Todos ",'0'); 
    if(error){
        //alert("mila"+new_text.length);
        j=1;
        for (i=0; i<new_text.length-1; i++)
        { j++
          myvar = new_text[i];
          aux=myvar.split(' ');
          valor_option =num_mes(aux[1]);
          document.forms.form1.mes[j]= new Option(myvar,valor_option);
        }
       //document.write(error);
       
    }
   document.forms.form1.mes.disabled=false;
}

function mes_siniestros(cliente,contratante,tipo_servicio,ano){
    var error = getDataServer("/js/mes_siniestros.php","?cliente="+cliente+"&contratante="+contratante+"&tipo_servicio="+tipo_servicio+"&ano="+ano+"");
    var new_text =error.split('/');
    var n = document.forms.form1.mes.length;
    var valor_option='';
    var aux='';
  //alert(error);
  
  for (var i=0; i<n;++i){      
      document.forms.form1.mes.remove(document.forms.form1.mes.options[i]);//eliminar lineas del 2do combo...
  }
   
   document.forms.form1.mes[0]= new Option(" - Seleccione una opción - ",'-1');  
   document.forms.form1.mes[1]= new Option("Todos",'todos'); 
    if(error){
        //alert("mila"+new_text.length);
        j=1;
        for (i=0; i<new_text.length-1; i++)
        { j++
          myvar = new_text[i];
          aux=myvar.split(' ');
          valor_option =num_mes(aux[1]);
          document.forms.form1.mes[j]= new Option(myvar,valor_option);
        }
       //document.write(error);
       
    }
   document.forms.form1.mes.disabled=false;
}
//DIAS HABILES
/*function eliminarPais(id,id2){
    var error = getDataServer("/js/servidor.php","?ini="+id+"&fin="+id2+"");
    if(error){
       //alert(error);
       document.form1.dias_habiles.value=error;
       //document.getByElementId('dias_habiles').value =error;
    }
    else{
       // document.getElementById("div_"+id).style.display = "hidden";
    }
}



function eliminarPais(id,id2){
    var error = getDataServer("/js/servidor.php","?ini="+id+"&fin="+id2+"");
    if(error){
       //alert(error);
       document.form1.dias_habiles.value=error;
       //document.getByElementId('dias_habiles').value =error;
    }
    else{
       // document.getElementById("div_"+id).style.display = "hidden";
    }
}*/


function num_dias(id,id2){
    var error = getDataServer("/js/servidor2.php","?mes="+id+"&year="+id2+"");
    if(error){       
       document.form1.dias_mes.value=error;
     }
    else{
      document.form1.dias_mes.value="";
    }
}

function num_mes(id){
    var error = getDataServer("/js/mes_nombre.php","?mes="+id+"");
    return error;   
  
}
/*function cliente_elegido(id){
    var error = getDataServer("/js/server3.php","?id="+id+"");
    if(error){
       alert(error);
    
    }
}*/