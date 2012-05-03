<div class="filemanager chunk">
  <h5>File Upload Directories</h5>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Path</th>
        <th>URL</th>
        <th>Types</th>
      </tr>
    </thead>
    <?php foreach ($file_uploads as $dir) : ?>
      <tr>
        <td><?= $dir['id'] ?></td>
        <td><?= $dir['name'] ?></td>
        <td><?= $dir['server_path'] ?></td>
        <td><?= $dir['url'] ?></td>
        <td><?= $dir['allowed_types'] ?></td>
      </tr>
    <?php endforeach; ?>
  </table>
</div> <!-- /#healthcheck_pathinfo -->