<?php 

try{
    $con = new PDO("mysql:hsot=localhost;dbname=projects","root",'');
    $con->setAttribute(PDO::ATTR_ERRMODE ,PDO::ERRMODE_EXCEPTION);
}catch(PDOException $e){
    die($e->getMessage());
}









/**
 *  Function fetch all data
 *  @var tb is table name  
 *  @return array of data
 *  */

 function all (String $tb) {

    global $con;
    try{
        $stmt = $con->prepare("SELECT * FROM $tb");
        $stmt->execute();
        return $stmt->fetchAll();
    }catch(PDOException $e){
        die($e->getMessage());
    }
    
    
 }


 /**
 *  Function insert  data
 *  @var tb is table name  
 *  @var data is array of data   
 *  @return null
 *  */

function insert (String $tb,Array $data = []) {
    
    // ['name' => 'dz','id'=>1]

    // array_keys($data) => ['name','id']
    global $con;

    // name,id
    $fields = join(',', array_keys($data));
   
    // array_fill(0,2,'?)
    // ?,?
    $qui =   join(',', array_fill(0,count($data),'?'));
    
    /// 1 , dz
    $values =  array_values($data);
    
    // INSET INTO TABLENAME () values ()
    // prepare('INSET INTO TABLENAME (name) values (?)')
    // execute(['dz'])

    try{
        $stmt = $con->prepare("INSERT INTO $tb ($fields) values ($qui) ");
        $stmt->execute($values);
     
        echo 'insert new recorde';
    }catch(PDOException $e){
        die($e->getMessage());
    }
    
    
 }


  /**
 *  Function insert  data
 *  @var tb is table name  
 *  @var data is array of data   
 *  @return null
 *  */

function update (String $tb,Array $data = [],$id) {

    global $con;
    $fields = join('=?,', array_keys($data)).'=?';

    $values =  array_values($data);
     
    //UPDATE namet set name = "aaa"  where id = 7
    // prepare(UPDATE namet set (name=?)  where id = $id)
       // execute(['dz'])
   
    try{
        $stmt = $con->prepare("UPDATE $tb set $fields WHERE id= $id");
       
        $stmt->execute($values);
     
        echo "{$stmt->rowCount()} updated";
    }catch(PDOException $e){
        die($e->getMessage());
    }
    
    
 }

   /**
 *  Function delte  data
 *  @var tb is table name  
 *  @var data is array of data   
 *  @return null
 *  */

function delete (String $tb,$id) {

    global $con;
    
    try{
        $stmt = $con->prepare("DELETE FROM ?  WHERE id= ?");
       
        $stmt->execute([$tb,$id]);
     
        echo "{$stmt->rowCount()} deleted";
    }catch(PDOException $e){
        die($e->getMessage());
    }
    
    
 }