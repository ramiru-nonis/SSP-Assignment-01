<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Celario_lite/cellario_lite/Login"); exit;
}

require_once "./src/php/Controller/ProductController.php";
$controller = new ProductController();
$products   = $controller->getAllProductsAdmin();
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Manage Products — Cellario Admin</title>
<link rel="stylesheet" href="/Celario_lite/cellario_lite/src/output.css">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{font-family:'Inter',sans-serif;background:#F4F4F4;margin:0;}
.sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.625rem 1rem;border-radius:6px;color:#9CA3AF;text-decoration:none;font-size:.8rem;font-weight:500;transition:all .2s;}
.sidebar-link:hover,.sidebar-link.active{background:rgba(201,168,76,.1);color:#C9A84C;}
table{width:100%;border-collapse:collapse;}th,td{padding:.875rem 1rem;text-align:left;font-size:.8rem;border-bottom:1px solid #F0F0F0;}
th{background:#FAFAF8;font-weight:600;color:#6B6B6B;letter-spacing:.05em;text-transform:uppercase;font-size:.7rem;}
</style></head><body>
<div id="mobileSidebar" style="position:fixed;inset:0;z-index:100;background:#0D0D0D;transform:translateX(-100%);transition:transform .3s;width:75%;max-width:280px;">
  <div style="padding:1.5rem;"><?php include "./src/pages/Admin/_sidebar_links.php"; ?></div>
</div>
<div style="display:flex;min-height:100vh;">
  <aside id="desktopSidebar" style="display:none;width:220px;background:#0D0D0D;position:fixed;top:0;left:0;bottom:0;z-index:10;padding:1.5rem;">
    <div style="margin-bottom:2rem;padding-bottom:1.25rem;border-bottom:1px solid rgba(201,168,76,.15);">
      <div style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:#C9A84C;font-weight:700;">CELLARIO</div>
      <div style="font-size:.6rem;color:#555;letter-spacing:.15em;text-transform:uppercase;">Admin Panel</div>
    </div>
    <?php include "./src/pages/Admin/_sidebar_links.php"; ?>
  </aside>
  <main style="flex:1;padding:1.5rem;" id="mainContent">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1rem 1.25rem;border-radius:8px;border:1px solid #EFEFEF;">
      <div style="display:flex;align-items:center;gap:1rem;">
        <button onclick="toggleSidebar()" id="hamburgerBtn" style="background:none;border:none;cursor:pointer;display:none;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <h2 style="font-size:1rem;font-weight:600;color:#0D0D0D;">Manage Products</h2>
      </div>
      <a href="/Celario_lite/cellario_lite/Admin/AddProduct" style="display:inline-flex;align-items:center;gap:.5rem;padding:.5rem 1rem;background:#C9A84C;color:#0D0D0D;font-size:.75rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;border-radius:6px;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">
        <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        Add Product
      </a>
    </div>

    <div style="background:white;border-radius:8px;border:1px solid #EFEFEF;overflow:hidden;">
      <?php if (!empty($products)): ?>
      <div style="overflow-x:auto;">
        <table>
          <thead><tr>
            <th>Product</th><th>Category</th><th>Price</th><th>Stock</th><th>Status</th><th>Actions</th>
          </tr></thead>
          <tbody>
            <?php foreach($products as $p): ?>
              <?php
                $img = !empty($p['main_image']) ? htmlspecialchars($p['main_image']) : 'https://placehold.co/48x36/F8F8F8/9CA3AF?text=IMG';
                $statusColor = $p['status']==='active' ? ['rgba(16,185,129,.1)','#10B981'] : ['rgba(107,107,107,.1)','#6B6B6B'];
                $catColors = ['smartphone'=>'#3B82F6','laptop'=>'#8B5CF6','audio'=>'#10B981','accessory'=>'#F59E0B'];
                $catColor  = $catColors[$p['category']] ?? '#9CA3AF';
              ?>
              <tr>
                <td>
                  <div style="display:flex;align-items:center;gap:.875rem;">
                    <div style="width:48px;height:36px;border-radius:4px;overflow:hidden;flex-shrink:0;background:#F8F8F8;">
                      <img src="<?= $img ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
                    </div>
                    <div>
                      <div style="font-weight:600;color:#1A1A1A;font-size:.85rem;"><?= htmlspecialchars($p['model_name']) ?></div>
                      <div style="font-size:.7rem;color:#9CA3AF;"><?= htmlspecialchars($p['brand']) ?></div>
                    </div>
                  </div>
                </td>
                <td><span style="display:inline-block;padding:.2rem .5rem;background:rgba(0,0,0,.05);color:<?= $catColor ?>;font-size:.65rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;border-radius:100px;"><?= ucfirst($p['category']) ?></span></td>
                <td style="font-family:'Cormorant Garamond',serif;font-size:.95rem;font-weight:700;color:#C9A84C;">$<?= number_format($p['price'],2) ?></td>
                <td style="color:<?= $p['stock']<=5?'#EF4444':($p['stock']<=20?'#F59E0B':'#10B981') ?>;font-weight:600;font-size:.85rem;"><?= $p['stock'] ?></td>
                <td><span style="display:inline-block;padding:.25rem .625rem;background:<?= $statusColor[0] ?>;color:<?= $statusColor[1] ?>;font-size:.65rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;border-radius:100px;"><?= ucfirst($p['status']) ?></span></td>
                <td>
                  <div style="display:flex;gap:.5rem;">
                    <a href="/Celario_lite/cellario_lite/Admin/EditProduct?id=<?= $p['id'] ?>" style="padding:.35rem .75rem;border:1px solid #E0E0E0;color:#6B6B6B;font-size:.7rem;font-weight:600;text-decoration:none;border-radius:6px;transition:all .2s;" onmouseover="this.style.borderColor='#C9A84C';this.style.color='#C9A84C'" onmouseout="this.style.borderColor='#E0E0E0';this.style.color='#6B6B6B'">Edit</a>
                    <a href="/Celario_lite/cellario_lite/Admin/DeleteProduct?id=<?= $p['id'] ?>" onclick="return confirm('Delete this product?')" style="padding:.35rem .75rem;border:1px solid #FEE2E2;color:#EF4444;font-size:.7rem;font-weight:600;text-decoration:none;border-radius:6px;transition:all .2s;" onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background=''">Delete</a>
                  </div>
                </td>
              </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div style="text-align:center;padding:4rem;">
        <div style="font-size:3rem;margin-bottom:1rem;">📦</div>
        <p style="font-size:.9rem;color:#9CA3AF;margin-bottom:1.5rem;">No products yet. Add your first luxury product.</p>
        <a href="/Celario_lite/cellario_lite/Admin/AddProduct" style="display:inline-block;padding:.75rem 1.5rem;background:#C9A84C;color:#0D0D0D;font-size:.8rem;font-weight:700;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;border-radius:6px;">Add First Product</a>
      </div>
      <?php endif; ?>
    </div>
  </main>
</div>
<script>
  function checkSize(){var s=document.getElementById('desktopSidebar');var m=document.getElementById('mainContent');var h=document.getElementById('hamburgerBtn');if(window.innerWidth>=768){s.style.display='block';m.style.marginLeft='220px';h.style.display='none';}else{s.style.display='none';m.style.marginLeft='0';h.style.display='flex';}}
  checkSize();window.addEventListener('resize',checkSize);
  function toggleSidebar(){var sb=document.getElementById('mobileSidebar');sb.style.transform=sb.style.transform==='translateX(0%)'?'translateX(-100%)':'translateX(0%)';}
</script>
</body></html>
