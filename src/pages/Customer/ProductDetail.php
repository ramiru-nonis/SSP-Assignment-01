<?php
include_once "./src/private/initialize.php";
session_start();

require_once "./src/php/Controller/ProductController.php";
$controller = new ProductController();

$id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $controller->getProductById($id);

if (!$product) {
    header("Location: /Celario_lite/cellario_lite/Products");
    exit;
}

$pageTitle = htmlspecialchars($product['brand'] . ' ' . $product['model_name']);
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>

<main style="min-height:100vh;background:#FAFAF8;">
  <div style="max-width:1400px;margin:0 auto;padding:3rem 2rem;">
    <!-- Breadcrumb -->
    <nav style="margin-bottom:2rem;font-size:.8rem;color:#9CA3AF;">
      <a href="/Celario_lite/cellario_lite/" style="color:#9CA3AF;text-decoration:none;">Home</a>
      <span style="margin:0 .5rem;">›</span>
      <a href="/Celario_lite/cellario_lite/Products" style="color:#9CA3AF;text-decoration:none;">Products</a>
      <span style="margin:0 .5rem;">›</span>
      <span style="color:#C9A84C;"><?= htmlspecialchars($product['brand'].' '.$product['model_name']) ?></span>
    </nav>

    <div style="display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:start;" id="pdpGrid">
      <!-- Image Gallery -->
      <div>
        <?php
          $mainImg = !empty($product['images'][0]['image_path'])
            ? htmlspecialchars($product['images'][0]['image_path'])
            : 'https://placehold.co/600x500/1A1A1A/C9A84C?text='.urlencode($product['brand']);
        ?>
        <div style="background:#F8F8F8;border:1px solid #F0F0F0;border-radius:4px;overflow:hidden;margin-bottom:1rem;height:420px;">
          <img id="mainImage" src="<?= $mainImg ?>" alt="<?= htmlspecialchars($product['model_name']) ?>" style="width:100%;height:100%;object-fit:cover;">
        </div>
        <?php if (!empty($product['images']) && count($product['images']) > 1): ?>
        <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
          <?php foreach($product['images'] as $img): ?>
            <?php $src = htmlspecialchars($img['image_path']); ?>
            <div onclick="document.getElementById('mainImage').src='<?= $src ?>'" style="width:80px;height:60px;border:2px solid <?= $img['is_main']?'#C9A84C':'#F0F0F0' ?>;border-radius:2px;overflow:hidden;cursor:pointer;transition:border-color .2s;flex-shrink:0;" onmouseover="this.style.borderColor='#C9A84C'" onmouseout="">
              <img src="<?= $src ?>" alt="View" style="width:100%;height:100%;object-fit:cover;">
            </div>
          <?php endforeach; ?>
        </div>
        <?php endif; ?>
      </div>

      <!-- Product Info -->
      <div>
        <?php
          $catColors = ['smartphone'=>'#3B82F6','laptop'=>'#8B5CF6','audio'=>'#10B981','accessory'=>'#F59E0B'];
          $catColor  = $catColors[$product['category']] ?? '#C9A84C';
          $inStock   = $product['stock'] > 0;
        ?>
        <div style="display:inline-block;padding:.3rem .8rem;background:<?= $catColor ?>;color:white;font-size:.65rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;border-radius:100px;margin-bottom:1rem;"><?= ucfirst($product['category']) ?></div>
        <div style="font-size:.75rem;letter-spacing:.15em;color:#9CA3AF;text-transform:uppercase;margin-bottom:.5rem;"><?= htmlspecialchars($product['brand']) ?></div>
        <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.25rem;font-weight:600;color:#0D0D0D;line-height:1.2;margin-bottom:1rem;"><?= htmlspecialchars($product['model_name']) ?></h1>

        <div style="display:flex;align-items:center;gap:1rem;margin-bottom:1.5rem;">
          <div style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:700;color:#C9A84C;">$<?= number_format($product['price'], 2) ?></div>
          <div style="display:flex;align-items:center;gap:.4rem;font-size:.8rem;color:<?= $inStock?'#10B981':'#EF4444' ?>;">
            <span style="width:8px;height:8px;border-radius:50%;background:currentColor;display:inline-block;"></span>
            <?= $inStock ? "In Stock — {$product['stock']} available" : "Out of Stock" ?>
          </div>
        </div>

        <!-- Divider -->
        <div style="height:1px;background:linear-gradient(90deg,#C9A84C,rgba(201,168,76,.1));margin-bottom:1.5rem;"></div>

        <p style="font-size:.9rem;color:#6B6B6B;line-height:1.8;margin-bottom:2rem;"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

        <!-- Action Buttons -->
        <?php if ($inStock): ?>
          <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'customer'): ?>
            <div style="display:flex;flex-direction:column;gap:.875rem;">
              <a href="/Celario_lite/cellario_lite/Cart/Add?id=<?= $product['id'] ?>&qty=1" style="display:flex;justify-content:center;align-items:center;gap:.75rem;padding:1rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;border-radius:2px;transition:all .3s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                Add to Cart
              </a>
              <a href="/Celario_lite/cellario_lite/Favorites/Add?id=<?= $product['id'] ?>" style="display:flex;justify-content:center;align-items:center;gap:.75rem;padding:1rem;background:white;color:#0D0D0D;font-size:.8rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;border:1px solid #0D0D0D;border-radius:2px;transition:all .3s;" onmouseover="this.style.borderColor='#C9A84C';this.style.color='#C9A84C'" onmouseout="this.style.borderColor='#0D0D0D';this.style.color='#0D0D0D'">
                <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
                Add to Wishlist
              </a>
            </div>
          <?php else: ?>
            <a href="/Celario_lite/cellario_lite/Login" style="display:block;padding:1rem;background:#C9A84C;color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;text-align:center;border-radius:2px;">Login to Purchase</a>
          <?php endif; ?>
        <?php else: ?>
          <button disabled style="width:100%;padding:1rem;background:#E5E4E2;color:#9CA3AF;font-size:.8rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;border:none;cursor:not-allowed;border-radius:2px;">Currently Unavailable</button>
        <?php endif; ?>

        <!-- Trust Badges -->
        <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid #F0F0F0;">
          <?php
            $badges = [
              ['🔒','Secure Payment'],
              ['✓','Authentic Product'],
              ['🚀','Express Delivery'],
            ];
            foreach($badges as $b) echo "
            <div style='text-align:center;padding:.75rem .5rem;background:#F8F8F8;border-radius:4px;'>
              <div style='font-size:1.1rem;margin-bottom:.25rem;'>{$b[0]}</div>
              <div style='font-size:.65rem;color:#6B6B6B;font-weight:500;'>{$b[1]}</div>
            </div>";
          ?>
        </div>
      </div>
    </div>

    <!-- Related by category -->
    <div style="margin-top:4rem;padding-top:3rem;border-top:1px solid #F0F0F0;">
      <h2 style="font-family:'Cormorant Garamond',serif;font-size:1.75rem;font-weight:600;color:#0D0D0D;margin-bottom:2rem;">More from <?= ucfirst($product['category']) ?></h2>
      <?php
        $related = $controller->getAllProducts($product['category']);
        $related = array_filter($related, fn($p) => $p['id'] != $product['id']);
        $related = array_slice(array_values($related), 0, 4);
        if(!empty($related)):
      ?>
      <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(220px,1fr));gap:1.25rem;">
        <?php foreach($related as $rp): ?>
          <?php $ri = !empty($rp['main_image']) ? htmlspecialchars($rp['main_image']) : 'https://placehold.co/400x300/1A1A1A/C9A84C?text='.urlencode($rp['brand']); ?>
          <a href="/Celario_lite/cellario_lite/Products/Detail?id=<?= $rp['id'] ?>" style="display:block;background:white;border:1px solid #F0F0F0;border-radius:4px;overflow:hidden;text-decoration:none;transition:all .3s;" onmouseover="this.style.borderColor='rgba(201,168,76,.5)';this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='#F0F0F0';this.style.transform=''">
            <div style="height:160px;overflow:hidden;background:#F8F8F8;">
              <img src="<?= $ri ?>" alt="<?= htmlspecialchars($rp['model_name']) ?>" style="width:100%;height:100%;object-fit:cover;">
            </div>
            <div style="padding:1rem;">
              <div style="font-size:.65rem;color:#9CA3AF;letter-spacing:.08em;text-transform:uppercase;"><?= htmlspecialchars($rp['brand']) ?></div>
              <div style="font-size:.875rem;font-weight:600;color:#1A1A1A;margin:.25rem 0;"><?= htmlspecialchars($rp['model_name']) ?></div>
              <div style="font-family:'Cormorant Garamond',serif;font-size:1.1rem;font-weight:700;color:#C9A84C;">$<?= number_format($rp['price'],2) ?></div>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</main>
<style>
  #pdpGrid { grid-template-columns: 1fr 1fr; }
  @media (max-width:768px) { #pdpGrid { grid-template-columns: 1fr; } }
</style>
<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
