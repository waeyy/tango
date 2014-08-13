<!DOCTYPE html>
    <html lang="fr">
        <head>
            <meta charset="utf-8" />
            <link rel="shortcut icon" href="favicon.ico" />

            <?php
            if (!empty($title))
                echo '<title> '.$title.' &bull; Symplicity </title>';
            else
                echo '<title> Symplicity Framework </title>';
            ?>

            <link rel="stylesheet" href="/css/style.css" type="text/css" />
        </head>

        <body>
            <?php if ($user->hasFlash()) echo '<p style="text-align: center; color: red;">', $user->getFlash(), '</p>'; ?>
            <?php echo $content; ?>
        </body>
</html>