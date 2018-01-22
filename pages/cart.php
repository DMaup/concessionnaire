<h1> Comparateur: </h1>
<?php 

    $id_user = $_SESSION["user"]["id"];
    $cart = getCars($id_user);
    // $total = 0;

    foreach( $cart as $car ) {

        $html_car = '<div style="border: 1px solid black; margin: 5px;">';
            $html_car .= '<h4>' . $car["mark"] . '</h4>';
            $html_car .= '<img src="img/' . $car["picture"] . '" width="200px" />';
            $html_car .= '<p>' . $car["price"] . ' €</p>';         
        $html_car .= '</div>';

        echo $html_car;        
    }
    echo '<input type="submit" value="Vider le comparateur">'; 
    
?>