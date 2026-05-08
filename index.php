<?php
include_once "./src/private/initialize.php";
session_start();

require_once "./src/php/Controller/ProductController.php";
$productController = new ProductController();
$featuredProducts  = $productController->getFeaturedProducts(8);

$pageTitle = "Home — Premium Luxury Electronics";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>

<main>

<!-- ═══════════════ HERO ═══════════════ -->
<section style="position:relative;background:#0D0D0D;overflow:hidden;min-height:100vh;display:flex;align-items:center;">
  <!-- Animated BG Grid -->
  <div style="position:absolute;inset:0;opacity:.04;background-image:linear-gradient(rgba(201,168,76,.8) 1px,transparent 1px),linear-gradient(90deg,rgba(201,168,76,.8) 1px,transparent 1px);background-size:60px 60px;"></div>
  <!-- Gradient Orbs -->
  <div style="position:absolute;top:-20%;right:-10%;width:600px;height:600px;background:radial-gradient(circle,rgba(201,168,76,.08) 0%,transparent 70%);pointer-events:none;"></div>
  <div style="position:absolute;bottom:-20%;left:-10%;width:500px;height:500px;background:radial-gradient(circle,rgba(201,168,76,.05) 0%,transparent 70%);pointer-events:none;"></div>

  <div style="max-width:1400px;margin:0 auto;padding:0 2rem;display:grid;grid-template-columns:1fr 1fr;gap:4rem;align-items:center;width:100%;position:relative;z-index:1;" id="heroGrid">
    <!-- Text -->
    <div>
      <div style="display:inline-flex;align-items:center;gap:.75rem;border:1px solid rgba(201,168,76,.3);padding:.4rem 1rem;border-radius:100px;margin-bottom:2rem;">
        <span style="width:6px;height:6px;background:#C9A84C;border-radius:50%;animation:pulse 2s infinite;display:inline-block;"></span>
        <span style="font-size:.7rem;letter-spacing:.2em;color:#C9A84C;text-transform:uppercase;font-weight:500;">New Arrivals Available</span>
      </div>
      <h1 style="font-family:'Cormorant Garamond',serif;font-size:clamp(2.5rem,5vw,4.5rem);font-weight:600;color:white;line-height:1.1;letter-spacing:.02em;margin-bottom:1.5rem;">
        The World's<br>
        <span style="background:linear-gradient(135deg,#C9A84C,#E8D5A3,#C9A84C);-webkit-background-clip:text;-webkit-text-fill-color:transparent;background-clip:text;">Most Exclusive</span><br>
        Tech Experience
      </h1>
      <p style="font-size:1rem;color:#9CA3AF;line-height:1.8;max-width:480px;margin-bottom:2.5rem;">Discover a curated collection of flagship smartphones, performance laptops, premium audio, and limited-edition accessories from the world's most prestigious brands.</p>

      <div style="display:flex;gap:1rem;flex-wrap:wrap;">
        <a href="/Celario_lite/cellario_lite/Products" style="display:inline-flex;align-items:center;gap:.75rem;padding:.875rem 2rem;background:linear-gradient(135deg,#9A7B2E,#C9A84C,#9A7B2E);background-size:200% auto;color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;transition:background-position .4s ease;border-radius:2px;" onmouseover="this.style.backgroundPosition='right center'" onmouseout="this.style.backgroundPosition='left center'">
          Explore Collection
          <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
        </a>
        <a href="/Celario_lite/cellario_lite/Register" style="display:inline-flex;align-items:center;gap:.75rem;padding:.875rem 2rem;border:1px solid rgba(201,168,76,.4);color:#C9A84C;font-size:.8rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;transition:all .3s;border-radius:2px;" onmouseover="this.style.borderColor='#C9A84C';this.style.background='rgba(201,168,76,.08)'" onmouseout="this.style.borderColor='rgba(201,168,76,.4)';this.style.background='transparent'">
          Join Cellario
        </a>
      </div>

      <!-- Stats -->
      <div style="display:flex;gap:2.5rem;margin-top:3rem;padding-top:2rem;border-top:1px solid rgba(201,168,76,.1);">
        <?php
          $stats = [['500+','Premium Products'],['50+','Luxury Brands'],['10K+','Members'],['99%','Satisfaction']];
          foreach($stats as $s) echo "
          <div>
            <div style='font-family:Cormorant Garamond,serif;font-size:1.75rem;font-weight:700;color:#C9A84C;'>{$s[0]}</div>
            <div style='font-size:.7rem;color:#555;letter-spacing:.08em;text-transform:uppercase;margin-top:2px;'>{$s[1]}</div>
          </div>";
        ?>
      </div>
    </div>

    <!-- Visual Panel -->
    <div style="display:flex;flex-direction:column;gap:1rem;">
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
        <!-- Category Cards -->
        <?php
          $cats = [
            ['📱','Smartphones','Flagship devices','?category=smartphone'],
            ['💻','Laptops','Performance driven','?category=laptop'],
            ['🎧','Audio','Premium sound','?category=audio'],
            ['⌚','Accessories','Limited editions','?category=accessory'],
          ];
          foreach($cats as $cat) echo "
          <a href='/Celario_lite/cellario_lite/Products{$cat[3]}' style='display:block;padding:1.5rem 1rem;background:rgba(255,255,255,.03);border:1px solid rgba(201,168,76,.12);border-radius:4px;text-decoration:none;transition:all .3s;text-align:center;' onmouseover=\"this.style.background='rgba(201,168,76,.07)';this.style.borderColor='rgba(201,168,76,.4)';this.style.transform='translateY(-4px)'\" onmouseout=\"this.style.background='rgba(255,255,255,.03)';this.style.borderColor='rgba(201,168,76,.12)';this.style.transform=''\">
            <div style='font-size:2rem;margin-bottom:.75rem;'>{$cat[0]}</div>
            <div style='font-size:.85rem;font-weight:600;color:#E5E4E2;margin-bottom:.25rem;'>{$cat[1]}</div>
            <div style='font-size:.7rem;color:#555;letter-spacing:.05em;'>{$cat[2]}</div>
          </a>";
        ?>
      </div>
      <!-- Trust Badges -->
      <div style="display:grid;grid-template-columns:1fr 1fr 1fr;gap:.75rem;margin-top:.5rem;">
        <?php
          $badges = [
            ['🔒','Secure','Payments'],
            ['✓','Authentic','Guaranteed'],
            ['🚀','Express','Delivery'],
          ];
          foreach($badges as $b) echo "
          <div style='padding:.875rem .5rem;background:rgba(255,255,255,.02);border:1px solid rgba(201,168,76,.08);border-radius:4px;text-align:center;'>
            <div style='font-size:1.2rem;margin-bottom:.35rem;'>{$b[0]}</div>
            <div style='font-size:.7rem;color:#C9A84C;font-weight:600;letter-spacing:.08em;'>{$b[1]}</div>
            <div style='font-size:.65rem;color:#555;'>{$b[2]}</div>
          </div>";
        ?>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════ BRANDS ═══════════════ -->
