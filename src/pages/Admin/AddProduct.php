<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Celario_lite/cellario_lite/Login"); exit;
}

require_once "./src/php/Controller/ProductController.php";
$controller = new ProductController();
$success = false; $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand       = htmlspecialchars(trim($_POST['brand']));
    $modelName   = htmlspecialchars(trim($_POST['model_name']));
    $category    = $_POST['category'];
    $description = htmlspecialchars(trim($_POST['description']));
    $price       = (float)$_POST['price'];
    $stock       = (int)$_POST['stock'];

    if ($brand && $modelName && $category && $price > 0) {
        $productId = $controller->addProduct($_SESSION['user_id'], $brand, $modelName, $category, $description, $price, $stock, $_FILES['images'] ?? null);
        if ($productId) {
            $success = true;
        } else {
            $error = "Failed to add product. Please try again.";
        }
    } else {
        $error = "Please fill in all required fields.";
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Add Product — Cellario Admin</title>
<link rel="stylesheet" href="/Celario_lite/cellario_lite/src/output.css">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{font-family:'Inter',sans-serif;background:#F4F4F4;margin:0;}
.sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.625rem 1rem;border-radius:6px;color:#9CA3AF;text-decoration:none;font-size:.8rem;font-weight:500;transition:all .2s;}
.sidebar-link:hover{background:rgba(201,168,76,.1);color:#C9A84C;}
label{display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:600;}
input,select,textarea{width:100%;padding:.75rem;border:1px solid #E0E0E0;background:white;font-size:.875rem;outline:none;border-radius:6px;font-family:'Inter',sans-serif;transition:border-color .2s,box-shadow .2s;}
input:focus,select:focus,textarea:focus{border-color:#C9A84C;box-shadow:0 0 0 3px rgba(201,168,76,.1);}
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
        <h2 style="font-size:1rem;font-weight:600;color:#0D0D0D;">Add New Product</h2>
      </div>
      <a href="/Celario_lite/cellario_lite/Admin/ManageProducts" style="font-size:.8rem;color:#9CA3AF;text-decoration:none;">← Back to Products</a>
    </div>

    <?php if ($success): ?>
    <div style="background:rgba(16,185,129,.1);border:1px solid #10B981;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem;display:flex;align-items:center;gap:.875rem;">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#10B981" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
      <div>
        <div style="font-weight:600;color:#10B981;font-size:.875rem;">Product Added Successfully!</div>
        <div style="font-size:.8rem;color:#065F46;margin-top:.2rem;"><a href="/Celario_lite/cellario_lite/Admin/ManageProducts" style="color:#C9A84C;text-decoration:none;font-weight:600;">View all products</a> or add another below.</div>
      </div>
    </div>
    <?php elseif ($error): ?>
    <div style="background:rgba(239,68,68,.1);border:1px solid #EF4444;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem;color:#EF4444;font-size:.875rem;"><?= $error ?></div>
    <?php endif; ?>

    <div style="background:white;border-radius:8px;border:1px solid #EFEFEF;padding:2rem;">
      <form method="post" enctype="multipart/form-data">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
          <div>
            <label>Brand *</label>
            <input type="text" name="brand" placeholder="e.g. Apple, Samsung, Sony" required>
          </div>
          <div>
            <label>Model Name *</label>
            <input type="text" name="model_name" placeholder="e.g. iPhone 15 Pro Max" required>
          </div>
          <div>
            <label>Category *</label>
            <select name="category" required>
              <option value="" disabled selected>Select category</option>
              <option value="smartphone">Smartphone</option>
              <option value="laptop">Laptop</option>
              <option value="audio">Audio Device</option>
              <option value="accessory">Accessory</option>
            </select>
          </div>
          <div>
            <label>Price (USD) *</label>
            <input type="number" name="price" min="0.01" step="0.01" placeholder="1299.99" required>
          </div>
          <div>
            <label>Stock Quantity *</label>
            <input type="number" name="stock" min="0" placeholder="50" required>
          </div>
        </div>

        <div style="margin-top:1.5rem;">
          <label>Description</label>
          <textarea name="description" rows="5" placeholder="Describe the product, its features, specifications..."
            style="width:100%;padding:.75rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:6px;font-family:'Inter',sans-serif;resize:vertical;transition:border-color .2s;"
            onfocus="this.style.borderColor='#C9A84C';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.1)'"
            onblur="this.style.borderColor='#E0E0E0';this.style.boxShadow=''"></textarea>
        </div>

        <div style="margin-top:1.5rem;">
          <label>Product Images</label>
          <div style="border:2px dashed #E0E0E0;border-radius:8px;padding:2rem;text-align:center;cursor:pointer;transition:border-color .2s;" id="dropzone" onmouseover="this.style.borderColor='#C9A84C'" onmouseout="this.style.borderColor='#E0E0E0'" onclick="document.getElementById('imageInput').click()">
            <div style="font-size:2rem;margin-bottom:.75rem;">📷</div>
            <div style="font-size:.85rem;color:#6B6B6B;margin-bottom:.5rem;">Click to upload product images</div>
            <div style="font-size:.75rem;color:#9CA3AF;">JPG, PNG, WEBP up to 10MB each</div>
            <div id="fileNames" style="margin-top:1rem;font-size:.8rem;color:#C9A84C;font-weight:500;"></div>
          </div>
          <input type="file" id="imageInput" name="images[]" multiple accept="image/*" style="display:none;" onchange="updateFileNames(this)">
          <div style="margin-top:.5rem;font-size:.7rem;color:#9CA3AF;">First image will be used as the main product image</div>
        </div>

        <div style="display:flex;gap:1rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid #F0F0F0;">
          <button type="submit" style="flex:1;padding:.875rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;border:none;cursor:pointer;border-radius:6px;transition:all .2s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">Add Product</button>
          <a href="/Celario_lite/cellario_lite/Admin/ManageProducts" style="padding:.875rem 1.5rem;border:1px solid #E0E0E0;color:#6B6B6B;font-size:.8rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;text-decoration:none;border-radius:6px;display:flex;align-items:center;transition:all .2s;" onmouseover="this.style.borderColor='#9CA3AF'" onmouseout="this.style.borderColor='#E0E0E0'">Cancel</a>
        </div>
      </form>
    </div>
  </main>
</div>
<script>
  function checkSize(){var s=document.getElementById('desktopSidebar');var m=document.getElementById('mainContent');var h=document.getElementById('hamburgerBtn');if(window.innerWidth>=768){s.style.display='block';m.style.marginLeft='220px';h.style.display='none';}else{s.style.display='none';m.style.marginLeft='0';h.style.display='flex';}}
  checkSize();window.addEventListener('resize',checkSize);
  function toggleSidebar(){var sb=document.getElementById('mobileSidebar');sb.style.transform=sb.style.transform==='translateX(0%)'?'translateX(-100%)':'translateX(0%)';}
  function updateFileNames(input){
    var names=Array.from(input.files).map(f=>f.name).join(', ');
    document.getElementById('fileNames').textContent=names||'';
  }
</script>
</body></html>
