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
    
    function getClassmentTable(){
        return queryAll("SELECT * FROM `classement` ORDER BY pos ASC");
    }
    
    function getPlaersByCateg($i){
        return query_all("SELECT * FROM `joueurs` WHERE categorie = ? AND `published` = ? ORDER BY nom ASC",array($i,1));
    }
    function getPlayersByNumber($i){
        $data = query_all("SELECT * FROM `joueurs` WHERE dossard = ?",array($i));
        return $data[0];
    }
    function getFeaturedPlayers(){
        return query_all("SELECT * FROM `joueurs` WHERE `featured` = ?  AND `published` = ?  LIMIT 4",array(1,1));
    }
    function getContact(){
        $data = queryAll("SELECT * FROM `contact`");
        return $data[0];
    }
    function getNextMatch(){
        $data = queryAll("SELECT * FROM `calendrier25`");
        return $data[0];
    }
    function getNextMatchList(){
        return queryAll("SELECT * FROM `calendrier25`");
    }
    function getPartenairesList(){
        return query_all("SELECT * FROM `partenaires` WHERE `published` = ? LIMIT 3",array(1));
    }
    