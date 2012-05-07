<div class="addons chunk">
  <h5>Add-Ons</h5>

  <div class="section">
    <strong>Modules</strong>
    <ul>
    <?php foreach($modules as $module) { ?>
      <li><?= $module['name'] ?> <?= $module['module_version'] ?></li>
    <?php } ?>
    </ul>
  </div>
  
  <div class="section">  
    <strong>Extensions</strong>
    <ul>
    <?php foreach($extensions as $extension) { ?>
      <li><?= $extension['name'] ?> <?= $extension['version'] ?></li>
    <?php } ?>
    </ul>
  </div>

  <div class="section">  
    <strong>Plugins</strong>
    <ul>
    <?php foreach($plugins as $plugin) { ?>
      <li><?= $plugin['pi_name'] ?> <?= $plugin['pi_version'] ?></li>
    <?php } ?>
    </ul>
  </div>

  <div class="section">  
    <strong>Field Types</strong>
    <ul>
    <?php foreach($fieldtypes as $fieldtype) { ?>
      <li><?= $fieldtype['name'] ?> <?= $fieldtype['version'] ?></li>
    <?php } ?>
    </ul>
  </div>

  <div class="section last">
    <strong>Accessories</strong>
    <ul>
    <?php foreach($accessories as $accessory) { ?>
      <li><?= $accessory['name'] ?> <?= $accessory['accessory_version'] ?></li>
    <?php } ?>
    </ul>
  </div>
</div> <!-- /#healthcheck_addons -->