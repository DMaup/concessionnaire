<div id="shop">
<?php 

    $index_page = 0;
    if( isset( $_GET["index_page"] ) ){
        $index_page = $_GET["index_page"];
    }

?>
<?php 
    $cars = getCars( $index_page );

    if( count($cars) ){

        $html_car = '<form action="?service=cart" method="POST">';

            // Génération des articles
            foreach( $cars as $key => $car ) {

                $html_car .= '<div style="border: 1px solid black; margin: 5px;">';
                    $html_car .= '<input type="checkbox" name="' . $car["mark"] . '" value="' . $car["id"] . '">';
                    $html_car .= '<h4>' . $car["mark"] . '</h4>';
                    $html_car .= '<p>' . $car["color"] . '</p>';
                    $html_car .= '<img src="img/' . $car["picture"] . '" width="200px" />';
                    $html_car .= '<p>' . $car["price"] . ' €</p>';
                $html_car .= '</div>';  

            }

            $html_car .= '<input type="submit" value="Comparer">';
        $html_car .= '</form>';

        // Génération de la liste des pages
        $html_car .= '<ul>';

        $nb_pages = ceil( countCars() / CARS_BY_PAGE );
        
        for( $i=0; $i < $nb_pages; $i++ ){

            $html_car .= '<li>';
                $html_car .= '<a href="?page=shop&index_page=' . $i .'" >' ;
                    $html_car .= ($i + 1);
                $html_car .= '</a>';
            $html_car .= '</li>';

        }

        $html_car .= '</ul>';

        echo $html_car;
    }
    else {
        echo "<div> Aucun article trouvé ! </div>";
    }
?>
</div>