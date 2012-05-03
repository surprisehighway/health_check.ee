<div class="status chunk">
  <?php 
  if (isset($errors)) {
    if (count($errors) == 1) {
      echo "<p>There is 1 potential issue you should check out.</p>";
    } else {
      echo "<p>There are " . count($errors) . " potential issues you should check out.</p>";
    }
      
    echo "<ul>";
    foreach($errors as $error => $fix) {
      echo "<li>{$error}";
      echo "<span><em>To fix try this:</em> {$fix}</span></li>";
    }
    echo "</ul>";
  } else {
    echo "<p>Everything looks great. All systems go, captain.</p>";
  }
  ?>
</div> <!-- /.status -->