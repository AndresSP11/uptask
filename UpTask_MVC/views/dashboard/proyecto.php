<?php include_once __DIR__.'/header-dashboard.php'; ?>

    <div class="contenedor-sm">

        <div class="contenedor-nueva-tarea">
            <button
            type="button"
            class="agregar-tarea"
            id="agregar-tarea">
            Nueva Tarea 
        </button>
        </div>

    </div>

<?php include_once __DIR__.'/footer-dashboard.php'; ?>

<?php
    /* En base a la parte de $script  */
$script='
    
    <script src="./build/js/tareas.js"></script>
    <script src="./build/js/app.js"></script>
';
?>