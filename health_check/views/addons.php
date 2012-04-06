<div class="addons">
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
    <strong>Accessories</strong>
    <ul>
    <?php foreach($accessories as $accessory) { ?>
      <li><?= $accessory['name'] ?> <?= $accessory['accessory_version'] ?></li>
    <?php } ?>
    </ul>
  </div>
  
  <div class="section last">  
    <strong>Field Types</strong>
    <ul>
    <?php foreach($fieldtypes as $fieldtype) { ?>
      <li><?= $fieldtype['name'] ?> <?= $fieldtype['version'] ?></li>
    <?php } ?>
    </ul>
  </div>
</div> <!-- /#healthcheck_addons -->

<div class="pathinfo">
  <table>
    <thead>
      <tr>
        <th colspan="2">Path Info</th>
      </tr>
    </thead>
    <tr>
      <td class="label">theme</td>
      <td><?= PATH_THEMES ?></td>
    </tr>
    <tr>
      <td class="label">app</td>
      <td><?= APPPATH ?></td>
    </tr>
    <tr>
      <td class="label">third_party</td>
      <td><?= PATH_THIRD ?></td>
    </tr>
  </table>
</div> <!-- /#healthcheck_pathinfo -->