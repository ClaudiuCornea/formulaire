<?php
    require('src/class.upload.php');
    use PHPMailer\PHPMailer\PHPMailer;
    require 'vendor/autoload.php';
    function check_input($x){
        if(isset($x) AND !empty($x)){
            return(TRUE);
        }else{
            return(FALSE);
        }
    }
    function validate_extension($extension){
        if($extension == "png" OR $extension == "jpg" OR $extension == "jpeg" OR $extension == "gif" OR $extension == ""){
            return(TRUE);
        }else{
            return(FALSE);
        }
    }
    $error_sanitize = [];
    if(isset($_POST["submit"])){
        $titre = check_input($_POST["titre"]) ? filter_var($_POST["titre"],FILTER_SANITIZE_STRING) : "";
        $nom = check_input($_POST["nom"]) ? filter_var($_POST["nom"],FILTER_SANITIZE_STRING) : "";
        $prenom = check_input($_POST["prenom"]) ? filter_var($_POST["prenom"], FILTER_SANITIZE_STRING) : "";
        $email = check_input($_POST["email"]) ? filter_var($_POST["email"], FILTER_SANITIZE_EMAIL) : FALSE;
        $objet = check_input($_POST["objet"]) ? filter_var($_POST["objet"], FILTER_SANITIZE_STRING) : "";
        $message = check_input($_POST["message"]) ? filter_var($_POST["message"], FILTER_SANITIZE_STRING) : FALSE;
        $format = check_input($_POST["format"]) ? filter_var($_POST["format"], FILTER_SANITIZE_STRING) : "";
        if(!$titre AND is_bool($titre)){
            array_push($error_sanitize, "sanitize_titre");
        }
        if(!$nom AND is_bool($nom)){
           array_push($error_sanitize, "sanitize_nom");
        }
        if(!$prenom AND is_bool($prenom)){
            array_push($error_sanitize, "sanitize_prenom");
        }
        if(!$email AND is_bool($email)){
            array_push($error_sanitize, "sanitize_email");
        }
        if(!$objet AND is_bool($objet)){
            array_push($error_sanitize, "sanitize_objet");
        }
        if(!$message AND is_bool($message)){
            array_push($error_sanitize, "sanitize_message");
        }
        if(!$format AND is_bool($format)){
            array_push($error_sanitize, "sanitize_format");
        }
        if(count($error_sanitize) == 0){
            $val_email = filter_var($email, FILTER_VALIDATE_EMAIL);
            if($val_email){
                $upload_image = TRUE;
                $image = new upload($_FILES["document"]);
                $extension = ($image->file_src_name_ext);
                if(validate_extension($extension)){
                    if($image->uploaded){
                        $image->file_new_name_body   = ($image->file_src_name_body);
                        $image->file_auto_rename = true;
                        $image->mime_check = true;
                        $image->process('upload/');
                        if ($image->processed) {
                            $file = ($image->file_dst_name);
                            $image->clean();
                        }else{
                            $upload_image = FALSE;
                            header("Location: index.php?status=false&upload_image=false");
                        }
                    }
                }else{
                    $upload_image = FALSE;
                    header("Location: index.php?status=false&format_image=false");
                }
                if($upload_image){
                    $mail = new PHPMailer;
                    $mail->isSMTP();
                    $mail->SMTPDebug = 0;
                    $mail->Host = 'ssl://smtp.gmail.com:465';
                    $mail->Port = 465;
                    $mail->SMTPSecure = 'ssl';
                    $mail->SMTPAuth = true;
                    $mail->Username = getenv("user_mail");
                    $mail->Password = getenv("user_password");
                    $mail->setFrom(getenv("user_mail"), getenv("user_name"));
                    $mail->addReplyTo($email, ($titre . $nom ." ". $prenom));
                    $mail->addAddress(getenv("user_mail"));
                    $mail->addAddress($email);
                    $mail->Subject = $objet;
                    $mail->msgHTML($message);
                    $mail->addAttachment(__DIR__ . "/upload/" . $file);
                    if (!$mail->send()){
                        header("Location: index.php?status=false&email_send=false");
                    }else{
                        $user =[
                            "titre" => $titre,
                            "nom" => $nom,
                            "prenom" => $prenom,
                            "email" => $email,
                            "objet" => $objet,
                            "message" => $message,
                            "format" => $format,
                            "date" => date('H:i:s l j/m/Y')];
                        $json = file_get_contents("log.json");
                        $json_array = json_decode($json, TRUE);
                        $json_array[] = $user;
                        $json_array_encode = json_encode($json_array);
                        file_put_contents("log.json", $json_array_encode);
                        header("Location: index.php?status=true");
                    }
                }
            }else{
                header("Location: index.php?status=false&validation_email=false");
            }
        }else{
            $string = 'index.php?status=false';
            foreach($error_sanitize as $index=>$value){
                $string .= '&'.$value.'=false';
            }
            header('Location: '.$string);
        }
    }
?>