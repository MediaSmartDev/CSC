<?php
/**
 * Description of DatabaseObject
 *
 * @author Wissem
 */
date_default_timezone_set("Africa/Algiers");
include('Connexion.php');

    function find_by_full_sql($sql, $array){
        return query_all($sql, $array);
    }    
    function find_by_fullsql($sql){    
        return queryAll($sql);      
    } 
    
    function insert($table, $sql, $array){
        return insertQuery("INSERT INTO ".$table." ".$sql, $array);
    }
    function insert_fullsql($sql){
        return insertQueryPDO($sql);
    }
    function update($table, $sql, $array){
        return updateQuery("UPDATE ".$table." SET ".$sql, $array);
    }
    function delete($table, $sql, $array){
        return (updateQuery("DELETE FROM ".$table." WHERE ".$sql, $array) == 1);
    }
    
    /* Classement : lu depuis Data/classement.php (plus de SQL à importer) */
    function csc_classement_data(){
        static $d = null;
        if ($d === null) { $d = @include __DIR__ . '/classement.php'; if (!is_array($d)) $d = []; }
        return $d;
    }
    function getClassmentTable(){
        $d = csc_classement_data();
        $clubs = @include __DIR__ . '/clubs.php';
        if (!is_array($clubs)) $clubs = [];
        $rows = []; $pos = 0;
        foreach (($d['clubs'] ?? []) as $c) {
            $pos++;
            [$code, $j, $g, $n, $p, $bp, $bc, $pts] = $c;
            $info = $clubs[$code] ?? ['fr' => $code, 'ar' => $code, 'logo' => 'images/logo-csc.png'];
            $rows[] = ['pos' => $pos, 'position' => $pos, 'club' => $info['fr'], 'club_ar' => $info['ar'],
                       'logo' => $info['logo'], 'j' => $j, 'g' => $g, 'n' => $n, 'p' => $p,
                       'bp' => $bp, 'bc' => $bc, 'db' => $bp - $bc, 'points' => $pts];
        }
        if ($rows) return $rows;
        $r = queryAll("SELECT *, pos AS position FROM `classement` ORDER BY pos ASC");
        return is_array($r) ? $r : [];
    }
    function getClassementInfo(){
        $d = csc_classement_data();
        if (!empty($d['clubs'])) return ['saison' => $d['saison'] ?? '', 'journee' => $d['journee'] ?? '', 'mise_a_jour' => $d['mise_a_jour'] ?? ''];
        $r = queryAll("SELECT * FROM `classement_info` LIMIT 1");
        return (is_array($r) && isset($r[0])) ? $r[0] : null;
    }

    function getPlaersByCateg($i){
        $r = query_all("SELECT * FROM `joueurs` WHERE categorie = ? AND `published` = ? ORDER BY ordre ASC, dossard ASC, nom ASC",array($i,1));
        return is_array($r) ? $r : [];
    }
    function getPlayersByNumber($i){
        $data = query_all("SELECT * FROM `joueurs` WHERE dossard = ?",array($i));
        return (is_array($data) && isset($data[0])) ? $data[0] : null;
    }
    /* Joueurs affichés sur l'accueil (numéros de maillot, dans cet ordre) */
    function getHomePlayers($numeros = [17, 10, 4, 9]){
        $in = implode(',', array_map('intval', $numeros));
        $r = queryAll("SELECT * FROM `joueurs` WHERE categorie BETWEEN 1 AND 4 AND published = 1 AND dossard IN ($in) ORDER BY FIELD(dossard, $in)");
        return is_array($r) ? $r : [];
    }
    function getFeaturedPlayers(){
        $r = query_all("SELECT * FROM `joueurs` WHERE `featured` = ?  AND `published` = ?  LIMIT 4",array(1,1));
        return is_array($r) ? $r : [];
    }
    /* Age : calculé depuis date_naissance si connue, sinon colonne age (donnée LFP) */
    function playerAge($row){
        if (!empty($row['date_naissance'])) {
            return (new DateTime())->diff(new DateTime($row['date_naissance']))->y;
        }
        return isset($row['age']) ? (int)$row['age'] : '';
    }
    function getContact(){
        $data = queryAll("SELECT * FROM `contact`");
        return (is_array($data) && isset($data[0])) ? $data[0] : null;
    }
    function getNextMatch(){
        $data = queryAll("SELECT * FROM `calendrier25`");
        return (is_array($data) && isset($data[0])) ? $data[0] : null;
    }
    function getNextMatchList(){
        $r = queryAll("SELECT * FROM `calendrier25`");
        return is_array($r) ? $r : [];
    }
    function getPartenairesList(){
        $r = query_all("SELECT * FROM `partenaires` WHERE `published` = ? LIMIT 3",array(1));
        return is_array($r) ? $r : [];
    }