<section style="background:#1A1A1A;padding:3rem 2rem;border-top:1px solid rgba(201,168,76,.1);border-bottom:1px solid rgba(201,168,76,.1);">
  <div style="max-width:1400px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:2rem;">
      <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;">Trusted Luxury Brands</div>
    </div>
    <div style="display:flex;justify-content:center;align-items:center;gap:3rem;flex-wrap:wrap;opacity:.6;">
      <?php
        $brands = ['Apple','Samsung','Sony','Bose','B&O','Google','OnePlus','Sennheiser'];
        foreach($brands as $b) echo "<span style='font-family:Cormorant Garamond,serif;font-size:1.25rem;color:#E5E4E2;letter-spacing:.08em;font-weight:500;white-space:nowrap;transition:opacity .2s;cursor:default;' onmouseover=\"this.style.opacity='1';this.style.color='#C9A84C'\" onmouseout=\"this.style.opacity=''\">$b</span>";
      ?>
    </div>
  </div>
</section>

<!-- ═══════════════ FEATURED PRODUCTS ═══════════════ -->
<section style="padding:5rem 2rem;background:#FAFAF8;">
  <div style="max-width:1400px;margin:0 auto;">
    <div style="display:flex;align-items:flex-end;justify-content:space-between;margin-bottom:3rem;flex-wrap:wrap;gap:1rem;">
      <div>
        <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;margin-bottom:.5rem;">Featured Collection</div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:600;color:#0D0D0D;letter-spacing:.02em;">New Arrivals</h2>
      </div>
      <a href="/Celario_lite/cellario_lite/Products" style="display:inline-flex;align-items:center;gap:.5rem;font-size:.8rem;color:#C9A84C;text-decoration:none;letter-spacing:.1em;text-transform:uppercase;font-weight:600;border-bottom:1px solid #C9A84C;padding-bottom:2px;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">
        View All <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
      </a>
    </div>

    <?php if (!empty($featuredProducts)): ?>
    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:1.5rem;">
      <?php foreach($featuredProducts as $product): ?>
        <?php
          $img = !empty($product['main_image']) ? htmlspecialchars($product['main_image']) : 'https://placehold.co/400x300/1A1A1A/C9A84C?text=CELLARIO';
          $catColors = ['smartphone'=>'#3B82F6','laptop'=>'#8B5CF6','audio'=>'#10B981','accessory'=>'#F59E0B'];
          $catColor = $catColors[$product['category']] ?? '#C9A84C';
        ?>
        <a href="/Celario_lite/cellario_lite/Products/Detail?id=<?= $product['id'] ?>" style="text-decoration:none;display:block;background:white;border:1px solid #F0F0F0;border-radius:4px;overflow:hidden;transition:all .3s;" onmouseover="this.style.borderColor='#C9A84C';this.style.boxShadow='0 8px 40px rgba(0,0,0,.1)';this.style.transform='translateY(-4px)'" onmouseout="this.style.borderColor='#F0F0F0';this.style.boxShadow='none';this.style.transform=''">
          <div style="position:relative;overflow:hidden;height:220px;background:#F8F8F8;">
            <img src="<?= $img ?>" alt="<?= htmlspecialchars($product['brand'] . ' ' . $product['model_name']) ?>" style="width:100%;height:100%;object-fit:cover;transition:transform .4s ease;" onmouseover="this.style.transform='scale(1.05)'" onmouseout="this.style.transform='scale(1)'">
            <div style="position:absolute;top:.75rem;left:.75rem;background:<?= $catColor ?>;color:white;font-size:.6rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;padding:.25rem .6rem;border-radius:100px;"><?= ucfirst($product['category']) ?></div>
          </div>
          <div style="padding:1.25rem;">
            <div style="font-size:.7rem;letter-spacing:.08em;color:#9CA3AF;text-transform:uppercase;margin-bottom:.25rem;"><?= htmlspecialchars($product['brand']) ?></div>
            <h3 style="font-weight:600;color:#1A1A1A;font-size:.95rem;margin-bottom:.75rem;line-height:1.3;"><?= htmlspecialchars($product['model_name']) ?></h3>
            <div style="display:flex;align-items:center;justify-content:space-between;">
              <div style="font-family:'Cormorant Garamond',serif;font-size:1.2rem;font-weight:700;color:#C9A84C;">$<?= number_format($product['price'], 2) ?></div>
              <div style="display:flex;align-items:center;gap:.25rem;font-size:.75rem;color:<?= $product['stock'] > 0 ? '#10B981' : '#EF4444' ?>;">
                <span style="width:6px;height:6px;border-radius:50%;background:currentColor;display:inline-block;"></span>
                <?= $product['stock'] > 0 ? 'In Stock' : 'Sold Out' ?>
              </div>
            </div>
          </div>
        </a>
      <?php endforeach; ?>
    </div>
    <?php else: ?>
    <div style="text-align:center;padding:5rem;background:white;border:1px solid rgba(201,168,76,.2);border-radius:4px;">
      <div style="font-size:3rem;margin-bottom:1rem;">📦</div>
      <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:#0D0D0D;margin-bottom:.5rem;">No Products Yet</h3>
      <p style="font-size:.875rem;color:#6B6B6B;margin-bottom:1.5rem;">The collection is being curated. Check back soon.</p>
      <a href="/Celario_lite/cellario_lite/Admin/AddProduct" style="display:inline-block;padding:.75rem 2rem;background:#C9A84C;color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:2px;">Add First Product (Admin)</a>
    </div>
    <?php endif; ?>
  </div>
