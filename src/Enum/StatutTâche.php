<?php
namespace App\Enum;


enum StatutTâche : string {
    case EnCours = 'En cours';
    case EnAttente = 'En attente';
    case Termine = 'terminé';
}
