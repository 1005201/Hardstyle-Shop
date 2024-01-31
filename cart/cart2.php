<?php


// pussydogwinkel@hotmail.com
// pussydog123#
require_once('header.php');

if(!empty($_POST["Email"]))
{
    header('Location: thankyou.php');
}

if(isset($_GET['product']))
{
    $_SESSION['winkelwagen'][time()] = [$_GET['product'], $_GET['price']];
}

if(isset($_GET['delete']))
{
    unset($_SESSION['winkelwagen'][$_GET['delete']]);
}

if(!empty($_SESSION['winkelwagen']))
{
    $total = 0;
    foreach($_SESSION['winkelwagen'] as $key => $product)
    {
        $delete = " <a href=\"?delete={$key}\">X</a>";
        echo "<br />". $product[0]." a ".$product[1].$delete;
        $total += $product[1];
        $index++;
    }

    echo "<br /><br />Totaal: ".$total;
}
?>

    <h3>Bestellen</h3>
    <p>U kunt de producten bij ons bestellen en afhalen. Betalen alleen contant in de winkel. Wij sturen u een e-mail als de bestelling klaar ligt</p>
    <form method="POST">
        Naam:
        <input type="text" name="Naam">
        <br />
        E-mail:
        <input type="text" name="Email">
        <br />
        <input type="submit">

<?php
