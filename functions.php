<?php
session_start();

define("DB_HOST", "localhost");
define("DB_NAME", "concessionnaire");
define("DB_USER", "root");
define("DB_PASS", "root");
define("CARS_BY_PAGE", 2);

// function connectionRequired(){
    
//     if( !isset( $_SESSION["user"] ) ){

//         header("Location: ?page=login");
//         die();
//     }
//     else if( !isLogged() ){

//         $error = "Vous n'avez les autorisations nécessaires !";
//         header("Location: ?page=login&error=".$error);
//         die();

//     }

// }

function getConnection(){

    $connection = mysqli_connect(DB_HOST, DB_USER, DB_PASS, DB_NAME);
    if( $errors = mysqli_connect_error($connection) ){
        $errors = utf8_encode($errors);
        header("Location: ?page=login&error=" . $errors); 
        die();
    }

    return $connection;

}   

/***** cars ******/

function getcars( $page_index = 0 ){

    $connection = getConnection();
    $sql = "SELECT id, marks.label_mark, colors.label_color, price, picture
    FROM cars
    INNER JOIN colors ON colors.id_color = cars.id_color
    INNER JOIN marks ON marks.id_mark = cars.id_mark
    LIMIT ?, ?";
    
    $start_index = $page_index * CARS_BY_PAGE;
    $end_index = CARS_BY_PAGE;
    
    // var_dump ($start_index);
    // var_dump ($end_index);

    $statement = mysqli_prepare( $connection, $sql );
    mysqli_stmt_bind_param( $statement, "ii", $start_index, $end_index);
    mysqli_stmt_execute( $statement );
    mysqli_stmt_bind_result( $statement, $b_id, $b_mark, $b_color, $b_price, $b_picture );

    $cars = [];
    while( mysqli_stmt_fetch( $statement ) ) {
        
        $cars[] = [
            "id" => $b_id,
            "mark" => $b_mark,
            "color" => $b_color,
            "price" => $b_price,
            "picture" => $b_picture
        ];

    }
    
    mysqli_stmt_close( $statement );
    mysqli_close( $connection );

    return $cars;
}

function countcars(){

    $connection = getConnection();
    $sql = "SELECT COUNT(*) as number FROM cars";
    $results = mysqli_query( $connection, $sql );
    $result = mysqli_fetch_assoc( $results );
    mysqli_close( $connection );

    return $result["number"];

}

/****** CART ******/


// function addToCart( $id_user, $id_cars ){

//     // Vérifier si la liaison existe
//     // Insert / Update en fonction de la présence

//     $connection = getConnection();
//     $sql = "SELECT COUNT(*) as number FROM carts 
//     AND cars  $statement = mysqli_prepare( $connection, $sql );
//     mysqli_stmt_bind_param( $statement, "ii", $id_user, $carsmysqli_stmt_execute( $statement );
//     mysqli_stmt_bind_result( $statement, $b_number );
//     mysqli_stmt_fetch($statement);
    
//     // $b_number 0 ou 1
//     if( $b_number ){

//         $sql = "UPDATE carts SET quantity=quantity+1 WHERE id_user=? AND cars   }
//     else {
        
//         // Par default, le champs quantity est configuré sur 1
//         $sql = "INSERT INTO carts (id_user, carsS (?, ?)";

//     }

//     mysqli_stmt_close( $statement );

//     $statement = mysqli_prepare( $connection, $sql );
//     mysqli_stmt_bind_param( $statement, "ii", $id_user, $carsmysqli_stmt_execute( $statement );
//     $error = mysqli_error( $connection )
//     mysqli_stmt_close( $statement );
//     mysqli_close( $connection );

//     if( $error ){
//         return false;
//     }
//     else {
//         return true;
//     }
// }

function debug( $arg, $printr = false ){
    
    if( $printr ){
        echo "<pre>";
        print_r($arg);
        echo "</pre>";
    }
    else {
        var_dump( $arg );
    }
    
    die();

}

/* COOKIE */

// $cart = [
//     [
//         "name" => "rocket",
//         "price" => 15,
//         "image" => "rocket.jpg"
//     ],
//     [
//         "name" => "groot",
//         "price" => 18,
//         "image" => "groot.jpg"
//     ]
// ];

//JSON.stringify -> json_encode
// $str_cart = json_encode($cart);
// echo $str_cart;
// setcookie("TEST", $str_cart, time() + 3600*24);

// //JSON.parse -> json_decode
// $decode_cart = json_decode( $_COOKIE["TEST"] );
// var_dump( $decode_cart );