</section>

<!-- ═══════════════ CATEGORIES ═══════════════ -->
<section style="padding:5rem 2rem;background:#0D0D0D;">
  <div style="max-width:1400px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;">
      <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;margin-bottom:.5rem;">Shop by Category</div>
      <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:600;color:white;">Find Your Perfect Device</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(220px,1fr));gap:1.5rem;">
      <?php
        $categories = [
          ['smartphone','📱','Flagship Smartphones','Latest technology, ultimate performance','#3B82F6'],
          ['laptop','💻','Performance Laptops','Power meets elegance','#8B5CF6'],
          ['audio','🎧','Premium Audio','Crystal-clear sound experience','#10B981'],
          ['accessory','⌚','Luxury Accessories','Limited edition exclusives','#F59E0B'],
        ];
        foreach($categories as $c) echo "
        <a href='/Celario_lite/cellario_lite/Products?category={$c[0]}' style='display:block;padding:2.5rem 1.5rem;border:1px solid rgba(255,255,255,.06);border-radius:4px;text-decoration:none;text-align:center;transition:all .3s;position:relative;overflow:hidden;background:rgba(255,255,255,.02);' onmouseover=\"this.style.borderColor='rgba(201,168,76,.4)';this.style.background='rgba(201,168,76,.05)';this.style.transform='translateY(-6px)'\" onmouseout=\"this.style.borderColor='rgba(255,255,255,.06)';this.style.background='rgba(255,255,255,.02)';this.style.transform=''\">
          <div style='font-size:2.5rem;margin-bottom:1rem;'>{$c[1]}</div>
          <div style='font-size:1rem;font-weight:600;color:white;margin-bottom:.5rem;'>{$c[2]}</div>
          <div style='font-size:.8rem;color:#6B6B6B;line-height:1.5;margin-bottom:1.25rem;'>{$c[3]}</div>
          <span style='display:inline-flex;align-items:center;gap:.35rem;font-size:.7rem;color:#C9A84C;letter-spacing:.1em;text-transform:uppercase;font-weight:600;'>Shop Now <svg width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5'><path d='M5 12h14M12 5l7 7-7 7'/></svg></span>
        </a>";
      ?>
    </div>
  </div>
