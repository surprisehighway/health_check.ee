<div class="status">
  <?php 
  if (isset($errors)) {
    if (count($errors) == 1) {
      echo "<p>There is 1 potential issue you should look into.</p>";
    } else {
      echo "<p>There are " . count($errors) . " potential issues you should look into.</p>";
    }
      
    echo "<ul>";
    foreach($errors as $error => $fix) {
      echo "<li>{$error}";
      echo "<br/>To fix: {$fix}</li>";
    }
    echo "</ul>";
  } else {
    echo "<p>Everything looks great. All systems go, captain.</p>";
  }
  ?>
</div> <!-- /.status -->