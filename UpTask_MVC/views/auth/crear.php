<div class="contenedor  crear">
    <?php include __DIR__.'/../templates/nombre-sitio.php';?>


    <div class="contenedor-sm">
        <p class="descripcion-pagina">Crea tu cuenta en UpTask</p>
        <?php include __DIR__.'/../templates/alertas.php';?>
        <form action="./crear" class="formulario" method="POST">
            <div class="campo">
                <label for="email">Nombre: </label>
                <input 
                type="text"
                id="nombre"
                placeholder="Tu Nombre"
                name="nombre"
                value="<?php echo $usuario->nombre;?>">
            </div>
            <div class="campo">
                <label for="email">Email: </label>
                <input 
                type="email"
                id="email"
                placeholder="Tu Email"
                name="email"
                value="<?php echo $usuario->email;?>">>
            </div>
            <div class="campo">
                <label for="password">Password: </label>
                <input 
                type="password"
                id="password"
                placeholder="Tu Password"
                name="password">
            </div>
           
            <div class="campo">
                <label for="password2">Repetir Password: </label>
                <input 
                type="password"
                id="password2"
                placeholder="Repite tu Password"
                name="password2">
            </div> 
            <input type="submit" class="boton" value="Iniciar Sesión">
        </form>
        <!-- Forma en la que se manda a los demás -->
            <div class="acciones">
            <a href="./">Tienes una cuenta, Logeate... </a>
            <a href="./olvide">Olvidaste tu password</a>
        </div>
    </div><!-- Contenedor - Sm -->

</div>