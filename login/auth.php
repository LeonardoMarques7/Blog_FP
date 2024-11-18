<?php 



include('../vendor/autoload.php');

include('app.php');



function register_user($email, $nome, $senha, $foto, $profissao, $instagram, $twitter, $facebook, $activation_code, $tipouser)

{

    global $conexao;

	

	$expiry = 1 * 24  * 60 * 60;

	$act_code = password_hash($activation_code, PASSWORD_DEFAULT);

	$expiry = date('Y-m-d H:i:s',  time() + $expiry);

	

    $sql = "INSERT INTO users(use_Nome, use_Login, use_Senha, use_TypeUser, use_Profissao, use_Instagram, use_Twitter, use_Facebook, use_Foto, use_ActivationCode, use_ActivationExpiry)

            VALUES(?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

	

	$stmt = $conexao->prepare($sql);

    $stmt->bind_param('sssisssssss', $nome, $email, $senha, $tipouser, $profissao, $instagram, $twitter, $facebook, $foto, $act_code, $expiry);

    return $stmt->execute();

}



function redefinindo_senha($email, $activation_code)

{

    global $conexao;

	

	$expiry = 1 * 24  * 60 * 60;

	$act_code = password_hash($activation_code, PASSWORD_DEFAULT);

	$expiry = date('Y-m-d H:i:s',  time() + $expiry);

	

    $sql = "UPDATE users SET use_ActivationCode = ?, use_ActivationExpiry = ?, use_Active = 0 WHERE use_Login = ?";

    

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param('sss', $act_code, $expiry, $email);

    return $stmt->execute();

}



function criptografia($senha)

{

	$custo = "08";

	$salt = "Cf1f11ePArKlBJomM0F6aJ";



	// Gera um hash baseado em bcrypt

	$hash = crypt($senha, SALT);



	return $hash;

}



function generate_activation_code()

{

    return bin2hex(random_bytes(16));

}



function gerarCodigoNumerico($digitos = 6) {

    $min = pow(10, $digitos - 1);

    $max = pow(10, $digitos) - 1;

    return random_int($min, $max);

}



function send_activation_email($email, $activation_code)

{

    // create the activation link

    $activation_link = APP_URL . "/login/activate.php?e=$email&c=$activation_code";

	$from = SENDER_EMAIL_ADDRESS;



	$sendEmail = new \SendGrid\Mail\Mail(); 

	

	$sendEmail->setFrom($from, "Blog FP");

	$sendEmail->setSubject(subject: "Ativação de Conta - Blog FP");

	$sendEmail->addTo($email, "Example User");



	// Conteúdo em texto simples

	$sendEmail->addContent(

		"text/plain", 

		"Olá,\n\nObrigado por se registrar no Blog FP!\nClique no link a seguir para ativar sua conta: $activation_link\n\nSe você não se registrou, ignore este e-mail.\n\nAtenciosamente,\nEquipe Blog FP"

	);



	// Conteúdo em HTML

	$sendEmail->addContent(

		"text/html", 

		"

		<html>

    <head>

        <style>

            body {

                font-family: Arial, sans-serif;

                background-color: #f0f0f5;

                margin: 0;

                padding: 0;

                color: #333;

            }

            .container {

                background-color: #fff;

                padding: 30px;

                margin: 40px auto;

                width: 100%;

                max-width: 600px;

                border-radius: 10px;

                box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);

                text-align: center;

            }

            h2 {

                color: #0056b3;

                font-size: 24px;

                margin-bottom: 20px;

            }

            .black {

                color: #333;

            }

            p {

                font-size: 16px;

                line-height: 1.5;

                margin: 15px 0;

            }

            .activation-link {

                display: inline-block;

                padding: 12px 25px;

                background-color: #0056b3;

                color: #fff !important;

                text-decoration: none;

                font-size: 16px;

                border-radius: 50px;

                transition: background-color 0.3s ease;

            }

            .activation-link:hover {

                background-color: #004494;

            }

            .footer {

                margin-top: 20px;

                font-size: 12px;

                color: #999;

                text-align: center;

            }

            .footer a {

                color: #0056b3;

                text-decoration: none;

            }

        </style>

    </head>

    <body>

        <div class='container'>

            <h2>Bem-vindo ao Blog FP!</h2>

            <p class='black title-email'>Olá,</p>

            <p class='black'>Obrigado por se registrar no Blog Fernando Prestes! Para ativar sua conta, por favor clique no botão abaixo:</p>

            <a href='$activation_link' class='activation-link'>Ativar Conta</a>

            <p class='black'>Se você não se registrou, ignore este e-mail.</p>

            <p class='black'>Atenciosamente,<br>Equipe Blog FP</p>

        </div>

        <div class='footer'>

            <p class='black'>Você está recebendo este e-mail porque se registrou no <a href='https://blog-fp.infinityfreeapp.com/'>Blog FP</a>. Se não foi você, por favor desconsidere esta mensagem.</p>

        </div>

    </body>

</html>



		"

	);

	

	$key = SENDGRID_API_KEY;

	$sendgrid = new \SendGrid($key);



	try {

		$response = $sendgrid->send($sendEmail);

		//print $response->statusCode() . "\n";

		//print_r($response->headers());

		//print $response->body() . "\n";

	} catch (Exception $e) {

		echo 'Caught exception: '. $e->getMessage() ."\n";

	}

}



