<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Celario_lite/cellario_lite/Login"); exit;
}

require_once "./src/php/Controller/AdminController.php";
$adminCtrl = new AdminController();
$customers = $adminCtrl->getAllCustomers();
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Manage Accounts — Cellario Admin</title>
<link rel="stylesheet" href="/Celario_lite/cellario_lite/src/output.css">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{font-family:'Inter',sans-serif;background:#F4F4F4;margin:0;}
.sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.625rem 1rem;border-radius:6px;color:#9CA3AF;text-decoration:none;font-size:.8rem;font-weight:500;transition:all .2s;}
.sidebar-link:hover{background:rgba(201,168,76,.1);color:#C9A84C;}
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
        <h2 style="font-size:1rem;font-weight:600;color:#0D0D0D;">Customer Accounts</h2>
      </div>
      <span style="font-size:.8rem;color:#9CA3AF;"><?= count($customers) ?> customers</span>
    </div>

    <div style="background:white;border-radius:8px;border:1px solid #EFEFEF;overflow:hidden;">
      <?php if (!empty($customers)): ?>
      <div style="overflow-x:auto;">
        <table>
          <thead><tr>
            <th>Customer</th><th>Email</th><th>Joined</th><th>Actions</th>
          </tr></thead>
          <tbody>
            <?php foreach($customers as $c): ?>
            <tr>
              <td>
                <div style="display:flex;align-items:center;gap:.75rem;">
                  <div style="width:36px;height:36px;border-radius:50%;background:<?= !empty($c['image_path'])?'transparent':'rgba(201,168,76,.1)' ?>;display:flex;align-items:center;justify-content:center;flex-shrink:0;overflow:hidden;border:1.5px solid rgba(201,168,76,.2);">
                    <?php if(!empty($c['image_path'])): ?>
                      <img src="<?= htmlspecialchars($c['image_path']) ?>" style="width:100%;height:100%;object-fit:cover;">
                    <?php else: ?>
                      <span style="font-size:.8rem;font-weight:700;color:#C9A84C;"><?= strtoupper($c['firstName'][0]) ?></span>
                    <?php endif; ?>
                  </div>
                  <div>
                    <div style="font-weight:600;color:#1A1A1A;font-size:.85rem;"><?= htmlspecialchars($c['firstName'].' '.$c['lastName']) ?></div>
                    <div style="font-size:.7rem;color:#9CA3AF;">Customer</div>
                  </div>
                </div>
              </td>
              <td style="color:#6B6B6B;font-size:.8rem;"><?= htmlspecialchars($c['email']) ?></td>
              <td style="color:#9CA3AF;font-size:.75rem;">ID #<?= $c['id'] ?></td>
              <td>
                <a href="/Celario_lite/cellario_lite/Admin/DeleteAccount?id=<?= $c['id'] ?>" onclick="return confirm('Delete this customer account? This action cannot be undone.')"
                  style="padding:.35rem .75rem;border:1px solid #FEE2E2;color:#EF4444;font-size:.7rem;font-weight:600;text-decoration:none;border-radius:6px;transition:all .2s;" onmouseover="this.style.background='#FEE2E2'" onmouseout="this.style.background=''">Delete</a>
              </td>
            </tr>
            <?php endforeach; ?>
          </tbody>
        </table>
      </div>
      <?php else: ?>
      <div style="text-align:center;padding:4rem;">
        <div style="font-size:3rem;margin-bottom:1rem;">👥</div>
        <p style="font-size:.9rem;color:#9CA3AF;">No customer accounts registered yet.</p>
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
