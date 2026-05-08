<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: /Celario_lite/cellario_lite/Login");
    exit;
}

require_once "./src/php/Controller/CustomerController.php";
$controller = new CustomerController();
$favorites  = $controller->loadFavorites($_SESSION['user_id']);

$pageTitle = "My Wishlist";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>
<main style="min-height:100vh;background:#FAFAF8;padding:3rem 2rem;">
  <div style="max-width:1200px;margin:0 auto;">
    <div style="margin-bottom:2rem;">
      <h1 style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:#0D0D0D;">My Wishlist</h1>
      <p style="font-size:.85rem;color:#9CA3AF;"><?= count($favorites) ?> saved item<?= count($favorites)!==1?'s':'' ?></p>
    </div>
    <?php if (!empty($favorites)): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:1.5rem;">
      <?php foreach($favorites as $fav): ?>
        <?php $img = !empty($fav['main_image']) ? htmlspecialchars($fav['main_image']) : 'https://placehold.co/400x300/1A1A1A/C9A84C?text='.urlencode($fav['brand']); ?>
        <div style="background:white;border:1px solid #F0F0F0;border-radius:4px;overflow:hidden;transition:all .3s;display:flex;flex-direction:column;" onmouseover="this.style.borderColor='rgba(201,168,76,.4)';this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#F0F0F0';this.style.transform=''">
          <a href="/Celario_lite/cellario_lite/Products/Detail?id=<?= $fav['product_id'] ?>" style="display:block;height:200px;overflow:hidden;background:#F8F8F8;text-decoration:none;">
            <img src="<?= $img ?>" alt="<?= htmlspecialchars($fav['model_name']) ?>" style="width:100%;height:100%;object-fit:cover;transition:transform .4s;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform=''">
          </a>
          <div style="padding:1.25rem;flex:1;display:flex;flex-direction:column;">
            <div style="font-size:.65rem;letter-spacing:.1em;color:#9CA3AF;text-transform:uppercase;"><?= htmlspecialchars($fav['brand']) ?></div>
            <h3 style="font-weight:600;color:#1A1A1A;font-size:.9rem;margin:.25rem 0 .75rem;flex:1;"><?= htmlspecialchars($fav['model_name']) ?></h3>
            <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:700;color:#C9A84C;margin-bottom:1rem;">$<?= number_format($fav['price'],2) ?></div>
            <div style="display:flex;gap:.625rem;">
              <a href="/Celario_lite/cellario_lite/Favorites/AddToCart?id=<?= $fav['fav_id'] ?>" style="flex:1;padding:.6rem;background:#0D0D0D;color:#C9A84C;font-size:.7rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;text-align:center;border-radius:2px;transition:all .2s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">Add to Cart</a>
              <a href="/Celario_lite/cellario_lite/Favorites/Remove?id=<?= $fav['fav_id'] ?>" style="padding:.6rem .875rem;border:1px solid #F0F0F0;color:#9CA3AF;font-size:.75rem;text-decoration:none;border-radius:2px;display:flex;align-items:center;transition:all .2s;" title="Remove" onmouseover="this.style.borderColor='#EF4444';this.style.color='#EF4444'" onmouseout="this.style.borderColor='#F0F0F0';this.style.color='#9CA3AF'">
                <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="3 6 5 6 21 6"/><path d="M19 6l-1 14a2 2 0 01-2 2H8a2 2 0 01-2-2L5 6"/><path d="M10 11v6M14 11v6"/><path d="M9 6V4a1 1 0 011-1h4a1 1 0 011 1v2"/></svg>
              </a>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="text-align:center;padding:6rem 2rem;background:white;border:1px solid #F0F0F0;border-radius:4px;">
      <div style="font-size:4rem;margin-bottom:1.25rem;">❤️</div>
      <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.75rem;color:#0D0D0D;margin-bottom:.5rem;">Your Wishlist is Empty</h3>
      <p style="font-size:.875rem;color:#6B6B6B;margin-bottom:2rem;">Save items you love for later. Explore our exclusive collection.</p>
      <a href="/Celario_lite/cellario_lite/Products" style="display:inline-block;padding:.875rem 2.5rem;background:#C9A84C;color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:2px;">Discover Products</a>
    </div>
    <?php endif; ?>
  </div>
</main>
<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
