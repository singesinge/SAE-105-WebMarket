<?php
session_start();

// Vérification de l'état de la session
if (!isset($_SESSION['cart']) || !is_array($_SESSION['cart'])) {
    $_SESSION['cart'] = []; // Initialisation du panier sous forme de tableau
}

// Mise à jour des quantités ou suppression des produits
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['update'])) {
        foreach ($_POST['quantite'] as $productID => $quantity) {
            if ($quantity <= 0) {
                unset($_SESSION['cart'][$productID]); // Supprimer le produit si la quantité est 0 ou moins
            } else {
                $_SESSION['cart'][$productID]['quantity'] = intval($quantity); // Mettre à jour la quantité
            }
        }
    } elseif (isset($_POST['remove'])) {
        $productID = intval($_POST['product_id']);
        unset($_SESSION['cart'][$productID]); // Supprimer le produit
    }
}

// Calcul du total
$total = 0;
foreach ($_SESSION['cart'] as $product) {
    if (is_array($product)) {
        $total += $product['price'] * $product['quantity'];
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart - MMI SDG</title>
    <link rel="stylesheet" href="../CSS/stylePanier.css">
</head>

<body>
    <header>
        <nav class="navbar">
            <a href="Index.html">
                <img class="logo" src="../Ressources/Logo.png" alt="Logo de l'entreprise">
            </a>
            <a href="../HTML/Panier.php" class="lang-button">FR</a>
            <ul class="liens">
                <li><a href="Index.html">Home</a></li>
                <li><a href="Vetements.html">Clothing</a>
                    <ul class="sousliens">
                        <li><a href="Homme.html">Man</a></li>
                        <li><a href="Femme.html">Woman</a></li>
                        <li><a href="Enfants.html">Child</a></li>
                    </ul>
                </li>
                <li><a href="Accessoires.html">Accessories</a>
                    <ul class="sousliens">
                        <li><a href="SkiNautique.html">Water skiing</a></li>
                        <li><a href="PlancheAVoile.html">Windsurf</a></li>
                        <li><a href="SUP.html">SUP</a></li>
                        <li><a href="Kayak.html">Canoeing</a></li>
                    </ul>
                </li>
                <li><a href="Tutoriels.html">Tutorials</a></li>
                <li><a href="Contact.html">Contact</a></li>
                <li><a href="Panier.php"><img class="panier" src="../Ressources/Panier.png" alt="iconPanier"></li></a>
            </ul>
        </nav>
        <div class="promo-banner">
            <p>Use the code ‘BIENVENUE’ to get 10% off your entire order!</p>
        </div>
    </header>
    <h1>Your cart</h1>
    <div class="cart-container">
        <?php if (empty($_SESSION['cart'])): ?>
            <p>Your cart is empty.</p>
        <?php else: ?>
            <form action="Panier.php" method="POST">
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($_SESSION['cart'] as $productID => $product): ?>
                            <?php if (is_array($product)): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($product['name']); ?></td>
                                    <td><?php echo htmlspecialchars($product['price']); ?> €</td>
                                    <td>
                                        <input type="number" name="quantite[<?php echo $productID; ?>]" value="<?php echo $product['quantity']; ?>" min="0">
                                    </td>
                                    <td><?php echo htmlspecialchars($product['price'] * $product['quantity']); ?> €</td>
                                    <td>
                                        <button type="submit" name="remove" value="1">Remove</button>
                                        <input type="hidden" name="product_id" value="<?php echo $productID; ?>">
                                    </td>
                                </tr>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <p class="total">Total: <?php echo $total; ?> €</p>
                <button type="submit" name="update">Update cart</button>
                <button type="button" class="pay-button">Pay</button>
            </form>
        <?php endif; ?>
        <a class="continue-shopping" href="index.html">continue shopping </a>
    </div>

    <footer>
        <div class="footer">
            <div class="footer1">
                <p>@BUT MMI Toulon</p>
                <a href="Index.html">
                    <img class="logo" src="../Ressources/Logo.png" alt="Logo de l'entreprise">
                </a>
                <a href="Vetements.html"><button class="buttonFoot">Buy here</button></a>
            </div>

            <div class="footer2">
                <hr>
            </div>

            <div class="footer3">
                <div class="leftFoot">
                    <a href="Index.html">home</a>
                    <a href="Vetements.html">Clothing</a>
                    <a href="Accessoires.html">Accessories</a>
                    <a href="Tutoriels.html">Tutorials</a>
                    <a href="Contact.html">Contact</a>
                </div>

                <div class="rightFoot">
                    <a href="">in</a>
                    <a href="">fb</a>
                    <a href="">X</a>
                    <a href="">Contact</a>
                </div>
            </div>
        </div>


    </footer>

</body>

</html>