</section>

<!-- ═══════════════ WHY CELLARIO ═══════════════ -->
<section style="padding:5rem 2rem;background:#F8F5EF;">
  <div style="max-width:1400px;margin:0 auto;">
    <div style="display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;" id="whyGrid">
      <div>
        <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;margin-bottom:.75rem;">Why Cellario</div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:600;color:#0D0D0D;line-height:1.2;margin-bottom:1.5rem;">We Are Big on What Matters Most to You</h2>
        <p style="font-size:.9rem;color:#6B6B6B;line-height:1.8;margin-bottom:2rem;">At Cellario, we bridge the gap between luxury tech brands and high-value customers seeking exclusive, authentic products in a secure environment.</p>
        <a href="/Celario_lite/cellario_lite/About" style="display:inline-flex;align-items:center;gap:.5rem;font-size:.8rem;color:#C9A84C;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-bottom:1px solid #C9A84C;padding-bottom:2px;">Learn More <svg width='14' height='14' viewBox='0 0 24 24' fill='none' stroke='currentColor' stroke-width='2.5'><path d='M5 12h14M12 5l7 7-7 7'/></svg></a>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
        <?php
          $features = [
            ['🔒','Authenticity Guarantee','100% verified premium tech brands — every single product.'],
            ['⚡','Express Delivery','Priority shipping for your luxury purchases worldwide.'],
            ['💎','Curated Selection','Only the finest, hand-picked luxury tech devices.'],
            ['🛡️','Extended Warranty','Comprehensive warranty on all eligible luxury products.'],
          ];
          foreach($features as $f) echo "
          <div style='padding:1.5rem;background:white;border:1px solid #F0F0F0;border-radius:4px;transition:all .3s;' onmouseover=\"this.style.borderColor='#C9A84C';this.style.boxShadow='0 4px 20px rgba(201,168,76,.1)';this.style.transform='translateY(-2px)'\" onmouseout=\"this.style.borderColor='#F0F0F0';this.style.boxShadow='none';this.style.transform=''\">
            <div style='font-size:1.75rem;margin-bottom:.875rem;'>{$f[0]}</div>
            <h3 style='font-size:.875rem;font-weight:700;color:#0D0D0D;margin-bottom:.5rem;'>{$f[1]}</h3>
            <p style='font-size:.8rem;color:#9CA3AF;line-height:1.6;'>{$f[2]}</p>
          </div>";
        ?>
      </div>
    </div>
  </div>
</section>

