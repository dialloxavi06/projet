<?php

namespace App\Event;

use App\Entity\Projet;
use Symfony\Contracts\EventDispatcher\Event;

class AddProjetEvent extends Event
{
    public const ADD_PROJET_EVENT = 'projet.add';

    private Projet $projet;

    public function __construct(Projet $projet)
    {
        $this->projet = $projet;
    }

    public function getProjet(): Projet
    {
        return $this->projet;
    }
}
?>