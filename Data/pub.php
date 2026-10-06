<?php
/* =====================================================================
 * ESPACE PUBLICITAIRE (bande fixe en bas de toutes les pages)
 * ---------------------------------------------------------------------
 * Pour changer la pub : mettre le nouveau fichier dans images/pub/
 * puis modifier 'fichier' (et 'type' si c'est une image).
 *   - type    : 'video' (.mp4) ou 'image' (.jpg / .png / .gif)
 *   - fichier : chemin du fichier
 *   - lien    : page ouverte au clic ('' = pas de lien)
 *   - actif   : false pour cacher complètement la bande
 * Format conseillé : 1920 x 96 px (bande horizontale)
 * ===================================================================== */
return [
    'actif'   => true,
    'type'    => 'video',
    'fichier' => 'images/pub/pub-csc.mp4',
    'poster'  => 'images/pub/pub-csc-poster.jpg',   // image affichée pendant le chargement de la vidéo
    'lien'    => '',
    'alt'     => 'CS Constantine - The Dean 1898',
];
