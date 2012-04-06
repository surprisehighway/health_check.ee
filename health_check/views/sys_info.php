<div class="sysinfo">
  <table>
    <thead>
      <tr>
        <th colspan="2">EE Info</th>
      </tr>
    </thead>
    <tr>
      <td class="label">ExpressionEngine</td>
      <td><?= APP_VER ?> Build <?= APP_BUILD ?></td>
    </tr>
    <tr>
      <td class="label">MSM</td>
      <td><?= $ee_msm?></td>
    </tr>
    <tr>
      <td class="label">extensions</td>
      <td><?= $ee_extensions ?></td>
    </tr>
    <tr>
      <td class="label">jQuery</td>
      <td><?= $jquery_version ?></td>
    </tr>
    <tr>
      <td class="label">MySQL</td>
      <td><?= $mysql_version ?></td>
    </tr>
    <tr>
      <td class="label">server</td>
      <td><?= $webserver ?></td>
    </tr>
  </table>
  
  <table>
    <thead>
      <tr>
        <th colspan="2">EE Stats</th>
      </tr>
    </thead>
    <tr>
      <td class="label">sites</td>
      <td><?= $ee_sites ?></td>
    </tr>
    <tr>
      <td class="label">channels</td>
      <td><?= $ee_channels ?></td>
    </tr>
    <tr>
      <td class="label">entries</td>
      <td><?= $ee_entries ?></td>
    </tr>
    <tr>
      <td class="label">comments</td>
      <td><?= $ee_comments ?></td>
    </tr>
  </table>
  
  <table>
    <thead>
      <tr>
        <th colspan="2">PHP Info</th>
      </tr>
    </thead>
  <?php foreach ($php as $setting => $value) { ?>
    <tr>
      <td class="label"><?= $setting ?></td>
      <td><?= $value ?></td>
    </tr>
  <?php } ?>
  </table>
  
  <table>
    <thead>
      <tr>
        <th colspan="2">Browser Info</th>
      </tr>
    </thead>
    <tr>
      <td class="label">browser</td>
      <td><?= $browser?></td>
    </tr>
    <tr>
      <td class="label">platform</td>
      <td><?= $platform ?></td>
    </tr>
  </table>
</div> <!-- /.sysinfo -->