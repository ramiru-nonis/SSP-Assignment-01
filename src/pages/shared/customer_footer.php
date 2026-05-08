<footer style="background:#0D0D0D;border-top:1px solid rgba(201,168,76,.2);margin-top:auto;">
  <div style="max-width:1400px;margin:0 auto;padding:3rem 2rem;">
    <div style="display:grid;grid-template-columns:repeat(auto-fit,minmax(200px,1fr));gap:2.5rem;margin-bottom:2.5rem;">
      <!-- Brand -->
      <div>
        <div style="font-family:'Cormorant Garamond',serif;font-size:1.5rem;font-weight:700;color:#C9A84C;letter-spacing:.1em;margin-bottom:.5rem;">CELLARIO</div>
        <p style="font-size:.8rem;color:#6B6B6B;line-height:1.7;max-width:200px;">Premium luxury electronics for the discerning customer. Authenticity guaranteed.</p>
        <div style="display:flex;gap:.75rem;margin-top:1rem;">
          <a href="#" style="width:32px;height:32px;border:1px solid rgba(201,168,76,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#C9A84C;text-decoration:none;font-size:.7rem;transition:all .2s;" onmouseover="this.style.borderColor='#C9A84C';this.style.background='rgba(201,168,76,.1)'" onmouseout="this.style.borderColor='rgba(201,168,76,.3)';this.style.background=''">IG</a>
          <a href="#" style="width:32px;height:32px;border:1px solid rgba(201,168,76,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#C9A84C;text-decoration:none;font-size:.7rem;transition:all .2s;" onmouseover="this.style.borderColor='#C9A84C';this.style.background='rgba(201,168,76,.1)'" onmouseout="this.style.borderColor='rgba(201,168,76,.3)';this.style.background=''">TW</a>
          <a href="#" style="width:32px;height:32px;border:1px solid rgba(201,168,76,.3);border-radius:50%;display:flex;align-items:center;justify-content:center;color:#C9A84C;text-decoration:none;font-size:.7rem;transition:all .2s;" onmouseover="this.style.borderColor='#C9A84C';this.style.background='rgba(201,168,76,.1)'" onmouseout="this.style.borderColor='rgba(201,168,76,.3)';this.style.background=''">FB</a>
        </div>
      </div>
      <!-- Shop -->
      <div>
        <h4 style="font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;color:#C9A84C;margin-bottom:1rem;font-weight:600;">Shop</h4>
        <?php
          $shopLinks = ['Smartphones'=>'?category=smartphone','Laptops'=>'?category=laptop','Audio Devices'=>'?category=audio','Accessories'=>'?category=accessory','All Products'=>''];
          foreach($shopLinks as $l=>$q) echo "<a href='/Celario_lite/cellario_lite/Products{$q}' style='display:block;color:#9CA3AF;text-decoration:none;font-size:.825rem;margin-bottom:.5rem;transition:color .2s;' onmouseover=\"this.style.color='#C9A84C'\" onmouseout=\"this.style.color='#9CA3AF'\">{$l}</a>";
        ?>
      </div>
      <!-- Company -->
      <div>
        <h4 style="font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;color:#C9A84C;margin-bottom:1rem;font-weight:600;">Company</h4>
        <?php
          $coLinks = ['About Us'=>'About','Contact'=>'Contact','Privacy Policy'=>'#','Terms of Service'=>'#'];
          foreach($coLinks as $l=>$h) echo "<a href='/Celario_lite/cellario_lite/{$h}' style='display:block;color:#9CA3AF;text-decoration:none;font-size:.825rem;margin-bottom:.5rem;transition:color .2s;' onmouseover=\"this.style.color='#C9A84C'\" onmouseout=\"this.style.color='#9CA3AF'\">{$l}</a>";
        ?>
      </div>
      <!-- Newsletter -->
      <div>
        <h4 style="font-size:.7rem;letter-spacing:.2em;text-transform:uppercase;color:#C9A84C;margin-bottom:1rem;font-weight:600;">Stay Exclusive</h4>
        <p style="font-size:.8rem;color:#6B6B6B;margin-bottom:1rem;">Early access to limited editions. No spam, ever.</p>
        <form onsubmit="return false;" style="display:flex;gap:.5rem;">
          <input type="email" placeholder="your@email.com" style="flex:1;padding:.5rem .75rem;background:#1A1A1A;border:1px solid rgba(201,168,76,.3);color:#D1D5DB;font-size:.8rem;outline:none;" onfocus="this.style.borderColor='#C9A84C'" onblur="this.style.borderColor='rgba(201,168,76,.3)'">
          <button type="submit" style="padding:.5rem 1rem;background:#C9A84C;color:#0D0D0D;font-size:.75rem;font-weight:600;border:none;cursor:pointer;letter-spacing:.05em;transition:opacity .2s;" onmouseover="this.style.opacity='.85'" onmouseout="this.style.opacity='1'">JOIN</button>
        </form>
      </div>
    </div>
    <div style="border-top:1px solid rgba(201,168,76,.1);padding-top:1.5rem;display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:1rem;">
      <p style="font-size:.75rem;color:#555;">© <?= date('Y') ?> Cellario. All rights reserved. Authenticity guaranteed.</p>
      <div style="display:flex;gap:1rem;flex-wrap:wrap;">
        <span style="font-size:.7rem;color:#555;display:flex;align-items:center;gap:.35rem;">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2"><path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/></svg>
          Secure Payments
        </span>
        <span style="font-size:.7rem;color:#555;display:flex;align-items:center;gap:.35rem;">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2"><circle cx="12" cy="12" r="10"/><polyline points="12 6 12 12 16 14"/></svg>
          Express Delivery
        </span>
        <span style="font-size:.7rem;color:#555;display:flex;align-items:center;gap:.35rem;">
          <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="#C9A84C" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>
          100% Authentic
        </span>
      </div>
    </div>
  </div>
</footer>
</body>
</html>
