<?php
// //########### 
// //##getTitle function v.1.0
// //## title function that echo the page title in case the page has a variable $pageTitle
// //###########
function getTitle(){
    // global $titlePae;
    global $titlePae;
    if(isset($titlePae)){
        echo $titlePae;
    } else{
        echo "Defaulte";
    }
}
// function to get all categories
function getcat(){
    global $con;
        $cat=$con       -> prepare("SELECT * FROM Categories ORDER BY id");
        $cat            -> execute();
        $categorie=$cat -> fetchAll(PDO::FETCH_ASSOC);
        return $categorie;
}
// function to get all items
function getItems($where , $val){
    global $con;
        $items=$con      -> prepare("SELECT * FROM Items WHERE $where=? ORDER BY item_id DESC");
        $items           -> bindValue(1,$val);
        $items           -> execute();
        $allItems=$items -> fetchAll(PDO::FETCH_ASSOC);
        return $allItems;
}
// function to fetch users from database
function getUser($userID){
    global $con;
    $STMT=$con   -> prepare("SELECT * FROM users WHERE userID=:userid");
    $STMT        -> bindValue(':userid',$userID);
    $STMT        -> execute();
    $users=$STMT -> fetch(PDO::FETCH_ASSOC);
    return $users;
}
// function to check if user exits in database
function checkExits($select , $from , $closeCondi , $closeVal ){
    global $con;
    $statment=$con  -> prepare("SELECT $select FROM $from WHERE $closeCondi=?");
    $statment       -> bindValue(1,$closeVal);
    $statment       -> execute();
    $count=$statment-> rowCount();
    return $count;
}
// function to insert data in database
function InsertUser($vals){
    global $con;
    $isertStmt=$con ->prepare("INSERT INTO users(username,password,email,fullname,dateE)
                                VALUES (?,?,?,?,now())");
    $isertStmt ->execute([...$vals]);
    $results=$isertStmt ->fetch(PDO::FETCH_ASSOC);
    return $results;
}
// ########################################## My Work ################################################################
// function to success message
function getMsg($msg , $err=true){
    if($err === true){
        echo "<div class='alert alert-danger p-0 w-75 mx-auto text-center'>";
            echo $msg;
        echo"</div>";
    }else
    {
        echo "<div class='alert alert-success p-0 w-75 mx-auto text-center'>";
            echo $msg;
        echo"</div>";
    }
}
// function to get date from any table in data base v1
// $select  ==> what we want to select them
// $table   ==> table to select from
// $orderby ==> varable to specifed with what data ordered
function getDat($select , $table , $orderby , $orderWay){
    global $con;
        $dataStmt=$con     -> prepare("SELECT $select FROM $table ORDER BY $orderby $orderWay");
        $dataStmt          -> execute();
        $allData=$dataStmt -> fetchAll(PDO::FETCH_ASSOC);
        return $allData;
}
// function to select data with where close
// this function it use to select some data depend to condition 
// $select       ==> what we want to select them
// $conditionFor ==> for what apliced the condition
// $table        ==> table to select from
// $condition    ==> where close to select data
function getDataWcondition($select , $table ,$conditionFor ,$condition){
    global $con;
    $dataStatment=$con         -> prepare("SELECT $select FROM $table WHERE $conditionFor=?");
    $dataStatment              -> bindValue(1,$condition);
    $dataStatment              -> execute();
    $alldatareslt=$dataStatment-> fetchAll(PDO::FETCH_ASSOC);
    return $alldatareslt;
}
// function to check if user active or not
// function depend to regStatus to decide if user actived or not
// function accept one param
function checkUsersatus($ID){
    global $con;
    $STMTX=$con    -> prepare("SELECT regStatus FROM users WHERE userID =? AND regStatus = 0 ");
    $STMTX         -> bindValue(1,$ID);
    $STMTX         -> execute();
    $status=$STMTX -> rowCount();
    return $status;
}













































































































































































































// // ####################### redirectTohom function v.2.0
// //hom readirect function where we have error [this function accept parameters]
//         //# $theMessage = echo the  message[error  , success , worning ,]
//         //# $econd      = befaure redirecting
//         //# url         = teh link that you are want to direct to hem
// ///########################
// function redirectToHom($errMessage ,$url=null,$seconds=3){
//     if($url === null){
//         $url='dashbord.php';
//         $link='home page';
//     }
//     else{
//         $url=isset($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] !=='' ? $url=$_SERVER['HTTP_REFERER'] :'dashbord.php';
//         $link='Previous Page';
//     }
//     echo  $errMessage;
//     echo "<div class='alert alert-info'>You Well Be Redirected To $link  After $seconds Second </div>";
//     header("refresh:$seconds;url=$url");
//     exit();
// }
// /*
//     #### check item function v.1.0
//     # function to check item if it is exists in database[function accept parameter]
//     # $select --> the item to select [Exemple --> item , user , categorie ,...]
//     # $from   --> the table to select from [Exemples ---> users , items , categories , ...]
//     3 $value  --> the value of select [my tatch --> if $value !== tan null we use function to count itmes]
// */
// function checkItme($select , $from , $value=null){
//     global $con;
//     if($value !== null){
//         $stmtChekItem=$con   -> prepare("SELECT $select FROM $from WHERE $select=:val");
//         $stmtChekItem        -> bindValue(":val",$value);
//         $stmtChekItem        -> execute();
//         $count=$stmtChekItem -> rowCount();
//         return $count;
//     }else{
//         $stmtChekItem=$con   -> prepare("SELECT $select FROM $from");
//         $stmtChekItem        -> execute();
//         $count=$stmtChekItem -> rowCount();
//         return $count;
//     }
// }
// /*
// ### count Number of items
// countItms() function v.1.0
// ## function accept 2 parameter
//     1/ $itme  ---> for you sherche to count it
//     2/ $table ---> table from you get count

// */
// function countItms($item , $table){
//     global $con;
//     $stmt2=$con ->prepare("SELECT COUNT($item) FROM $table");
//     $stmt2      -> execute();
//     return $stmt2->fetchColumn();
// }
// /*
// **  get Latest REcords function v1.0 
// **  Functon to get Latest items fro data base [Users , items , Comments]
// **  $select   --> filed to select
// **  $table    --> table to chooce from
// **  $orderdBy --> teh desc order
// **  $limit  number of items to get [not requiered take 5 by defaulte]
// */
// function getLatestItmes($select , $table, $orderdBy ,$limit=5){
//     global $con;
//     $getStmt = $con -> prepare("SELECT $select FROM $table ORDER BY $orderdBy DESC LIMIT $limit");
//     $getStmt        -> execute();
//     $rows=$getStmt  -> fetchAll(PDO::FETCH_ASSOC);
//     return $rows;
// }





















?>