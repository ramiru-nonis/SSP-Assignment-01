<?php

// Remove query string and leading slash
$requestURI  = explode('?', $_SERVER['REQUEST_URI'], 2)[0];
$requestPath = trim($requestURI, '/');

// ─── Route Map ──────────────────────────────────────────────────────────────
$links = [

    // Auth
    "Celario_lite/cellario_lite/Login"    => "./src/pages/Login.php",
    "Celario_lite/cellario_lite/Register" => "./src/pages/Register.php",
    "Celario_lite/cellario_lite/Logout"   => "./src/pages/Logout.php",

    // Customer — Browse
    "Celario_lite/cellario_lite/Products"        => "./src/pages/Customer/Products.php",
    "Celario_lite/cellario_lite/Products/Detail" => "./src/pages/Customer/ProductDetail.php",

    // Customer — Cart
    "Celario_lite/cellario_lite/Cart"        => "./src/pages/Customer/Cart.php",
    "Celario_lite/cellario_lite/Cart/Add"    => "./src/pages/Customer/cart_add.php",
    "Celario_lite/cellario_lite/Cart/Remove" => "./src/pages/Customer/cart_remove.php",

    // Customer — Favorites / Wishlist
    "Celario_lite/cellario_lite/Favorites"           => "./src/pages/Customer/Wishlist.php",
    "Celario_lite/cellario_lite/Favorites/Add"       => "./src/pages/Customer/addFavorite.php",
    "Celario_lite/cellario_lite/Favorites/Remove"    => "./src/pages/Customer/removeFavorite.php",
    "Celario_lite/cellario_lite/Favorites/AddToCart" => "./src/pages/Customer/wishlistAddToCart.php",

    // Customer — Checkout
    "Celario_lite/cellario_lite/Checkout"    => "./src/pages/Customer/Checkout.php",

    // Customer — Account
    "Celario_lite/cellario_lite/Account/Edit" => "./src/pages/Customer/EditAccount.php",

    // Static pages
    "Celario_lite/cellario_lite/About"   => "./src/pages/Customer/About.php",
    "Celario_lite/cellario_lite/Contact" => "./src/pages/Customer/Contact.php",

    // Admin
    "Celario_lite/cellario_lite/Admin/Dashboard"      => "./src/pages/Admin/Dashboard.php",
    "Celario_lite/cellario_lite/Admin/ManageProducts" => "./src/pages/Admin/ManageProducts.php",
    "Celario_lite/cellario_lite/Admin/AddProduct"     => "./src/pages/Admin/AddProduct.php",
    "Celario_lite/cellario_lite/Admin/EditProduct"    => "./src/pages/Admin/EditProduct.php",
    "Celario_lite/cellario_lite/Admin/DeleteProduct"  => "./src/pages/Admin/DeleteProduct.php",
    "Celario_lite/cellario_lite/Admin/ManageAccounts" => "./src/pages/Admin/ManageAccounts.php",
    "Celario_lite/cellario_lite/Admin/DeleteAccount"  => "./src/pages/Admin/DeleteAccount.php",
];

foreach ($links as $key => $value) {
    if ($requestPath === $key) {
        include_once $value;
        exit;
    }
}

// Home page fallback
if ($requestPath === 'Celario_lite/cellario_lite' || $requestPath === '') {
    include_once "./index.php";
    exit;
}

// 404
http_response_code(404);
include_once "./src/private/initialize.php";
session_start();
$pageTitle = "Page Not Found";
include_once(SHARED_PATH . "/customer_header.php");
echo '<div style="min-height:60vh;display:flex;flex-direction:column;justify-content:center;align-items:center;text-align:center;padding:3rem;">
  <div style="font-family:Cormorant Garamond,serif;font-size:6rem;font-weight:700;color:#C9A84C;line-height:1;">404</div>
  <h1 style="font-family:Cormorant Garamond,serif;font-size:2rem;font-weight:600;color:#0D0D0D;margin:.5rem 0;">Page Not Found</h1>
  <p style="font-size:.9rem;color:#9CA3AF;margin-bottom:2rem;">The page you are looking for does not exist.</p>
  <a href="/Celario_lite/cellario_lite/" style="display:inline-block;padding:.875rem 2rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:2px;">Return Home</a>
</div>';
include_once(SHARED_PATH . "/customer_footer.php");
