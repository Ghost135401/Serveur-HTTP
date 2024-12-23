<?php
$id=$_GET["id"];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Page de Dialogue</title>
    <link rel="stylesheet" href="../assets/css/style6.css">
</head>
<body>

    <!-- La boîte de dialogue (modale) qui apparaît dès le chargement -->
    <div id="dialog" class="dialog-overlay show">
        <div class="dialog-box">
            <h2>Êtes-vous sûr de vouloir continuer ?</h2>
            <p>Cette action est irréversible.</p>
            <div class="dialog-actions">
                <a href="supprimer.php?id=<?php echo $id;?>" id="confirm-btn" class="link-btn">OK</a>
                <a href="gestion.php" id="cancel-btn" class="link-btn">Annuler</a>
            </div>
        </div>
    </div>

</body>
</html>
