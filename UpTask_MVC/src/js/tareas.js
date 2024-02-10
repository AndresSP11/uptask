(function(){
    //Botón para mostrar el Modal de Agregar tarea 
    const nuevaTareaBtn=document.querySelector('#agregar-tarea');
    nuevaTareaBtn.addEventListener('click',mostrarFormulario);

    function mostrarFormulario(){
        const modal=document.createElement('DIV');
        modal.classList.add('modal');
        /* Tener cuidado al momento de generar la nueva clase */
        modal.innerHTML =`
            <form class="formulario nueva-tarea">
                <legend> Añada una nueva tarea </legend> 
                <div class="campo">
                    <label>Tarea</label>
                    <input 
                    type="text"
                    name="tarea"
                    placeholder="Añadir Tarea al Proyecto Actual"
                    id="tarea"
                    >


                    </input>
                </div>
                <div class="opciones">
                    <input type="submit" class="submit-nueva-tarea" value="Añadir tarea"/>
                    <button type="button" class="cerrar-modal">Cancelar</button>
                </div>
            </form>
        `;

        /* Esto ha sido para probar que no funciona del todo la paret al momento e querer remover o agregar un eventListener */
        /* No funcionara  */
        /* onst btnCerrarModal=document.querySelector('.cerrar-modal'); */
        
        /* btnCerrarModal.addEventListener('click',disteClick);

        function disteClick(){
            console.log('Diste click')
        } */

        /* Este por ser un setTimeOut funcionarà , pero en el anterior digamos que estuvo solo y no funcionò debido aese problema, esto debido a que como ya existe el elemento
        de una vez creado, esta vez si lo detectarà, es or ello que ejecuta por orden de las funciones convocadas en JavaScript */
        setTimeout(()=>{
            const formulario=document.querySelector('.formulario');
            formulario.classList.add('animar');
        },500  );
        
        /* En este caso si hará caso a la parte por qeu se esta creando de forma estatica la parte del modal-DIV así que no hay problema */
        /* Teniendo como conjunto solución todo el contenedor en general. */
        modal.addEventListener('click',function(e){
            /* E.TARGET PERMITE VER LOS CLICK... VER DE ELLO  */
            e.preventDefault();

            if(e.target.classList.contains('cerrar-modal')){

                const formulario=document.querySelector('.formulario');
                formulario.classList.add('cerrar');

                setTimeout(()=>{
                    modal.remove();
                },1200)
            }
            if(e.target.classList.contains('submit-nueva-tarea')){
                submitFormularioNuevaTarea();
            }

        })


        document.querySelector('body').appendChild(modal);
    }

    /* En este caso se crea la alerta para definir como está los procesos a seguir */

    function submitFormularioNuevaTarea(){
        /* trim , limpia los espacios de los inputs */
        const tarea=document.querySelector('#tarea').value.trim();
        if(tarea===''){
            //Mostrar una alerta de error
            mostrarAlerta('El nombre de la tarea es obligatorio', 'error', document.querySelector(
                '.formulario legend'
            ));
            
            return;
        }
        /* invocando funciòn que activa la creaciòn de tarea */
        agregarTarea(tarea);

      /*   console.log('Despues del IF'); */
    }
    //Muestra un mensaje en la interfaz
    function mostrarAlerta(mensaje, tipo, referencia){
        const alertaPrevisa=document.querySelector('.alerta')
        if(alertaPrevisa){
            alertaPrevisa.remove();
        }

        //Previene la creación de multiples Alertas
        const alerta=document.createElement('DIV');
        alerta.classList.add('alerta',tipo);
        alerta.textContent=mensaje;
        /* AppendChild, significq uqe va agregar debajo del contenedor creado anteriomente  */
        /* Indicad que referencia , es l pate del document,querySelector  */

        /* #### PARENT ELEMENT #####*/
        /* DIGAMOS DE UN DOCUMENT.qUERYSELECTOR, EL PARENT ELELMENT SIGNIFICA QUE DEL ATRIBUTO QUE SELECCIONASTE, TE ARROJARÁ AL PADRE CORRESPONDIENTE */
        /* Insertar en el padre formulario, y antes de legend.... es lo que hace esta linea de codigo */
        referencia.parentElement.insertBefore(alerta, referencia);

        console.log(alerta);

        //Eliminar la Alerta
        setTimeout(()=>{
            alerta.remove();
        },3500)
    }
    //Consultar al servidor para agregar Tarea actual
    async  function agregarTarea(tarea){
        const datos = new FormData();
        /* EL APPEND LO ENVIA MEDIANTE FORMATO JSON LOS VALORES CORRESPONDIENTES */
        datos.append('nombre', tarea);
        /* Obtener proyecto id, obtendra la url para realiaar la respectiva verificación de seguro  */
        datos.append('proyectoId', obtenerProyecto());
    
        try {
            const url='http://localhost:3000/api/tarea';  
            const respuesta= await fetch(url,{
                method:'POST',
                body:datos
            });
            const resultado= await respuesta.json();
            /* Respuesta del servidor */
            if(!resultado.tipo=='error'){
                mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector(
                    '.formulario legend'
                ));
            }else{mostrarAlerta(resultado.mensaje, resultado.tipo, document.querySelector(
                '.formulario legend'
            ));
            }
            console.log(resultado);
        } catch (error) {
            console.log(error);
        }
    }

    function obtenerProyecto(){
        const proyectoParams= new URLSearchParams(window.location.search);  
        /* Entra al objeto para poder obtener el valor correspondiente */
        const proyecto=Object.fromEntries(proyectoParams.entries());
        /* Obtiene la url */
        return proyecto.id;
    }
})();

/* Esas llaves ultimas permiten que se ejecute la función */