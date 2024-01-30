<?php

namespace App\Enum;


enum StatutTâche: string {
    case EnCours = 'En cours';
    case EnAttente = 'En attente';
    case Termine = 'terminé';


    public function toString(): string {
        return match($this) {
            self::EnCours => 'En cours',
            self::EnAttente => 'En attente',
            self::Termine => 'terminé',
        };
    }

    
}


 




