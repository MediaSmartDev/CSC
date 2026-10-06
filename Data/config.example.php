<?php
/*
 * Modèle de configuration.
 * 1) Copier ce fichier en "config.php" dans le même dossier (Data/).
 * 2) Mettre les vrais identifiants (local XAMPP ou serveur cPanel).
 * config.php est ignoré par Git : les mots de passe ne partent jamais sur GitHub.
 */
return [
    'db_host' => 'localhost',
    'db_name' => 'csc_db',
    'db_user' => 'root',
    'db_pass' => '',
    // Adresse qui reçoit les inscriptions du site
    'mail_to'   => 'contact@csconstantine.dz',
    'mail_from' => 'no-reply@csconstantine.dz',
    'debug'   => true,   // false en production
];
