<div class="recordMenuBox">
    <p>
        Usuario: <?php echo strtoupper($UserName); ?> <br />
        Nombre: <?php echo strtoupper($FirstName) .' '. strtoupper($LastName); ?><br />        
        Ente: HMO<br />        
        Creado: <?php echo format_date($CreatedAt,'dd/MM/y - HH:MM'); ?> <br />
<!--        BD. Actualizado: 31/01/2011<br />-->
        <?php echo sfConfig::get('app_version_number'); ?>
    </p>
</div>