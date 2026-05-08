<?php
include_once "./src/private/initialize.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include_once "./src/php/Controller/UserController.php";
    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName  = htmlspecialchars(trim($_POST['lastName']));
    $email     = htmlspecialchars(trim($_POST['email']));
    $password  = htmlspecialchars(trim($_POST['password']));
    $role        = $_POST['role'];
    $adminSecret = trim($_POST['admin_secret'] ?? '');

    $user = new UserController();
    $user->register($firstName, $lastName, $email, $password, $role, $adminSecret);
}

$pageTitle = "Create Account";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>

<main style="min-height:calc(100vh - 68px);display:grid;grid-template-columns:1fr 1fr;">
  <!-- Left Panel -->
  <div id="regImagePanel" style="display:none;position:relative;background:#0D0D0D;overflow:hidden;">
    <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:3rem;text-align:center;">
      <div style="font-family:'Cormorant Garamond',serif;font-size:3rem;font-weight:300;color:#C9A84C;letter-spacing:.15em;line-height:1;margin-bottom:1rem;">JOIN<br>CELLARIO</div>
      <div style="width:60px;height:1px;background:linear-gradient(90deg,transparent,#C9A84C,transparent);margin:1.5rem auto;"></div>
      <p style="font-size:.85rem;color:#6B6B6B;letter-spacing:.08em;line-height:2;max-width:250px;">Become a member of the most exclusive luxury tech community in the world.</p>
      <div style="margin-top:2.5rem;width:100%;max-width:280px;">
        <div style="background:rgba(201,168,76,.05);border:1px solid rgba(201,168,76,.15);padding:1.5rem;border-radius:4px;">
          <div style="font-size:.75rem;color:#C9A84C;letter-spacing:.15em;text-transform:uppercase;margin-bottom:1rem;font-weight:600;">Member Benefits</div>
          <?php
            $benefits = ['Early access to limited editions','Priority customer support','Exclusive member discounts','Personalized recommendations'];
            foreach($benefits as $b) echo "<div style='display:flex;align-items:center;gap:.5rem;margin-bottom:.625rem;'><svg width='12' height='12' viewBox='0 0 24 24' fill='none' stroke='#C9A84C' stroke-width='2.5'><polyline points='20 6 9 17 4 12'/></svg><span style='font-size:.8rem;color:#9CA3AF;'>{$b}</span></div>";
          ?>
        </div>
      </div>
    </div>
  </div>

  <!-- Right: Register Form -->
  <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;padding:3rem 2rem;background:#FAFAF8;">
    <div style="width:100%;max-width:420px;">
      <div style="margin-bottom:2rem;">
        <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.25rem;font-weight:600;color:#0D0D0D;letter-spacing:.02em;margin-bottom:.5rem;">Create Account</h1>
        <p style="font-size:.875rem;color:#6B6B6B;">Join Cellario — your gateway to luxury tech</p>
        <div style="width:40px;height:2px;background:linear-gradient(90deg,#C9A84C,#E8D5A3);margin-top:1rem;"></div>
      </div>

      <form method="post" style="display:flex;flex-direction:column;gap:1.1rem;">
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
          <div>
            <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">First Name</label>
            <input type="text" name="firstName" placeholder="John" required
              style="width:100%;padding:.7rem 1rem;border:1px solid #E0E0E0;background:white;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s,box-shadow .2s;"
              onfocus="this.style.borderColor='#C9A84C';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.1)'"
              onblur="this.style.borderColor='#E0E0E0';this.style.boxShadow='none'">
          </div>
          <div>
            <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Last Name</label>
            <input type="text" name="lastName" placeholder="Doe" required
              style="width:100%;padding:.7rem 1rem;border:1px solid #E0E0E0;background:white;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s,box-shadow .2s;"
              onfocus="this.style.borderColor='#C9A84C';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.1)'"
              onblur="this.style.borderColor='#E0E0E0';this.style.boxShadow='none'">
          </div>
        </div>

        <div>
          <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Email Address</label>
          <input type="email" name="email" placeholder="your@email.com" required
            style="width:100%;padding:.7rem 1rem;border:1px solid #E0E0E0;background:white;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s,box-shadow .2s;"
            onfocus="this.style.borderColor='#C9A84C';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.1)'"
            onblur="this.style.borderColor='#E0E0E0';this.style.boxShadow='none'">
        </div>

        <div>
          <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Password</label>
          <input type="password" name="password" placeholder="Minimum 6 characters" required
            style="width:100%;padding:.7rem 1rem;border:1px solid #E0E0E0;background:white;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s,box-shadow .2s;"
            onfocus="this.style.borderColor='#C9A84C';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.1)'"
            onblur="this.style.borderColor='#E0E0E0';this.style.boxShadow='none'">
        </div>

        <div>
          <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Account Type</label>
          <select name="role" id="roleSelect" required
            style="width:100%;padding:.7rem 1rem;border:1px solid #E0E0E0;background:white;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;cursor:pointer;"
            onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'"
            onchange="toggleAdminSecret(this.value)">
            <option value="" disabled selected>Select account type</option>
            <option value="customer">Customer</option>
            <option value="admin">Admin</option>
          </select>
        </div>

        <!-- Admin Secret Key — only visible when Admin is selected -->
        <div id="adminSecretWrap" style="overflow:hidden;max-height:0;opacity:0;transition:max-height .35s ease,opacity .3s ease;">
          <div style="padding:.125rem 0;">
            <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">
              Admin Secret Key
              <span style="color:#C9A84C;"> *</span>
            </label>
            <div style="position:relative;">
              <input type="password" name="admin_secret" id="adminSecretInput" placeholder="Enter the admin secret key"
                style="width:100%;padding:.7rem 1rem .7rem 2.5rem;border:1px solid #E0E0E0;background:white;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s,box-shadow .2s;"
                onfocus="this.style.borderColor='#C9A84C';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.1)'"
                onblur="this.style.borderColor='#E0E0E0';this.style.boxShadow='none'">
              <svg width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2"
                style="position:absolute;left:.75rem;top:50%;transform:translateY(-50%);pointer-events:none;">
                <rect x="3" y="11" width="18" height="11" rx="2" ry="2"/>
                <path d="M7 11V7a5 5 0 0 1 10 0v4"/>
              </svg>
            </div>
            <p style="font-size:.7rem;color:#9CA3AF;margin-top:.4rem;">Contact the platform owner to obtain the admin secret key.</p>
          </div>
        </div>

        <button type="submit"
          style="width:100%;padding:.875rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;border:1px solid #0D0D0D;cursor:pointer;transition:all .3s;margin-top:.5rem;border-radius:2px;"
          onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D';this.style.borderColor='#C9A84C'"
          onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C';this.style.borderColor='#0D0D0D'">
          Create Account
        </button>
      </form>

      <div style="margin-top:1.5rem;padding-top:1.25rem;border-top:1px solid #EFEFEF;text-align:center;">
        <p style="font-size:.85rem;color:#6B6B6B;">Already a member?
          <a href="/Celario_lite/cellario_lite/Login" style="color:#C9A84C;font-weight:600;text-decoration:none;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">Sign In</a>
        </p>
      </div>
    </div>
  </div>
</main>
<script>
  // Responsive image panel
  document.getElementById('regImagePanel').style.display = window.innerWidth >= 768 ? 'block' : 'none';
  window.addEventListener('resize', function(){
    document.getElementById('regImagePanel').style.display = window.innerWidth >= 768 ? 'block' : 'none';
  });

  // Toggle admin secret key field
  function toggleAdminSecret(role) {
    var wrap  = document.getElementById('adminSecretWrap');
    var input = document.getElementById('adminSecretInput');
    if (role === 'admin') {
      wrap.style.maxHeight = '120px';
      wrap.style.opacity   = '1';
      input.required = true;
    } else {
      wrap.style.maxHeight = '0';
      wrap.style.opacity   = '0';
      input.required = false;
      input.value = '';
    }
  }
</script>
<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
