<div class="contenedor  olvide">

    <?php include __DIR__.'/../templates/nombre-sitio.php';?>

    <div class="contenedor-sm">
        
        <p class="descripcion-pagina">Iniciar Sesión</p>

        <form action="/olvide" class="formulario" method="POST">
            <div class="campo">
                <label for="email">Email: </label>
                <input 
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email">
            </div>
            <input type="submit" class="boton" value="Enviar Instrucciones">
        </form>
        <div class="acciones">
            <!-- Recordar que ese ./ esta definido e nal parte de public , cuando estamos definiedo las rutas. -->
            <a href="./">Iniciar Sesión</a>
            <a href="./crear">¿Aún no tienes una cuenta? Obtener una</a>
        </div>
    </div><!-- Contenedor - Sm -->

</div>