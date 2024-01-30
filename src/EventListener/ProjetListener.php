<?php

namespace App\EventListener;

class ProjetListener
{
    public function onAddProjetadd()
    {
        dd("J'écoute mon événement de ma classe projet.add");
    }
}

?>