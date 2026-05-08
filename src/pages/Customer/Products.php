<?php
include_once "./src/private/initialize.php";
session_start();

require_once "./src/php/Controller/ProductController.php";
$controller = new ProductController();

$category = isset($_GET['category']) ? $_GET['category'] : null;
$search   = isset($_GET['search'])   ? trim($_GET['search']) : null;
$products = $controller->getAllProducts($category, $search);

$pageTitle = "Products — Luxury Electronics";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>

<main style="min-height:100vh;background:#FAFAF8;">
  <!-- Page Header -->
  <div style="background:#0D0D0D;padding:3rem 2rem;border-bottom:1px solid rgba(201,168,76,.15);">
    <div style="max-width:1400px;margin:0 auto;">
      <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;margin-bottom:.5rem;">Exclusive Collection</div>
      <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:600;color:white;letter-spacing:.02em;">Luxury Products</h1>
    </div>
  </div>

  <div style="max-width:1400px;margin:0 auto;padding:2.5rem 2rem;">
    <!-- Filters & Search -->
    <div style="display:flex;gap:1rem;align-items:center;flex-wrap:wrap;margin-bottom:2.5rem;padding:1.25rem;background:white;border:1px solid #F0F0F0;border-radius:4px;">
      <form method="GET" style="display:flex;gap:1rem;flex-wrap:wrap;align-items:center;width:100%;">
        <!-- Search -->
        <div style="flex:1;min-width:200px;position:relative;">
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#9CA3AF" stroke-width="2" style="position:absolute;left:.875rem;top:50%;transform:translateY(-50%);"><circle cx="11" cy="11" r="8"/><path d="m21 21-4.35-4.35"/></svg>
          <input type="text" name="search" value="<?= htmlspecialchars($search ?? '') ?>" placeholder="Search brand, model..."
            style="width:100%;padding:.625rem .875rem .625rem 2.5rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;"
            onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
        </div>
        <!-- Category Filter -->
        <div style="display:flex;gap:.5rem;flex-wrap:wrap;">
          <?php
            $cats = [''=>'All','smartphone'=>'Smartphones','laptop'=>'Laptops','audio'=>'Audio','accessory'=>'Accessories'];
            foreach($cats as $val=>$label){
              $active = ($category === $val || ($val==='' && !$category));
              $qs = $val ? "?category={$val}" . ($search ? "&search={$search}" : '') : ($search ? "?search={$search}" : '?');
              echo "<a href='/Celario_lite/cellario_lite/Products{$qs}' style='display:inline-block;padding:.5rem 1rem;font-size:.75rem;font-weight:600;letter-spacing:.05em;text-transform:uppercase;text-decoration:none;border-radius:2px;transition:all .2s;" . ($active ? "background:#0D0D0D;color:#C9A84C;border:1px solid #0D0D0D;" : "background:transparent;color:#6B6B6B;border:1px solid #E0E0E0;") . "' onmouseover=\"if(!this.classList.contains('a')){this.style.borderColor='#C9A84C';this.style.color='#C9A84C';}\" onmouseout=\"\">{$label}</a>";
            }
          ?>
        </div>
        <button type="submit" style="padding:.625rem 1.25rem;background:#C9A84C;color:#0D0D0D;font-size:.75rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;border:none;cursor:pointer;border-radius:2px;white-space:nowrap;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">Search</button>
      </form>
    </div>

    <!-- Results Info -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
      <p style="font-size:.85rem;color:#6B6B6B;"><?= count($products) ?> product<?= count($products)!==1?'s':'' ?> found<?= $search ? " for \"".htmlspecialchars($search)."\"" : '' ?><?= $category ? " in ".ucfirst($category) : '' ?></p>
    </div>

    <!-- Product Grid -->
    <?php if (!empty($products)): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
      <?php foreach($products as $product): ?>
        <?php
          $img = !empty($product['main_image']) ? htmlspecialchars($product['main_image']) : 'https://placehold.co/400x300/1A1A1A/C9A84C?text='.urlencode($product['brand']);
          $catColors = ['smartphone'=>'#3B82F6','laptop'=>'#8B5CF6','audio'=>'#10B981','accessory'=>'#F59E0B'];
          $catColor = $catColors[$product['category']] ?? '#C9A84C';
          $inStock = $product['stock'] > 0;
        ?>
        <div style="background:white;border:1px solid #F0F0F0;border-radius:4px;overflow:hidden;transition:all .3s;display:flex;flex-direction:column;" onmouseover="this.style.borderColor='rgba(201,168,76,.5)';this.style.boxShadow='0 8px 32px rgba(0,0,0,.08)';this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='#F0F0F0';this.style.boxShadow='none';this.style.transform=''">
          <!-- Image -->
          <a href="/Celario_lite/cellario_lite/Products/Detail?id=<?= $product['id'] ?>" style="display:block;text-decoration:none;position:relative;overflow:hidden;height:220px;background:#F8F8F8;">
            <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['brand'].' '.$product['model_name']) ?>" style="width:100%;height:100%;object-fit:cover;transition:transform .5s ease;">
            <div style="position:absolute;top:.75rem;left:.75rem;background:<?= $catColor ?>;color:white;font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.25rem .6rem;border-radius:100px;"><?= ucfirst($product['category']) ?></div>
            <?php if (!$inStock): ?>
              <div style="position:absolute;inset:0;background:rgba(0,0,0,.5);display:flex;align-items:center;justify-content:center;">
                <span style="background:rgba(239,68,68,.9);color:white;font-size:.75rem;font-weight:700;letter-spacing:.1em;padding:.35rem .875rem;text-transform:uppercase;">Sold Out</span>
              </div>
            <?php endif; ?>
          </a>
          <!-- Details -->
          <div style="padding:1.25rem;flex:1;display:flex;flex-direction:column;">
            <div style="font-size:.65rem;letter-spacing:.1em;color:#9CA3AF;text-transform:uppercase;margin-bottom:.25rem;"><?= htmlspecialchars($product['brand']) ?></div>
            <h3 style="font-weight:600;color:#1A1A1A;font-size:.95rem;margin-bottom:.5rem;line-height:1.35;flex:1;"><?= htmlspecialchars($product['model_name']) ?></h3>
            <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:1rem;">
              <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:700;color:#C9A84C;">$<?= number_format($product['price'], 2) ?></div>
              <div style="font-size:.7rem;color:<?= $inStock?'#10B981':'#EF4444' ?>;display:flex;align-items:center;gap:.3rem;">
                <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                <?= $inStock ? "In Stock ({$product['stock']})" : 'Out of Stock' ?>
              </div>
            </div>
            <!-- Action Buttons -->
            <div style="display:flex;gap:.625rem;">
              <a href="/Celario_lite/cellario_lite/Products/Detail?id=<?= $product['id'] ?>" style="flex:1;padding:.625rem;background:#0D0D0D;color:#C9A84C;font-size:.7rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:2px;text-align:center;transition:all .2s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">View Details</a>
              <?php if($inStock && isset($_SESSION['role']) && $_SESSION['role']==='customer'): ?>
                <a href="/Celario_lite/cellario_lite/Cart/Add?id=<?= $product['id'] ?>&qty=1" style="padding:.625rem .875rem;border:1px solid #C9A84C;color:#C9A84C;font-size:.7rem;font-weight:600;text-decoration:none;border-radius:2px;transition:all .2s;display:flex;align-items:center;" title="Add to Cart" onmouseover="this.style.background='rgba(201,168,76,.08)'" onmouseout="this.style.background=''">
                  <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
                </a>
              <?php endif; ?>
            </div>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="text-align:center;padding:5rem 2rem;background:white;border:1px solid #F0F0F0;border-radius:4px;">
      <div style="font-size:3.5rem;margin-bottom:1rem;">🔍</div>
      <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.75rem;color:#0D0D0D;margin-bottom:.5rem;">No Products Found</h3>
      <p style="font-size:.875rem;color:#6B6B6B;margin-bottom:1.5rem;">Try adjusting your search or browse all products.</p>
      <a href="/Celario_lite/cellario_lite/Products" style="display:inline-block;padding:.75rem 2rem;background:#C9A84C;color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:2px;">Browse All Products</a>
    </div>
    <?php endif; ?>
  </div>
</main>

<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
