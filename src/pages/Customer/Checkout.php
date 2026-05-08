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

$orderPlaced = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $address   = htmlspecialchars(trim($_POST['address']));
    $apartment = htmlspecialchars(trim($_POST['apartment'] ?? ''));
    $city      = htmlspecialchars(trim($_POST['city']));
    $country   = htmlspecialchars(trim($_POST['country']));
    $zipcode   = htmlspecialchars(trim($_POST['zipcode']));

    $result = $controller->placeOrder($_SESSION['user_id'], $address, $apartment, $city, $country, $zipcode);
    if ($result) {
        $orderPlaced = true;
        $cart = ['items'=>[], 'subtotal'=>0, 'tax'=>0, 'total'=>0];
    }
}

$pageTitle = "Checkout";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>
<main style="min-height:100vh;background:#FAFAF8;padding:3rem 2rem;">
  <div style="max-width:1200px;margin:0 auto;">
    <?php if ($orderPlaced): ?>
    <!-- Success State -->
    <div style="text-align:center;padding:5rem 2rem;background:white;border:1px solid rgba(201,168,76,.3);border-radius:4px;max-width:600px;margin:0 auto;">
      <div style="width:72px;height:72px;border-radius:50%;background:rgba(16,185,129,.1);border:2px solid #10B981;display:flex;align-items:center;justify-content:center;margin:0 auto 1.5rem;">
        <svg width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      </div>
      <h2 style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:#0D0D0D;margin-bottom:.75rem;">Order Placed Successfully!</h2>
      <p style="font-size:.9rem;color:#6B6B6B;line-height:1.7;margin-bottom:2rem;">Thank you for your purchase, <?= htmlspecialchars($_SESSION['first_name']) ?>. Your luxury items will be delivered with the utmost care and discretion.</p>
      <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
        <a href="/Celario_lite/cellario_lite/Products" style="display:inline-block;padding:.875rem 2rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:2px;">Continue Shopping</a>
      </div>
    </div>
    <?php elseif (!empty($cart['items'])): ?>
    <div style="display:grid;grid-template-columns:3fr 2fr;gap:3rem;align-items:start;" id="checkoutGrid">
      <!-- Left: Shipping Form -->
      <div>
        <h1 style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:#0D0D0D;margin-bottom:.5rem;">Checkout</h1>
        <nav style="display:flex;align-items:center;gap:.75rem;font-size:.75rem;color:#9CA3AF;margin-bottom:2rem;letter-spacing:.05em;text-transform:uppercase;">
          <span style="color:#C9A84C;font-weight:600;">Shipping</span>
          <span>›</span>
          <span>Payment</span>
          <span>›</span>
          <span>Confirmation</span>
        </nav>

        <div style="background:white;border:1px solid #F0F0F0;border-radius:4px;padding:2rem;">
          <h3 style="font-weight:700;color:#0D0D0D;font-size:.9rem;letter-spacing:.05em;text-transform:uppercase;margin-bottom:1.5rem;">Shipping Information</h3>
          <form method="post" style="display:flex;flex-direction:column;gap:1.25rem;">
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
              <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">First Name</label>
                <input type="text" name="fname" value="<?= htmlspecialchars($_SESSION['first_name']??'') ?>"
                  style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;"
                  onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
              </div>
              <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Last Name</label>
                <input type="text" name="lname" value="<?= htmlspecialchars($_SESSION['last_name']??'') ?>"
                  style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;"
                  onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
              </div>
            </div>
            <div>
              <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Street Address *</label>
              <input type="text" name="address" placeholder="123 Luxury Avenue" required
                style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;"
                onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
            </div>
            <div>
              <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Apartment / Suite</label>
              <input type="text" name="apartment" placeholder="Optional"
                style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;"
                onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:1rem;">
              <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">City *</label>
                <input type="text" name="city" placeholder="Colombo" required
                  style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;"
                  onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
              </div>
              <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Country *</label>
                <select name="country" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;background:white;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
                  <option value="Sri Lanka">Sri Lanka</option>
                  <option value="India">India</option>
                  <option value="UAE">UAE</option>
                  <option value="UK">United Kingdom</option>
                  <option value="USA">United States</option>
                </select>
              </div>
              <div>
                <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Zip Code *</label>
                <input type="text" name="zipcode" placeholder="10150" required
                  style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;"
                  onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
              </div>
            </div>
            <button type="submit" style="width:100%;padding:1rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;border:none;cursor:pointer;border-radius:2px;margin-top:.5rem;transition:all .3s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">
              Place Order — $<?= number_format($cart['total'],2) ?>
            </button>
          </form>
        </div>
      </div>

      <!-- Right: Order Summary -->
      <div>
        <div style="background:white;border:1px solid #F0F0F0;border-radius:4px;padding:1.5rem;position:sticky;top:88px;">
          <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.25rem;font-weight:600;color:#0D0D0D;margin-bottom:1.25rem;padding-bottom:1rem;border-bottom:1px solid #F0F0F0;">Order Summary</h3>
          <div style="display:flex;flex-direction:column;gap:1rem;margin-bottom:1.25rem;">
            <?php foreach($cart['items'] as $item): ?>
              <?php $img = !empty($item['main_image']) ? htmlspecialchars($item['main_image']) : 'https://placehold.co/60x50/F8F8F8/9CA3AF?text=IMG'; ?>
              <div style="display:flex;gap:.875rem;align-items:center;">
                <div style="width:56px;height:44px;flex-shrink:0;border-radius:2px;overflow:hidden;background:#F8F8F8;border:1px solid #F0F0F0;">
                  <img src="<?= $img ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                </div>
                <div style="flex:1;min-width:0;">
                  <div style="font-size:.75rem;font-weight:600;color:#1A1A1A;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;"><?= htmlspecialchars($item['model_name']) ?></div>
                  <div style="font-size:.7rem;color:#9CA3AF;">Qty: <?= $item['quantity'] ?></div>
                </div>
                <div style="font-size:.85rem;font-weight:600;color:#C9A84C;flex-shrink:0;">$<?= number_format($item['price']*$item['quantity'],2) ?></div>
              </div>
            <?php endforeach; ?>
          </div>
          <div style="border-top:1px solid #F0F0F0;padding-top:1rem;display:flex;flex-direction:column;gap:.625rem;">
            <div style="display:flex;justify-content:space-between;font-size:.8rem;color:#6B6B6B;"><span>Subtotal</span><span>$<?= number_format($cart['subtotal'],2) ?></span></div>
            <div style="display:flex;justify-content:space-between;font-size:.8rem;color:#6B6B6B;"><span>Tax (8%)</span><span>$<?= number_format($cart['tax'],2) ?></span></div>
            <div style="display:flex;justify-content:space-between;font-size:.8rem;color:#10B981;font-weight:500;"><span>Shipping</span><span>Free</span></div>
            <div style="display:flex;justify-content:space-between;font-weight:700;font-size:.9rem;color:#0D0D0D;padding-top:.625rem;border-top:1px solid #F0F0F0;"><span>Total</span><span style="color:#C9A84C;font-family:'Cormorant Garamond',serif;font-size:1.15rem;">$<?= number_format($cart['total'],2) ?></span></div>
          </div>
        </div>
      </div>
    </div>
    <?php else: ?>
    <div style="text-align:center;padding:5rem;background:white;border:1px solid #F0F0F0;border-radius:4px;">
      <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.75rem;color:#0D0D0D;margin-bottom:1rem;">Your cart is empty</h2>
      <a href="/Celario_lite/cellario_lite/Products" style="display:inline-block;padding:.875rem 2rem;background:#C9A84C;color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:2px;">Browse Products</a>
    </div>
    <?php endif; ?>
  </div>
</main>
<style>#checkoutGrid{grid-template-columns:3fr 2fr;}@media(max-width:768px){#checkoutGrid{grid-template-columns:1fr;}}</style>
<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
