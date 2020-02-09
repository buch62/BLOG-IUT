<?php

setcookie('sid', '', -1); //définition d'un cookie envoyé avec le reste des en-têtes HTTP.

header("Location: index.php");
exit();
