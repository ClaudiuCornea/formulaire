<!DOCTYPE html>
<html>
    <head>
        <title>PHP 4 Steps And Error</title>
    </head>
    <body>
        <form action = "script.php" method = "post" enctype = "multipart/form-data">
            <div>
                <input type = "radio" name = "titre" value = "mme">
                <label for = "mme">Mme.</label>
                <input type = "radio" name="titre" value = "melle">
                <label for = "melle">Melle.</label>
                <input type="radio" name="titre" value = "mr">
                <label for="mr">Mr.</label>
                <?php
                    if($_GET["sanitize_titre"] == "false"){
                        echo("<p>Il y a un soucis avec le titre.</p>");
                    }
                ?>
            </div>
            <div>
                <label for="nom">Nom</label>
                <input type="text" name="nom" placeholder="Nom :">
                <?php
                    if($_GET["sanitize_nom"] == "false"){
                        echo("<p>Il y a un soucis avec le nom.</p>");
                    }
                ?>
            </div>
            <div>
                <label for="prenom">Prénom</label>
                <input type="text" name="prenom" placeholder="Prénom :">
                <?php
                    if($_GET["sanitize_prenom"] == "false"){
                        echo("<p>Il y a un soucis avec le prenom.</p>");
                    }
                ?>
            </div>
            <div>
                <label for="email">E-mail</label>
                <input type="email" name="email" placeholder="E-mail :">
                <?php
                    if($_GET["sanitize_email"] == "false"){
                        echo("<p>Nous avons besoin d'un email.</p>");
                    }elseif($_GET["validation_email"] == "false"){
                        echo("<p>Nous avons besoin d'un email valide.</p>");
                    }
                ?>
            </div>
            <div>
                <select name="objet">
                    <option value=""></option>
                    <option value="info">Demande d'information</option>
                    <option value="inscription">Inscription</option>
                </select>
                <?php
                    if($_GET["sanitize_objet"] == "false"){
                        echo("<p>Il y a un soucis avec l'objet.</p>");
                    }
                ?>
            </div>
            <div>
                <label for="message">Message</label>
                <textarea name="message"></textarea>
                <?php
                    if($_GET["sanitize_message"] == "false"){
                        echo("<p>Nous avons besoin d'un mot de votre part.</p>");
                    }
                ?>
            </div>
            <div>
                <label for="document">Document</label>
                <input type="file" name="document">
                <?php
                    if($_GET["format_image"] == "false"){
                        echo("<p>Le format du fichier n'est pas bon.</p>");
                    }elseif($_GET["upload_image"] == "false"){
                        echo("<p>L'upload' du fichier n'a pas réussi.</p>");
                    }
                ?>
            </div>
            <div>
                <span>Format de la réponse : </span>
                <input type="radio" name="format" value="html" checked>
                <label for="html">HTML</label>
                <input type="radio" name="format" value="txt">
                <label for="txt">Texte</label>
                <?php
                    if($_GET["sanitize_format"] == "false"){
                        echo("<p>Nous avons besoin d'un format de réponse.</p>");
                    }
                ?>
            </div>
            <button type="submit" name="submit" >Envoyer</button>
        </form>
        <?php
            if($_GET["email_send"] == "false"){
                echo("<p>Nous n'avons pas pu envoyer l'email.</p>");
            }elseif($_GET["status"] == "true"){
                echo("<p>Votre email a bien été envoyé.</p>");
            }
        ?>
    </body>
</html>