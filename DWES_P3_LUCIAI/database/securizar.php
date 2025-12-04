<?php

function securizar($datos){
    return htmlspecialchars(stripslashes(trim($datos)));
    }

?>