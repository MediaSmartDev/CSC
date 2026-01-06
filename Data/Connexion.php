<?php
$DB_HOST = 'localhost';
$DB_USER = '';
$DB_PASS = '';
$DB_NAME = '';
$pdo;
$pdo2;
$statement;
$statement2;

        function getConnectionPDO(){
           global $DB_HOST, $DB_USER, $DB_PASS, $DB_NAME, $pdo;
                $dsn='mysql:host='.$DB_HOST.';dbname='.$DB_NAME.';charset=utf8';
                try{
                       //$pdo = new PDO($dsn, $DB_USER, $DB_PASS);
                        $pdo = new PDO('mysql:host=localhost;dbname=cscdz9818_pitanco;charset=utf8', 'cscdz9818_kia', 'Lovisca.com#2904' );
                        //echo'Connexion etablit avec succès !';                       
                } catch (PDOException $e) {
                        //echo 'Could not connect to database ' . $e->getMessage();
                    echo 'Could not service your request. Please try again later.!';
                }
                return $pdo;
	   }        
        function executeQuery_PDO($sql, array $array){
            global $pdo, $statement;            
            if ($pdo === null) getConnectionPDO ();           
            if (empty($sql)) return $null;           
            if ($array === null || sizeof($array) == 0) return null;            
            try {
                $statement = $pdo->prepare($sql);
                ini_set('memory_limit', '-1');
                $statement->execute($array);
//                $count = $statement->rowCount();
            } catch (Exception $ex) {
                    echo 'Could not execute query' . $ex->getMessage();
            }           
            return $statement;
        }        
        function executeQueryPDO($sql){
            global $pdo, $statement;            
            if ($pdo === null) getConnectionPDO ();           
            if (empty($sql)) return $null;                     
            try{
                $statement = $pdo->query($sql);                
            } catch (Exception $ex) {
                echo 'Could not execute query' . $ex->getMessage();
            }           
            return $statement;           
        }
        function insertQuery($sql, array $array){
             global $pdo, $statement;
            
            if ($pdo === null) getConnectionPDO ();           
            if (empty($sql)) return -1;           
            if ($array === null || sizeof($array) == 0) return -1;
            // -1 means operation didn't succeed
            $id = -1;
            try {
                $statement = $pdo->prepare($sql);
                $statement->execute($array);
                $err = $statement->errorInfo();
                //$statement->debugDumpParams();;
                $id= $pdo->lastInsertId();
              
            } catch (Exception $ex) {
                    echo 'Could not insert query' . $ex->getMessage();
            }
            if ($id == 0) {
                $id = -1;
                $fp = fopen('error_log_sql.txt', 'a');
                $input = "[".date('Y:m:d H:i:s')."] SQL insertQuery: ".print_r($err,true);
                fputs($fp, $input."\n");
                $input = "SQL: ".$sql." ".print_r($array,true);
                fputs($fp, $input."\n");
            }
			close();
            return $id;    
        }        
        function insertQueryPDO($sql){
            global $pdo, $statement;
            if ($pdo === null) getConnectionPDO ();   
            if (empty($sql)) return -1; 
            $id = -1;
            try {
                $statement = $pdo->query($sql);
                $err = $pdo->errorInfo();
                $id= $pdo->lastInsertId();
              
            } catch (Exception $ex) {
                    echo 'Could not insert query' . $ex->getMessage();
            }
            if ($id == 0) {
                $id = -1;
                $fp = fopen('error_log_sql.txt', 'a');
                $input = "[".date('Y:m:d H:i:s')."] SQL insertQueryPDO: ".print_r($err,true);
                fputs($fp, $input."\n");
                $input = "SQL: ".$sql;
                fputs($fp, $input."\n");
            }
			close();
            return $id;    
        }  
        function updateQuery($sql, array $array){
             global $pdo, $statement;
            
            if ($pdo === null) getConnectionPDO ();           
            if (empty($sql)) return -1;           
            if ($array === null || sizeof($array) == 0) return -1;
            
            $resultat = 1;
            try {
                $statement = $pdo->prepare($sql);
                $statement->execute($array);
                $err = $statement->errorInfo();
                $count = $statement->rowCount();
                $s = $statement->errorInfo();
                if ($count == 0){
                    $resultat = -1;
                    
                    $fp = fopen('error_log_sql.txt', 'a');
                    $input = "[".date('Y:m:d H:i:s')."] SQL updateQuery: ".print_r($err,true);
                    fputs($fp, $input."\n");
                    $input = "SQL: ".$sql." ".print_r($array,true);
                    fputs($fp, $input."\n");
                }
            } catch (Exception $ex) {
                    echo 'Could not update query' . $ex->getMessage();
            }
            close();
//            return $count;  
            return $resultat;
        }
        function updateQueryPDO($sql){
             global $pdo, $statement;
            
            if ($pdo === null) getConnectionPDO ();           
            if (empty($sql)) return -1;                      
            
            $resultat = 1;
            try {
                $statement = $pdo->query($sql);
                $err = $pdo->errorInfo();
                $count = $statement->rowCount();
                if ($count == 0){
                    $resultat = -1;
                    $fp = fopen('error_log_sql.txt', 'a');
                    $input = "[".date('Y:m:d H:i:s')."] SQL updateQuery: ".print_r($err,true);
                    fputs($fp, $input."\n");
                    $input = "SQL: ".$sql." ".print_r($array,true);
                    fputs($fp, $input."\n");
                }
              
            } catch (Exception $ex) {
                    echo 'Could not update query' . $ex->getMessage();
            }
			close();
            return $resultat;
        }        
        function query_all($sql, $array){
           
            $statement = executeQuery_PDO($sql, $array);
            
            if ($statement === null) return null;
            
            $data = array();
            $arraydata = array();
            
            while($data=$statement->fetch(PDO::FETCH_ASSOC)){
                $arraydata[]=$data;
            }
			close();
            return $arraydata;
            
        }
        function queryAll($sql){
            $statement = executeQueryPDO($sql);            
            if ($statement === null) return null;           
            $data = array();
            $arraydata = array();            
            if($statement != false){
                while($data=$statement->fetch(PDO::FETCH_ASSOC)){
                    $arraydata[]=$data;
                }
				close();
                return $arraydata;
            }else{
                return null;
            }
            
        }
        function close(){
            global $pdo;
                $pdo = null;
	}    
?>