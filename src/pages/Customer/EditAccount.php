<?php
include_once "./src/private/initialize.php";
session_start();

if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'customer') {
    header("Location: /Celario_lite/cellario_lite/Login"); exit;
}

require_once "./src/php/Model/User.php";
$success = false; $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $fname    = htmlspecialchars(trim($_POST['firstName']));
    $lname    = htmlspecialchars(trim($_POST['lastName']));
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $image    = $_FILES['image'] ?? [];

    if ($fname && $lname && $email && strlen($password) >= 6) {
        $db   = new Database();
        $conn = $db->getConnection();
        $result = User::editUser($conn, $_SESSION['user_id'], $fname, $lname, $email, $password, $image);
        if ($result === true) {
            $_SESSION['first_name'] = $fname;
            $_SESSION['last_name']  = $lname;
            $_SESSION['name']       = $fname . ' ' . $lname;
            $success = true;
        } else {
            $error = is_string($result) ? $result : "Update failed.";
        }
    } else {
        $error = "Please fill all fields. Password must be at least 6 characters.";
    }
}

$pageTitle = "My Account";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>
<main style="min-height:100vh;background:#FAFAF8;padding:3rem 2rem;">
  <div style="max-width:600px;margin:0 auto;">
    <div style="margin-bottom:2rem;">
      <h1 style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:#0D0D0D;">My Account</h1>
      <p style="font-size:.85rem;color:#9CA3AF;">Update your Cellario profile</p>
    </div>
    <?php if ($success): ?>
    <div style="background:rgba(16,185,129,.1);border:1px solid #10B981;border-radius:4px;padding:1.25rem;margin-bottom:1.5rem;color:#10B981;font-size:.875rem;font-weight:600;">Profile updated successfully!</div>
    <?php elseif ($error): ?>
    <div style="background:rgba(239,68,68,.1);border:1px solid #EF4444;border-radius:4px;padding:1.25rem;margin-bottom:1.5rem;color:#EF4444;font-size:.875rem;"><?= $error ?></div>
    <?php endif; ?>

    <div style="background:white;border:1px solid #F0F0F0;border-radius:4px;padding:2rem;">
      <!-- Avatar -->
      <div style="text-align:center;margin-bottom:2rem;">
        <?php if(isset($_SESSION['image'])&&$_SESSION['image']): ?>
          <img src="<?= htmlspecialchars($_SESSION['image']) ?>" alt="Profile" style="width:80px;height:80px;border-radius:50%;object-fit:cover;border:3px solid #C9A84C;margin:0 auto;">
        <?php else: ?>
          <div style="width:80px;height:80px;border-radius:50%;background:rgba(201,168,76,.1);border:3px solid rgba(201,168,76,.3);display:flex;align-items:center;justify-content:center;margin:0 auto;font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:700;color:#C9A84C;"><?= strtoupper($_SESSION['first_name'][0]) ?></div>
        <?php endif; ?>
        <div style="font-size:.8rem;color:#C9A84C;font-weight:600;margin-top:.75rem;text-transform:uppercase;letter-spacing:.08em;">Customer</div>
      </div>

      <form method="post" enctype="multipart/form-data" style="display:flex;flex-direction:column;gap:1.1rem;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
          <div>
            <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">First Name</label>
            <input type="text" name="firstName" value="<?= htmlspecialchars($_SESSION['first_name']??'') ?>" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
          </div>
          <div>
            <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Last Name</label>
            <input type="text" name="lastName" value="<?= htmlspecialchars($_SESSION['last_name']??'') ?>" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
          </div>
        </div>
        <div>
          <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Email</label>
          <input type="email" name="email" value="<?= htmlspecialchars($_SESSION['email']??'') ?>" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
        </div>
        <div>
          <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">New Password</label>
          <input type="password" name="password" placeholder="Minimum 6 characters" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
        </div>
        <div>
          <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Profile Photo</label>
          <input type="file" name="image" accept="image/*" style="width:100%;padding:.6rem;border:1px solid #E0E0E0;font-size:.8rem;outline:none;border-radius:2px;">
        </div>
        <button type="submit" style="width:100%;padding:.875rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;border:none;cursor:pointer;border-radius:2px;margin-top:.5rem;transition:all .3s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">Save Changes</button>
      </form>
    </div>

    <!-- Logout -->
    <div style="text-align:center;margin-top:1.5rem;">
      <a href="/Celario_lite/cellario_lite/Logout" style="font-size:.8rem;color:#EF4444;text-decoration:none;letter-spacing:.08em;text-transform:uppercase;font-weight:600;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">Sign Out of Account</a>
    </div>
  </div>
</main>
<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