// Email redefinir senha

function send_password_email($email, $activation_code) 

{

	// Cria o link de redefinição de senha (opcional, se necessário)

    $from = SENDER_EMAIL_ADDRESS;



    $sendEmail = new \SendGrid\Mail\Mail(); 



    $sendEmail->setFrom($from, "Blog FP");

    $sendEmail->setSubject("Redefinição de Senha - Blog FP");

    $sendEmail->addTo($email, "Example User");



    // Conteúdo em texto simples

    $sendEmail->addContent(

        "text/plain", 

        "Olá,\n\nNotamos que você solicitou uma redefinição de senha.\nEste é o código para realizar a troca de senha: $activation_code\n\nSe você não solicitou essa mudança, ignore este e-mail.\n\nAtenciosamente,\nEquipe Blog FP"

    );



    // Conteúdo em HTML

    $sendEmail->addContent(

        "text/html", 

        "

        <html>

            <head>

                <style>

                    body {

                        font-family: Arial, sans-serif;

                        background-color: #f0f0f5;

                        color: #333;

                    }

                    .container {

                        background-color: #fff;

                        padding: 30px;

                        width: 100%;

                        max-width: 600px;

                        border-radius: 10px;

                        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);

                    }

                    h2 {

                        color: #0056b3;

                        font-size: 24px;

                        margin-bottom: 20px;

                    }

                    p {

                        font-size: 16px;

                        line-height: 1.5;

                        margin: 15px 0;

                    }

                    .code {

                        width: 100px;

                        text-align: center;

                        border-radius: 5px;

                        color: #eee;

                        font-size: 20px;

                        font-weight: bold;

                        background-color: #39f;

                    }

                    .footer {

                        margin-top: 20px;

                        font-size: 12px;

                        color: #999;

                        text-align: center;

                    }

                    .footer a {

                        color: #0056b3;

                        text-decoration: none;

                    }

                </style>

            </head>

            <body>

                <div class='container'>

                    <h2>Redefinição de Senha</h2>

                    <p>Olá,</p>

                    <p>Notamos que você solicitou uma redefinição de senha. Este é o código para realizar a troca de senha:</p>

                    <p class='code'>$activation_code</p>

                    <p>Se você não solicitou essa mudança, ignore este e-mail.</p>

                    <p>Atenciosamente,<br>Equipe Blog FP</p>

                </div>

                <div class='footer'>

                    <p>Você está recebendo este e-mail porque foi solicitada uma redefinição de senha para a sua conta no <a href='https://blog-fp.infinityfreeapp.com/'>Blog FP</a>. Se não foi você, desconsidere esta mensagem.</p>

                </div>

            </body>

        </html>

        "

    );



    // Chave da API e envio

    $key = SENDGRID_API_KEY;

    $sendgrid = new \SendGrid($key);



    try {

        $response = $sendgrid->send($sendEmail);

        // Log ou tratativa da resposta, se necessário

    } catch (Exception $e) {

        echo 'Erro ao enviar e-mail: ' . $e->getMessage() . "\n";

    }

}









function delete_user_by_id($id, $active = 0)

{

    global $conexao;



    $sql = "DELETE FROM users WHERE use_Id = ? AND use_Active = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param('ii', $id, $active); 



    return $stmt->execute(); 

}





function find_unverified_user($activation_code, $email)

{

    global $conexao;



    $sql = "SELECT use_Id, use_ActivationCode, use_ActivationExpiry < NOW() as expired

            FROM users WHERE use_Active = 0 AND use_Login = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param('s', $email); 

    $stmt->execute();



    $result = $stmt->get_result(); 

    $user = $result->fetch_assoc(); 



    if ($user) {

        if ((int)$user['expired'] === 1) {

            delete_user_by_id($user['use_Id']);

            return null;

        }

        if (password_verify($activation_code, $user['use_ActivationCode'])) {

            return $user;

        }

    }



    return null;

}



function verificacao_codigo($activation_code, $email)

{

    global $conexao;



    $sql = "SELECT use_Id, use_ActivationCode, use_ActivationExpiry < NOW() as expired

            FROM users WHERE use_Active = 0 AND use_Login = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param('s', $email); 

    $stmt->execute();



    $result = $stmt->get_result(); 

    $user = $result->fetch_assoc(); 



    if ($user) {

        if ((int)$user['expired'] === 1) {

            return null;

        }

        if (password_verify($activation_code, $user['use_ActivationCode'])) {

            return $user;

        }

    }



    return null;

}



function activate_user($user_id)

{

    global $conexao;



    $sql = "UPDATE users SET use_Active = 1, use_ActivatedAt = CURRENT_TIMESTAMP WHERE use_Id = ?";

    $stmt = $conexao->prepare($sql);

    $stmt->bind_param('i', $user_id); 



    return $stmt->execute(); 

}



?>

