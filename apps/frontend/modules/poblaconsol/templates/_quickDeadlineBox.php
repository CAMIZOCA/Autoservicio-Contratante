<div class="deadlineMenuBox">
    <p><?php 
    $dias = array("Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sábado");
    $mes = array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","septiembre","Octubre","Nomviembre","Diciembre");
    echo $dias[date('w')].', '.strftime("%d de ").$mes[date('n')-1].strftime(" del %Y");   
    ?>       
    </p>
</div>
