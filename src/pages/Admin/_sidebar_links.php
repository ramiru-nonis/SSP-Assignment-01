<?php
$currentPage = basename($_SERVER['PHP_SELF'], '.php');
$links = [
    'Dashboard'       => ['/Celario_lite/cellario_lite/Admin/Dashboard',       '🏠'],
    'Products'        => ['/Celario_lite/cellario_lite/Admin/ManageProducts',   '📦'],
    'Add Product'     => ['/Celario_lite/cellario_lite/Admin/AddProduct',       '➕'],
    'Accounts'        => ['/Celario_lite/cellario_lite/Admin/ManageAccounts',   '👥'],
    'View Store'      => ['/Celario_lite/cellario_lite/',                       '🌐'],
    'Logout'          => ['/Celario_lite/cellario_lite/Logout',                 '🚪'],
];
foreach($links as $label => [$href, $icon]):
  $isActive = strpos($_SERVER['REQUEST_URI'], $href) !== false && $href !== '/Celario_lite/cellario_lite/';
  $style    = $isActive ? 'background:rgba(201,168,76,.12);color:#C9A84C;' : '';
  $danger   = $label === 'Logout' ? 'color:#EF4444 !important;' : '';
?>
<a href="<?= $href ?>" class="sidebar-link" style="<?= $style ?><?= $danger ?>">
  <span><?= $icon ?></span>
  <span><?= $label ?></span>
</a>
<?php endforeach; ?>
