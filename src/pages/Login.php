<?php
include_once "./src/private/initialize.php";
session_start();

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    include_once "./src/php/Controller/UserController.php";
    $email    = htmlspecialchars(trim($_POST['email']));
    $password = htmlspecialchars(trim($_POST['password']));
    $user = new UserController();
    $user->login($email, $password);
}

$pageTitle = "Login";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>

<main style="min-height:calc(100vh - 68px);display:grid;grid-template-columns:1fr 1fr;">
  <!-- Left: Image Panel -->
  <div style="position:relative;overflow:hidden;background:#0D0D0D;display:none;" id="loginImagePanel">
    <div style="position:absolute;inset:0;background:linear-gradient(135deg,#0D0D0D 0%,#1A1A1A 100%);"></div>
    <div style="position:absolute;inset:0;display:flex;flex-direction:column;justify-content:center;align-items:center;padding:3rem;text-align:center;">
      <div style="font-family:'Cormorant Garamond',serif;font-size:3.5rem;font-weight:300;color:#C9A84C;letter-spacing:.15em;line-height:1;margin-bottom:1rem;">CELLARIO</div>
      <div style="width:60px;height:1px;background:linear-gradient(90deg,transparent,#C9A84C,transparent);margin:1.5rem auto;"></div>
      <p style="font-size:.9rem;color:#6B6B6B;letter-spacing:.1em;text-transform:uppercase;line-height:2;">Exclusive Access<br>Premium Experience<br>Luxury Redefined</p>
      <div style="margin-top:3rem;display:flex;flex-direction:column;gap:1.5rem;width:100%;max-width:300px;">
        <div style="display:flex;align-items:center;gap:1rem;padding:1rem;border:1px solid rgba(201,168,76,.15);border-radius:4px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="1.5"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          <div>
            <div style="font-size:.8rem;color:#E5E4E2;font-weight:500;">Secure Platform</div>
            <div style="font-size:.7rem;color:#555;">256-bit encryption</div>
          </div>
        </div>
        <div style="display:flex;align-items:center;gap:1rem;padding:1rem;border:1px solid rgba(201,168,76,.15);border-radius:4px;">
          <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="1.5"><polyline points="20 6 9 17 4 12"/></svg>
          <div>
            <div style="font-size:.8rem;color:#E5E4E2;font-weight:500;">100% Authentic</div>
            <div style="font-size:.7rem;color:#555;">Verified luxury brands</div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Right: Login Form -->
  <div style="display:flex;flex-direction:column;justify-content:center;align-items:center;padding:3rem 2rem;background:#FAFAF8;">
    <div style="width:100%;max-width:400px;">
      <div style="margin-bottom:2.5rem;">
        <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.25rem;font-weight:600;color:#0D0D0D;letter-spacing:.02em;margin-bottom:.5rem;">Welcome Back</h1>
        <p style="font-size:.875rem;color:#6B6B6B;">Sign in to your Cellario account</p>
        <div style="width:40px;height:2px;background:linear-gradient(90deg,#C9A84C,#E8D5A3);margin-top:1rem;"></div>
      </div>

      <form method="post" style="display:flex;flex-direction:column;gap:1.25rem;">
        <div>
          <label for="email" style="display:block;font-size:.75rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.5rem;font-weight:500;">Email Address</label>
          <input type="email" id="email" name="email" placeholder="your@email.com" required
            style="width:100%;padding:.75rem 1rem;border:1px solid #E0E0E0;background:white;font-size:.9rem;outline:none;transition:border-color .2s,box-shadow .2s;border-radius:2px;"
            onfocus="this.style.borderColor='#C9A84C';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.1)'"
            onblur="this.style.borderColor='#E0E0E0';this.style.boxShadow='none'">
        </div>

        <div>
          <label for="password" style="display:block;font-size:.75rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.5rem;font-weight:500;">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter your password" required
            style="width:100%;padding:.75rem 1rem;border:1px solid #E0E0E0;background:white;font-size:.9rem;outline:none;transition:border-color .2s,box-shadow .2s;border-radius:2px;"
            onfocus="this.style.borderColor='#C9A84C';this.style.boxShadow='0 0 0 3px rgba(201,168,76,.1)'"
            onblur="this.style.borderColor='#E0E0E0';this.style.boxShadow='none'">
        </div>

        <button type="submit" id="loginBtn"
          style="width:100%;padding:.875rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:600;letter-spacing:.15em;text-transform:uppercase;border:1px solid #0D0D0D;cursor:pointer;transition:all .3s;margin-top:.5rem;border-radius:2px;"
          onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D';this.style.borderColor='#C9A84C'"
          onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C';this.style.borderColor='#0D0D0D'">
          Sign In
        </button>
      </form>

      <div style="margin-top:2rem;padding-top:1.5rem;border-top:1px solid #EFEFEF;text-align:center;">
        <p style="font-size:.85rem;color:#6B6B6B;">Don't have an account?
          <a href="/Celario_lite/cellario_lite/Register" style="color:#C9A84C;font-weight:600;text-decoration:none;transition:opacity .2s;" onmouseover="this.style.opacity='.7'" onmouseout="this.style.opacity='1'">Create Account</a>
        </p>
      </div>
    </div>
  </div>
</main>

<script>
  document.getElementById('loginImagePanel').style.display = window.innerWidth >= 768 ? 'block' : 'none';
  window.addEventListener('resize', function(){
    document.getElementById('loginImagePanel').style.display = window.innerWidth >= 768 ? 'block' : 'none';
  });
</script>

<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
