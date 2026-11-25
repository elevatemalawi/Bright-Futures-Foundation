<?php
require __DIR__.'/includes/bootstrap.php';
$stmt=$pdo->prepare("SELECT * FROM posts WHERE category=? AND status='published' ORDER BY published_at DESC, id DESC");
$stmt->execute(['news']); $posts=$stmt->fetchAll();
$pageTitle='News & Videos | Bright Futures Foundation'; require __DIR__.'/includes/header.php';
?>
<main class="dynamic-wrap"><div class="section-head"><span class="eyebrow">Bright Futures Foundation</span><h1>News & Videos</h1><p>Stories, updates and information from our work in Malawi.</p></div>
<?php if (!$posts): ?><div class="post-card"><h2>Updates coming soon</h2><p>New stories and updates will appear here when published by the foundation.</p></div><?php else: ?><div class="post-grid"><?php foreach($posts as $post): ?><article class="post-card"><?php if($post['image_path']): ?><img src="<?= e($post['image_path']) ?>" alt="<?= e($post['title']) ?>"><?php endif; ?><p class="post-meta"><?= e(date('d M Y', strtotime($post['published_at']))) ?></p><h2><?= e($post['title']) ?></h2><p><?= nl2br(e($post['body'])) ?></p></article><?php endforeach; ?></div><?php endif; ?></main>
<?php require __DIR__.'/includes/footer.php'; ?>