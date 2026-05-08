<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: /Celario_lite/cellario_lite/Login");
    exit;
}

require_once "./src/php/Controller/CustomerController.php";
$controller = new CustomerController();
$cart       = $controller->getCartTotal($_SESSION['user_id']);

$pageTitle = "Shopping Cart";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>

<main style="min-height:100vh;background:#FAFAF8;padding:3rem 2rem;">
  <div style="max-width:1200px;margin:0 auto;">
    <div style="margin-bottom:2rem;">
      <h1 style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:#0D0D0D;">Your Cart</h1>
      <p style="font-size:.85rem;color:#9CA3AF;margin-top:.25rem;">
        <?= count($cart['items']) ?> item<?= count($cart['items'])!==1?'s':'' ?> ·
        <a href="/Celario_lite/cellario_lite/Products" style="color:#C9A84C;text-decoration:none;">Continue Shopping</a>
      </p>
    </div>

    <?php if (!empty($cart['items'])): ?>
    <div style="display:grid;grid-template-columns:2fr 1fr;gap:2.5rem;align-items:start;" id="cartGrid">
      <!-- Cart Items -->
      <div style="display:flex;flex-direction:column;gap:1rem;">
        <?php foreach($cart['items'] as $item): ?>
          <?php $img = !empty($item['main_image']) ? htmlspecialchars($item['main_image']) : 'https://placehold.co/160x120/1A1A1A/C9A84C?text='.urlencode($item['brand']); ?>
          <div style="background:white;border:1px solid #F0F0F0;border-radius:4px;padding:1.5rem;display:flex;gap:1.25rem;align-items:center;transition:border-color .2s;" onmouseover="this.style.borderColor='rgba(201,168,76,.3)'" onmouseout="this.style.borderColor='#F0F0F0'">
            <div style="width:100px;height:80px;flex-shrink:0;border-radius:2px;overflow:hidden;background:#F8F8F8;">
              <img src="<?= $img ?>" alt="<?= htmlspecialchars($item['model_name']) ?>" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div style="flex:1;min-width:0;">
              <div style="font-size:.65rem;letter-spacing:.1em;color:#9CA3AF;text-transform:uppercase;"><?= htmlspecialchars($item['brand']) ?></div>
              <h3 style="font-weight:600;color:#1A1A1A;font-size:.95rem;margin:.25rem 0 .5rem;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($item['model_name']) ?></h3>
              <div style="font-size:.8rem;color:#6B6B6B;">Qty: <?= $item['quantity'] ?></div>
            </div>
            <div style="text-align:right;flex-shrink:0;">
              <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:700;color:#C9A84C;margin-bottom:.5rem;">$<?= number_format($item['price'] * $item['quantity'], 2) ?></div>
              <a href="/Celario_lite/cellario_lite/Cart/Remove?id=<?= $item['cart_id'] ?>" style="font-size:.75rem;color:#9CA3AF;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#EF4444'" onmouseout="this.style.color='#9CA3AF'">Remove</a>
            </div>
          </div>
        <?php endforeach; ?>
      </div>

      <!-- Order Summary -->
      <div style="background:white;border:1px solid #F0F0F0;border-radius:4px;padding:2rem;position:sticky;top:88px;">
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.35rem;font-weight:600;color:#0D0D0D;margin-bottom:1.5rem;padding-bottom:1rem;border-bottom:1px solid #F0F0F0;">Order Summary</h3>
        <div style="display:flex;flex-direction:column;gap:.875rem;margin-bottom:1.5rem;">
          <div style="display:flex;justify-content:space-between;font-size:.875rem;color:#6B6B6B;">
            <span>Subtotal</span><span style="color:#1A1A1A;">$<?= number_format($cart['subtotal'], 2) ?></span>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:.875rem;color:#6B6B6B;">
            <span>Tax (8%)</span><span style="color:#1A1A1A;">$<?= number_format($cart['tax'], 2) ?></span>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:.875rem;color:#6B6B6B;">
            <span>Shipping</span><span style="color:#10B981;font-weight:500;">Free</span>
          </div>
          <div style="display:flex;justify-content:space-between;font-size:1rem;font-weight:700;color:#0D0D0D;padding-top:.75rem;border-top:1px solid #F0F0F0;">
            <span>Total</span>
            <span style="font-family:'Cormorant Garamond',serif;font-size:1.25rem;color:#C9A84C;">$<?= number_format($cart['total'], 2) ?></span>
          </div>
        </div>
        <a href="/Celario_lite/cellario_lite/Checkout" style="display:block;padding:1rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;text-align:center;border-radius:2px;transition:all .3s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">Proceed to Checkout</a>
        <a href="/Celario_lite/cellario_lite/Products" style="display:block;margin-top:.75rem;padding:.875rem;border:1px solid #F0F0F0;color:#6B6B6B;font-size:.8rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;text-align:center;border-radius:2px;transition:all .2s;" onmouseover="this.style.borderColor='#C9A84C';this.style.color='#C9A84C'" onmouseout="this.style.borderColor='#F0F0F0';this.style.color='#6B6B6B'">Continue Shopping</a>
        <!-- Warranty Note -->
        <div style="margin-top:1.25rem;padding:1rem;background:#F8F5EF;border-radius:4px;">
          <div style="font-size:.7rem;font-weight:600;color:#C9A84C;letter-spacing:.08em;text-transform:uppercase;margin-bottom:.35rem;">Warranty Included</div>
          <p style="font-size:.75rem;color:#9CA3AF;line-height:1.6;">All Cellario products include standard warranty coverage and authenticity certificate.</p>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div style="text-align:center;padding:6rem 2rem;background:white;border:1px solid #F0F0F0;border-radius:4px;">
      <div style="font-size:4rem;margin-bottom:1.25rem;">🛒</div>
      <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.75rem;color:#0D0D0D;margin-bottom:.5rem;">Your Cart is Empty</h3>
      <p style="font-size:.875rem;color:#6B6B6B;margin-bottom:2rem;">Discover our exclusive luxury collection and add your favorite items.</p>
      <a href="/Celario_lite/cellario_lite/Products" style="display:inline-block;padding:.875rem 2.5rem;background:#C9A84C;color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:2px;">Browse Products</a>
    </div>
    <?php endif; ?>
  </div>
</main>
<style>
  #cartGrid { grid-template-columns: 2fr 1fr; }
  @media(max-width:768px){ #cartGrid { grid-template-columns: 1fr; } }
</style>
<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
