<?php
include_once "./src/private/initialize.php";
session_start();
$pageTitle = "About Cellario";
?>
<?php include_once(SHARED_PATH . "/customer_header.php"); ?>
<main>
  <!-- Hero -->
  <section style="background:#0D0D0D;padding:5rem 2rem;text-align:center;border-bottom:1px solid rgba(201,168,76,.15);">
    <div style="max-width:700px;margin:0 auto;">
      <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;margin-bottom:.75rem;">Our Story</div>
      <h1 style="font-family:'Cormorant Garamond',serif;font-size:3rem;font-weight:600;color:white;line-height:1.2;margin-bottom:1.25rem;">Redefining Luxury Technology Commerce</h1>
      <div style="width:60px;height:1px;background:linear-gradient(90deg,transparent,#C9A84C,transparent);margin:0 auto;"></div>
    </div>
  </section>

  <!-- Mission -->
  <section style="padding:5rem 2rem;background:#FAFAF8;">
    <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:5rem;align-items:center;" id="aboutGrid">
      <div>
        <div style="font-size:.65rem;letter-spacing:.25em;color:#C9A84C;text-transform:uppercase;font-weight:600;margin-bottom:.75rem;">Our Mission</div>
        <h2 style="font-family:'Cormorant Garamond',serif;font-size:2.25rem;font-weight:600;color:#0D0D0D;line-height:1.2;margin-bottom:1.25rem;">Bridging Luxury Tech Brands with Discerning Customers</h2>
        <p style="font-size:.9rem;color:#6B6B6B;line-height:1.8;margin-bottom:1rem;">Cellario was founded on a singular vision: to create the world's most exclusive and trusted marketplace for premium technology products. We believe that luxury is not just about price — it is about authenticity, exclusivity, and a shopping experience that matches the prestige of the products we offer.</p>
        <p style="font-size:.9rem;color:#6B6B6B;line-height:1.8;">Every product on Cellario is handpicked, verified for authenticity, and presented with the care it deserves. We serve high-net-worth individuals, tech enthusiasts, and corporate professionals who demand the very best.</p>
      </div>
      <div style="display:grid;grid-template-columns:1fr 1fr;gap:1.25rem;">
        <?php
          $vals = [
            ['🔒','Authenticity','Every product 100% verified'],
            ['💎','Exclusivity','Limited editions and rare finds'],
            ['🚀','Excellence','Premium service standards'],
            ['🌐','Global Reach','Worldwide secure delivery'],
          ];
          foreach($vals as $v) echo "
          <div style='padding:1.75rem 1.25rem;background:white;border:1px solid #F0F0F0;border-radius:4px;text-align:center;transition:all .3s;' onmouseover=\"this.style.borderColor='rgba(201,168,76,.4)';this.style.transform='translateY(-3px)'\" onmouseout=\"this.style.borderColor='#F0F0F0';this.style.transform=''\">
            <div style='font-size:2rem;margin-bottom:.875rem;'>{$v[0]}</div>
            <div style='font-size:.875rem;font-weight:700;color:#0D0D0D;margin-bottom:.35rem;'>{$v[1]}</div>
            <div style='font-size:.75rem;color:#9CA3AF;'>{$v[2]}</div>
          </div>";
        ?>
      </div>
    </div>
  </section>

  <!-- Stats -->
  <section style="background:#0D0D0D;padding:4rem 2rem;">
    <div style="max-width:1100px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:2rem;text-align:center;" id="statsGrid">
      <?php
        $stats = [['500+','Premium Products'],['50+','Luxury Brands'],['10K+','Happy Members'],['99%','Satisfaction Rate']];
        foreach($stats as $s) echo "
        <div>
          <div style='font-family:Cormorant Garamond,serif;font-size:2.5rem;font-weight:700;color:#C9A84C;'>{$s[0]}</div>
          <div style='font-size:.75rem;color:#6B6B6B;letter-spacing:.1em;text-transform:uppercase;margin-top:.35rem;'>{$s[1]}</div>
        </div>";
      ?>
    </div>
  </section>
</main>
<style>
  #aboutGrid{grid-template-columns:1fr 1fr;}
  #statsGrid{grid-template-columns:repeat(4,1fr);}
  @media(max-width:768px){#aboutGrid,#statsGrid{grid-template-columns:1fr;}}
  @media(max-width:480px){#statsGrid{grid-template-columns:1fr 1fr;}}
</style>
<?php include_once(SHARED_PATH . "/customer_footer.php"); ?>
