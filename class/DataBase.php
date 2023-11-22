<?php
    class Database
    {
        
        function __construct( )
        {
            require_once 'config.php';
            $this->pdo = connect_bd();
            
            
        }
        function getCars()
        {
            $query = $this->pdo->prepare('SELECT * FROM cars');
            if($query->execute()) {
                $datas = $query->fetchAll();
                return  $datas;
            }
            else {
                echo "Erreur";
            }
        }
        function printId($id)
        {
            $this->id = $id;
            echo $this->id;
        }
        function printTable($table)
        {
            $this->table = $table;
            echo $this->table;
        }
        function getTableByName($table)
        
        {
            $this->table = $table;
            $query = $this->pdo->prepare('SELECT * FROM '.$this->table);
            $query->execute(); 
            $datas = $query->fetchAll();
            return  $datas;
        }

        function getRowInTable($table, $id, $col)
        
        {
            $this->table = $table;
            $this->id = $id;
            $this->col = $col;
            $query = $this->pdo->prepare('SELECT * FROM '.$this->table.' WHERE '.$this->col.' = '.$this->id);
            $query->execute(); 
            $datas = $query->fetch();
            return  $datas;
        }
    }
?>
