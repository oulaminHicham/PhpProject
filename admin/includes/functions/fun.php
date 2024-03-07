<?php
//########### 
//##getTitle function v.1.0
//## title function that echo the page title in case the page has a variable $pageTitle
//###########
function getTitle(){
    global $pageTitle;
    if(isset($pageTitle)){
        echo $pageTitle;
    } else{
        echo "Defaulte";
    }
}
// ####################### redirectTohom function v.2.0
//hom readirect function where we have error [this function accept parameters]
        //# $theMessage = echo the  message[error  , success , worning ,]
        //# $econd      = befaure redirecting
        //# url         = teh link that you are want to direct to hem
///########################
function redirectToHom($errMessage ,$url=null,$seconds=3){
    if($url === null){
        $url='dashbord.php';
        $link='home page';
    }
    else{
        $url=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='' ? $url=$_SERVER['HTTP_REFERER'] :'dashbord.php';
        $link='Previous Page';
    }
    echo  $errMessage;
    echo "<div class='alert alert-info'>You Well Be Redirected To $link  After $seconds Second </div>";
    header("refresh:$seconds;url=$url");
    exit();
}
/*
    #### check item function v.1.0
    # function to check item if it is exists in database[function accept parameter]
    # $select --> the item to select [Exemple --> item , user , categorie ,...]
    # $from   --> the table to select from [Exemples ---> users , items , categories , ...]
    3 $value  --> the value of select [my tatch --> if $value !== tan null we use function to count itmes]
*/
function checkItme($select , $from , $value=null){
    global $con;
    if($value !== null){
        $stmtChekItem=$con   -> prepare("SELECT $select FROM $from WHERE $select=:val");
        $stmtChekItem        -> bindValue(":val",$value);
        $stmtChekItem        -> execute();
        $count=$stmtChekItem -> rowCount();
        return $count;
    }else{
        $stmtChekItem=$con   -> prepare("SELECT $select FROM $from");
        $stmtChekItem        -> execute();
        $count=$stmtChekItem -> rowCount();
        return $count;
    }
}
/*
### count Number of items
countItms() function v.1.0
## function accept 2 parameter
    1/ $itme  ---> for you sherche to count it
    2/ $table ---> table from you get count

*/
function countItms($item , $table){
    global $con;
    $stmt2=$con ->prepare("SELECT COUNT($item) FROM $table");
    $stmt2      -> execute();
    return $stmt2->fetchColumn();
}
/*
**  get Latest REcords function v1.0 
**  Functon to get Latest items fro data base [Users , items , Comments]
**  $select   --> filed to select
**  $table    --> table to chooce from
**  $orderdBy --> teh desc order
**  $limit  number of items to get [not requiered take 5 by defaulte]
*/
function getLatestItmes($select , $table, $orderdBy ,$limit=5){
    global $con;
    $getStmt = $con -> prepare("SELECT $select FROM $table ORDER BY $orderdBy DESC LIMIT $limit");
    $getStmt        -> execute();
    $rows=$getStmt  -> fetchAll(PDO::FETCH_ASSOC);
    return $rows;
}





















?>