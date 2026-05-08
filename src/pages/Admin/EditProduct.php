<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: /Celario_lite/cellario_lite/Login"); exit;
}

require_once "./src/php/Controller/ProductController.php";
$controller = new ProductController();

$id      = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$product = $controller->getProductByIdAdmin($id);

if (!$product) {
    header("Location: /Celario_lite/cellario_lite/Admin/ManageProducts"); exit;
}

$success = false; $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $brand       = htmlspecialchars(trim($_POST['brand']));
    $modelName   = htmlspecialchars(trim($_POST['model_name']));
    $category    = $_POST['category'];
    $description = htmlspecialchars(trim($_POST['description']));
    $price       = (float)$_POST['price'];
    $stock       = (int)$_POST['stock'];
    $status      = $_POST['status'];

    $images = (!empty($_FILES['images']['name'][0])) ? $_FILES['images'] : null;

    $result = $controller->updateProduct($id, $brand, $modelName, $category, $description, $price, $stock, $status, $images);
    if ($result) {
        $success = true;
        $product = $controller->getProductByIdAdmin($id);
    } else {
        $error = "Update failed. Please try again.";
    }
}
?>
<!DOCTYPE html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1.0">
<title>Edit Product — Cellario Admin</title>
<link rel="stylesheet" href="/Celario_lite/cellario_lite/src/output.css">
<link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
<style>
*{box-sizing:border-box}body{font-family:'Inter',sans-serif;background:#F4F4F4;margin:0;}
.sidebar-link{display:flex;align-items:center;gap:.75rem;padding:.625rem 1rem;border-radius:6px;color:#9CA3AF;text-decoration:none;font-size:.8rem;font-weight:500;transition:all .2s;}
.sidebar-link:hover{background:rgba(201,168,76,.1);color:#C9A84C;}
label{display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:600;}
input,select,textarea{width:100%;padding:.75rem;border:1px solid #E0E0E0;background:white;font-size:.875rem;outline:none;border-radius:6px;font-family:'Inter',sans-serif;transition:border-color .2s;}
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
        <h2 style="font-size:1rem;font-weight:600;color:#0D0D0D;">Edit Product</h2>
      </div>
      <a href="/Celario_lite/cellario_lite/Admin/ManageProducts" style="font-size:.8rem;color:#9CA3AF;text-decoration:none;">← Back</a>
    </div>

    <?php if ($success): ?>
    <div style="background:rgba(16,185,129,.1);border:1px solid #10B981;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem;color:#10B981;font-size:.875rem;font-weight:600;">Product updated successfully!</div>
    <?php elseif ($error): ?>
    <div style="background:rgba(239,68,68,.1);border:1px solid #EF4444;border-radius:8px;padding:1.25rem;margin-bottom:1.5rem;color:#EF4444;font-size:.875rem;"><?= $error ?></div>
    <?php endif; ?>

    <div style="background:white;border-radius:8px;border:1px solid #EFEFEF;padding:2rem;">
      <form method="post" enctype="multipart/form-data">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.5rem;">
          <div>
            <label>Brand *</label>
            <input type="text" name="brand" value="<?= htmlspecialchars($product['brand']) ?>" required>
          </div>
          <div>
            <label>Model Name *</label>
            <input type="text" name="model_name" value="<?= htmlspecialchars($product['model_name']) ?>" required>
          </div>
          <div>
            <label>Category *</label>
            <select name="category" required>
              <?php foreach(['smartphone','laptop','audio','accessory'] as $cat): ?>
                <option value="<?= $cat ?>" <?= $product['category']===$cat?'selected':'' ?>><?= ucfirst($cat) ?></option>
              <?php endforeach; ?>
            </select>
          </div>
          <div>
            <label>Price (USD) *</label>
            <input type="number" name="price" min="0.01" step="0.01" value="<?= $product['price'] ?>" required>
          </div>
          <div>
            <label>Stock Quantity</label>
            <input type="number" name="stock" min="0" value="<?= $product['stock'] ?>" required>
          </div>
          <div>
            <label>Status</label>
            <select name="status">
              <option value="active"   <?= $product['status']==='active'   ?'selected':'' ?>>Active</option>
              <option value="inactive" <?= $product['status']==='inactive' ?'selected':'' ?>>Inactive</option>
            </select>
          </div>
        </div>
        <div style="margin-top:1.5rem;">
          <label>Description</label>
          <textarea name="description" rows="5" style="width:100%;padding:.75rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:6px;font-family:'Inter',sans-serif;resize:vertical;"
            onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'"><?= htmlspecialchars($product['description']) ?></textarea>
        </div>
        <!-- Current Images -->
        <?php if (!empty($product['images'])): ?>
        <div style="margin-top:1.5rem;">
          <label>Current Images</label>
          <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:.5rem;">
            <?php foreach($product['images'] as $img): ?>
              <div style="width:80px;height:60px;border-radius:4px;overflow:hidden;border:2px solid <?= $img['is_main']?'#C9A84C':'#F0F0F0' ?>;">
                <img src="<?= htmlspecialchars($img['image_path']) ?>" alt="" style="width:100%;height:100%;object-fit:cover;">
              </div>
            <?php endforeach; ?>
          </div>
        </div>
        <?php endif; ?>
        <div style="margin-top:1.5rem;">
          <label>Add More Images</label>
          <div style="border:2px dashed #E0E0E0;border-radius:8px;padding:1.5rem;text-align:center;cursor:pointer;" onclick="document.getElementById('editImages').click()">
            <div style="font-size:.85rem;color:#9CA3AF;">Click to add more product images</div>
            <div id="editFileNames" style="margin-top:.5rem;font-size:.8rem;color:#C9A84C;"></div>
          </div>
          <input type="file" id="editImages" name="images[]" multiple accept="image/*" style="display:none;" onchange="document.getElementById('editFileNames').textContent=Array.from(this.files).map(f=>f.name).join(', ')">
        </div>
        <div style="display:flex;gap:1rem;margin-top:2rem;padding-top:1.5rem;border-top:1px solid #F0F0F0;">
          <button type="submit" style="flex:1;padding:.875rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;border:none;cursor:pointer;border-radius:6px;transition:all .2s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">Save Changes</button>
          <a href="/Celario_lite/cellario_lite/Admin/ManageProducts" style="padding:.875rem 1.5rem;border:1px solid #E0E0E0;color:#6B6B6B;font-size:.8rem;font-weight:600;text-decoration:none;border-radius:6px;display:flex;align-items:center;">Cancel</a>
        </div>
      </form>
    </div>
  </main>
</div>
<script>
  function checkSize(){var s=document.getElementById('desktopSidebar');var m=document.getElementById('mainContent');var h=document.getElementById('hamburgerBtn');if(window.innerWidth>=768){s.style.display='block';m.style.marginLeft='220px';h.style.display='none';}else{s.style.display='none';m.style.marginLeft='0';h.style.display='flex';}}
  checkSize();window.addEventListener('resize',checkSize);
  function toggleSidebar(){var sb=document.getElementById('mobileSidebar');sb.style.transform=sb.style.transform==='translateX(0%)'?'translateX(-100%)':'translateX(0%)';}
</script>
</body></html>
