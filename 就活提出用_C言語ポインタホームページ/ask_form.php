<form action="index.php" method="post">
  <input type="text" name="message">
  <button>送信</button>
</form>


<ul>
<?php foreach ($messages as $message): ?>
  <li><?= h($message); ?></li>
<?php endforeach; ?>
</ul>