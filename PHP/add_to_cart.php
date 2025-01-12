<?php
session_start();

// Vérification des données envoyées par le formulaire
if (isset($_POST['quantite'], $_POST['product_id'])) {
    $quantite = intval($_POST['quantite']); // Conversion de la quantité en entier
    $productID = intval($_POST['product_id']); // Conversion de l'ID du produit en entier

    // Vérification de l'état de la session
    if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
        $_SESSION['cart'] = []; // Initialisation du panier sous forme de tableau
    }

    // Vérification si le produit existe déjà dans le panier
    if (isset($_SESSION['cart'][$productID]) && is_array($_SESSION['cart'][$productID])) {
        // Si le produit existe déjà, on ajoute la quantité
        $_SESSION['cart'][$productID]['quantity'] += $quantite;
    } else {
        // Si le produit n'est pas dans le panier, on l'ajoute
        $_SESSION['cart'][$productID] = [
            'name' => 'Tee-shirt Homme', // Nom du produit
            'price' => 20,               // Prix du produit
            'quantity' => $quantite      // Quantité
        ];
    }

    // Redirection vers le panier
    header('Location: ../HTML/Panier.php');
    exit();
} else {
    echo "Les données du formulaire ne sont pas valides.";
}
?>