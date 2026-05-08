<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Celario_lite/cellario_lite/Login");
    exit;
}

require_once "./src/php/Controller/AdminController.php";
require_once "./src/php/Controller/ProductController.php";

$adminCtrl   = new AdminController();
$productCtrl = new ProductController();

$totalProducts = $productCtrl->getTotalProducts();
$totalUsers    = $adminCtrl->getTotal('users');
$totalOrders   = $adminCtrl->getTotal('orders');
$totalRevenue  = $adminCtrl->getTotalRevenue();
$recentOrders  = $adminCtrl->getRecentOrders(8);
$lowStock      = $adminCtrl->getLowStockProducts(5);

$pageTitle = "Admin Dashboard";
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cellario Admin — Dashboard</title>
  <link rel="stylesheet" href="/Celario_lite/cellario_lite/src/output.css">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box}body{font-family:'Inter',sans-serif;background:#F4F4F4;margin:0;}
    .sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.625rem 1rem;border-radius:6px;color:#9CA3AF;text-decoration:none;font-size:.8rem;font-weight:500;letter-spacing:.02em;transition:all .2s;}
    .sidebar-link:hover,.sidebar-link.active{background:rgba(201,168,76,.1);color:#C9A84C;}
    .stat-card{background:white;border-radius:8px;padding:1.5rem;border:1px solid #EFEFEF;display:flex;justify-content:space-between;align-items:center;}
    .stat-icon{width:48px;height:48px;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.4rem;}
    table{width:100%;border-collapse:collapse;}
    th,td{padding:.75rem 1rem;text-align:left;font-size:.8rem;border-bottom:1px solid #F0F0F0;}
    th{background:#FAFAF8;font-weight:600;color:#6B6B6B;letter-spacing:.05em;text-transform:uppercase;font-size:.7rem;}
  </style>
</head>
<body>

<!-- Mobile Sidebar -->
<div id="mobileSidebar" style="position:fixed;inset:0;z-index:100;background:#0D0D0D;transform:translateX(-100%);transition:transform .3s ease;width:75%;max-width:280px;">
  <div style="padding:1.5rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
      <span style="font-family:'Cormorant Garamond',serif;font-size:1.35rem;color:#C9A84C;font-weight:700;">CELLARIO</span>
      <button onclick="toggleSidebar()" style="background:none;border:none;cursor:pointer;color:#9CA3AF;">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <?php include "./src/pages/Admin/_sidebar_links.php"; ?>
  </div>
</div>

<div style="display:flex;min-height:100vh;">
  <!-- Desktop Sidebar -->
  <aside style="display:none;width:220px;background:#0D0D0D;position:fixed;top:0;left:0;bottom:0;z-index:10;padding:1.5rem;overflow-y:auto;" id="desktopSidebar">
    <div style="margin-bottom:2rem;padding-bottom:1.25rem;border-bottom:1px solid rgba(201,168,76,.15);">
      <div style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:#C9A84C;font-weight:700;letter-spacing:.08em;">CELLARIO</div>
      <div style="font-size:.6rem;color:#555;letter-spacing:.15em;text-transform:uppercase;margin-top:2px;">Admin Panel</div>
    </div>
    <?php include "./src/pages/Admin/_sidebar_links.php"; ?>
  </aside>

  <!-- Main Content -->
  <main style="flex:1;padding:1.5rem;" id="mainContent">
    <!-- Top Bar -->
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;background:white;padding:1rem 1.25rem;border-radius:8px;border:1px solid #EFEFEF;">
      <div style="display:flex;align-items:center;gap:1rem;">
        <button onclick="toggleSidebar()" style="background:none;border:none;cursor:pointer;color:#1A1A1A;display:none;" id="hamburgerBtn">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg>
        </button>
        <h2 style="font-size:1rem;font-weight:600;color:#0D0D0D;">Dashboard</h2>
      </div>
      <div style="display:flex;align-items:center;gap:.875rem;">
        <span style="font-size:.8rem;color:#6B6B6B;"><?= htmlspecialchars($_SESSION['name']) ?></span>
        <a href="/Celario_lite/cellario_lite/Logout" style="font-size:.75rem;padding:.4rem .875rem;border:1px solid #E0E0E0;color:#6B6B6B;text-decoration:none;border-radius:6px;transition:all .2s;" onmouseover="this.style.borderColor='#EF4444';this.style.color='#EF4444'" onmouseout="this.style.borderColor='#E0E0E0';this.style.color='#6B6B6B'">Logout</a>
      </div>
    </div>

    <!-- Stat Cards -->
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:1rem;margin-bottom:2rem;">
      <?php
        $stats = [
          ['Total Products','📦',$totalProducts,'#EFF6FF','#3B82F6'],
          ['Total Users','👥',$totalUsers,'#F0FDF4','#10B981'],
          ['Total Orders','🛍️',$totalOrders,'#FFF7ED','#F59E0B'],
          ['Total Revenue','💰','$'.number_format($totalRevenue),'#FDF4FF','#8B5CF6'],
        ];
        foreach($stats as $s) echo "
        <div class='stat-card'>
          <div>
            <p style='font-size:.7rem;color:#9CA3AF;text-transform:uppercase;letter-spacing:.08em;font-weight:600;margin-bottom:.35rem;'>{$s[0]}</p>
            <p style='font-size:1.75rem;font-weight:700;color:#0D0D0D;font-family:Cormorant Garamond,serif;'>{$s[2]}</p>
          </div>
          <div class='stat-icon' style='background:{$s[3]};'><span style='font-size:1.5rem;'>{$s[1]}</span></div>
        </div>";
      ?>
    </div>

    <div style="display:grid;grid-template-columns:2fr 1fr;gap:1.5rem;" id="dashGrid">
      <!-- Recent Orders -->
      <div style="background:white;border-radius:8px;padding:1.5rem;border:1px solid #EFEFEF;">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.25rem;">
          <h3 style="font-weight:600;color:#0D0D0D;font-size:.9rem;">Recent Orders</h3>
          <a href="#" style="font-size:.75rem;color:#C9A84C;text-decoration:none;">View All</a>
        </div>
        <?php if (!empty($recentOrders)): ?>
        <div style="overflow-x:auto;">
          <table>
            <thead><tr>
              <th>Customer</th><th>Product</th><th>Amount</th><th>Status</th>
            </tr></thead>
            <tbody>
              <?php foreach($recentOrders as $o): ?>
              <tr>
                <td style="color:#1A1A1A;font-weight:500;"><?= htmlspecialchars($o['firstName'].' '.$o['lastName']) ?></td>
                <td style="color:#6B6B6B;"><?= htmlspecialchars($o['brand'].' '.$o['model_name']) ?></td>
                <td style="color:#C9A84C;font-family:'Cormorant Garamond',serif;font-size:.95rem;font-weight:700;">$<?= number_format($o['price'],2) ?></td>
                <td>
                  <span style="display:inline-block;padding:.25rem .625rem;font-size:.65rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;border-radius:100px;background:<?= $o['status']==='completed'?'rgba(16,185,129,.1)':'rgba(245,158,11,.1)' ?>;color:<?= $o['status']==='completed'?'#10B981':'#F59E0B' ?>;"><?= ucfirst($o['status']) ?></span>
                </td>
              </tr>
              <?php endforeach; ?>
            </tbody>
          </table>
        </div>
        <?php else: ?>
        <p style="font-size:.85rem;color:#9CA3AF;text-align:center;padding:2rem;">No orders yet.</p>
        <?php endif; ?>
      </div>

      <!-- Low Stock Alert -->
      <div style="background:white;border-radius:8px;padding:1.5rem;border:1px solid #EFEFEF;">
        <h3 style="font-weight:600;color:#0D0D0D;font-size:.9rem;margin-bottom:1.25rem;">Low Stock Alert</h3>
        <?php if (!empty($lowStock)): ?>
          <div style="display:flex;flex-direction:column;gap:.875rem;">
            <?php foreach($lowStock as $p): ?>
            <div style="display:flex;justify-content:space-between;align-items:center;padding:.75rem;background:#FFF7ED;border-radius:6px;">
              <div>
                <div style="font-size:.8rem;font-weight:600;color:#1A1A1A;"><?= htmlspecialchars($p['brand'].' '.$p['model_name']) ?></div>
                <div style="font-size:.7rem;color:#9CA3AF;"><?= ucfirst($p['category']) ?></div>
              </div>
              <span style="background:#F59E0B;color:white;font-size:.65rem;font-weight:700;padding:.25rem .5rem;border-radius:100px;"><?= $p['stock'] ?> left</span>
            </div>
            <?php endforeach; ?>
          </div>
        <?php else: ?>
          <div style="text-align:center;padding:2rem;">
            <div style="font-size:2rem;margin-bottom:.5rem;">✅</div>
            <p style="font-size:.8rem;color:#9CA3AF;">All products well stocked</p>
          </div>
        <?php endif; ?>
        <a href="/Celario_lite/cellario_lite/Admin/ManageProducts" style="display:block;margin-top:1.25rem;padding:.625rem;background:#0D0D0D;color:#C9A84C;font-size:.7rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;text-decoration:none;text-align:center;border-radius:6px;transition:all .2s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">Manage Products</a>
      </div>
    </div>
  </main>
</div>

<script>
  function checkSize(){
    var s=document.getElementById('desktopSidebar');
    var m=document.getElementById('mainContent');
    var h=document.getElementById('hamburgerBtn');
    if(window.innerWidth>=768){
      s.style.display='block';
      m.style.marginLeft='220px';
      h.style.display='none';
    } else {
      s.style.display='none';
      m.style.marginLeft='0';
      h.style.display='flex';
    }
  }
  checkSize(); window.addEventListener('resize',checkSize);
  function toggleSidebar(){
    var sb=document.getElementById('mobileSidebar');
    sb.style.transform=sb.style.transform==='translateX(0%)'?'translateX(-100%)':'translateX(0%)';
  }
  document.getElementById('dashGrid').style.cssText=window.innerWidth>=768?'grid-template-columns:2fr 1fr':'grid-template-columns:1fr';
</script>
<style>#dashGrid{grid-template-columns:2fr 1fr;}@media(max-width:768px){#dashGrid{grid-template-columns:1fr;}}</style>
</body>
</html>
