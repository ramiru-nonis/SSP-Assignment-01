<?php
include_once "./src/private/initialize.php";
session_start();
$pageTitle = "Contact Us";
$sent = false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $sent = true; // In production, send email here
}
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>
<main>
  <section style="background:#0D0D0D;padding:4rem 2rem;text-align:center;border-bottom:1px solid rgba(201,168,76,.15);">
    <div style="max-width:600px;margin:0 auto;">
      <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;margin-bottom:.75rem;">Get in Touch</div>
      <h1 style="font-family:'Cormorant Garamond',serif;font-size:2.75rem;font-weight:600;color:white;">Contact Cellario</h1>
    </div>
  </section>

  <section style="padding:5rem 2rem;background:#FAFAF8;">
    <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:4rem;" id="contactGrid">
      <!-- Contact Info -->
      <div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:2rem;font-weight:600;color:#0D0D0D;margin-bottom:1.5rem;">We'd Love to Hear From You</h2>
        <p style="font-size:.9rem;color:#6B6B6B;line-height:1.8;margin-bottom:2rem;">Our luxury concierge team is available to assist you with any questions about our exclusive products, orders, or membership.</p>
        <div style="display:flex;flex-direction:column;gap:1.25rem;">
          <?php
            $contacts = [
              ['📧','Email','concierge@cellario.com'],
              ['📞','Phone','+94 11 234 5678'],
              ['⏰','Hours','Mon – Sat, 9AM – 7PM'],
              ['📍','Location','Colombo, Sri Lanka'],
            ];
            foreach($contacts as $c) echo "
            <div style='display:flex;gap:1rem;align-items:flex-start;padding:1.25rem;background:white;border:1px solid #F0F0F0;border-radius:4px;transition:border-color .2s;' onmouseover=\"this.style.borderColor='rgba(201,168,76,.4)'\" onmouseout=\"this.style.borderColor='#F0F0F0'\">
              <span style='font-size:1.5rem;flex-shrink:0;margin-top:2px;'>{$c[0]}</span>
              <div>
                <div style='font-size:.7rem;letter-spacing:.1em;color:#9CA3AF;text-transform:uppercase;font-weight:600;margin-bottom:.2rem;'>{$c[1]}</div>
                <div style='font-size:.9rem;color:#1A1A1A;font-weight:500;'>{$c[2]}</div>
              </div>
            </div>";
          ?>
        </div>
      </div>

      <!-- Contact Form -->
      <div style="background:white;border:1px solid #F0F0F0;border-radius:4px;padding:2rem;">
        <?php if ($sent): ?>
        <div style="text-align:center;padding:2rem;">
          <div style="font-size:3rem;margin-bottom:1rem;">✅</div>
          <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;color:#0D0D0D;margin-bottom:.5rem;">Message Sent!</h3>
          <p style="font-size:.875rem;color:#6B6B6B;">Our concierge team will respond within 24 hours.</p>
        </div>
        <?php else: ?>
        <h3 style="font-family:'Cormorant Garamond',serif;font-size:1.35rem;font-weight:600;color:#0D0D0D;margin-bottom:1.5rem;">Send a Message</h3>
        <form method="post" style="display:flex;flex-direction:column;gap:1.1rem;">
          <div style="display:grid;grid-template-columns:1fr 1fr;gap:1rem;">
            <div>
              <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">First Name</label>
              <input type="text" name="fname" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
            </div>
            <div>
              <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Last Name</label>
              <input type="text" name="lname" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
            </div>
          </div>
          <div>
            <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Email</label>
            <input type="email" name="email" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
          </div>
          <div>
            <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Subject</label>
            <input type="text" name="subject" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'">
          </div>
          <div>
            <label style="display:block;font-size:.7rem;letter-spacing:.1em;text-transform:uppercase;color:#6B6B6B;margin-bottom:.4rem;font-weight:500;">Message</label>
            <textarea name="message" rows="5" required style="width:100%;padding:.7rem;border:1px solid #E0E0E0;font-size:.875rem;outline:none;border-radius:2px;transition:border-color .2s;resize:vertical;font-family:'Inter',sans-serif;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='#E0E0E0'"></textarea>
          </div>
          <button type="submit" style="width:100%;padding:.875rem;background:#0D0D0D;color:#C9A84C;font-size:.8rem;font-weight:700;letter-spacing:.15em;text-transform:uppercase;border:none;cursor:pointer;border-radius:2px;transition:all .3s;" onmouseover="this.style.background='#C9A84C';this.style.color='#0D0D0D'" onmouseout="this.style.background='#0D0D0D';this.style.color='#C9A84C'">Send Message</button>
        </form>
        <?php endif; ?>
      </div>
    </div>
  </section>
</main>
<style>#contactGrid{grid-template-columns:1fr 1fr;}@media(max-width:768px){#contactGrid{grid-template-columns:1fr;}}</style>
<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
