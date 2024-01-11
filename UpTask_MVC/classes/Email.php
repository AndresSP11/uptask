<?php
/* En el composer se hace eso para que el autoload lo detecte , este es el framework inicial */

namespace Classes;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


class Email{
    protected $email;
    protected $nombre;
    protected $token;    
    //Generando el consntructor de Email
    public function __construct($email,$nombre,$token)
    {
        $this->email=$email;
        $this->nombre=$nombre;
        $this->token=$token;
    }
    public function enviarConfirmacion(){
        
        // Lee el contenido del archivo HTML y almacénalo en una variable

        $mail = new PHPMailer(true);
         //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'anderson.salazar.p@uni.edu.pe';                     //SMTP username
        $mail->Password   = 'ltmrwzgiegbkjxwt';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('anderson.salazar.p@uni.edu.pe', 'Confirmación de Cuenta');
        /* Aqui va en el this email, la configuración para mandarle el email correspondiente en su casilla, sea outlook o hotmail */
        $mail->addAddress('andres.salazar.p@uni.pe', 'Anderson Andres Salazar Pizarro');
        $mail->Subject = 'Confirma Tu Cuenta';
        //Add a recipient
        
    //Content
        $mail->isHTML(true);          
        $mail->CharSet='UTF-8';                        //Set email format to HTML
        
        $contenido='<html>';
        $contenido.="<p><strong> Hola " .$this->nombre . "</strong> Has creado tu cuenta en UpTask, solo debes confirmarla en el siguiente
        enlace </p>"; 
        /* En este caso se tiene que agregar el dominio corrrespondiente, pero por ahora se esta oclocando la parte del localhost */
        $contenido.="<p>Presiona aqui: <a href='http://localhost:3000/confirmar?token=" . $this->token .
        "'>Confirmar Cuenta</a></p>";
        $contenido.='</html>';
        $contenido.="<p>Si tu no creaste esta cuenta, ignora este mensaje</p>";
        $mail->Body=$contenido;
        $mail->AltBody = 'Correo de Prueba con phpMailer desde cuenta GMAIL';
        $mail->send();
    }
    public function enviarOlvidarPassword(){
        
        // Lee el contenido del archivo HTML y almacénalo en una variable

        $mail = new PHPMailer(true);
         //Server settings
        $mail->SMTPDebug = SMTP::DEBUG_OFF;                      //Enable verbose debug output
        $mail->isSMTP();                                            //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
        $mail->Username   = 'anderson.salazar.p@uni.edu.pe';                     //SMTP username
        $mail->Password   = 'ltmrwzgiegbkjxwt';                               //SMTP password
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
        $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('anderson.salazar.p@uni.edu.pe', 'Reestablecimiento de Cuenta');
        /* Aqui va en el this email, la configuración para mandarle el email correspondiente en su casilla, sea outlook o hotmail */
        $mail->addAddress('andres.salazar.p@uni.pe', 'Anderson Andres Salazar Pizarro');
        $mail->Subject = 'Reestablecer Contraseña';
        //Add a recipient
        
    //Content
        $mail->isHTML(true);          
        $mail->CharSet='UTF-8';                        //Set email format to HTML
        
        $contenido='<html>';
        $contenido.="<p><strong> Hola " .$this->nombre . "</strong> Has olvidado tu cuenta en UpTask, solo debes confirmarla en el siguiente
        enlace </p>"; 
        /* En este caso se tiene que agregar el dominio corrrespondiente, pero por ahora se esta oclocando la parte del localhost */
        $contenido.="<p>Presiona aqui: <a href='http://localhost:3000/reestablecer?token=" . $this->token .
        "'>Reestablecer Contraseña</a></p>";
        $contenido.='</html>';
        $contenido.="<p>Si tu no solicitaste este cambio, ignora este mensaje</p>";
        $mail->Body=$contenido;
        $mail->AltBody = 'Correo de Prueba con phpMailer desde cuenta GMAIL';
        $mail->send();
    }
}   

?>