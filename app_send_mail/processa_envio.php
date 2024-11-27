<?php 

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\Exception;

    require("../libs/PHPMailer/Exception.php");
    require("../libs/PHPMailer/OAuth.php");
    require("../libs/PHPMailer/PHPMailer.php");
    require("../libs/PHPMailer/POP3.php");
    require("../libs/PHPMailer/SMTP.php");

    class Mensagem {
        private $para = null;
        private $assunto = null;
        private $mensagem = null;

        public function __get($atributo) {
            return $this->$atributo;
        }

        public function __set($atributo, $valor) {
            $this->$atributo = $valor;
        }

        public function mensagemValida() {
            if (empty($this->para) || empty($this->assunto) || empty($this->mensagem)) {
                return false;
            }

            return true;
        }
    }

    $mensagem = new Mensagem();

    $mensagem->__set("para", $_POST["para"]);
    $mensagem->__set("assunto", $_POST["assunto"]);
    $mensagem->__set("mensagem", $_POST["mensagem"]);

    if (!$mensagem->mensagemValida()) {
        echo "Mensagem não é válida!";
        die();
    }

    $mail = new PHPMailer(true);

    try {
        //Server settings
        $mail->SMTPDebug = 2;                                //Enable verbose debug output
        $mail->isSMTP();                                     //Send using SMTP
        $mail->Host       = 'smtp.gmail.com';                //Set the SMTP server to send through
        $mail->SMTPAuth   = true;                            //Enable SMTP authentication
        $mail->Username   = 'teste@gmail.com';               //SMTP username
        $mail->Password   = '123123';                        //SMTP password
        $mail->SMTPSecure = 'tls';                           //Enable implicit TLS encryption
        $mail->Port       = 587;                             //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom('teste@gmail.com', 'Teste Remetente');
        $mail->addAddress('user1@gmail.com', 'User Teste Destinatário');    //Add a recipient
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

        //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');        //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');   //Optional name

        //Content
        $mail->isHTML(true);                                   //Set email format to HTML
        $mail->Subject = 'Oi, eu sou o assunto';
        $mail->Body    = 'Oi, eu sou o conteúdo do <strong>e-mail</strong>';
        $mail->AltBody = 'Oi, eu sou o conteúdo do e-mail';

        $mail->send();
        echo 'Message has been sent';
    } 
    
    catch (Exception $e) {
        echo "Não foi possível enviar este email. Por favor, tente novamente mais tarde!<br>";
        echo "Detalhes do erro: " . $mail->ErrorInfo;
    }

?>