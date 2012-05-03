<div class="sysinfo chunk">
  <h5>System Info</h5>
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
      <td class="label">Extensions</td>
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
      <td class="label">Server</td>
      <td><?= $webserver ?></td>
    </tr>
  </table>
  
  <table>
    <thead>
      <tr>
  	<th colspan="2">File permission constants</th>
      </tr>
    </thead>
    <tr>
      <td class="label">FILE_READ_MODE</td>
      <td><?= decoct(FILE_READ_MODE) ?></td>
    </tr>
    <tr>
      <td class="label">FILE_WRITE_MODE</td>
      <td><?= decoct(FILE_WRITE_MODE) ?></td>
    </tr>
    <tr>
      <td class="label">DIR_READ_MODE</td>
      <td><?= decoct(DIR_READ_MODE) ?></td>
    </tr>
    <tr>
      <td class="label">DIR_WRITE_MODE</td>
      <td><?= decoct(DIR_WRITE_MODE) ?></td>
    </tr>
  </table>
  
  <table>
    <thead>
      <tr>
        <th colspan="2">EE Stats</th>
      </tr>
    </thead>
    <tr>
      <td class="label">Sites</td>
      <td><?= $ee_sites ?></td>
    </tr>
    <tr>
      <td class="label">Channels</td>
      <td><?= $ee_channels ?></td>
    </tr>
    <tr>
      <td class="label">Entries</td>
      <td><?= $ee_entries ?></td>
    </tr>
    <tr>
      <td class="label">Comments</td>
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
      <td class="label">Browser</td>
      <td><?= $browser?></td>
    </tr>
    <tr>
      <td class="label">Platform</td>
      <td><?= $platform ?></td>
    </tr>
  </table>
</div> <!-- /.sysinfo -->

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