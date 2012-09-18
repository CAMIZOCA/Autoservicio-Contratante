/*!
 * jQuery mCombo Plugin
 * Marvin Baptista
 * marvinbaptista@gmail.com
 *
 * Latest Release: 27/03/2012 
 */


(function($) {        
    
    $.fn.mCombo = function(NAME_SELECT ,URL ,PAR1 ,PAR2,PAR3) {   
        
        //FUNCION PARA CAPTURAR VALORES EN EL URL
        function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
            return vars;
        }
        
        $(NAME_SELECT).attr("disabled","disabled");
        $(PAR1).change(function(event){
          

            if(PAR2){
                    
                if(PAR3){
                    
                    //validar si el campo esta en * para filtrar o no filtrar por el campo
                    $(NAME_SELECT).load(URL +'?idepol='+ $(PAR3).find(':selected').val() +'&idcontratante='+$(PAR2).find(':selected').val() +'&anno='+$(PAR1).find(':selected').val());
                                        
                    $(NAME_SELECT).removeAttr('disabled');                        
                }else{
                    $(NAME_SELECT).load(URL +'?idepol='+ $(PAR2).find(':selected').val() +'&idcontratante='+$(PAR1).find(':selected').val() );
                    $(NAME_SELECT).removeAttr('disabled');
                }
                    
                $(NAME_SELECT).removeAttr('disabled');  
                                
            }else {
                                
                $(NAME_SELECT).load(URL +'?idepol='+ $(PAR1).find(':selected').val());
                $(NAME_SELECT).removeAttr('disabled');
                                
            }
        });
    }
    
     $.fn.mCombo1 = function(NAME_SELECT ,URL ,PAR1 ,PAR2 ,PAR3 ) {   
        
        //FUNCION PARA CAPTURAR VALORES EN EL URL
        function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
            return vars;
        }
        
        $(NAME_SELECT).attr("disabled","disabled");
        $(PAR1).change(function(event){

        
        $(NAME_SELECT).load(URL +'?idepol='+ $(PAR3).find(':selected').val() +'&idcontratante='+$(PAR2).find(':selected').val() +'&anno='+$(PAR1).find(':selected').val());
        $(NAME_SELECT).removeAttr('disabled');

//            if(PAR2){
//                    
//                if(PAR3){
//                    
//                    //validar si el campo esta en * para filtrar o no filtrar por el campo
//                    $(NAME_SELECT).load(URL +'?idepol='+ $(PAR3).find(':selected').val() +'&idcontratante='+$(PAR2).find(':selected').val() +'&anno='+$(PAR1).find(':selected').val());
//                                        
//                    $(NAME_SELECT).removeAttr('disabled');                        
//                }else{
//                    $(NAME_SELECT).load(URL +'?idepol='+ $(PAR2).find(':selected').val() +'&idcontratante='+$(PAR1).find(':selected').val() );
//                    $(NAME_SELECT).removeAttr('disabled');
//                }
//                    
//                $(NAME_SELECT).removeAttr('disabled');  
//                                
//            }else {
//                                
//                $(NAME_SELECT).load(URL +'?idepol='+ $(PAR1).find(':selected').val());
//                $(NAME_SELECT).removeAttr('disabled');
//                                
//            }
        });
    }
    
    $.fn.mCombo3 = function(NAME_SELECT ,URL ,PAR1 ,PAR2,PAR3,PAR4) {   
        
        //FUNCION PARA CAPTURAR VALORES EN EL URL
        function getUrlVars() {
            var vars = {};
            var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value) {
                vars[key] = value;
            });
            return vars;
        }
        
        $(NAME_SELECT).attr("disabled","disabled");
        $(PAR1).change(function(event){
          
            $(NAME_SELECT).load(URL +
                '?idepol=' + $(PAR4).find(':selected').val() +
                '&idcontratante='+$(PAR3).find(':selected').val() +
                '&anno='+$(PAR2).find(':selected').val() +
                '&cmbstatus='+$(PAR1).find(':selected').val() 
        );
            $(NAME_SELECT).removeAttr('disabled');



        });
    }
    
    
    
    
    
})(jQuery); 

