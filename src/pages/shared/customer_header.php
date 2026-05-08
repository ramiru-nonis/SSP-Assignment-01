<?php ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="Cellario — Premium luxury electronics. Exclusive flagship smartphones, laptops, and audio devices.">
  <title>Cellario — <?php echo isset($pageTitle) ? htmlspecialchars($pageTitle) : 'Luxury Electronics'; ?></title>
  <link rel="stylesheet" href="/Celario_lite/cellario_lite/src/output.css">
  <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
  <style>
    *{box-sizing:border-box}body{font-family:'Inter',sans-serif;background:#FAFAF8;color:#1A1A1A}
    .nav-link{color:#9CA3AF;font-size:.8rem;letter-spacing:.1em;text-transform:uppercase;font-weight:500;text-decoration:none;transition:color .2s;padding-bottom:2px;position:relative}
    .nav-link:hover{color:#C9A84C}
    .cart-badge{position:absolute;top:-6px;right:-8px;background:#C9A84C;color:#0D0D0D;font-size:9px;font-weight:700;width:16px;height:16px;border-radius:50%;display:flex;align-items:center;justify-content:center}
  </style>
</head>
<body>
<header style="background:#0D0D0D;position:sticky;top:0;z-index:50;border-bottom:1px solid rgba(201,168,76,.2);">
  <div style="max-width:1400px;margin:0 auto;padding:0 2rem;display:flex;align-items:center;justify-content:space-between;height:68px;">
    <a href="/Celario_lite/cellario_lite/" style="text-decoration:none;">
      <div style="font-family:'Cormorant Garamond',serif;font-size:1.75rem;font-weight:700;color:#C9A84C;letter-spacing:.1em;line-height:1;">CELLARIO</div>
      <div style="font-size:.5rem;letter-spacing:.25em;color:#555;text-transform:uppercase;margin-top:2px;">Luxury Electronics</div>
    </a>
    <nav id="desktopNav" style="display:none;">
      <ul style="display:flex;gap:2rem;list-style:none;margin:0;padding:0;">
        <li><a href="/Celario_lite/cellario_lite/" class="nav-link">Home</a></li>
        <li><a href="/Celario_lite/cellario_lite/Products" class="nav-link">Products</a></li>
        <li><a href="/Celario_lite/cellario_lite/About" class="nav-link">About</a></li>
        <li><a href="/Celario_lite/cellario_lite/Contact" class="nav-link">Contact</a></li>
      </ul>
    </nav>
    <div style="display:flex;align-items:center;gap:1.25rem;">
      <?php if(isset($_SESSION['role']) && $_SESSION['role']==='customer'): ?>
        <a href="/Celario_lite/cellario_lite/Cart" style="position:relative;color:#9CA3AF;transition:color .2s;" onmouseover="this.style.color='#C9A84C'" onmouseout="this.style.color='#9CA3AF'" title="Cart">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M6 2L3 6v14a2 2 0 002 2h14a2 2 0 002-2V6l-3-4z"/><line x1="3" y1="6" x2="21" y2="6"/><path d="M16 10a4 4 0 01-8 0"/></svg>
          <?php
            if(isset($_SESSION['user_id'])){
              require_once "./src/php/Model/Customer.php";
              $c=new Customer(); $cnt=$c->getCartCount($_SESSION['user_id']);
              if($cnt>0) echo "<span class='cart-badge'>{$cnt}</span>";
            }
          ?>
        </a>
        <a href="/Celario_lite/cellario_lite/Favorites" style="color:#9CA3AF;transition:color .2s;" onmouseover="this.style.color='#C9A84C'" onmouseout="this.style.color='#9CA3AF'" title="Wishlist">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"><path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"/></svg>
        </a>
      <?php endif; ?>
      <?php
        $acctHref = '/Celario_lite/cellario_lite/Login';
        if(isset($_SESSION['role'])){
          $acctHref = ($_SESSION['role']==='admin') ? '/Celario_lite/cellario_lite/Admin/Dashboard' : '/Celario_lite/cellario_lite/Account/Edit';
        }
      ?>
      <a href="<?= $acctHref ?>" style="display:flex;align-items:center;gap:.5rem;text-decoration:none;">
        <?php if(isset($_SESSION['image'])&&$_SESSION['image']): ?>
          <img src="<?= htmlspecialchars($_SESSION['image']) ?>" alt="Profile" style="width:34px;height:34px;border-radius:50%;object-fit:cover;border:2px solid #C9A84C;">
        <?php else: ?>
          <div style="width:34px;height:34px;border-radius:50%;background:#2C2C2C;border:1.5px solid rgba(201,168,76,.3);display:flex;align-items:center;justify-content:center;">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2"><path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"/><circle cx="12" cy="7" r="4"/></svg>
          </div>
        <?php endif; ?>
      </a>
      <?php if(isset($_SESSION['email'])): ?>
        <a href="/Celario_lite/cellario_lite/Logout" style="font-size:.75rem;color:#6B6B6B;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;transition:color .2s;" onmouseover="this.style.color='#C9A84C'" onmouseout="this.style.color='#6B6B6B'">Logout</a>
      <?php else: ?>
        <a href="/Celario_lite/cellario_lite/Login" style="font-size:.75rem;padding:.45rem 1.25rem;border:1px solid #C9A84C;color:#C9A84C;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;transition:all .2s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='';this.style.color='#C9A84C'">Login</a>
      <?php endif; ?>
      <button onclick="toggleMobileNav()" style="background:none;border:none;cursor:pointer;padding:4px;display:flex;flex-direction:column;gap:5px;" aria-label="Menu">
        <span style="display:block;width:22px;height:1.5px;background:#C9A84C;"></span>
        <span style="display:block;width:22px;height:1.5px;background:#C9A84C;"></span>
        <span style="display:block;width:22px;height:1.5px;background:#C9A84C;"></span>
      </button>
    </div>
  </div>
</header>
<div id="mobileSidebar" style="position:fixed;inset:0;z-index:100;background:#0D0D0D;transform:translateX(-100%);transition:transform .35s ease;overflow-y:auto;">
  <div style="padding:2rem;">
    <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:2rem;">
      <span style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:#C9A84C;font-weight:700;">CELLARIO</span>
      <button onclick="toggleMobileNav()" style="background:none;border:none;cursor:pointer;color:#C9A84C;">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><line x1="18" y1="6" x2="6" y2="18"/><line x1="6" y1="6" x2="18" y2="18"/></svg>
      </button>
    </div>
    <nav style="display:flex;flex-direction:column;">
      <?php
        $mLinks = [
          'Home'     => '/Celario_lite/cellario_lite/',
          'Products' => '/Celario_lite/cellario_lite/Products',
          'About'    => '/Celario_lite/cellario_lite/About',
          'Contact'  => '/Celario_lite/cellario_lite/Contact',
        ];
        if(isset($_SESSION['role']) && $_SESSION['role']==='customer'){
          $mLinks['Cart']      = '/Celario_lite/cellario_lite/Cart';
          $mLinks['Favorites'] = '/Celario_lite/cellario_lite/Favorites';
        }
        foreach($mLinks as $label => $href){
          echo "<a href='{$href}' style='display:block;padding:.875rem 1rem;color:#D1D5DB;text-decoration:none;border-bottom:1px solid rgba(201,168,76,.1);font-size:.9rem;letter-spacing:.05em;text-transform:uppercase;'>{$label}</a>";
        }
      ?>
      <?php if(isset($_SESSION['email'])): ?>
        <a href="/Celario_lite/cellario_lite/Logout" style="display:block;padding:.875rem 1rem;color:#EF4444;text-decoration:none;font-size:.9rem;text-transform:uppercase;letter-spacing:.05em;">Logout</a>
      <?php else: ?>
        <a href="/Celario_lite/cellario_lite/Login" style="display:block;padding:.875rem 1rem;color:#C9A84C;text-decoration:none;font-size:.9rem;text-transform:uppercase;letter-spacing:.05em;">Login</a>
        <a href="/Celario_lite/cellario_lite/Register" style="display:block;padding:.875rem 1rem;color:#C9A84C;text-decoration:none;font-size:.9rem;text-transform:uppercase;letter-spacing:.05em;">Register</a>
      <?php endif; ?>
    </nav>
  </div>
</div>
<script>
  function checkScreen(){document.getElementById('desktopNav').style.display=window.innerWidth>=768?'block':'none';}
  checkScreen();window.addEventListener('resize',checkScreen);
  function toggleMobileNav(){
    var s=document.getElementById('mobileSidebar');
    s.style.transform=s.style.transform==='translateX(0%)'?'translateX(-100%)':'translateX(0%)';
  }
</script>
