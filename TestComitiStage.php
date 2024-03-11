<?php

function calculPrixAdherents($nbrAdherents, $federation, $moisEnCours, $nbrSections, $sectionsOffertes) {
    $tranches = [
        100 => 10,
        200 => 0.10,
        500 => 0.09,
        1000 => 0.08,
    ];
    // Init du prix de l'adhésion
    $prixAdherents = 0;

    // Si plus de 1000 adhérents ajout d'une tranche de 70€ HT
    if ($nbrAdherents > 1000) {
        $nombreDeTranches = ceil($nbrAdherents / 1000);
        $tranchePrice = $nombreDeTranches * 70;
            
    if ($nbrAdherents % 1000 !== 0) {
        $tranchePrice -= 70;
    }
        echo "$nbrAdherents adhérents , $nombreDeTranches tranches de 70€ pour un Total de $tranchePrice €\n";
        $prixAdherents += $tranchePrice;

    } else {
        // Calcul du prix pour chaque tranche
        foreach ($tranches as $limite => $tarif) {
            if ($nbrAdherents <= $limite) {
                $prixAdherents += $tarif * $nbrAdherents;
                echo "Tranche appliquée: $tarif * $nbrAdherents\n";
                break;
            } else {
                $prixAdherents += $tarif * $limite;
                $nbrAdherents -= $limite;
            }
        } 
    }

    // Si le nombre d'adhérents est supérieur à 10000
    if ($nbrAdherents > 10000) {
        $prixAdherents = 1000;
    }

    // Avantages selon la fédération
    switch ($federation) {
        case "N":
            $prixAdherents -= 3;
            echo "Avantage Fédération de Natation Déduction de 3 sections $prixAdherents €\n";
            break;
        case "G":
            $prixAdherents *= 0.85; // 15% pour la gymnastique
            echo "Avantage Fédération de Gymnastique Réduction de 15% $prixAdherents €\n";
            break;
        case "B":
            $prixAdherents *= 0.7; // 30% pour le basketball
            echo "Avantage Fédération de Basketball Réduction de 30% $prixAdherents €\n";
            break;
        case "C":
            $prixAdherents = 0; // Aucun avantage sans Fédération
            echo "Aucun Avantage de Fédérattion $prixAdherents €\n";
            break;
    }

    // Modification du prix des sections
    for ($i = 1; $i <= $nbrSections; $i++) {
        $prixSection = 5;

        // Si la section est offerte
        if ($i <= $sectionsOffertes) {
            $prixSection = 0; // Inchangé reste à 5€

        } elseif ($moisEnCours % $i == 0) {
            $prixSection = 3; // Le prix de la section passe à 3€
        }

        // Ajout du prix de la section à l'adhésion
        $prixAdherents += $prixSection;
    }

    // Ajout de la TVA
    $prixAdherents *= 1.20;
    echo "Ajout de la TVA de 20% : $prixAdherents €\n";

    return $prixAdherents;
}

$moisEnCours = 2;
$nbrSections = 4;
$sectionsOffertes = 3;

$test = calculPrixAdherents(301, "N", $moisEnCours, $nbrSections, $sectionsOffertes);
echo "Prix de l'adhésion : $test\n";