<!-- ═══════════════ TESTIMONIALS ═══════════════ -->
<section style="padding:5rem 2rem;background:#1A1A1A;">
  <div style="max-width:1400px;margin:0 auto;">
    <div style="text-align:center;margin-bottom:3rem;">
      <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;margin-bottom:.5rem;">What Our Members Say</div>
      <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.5rem;font-weight:600;color:white;">The Cellario Experience</h2>
    </div>
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:1.5rem;">
      <?php
        $testimonials = [
          ['The MacBook Pro arrived in pristine condition with all authenticity certificates. The packaging itself felt like a luxury experience.','Alexandra K.','Premium Member','⭐⭐⭐⭐⭐'],
          ['I purchased a Bang & Olufsen headset and the quality check they do before shipping is extraordinary. Will always shop here.','James R.','Verified Buyer','⭐⭐⭐⭐⭐'],
          ['The customer service is impeccable. They helped me choose the perfect iPhone limited edition and it arrived within 48 hours.','Priya M.','Elite Member','⭐⭐⭐⭐⭐'],
        ];
        foreach($testimonials as $t) echo "
        <div style='padding:2rem;background:rgba(255,255,255,.03);border:1px solid rgba(201,168,76,.1);border-radius:4px;transition:border-color .3s;' onmouseover=\"this.style.borderColor='rgba(201,168,76,.35)'\" onmouseout=\"this.style.borderColor='rgba(201,168,76,.1)'\">
          <div style='font-size:.9rem;margin-bottom:.5rem;'>{$t[3]}</div>
          <p style='font-size:.875rem;color:#9CA3AF;line-height:1.8;margin-bottom:1.5rem;font-style:italic;'>&ldquo;{$t[0]}&rdquo;</p>
          <div style='display:flex;align-items:center;gap:.75rem;border-top:1px solid rgba(201,168,76,.1);padding-top:1.25rem;'>
            <div style='width:38px;height:38px;border-radius:50%;background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.3);display:flex;align-items:center;justify-content:center;font-size:.8rem;color:#C9A84C;font-weight:700;'>{$t[1][0]}</div>
            <div>
              <div style='font-size:.85rem;color:#E5E4E2;font-weight:600;'>{$t[1]}</div>
              <div style='font-size:.7rem;color:#555;'>{$t[2]}</div>
            </div>
          </div>
        </div>";
      ?>
    </div>
  </div>
</section>

<!-- ═══════════════ CTA ═══════════════ -->
<section style="padding:5rem 2rem;background:linear-gradient(135deg,#0D0D0D 0%,#1A1A1A 50%,#0D0D0D 100%);position:relative;overflow:hidden;">
  <div style="position:absolute;inset:0;opacity:.04;background-image:radial-gradient(circle,#C9A84C 1px,transparent 1px);background-size:30px 30px;"></div>
  <div style="max-width:700px;margin:0 auto;text-align:center;position:relative;z-index:1;">
    <div style="width:80px;height:1px;background:linear-gradient(90deg,transparent,#C9A84C,transparent);margin:0 auto 2rem;"></div>
    <h2 style="font-family:'Cormorant Garamond',serif;font-size:clamp(2rem,4vw,3rem);font-weight:600;color:white;letter-spacing:.02em;margin-bottom:1rem;">Begin Your Luxury Journey</h2>
    <p style="font-size:.9rem;color:#6B6B6B;line-height:1.8;margin-bottom:2.5rem;">Join thousands of discerning customers who trust Cellario for authentic, exclusive luxury technology.</p>
    <div style="display:flex;gap:1rem;justify-content:center;flex-wrap:wrap;">
      <a href="/Celario_lite/cellario_lite/Register" style="display:inline-block;padding:.875rem 2.5rem;background:linear-gradient(135deg,#9A7B2E,#C9A84C);color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;border-radius:2px;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">Create Free Account</a>
      <a href="/Celario_lite/cellario_lite/Products" style="display:inline-block;padding:.875rem 2.5rem;border:1px solid rgba(201,168,76,.5);color:#C9A84C;font-size:.8rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;text-decoration:none;border-radius:2px;transition:all .2s;" onmouseover="this.style.borderColor='#C9A84C';this.style.background='rgba(201,168,76,.06)'" onmouseout="this.style.borderColor='rgba(201,168,76,.5)';this.style.background=''">Browse Products</a>
    </div>
    <div style="width:80px;height:1px;background:linear-gradient(90deg,transparent,#C9A84C,transparent);margin:2rem auto 0;"></div>
  </div>
</section>

</main>

<style>
  @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.4} }
  #heroGrid { grid-template-columns: 1fr 1fr; }
  #whyGrid  { grid-template-columns: 1fr 1fr; }
  @media (max-width:768px) {
    #heroGrid { grid-template-columns: 1fr; }
    #whyGrid  { grid-template-columns: 1fr; }
  }
</style>

<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
