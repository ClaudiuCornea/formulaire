<!DOCTYPE html>
<html>
    <head>
        <title>Logs</title>
    </head>
    <body>
        <?php
            if(file_exists('log.json')){
                $json = file_get_contents("log.json");
                $json_array = json_decode($json, TRUE);
                foreach ($json_array as $key => $value) {
                    $ine = '<p>' . $value["prenom"] . ' | ' . $value["objet"] . ' | ' . $value["message"] . ' | ' . $value["date"] . ' | ' . $value["format"] . '</p>';
                    echo($line);
                }
            }else {
                echo("Il n'y a pas encore de fichier log...");
            }
        ?>
    </body>
</html>