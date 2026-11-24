<?php
/* Catégories jeunes : mêmes codes que Data/jeunes.php */
require_once __DIR__ . '/../../Data/jeunes.php';
const JEUNE_TYPES = [1 => 'Players', 2 => 'Staff'];
const JEUNE_POSTES = ['Goalkeeper', 'Defender', 'Midfielder', 'Forward'];
const JEUNE_POSTES_STAFF = ['Coach', 'Assistant coach', 'Goalkeeper coach', 'Fitness coach'];
const JEUNE_PHOTO_SIZE = [600, 750];   // même format que les cartes (4:5)

function jeune_cat_label(string $code): string {
    $c = CSC_JEUNES_CATEGORIES[$code] ?? null;
    return $c ? (admin_lang() === 'ar' ? $c[1] : $c[0]) : $code;
}
function jeune_poste(array $r): string {
    if (admin_lang() === 'ar' && ($r['poste_ar'] ?? '') !== '') return $r['poste_ar'];
    return $r['poste'] !== '' ? tr($r['poste']) : '';
}
