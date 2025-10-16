<div class="container">
    <h1>Main page</h1>
    <?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <?php echo '<h4>' . $post['title'] . '</h4>'; ?>
        <?php echo '<p>' . $post['content'] . '<p>'?>
        <?php echo '<p>' . $post['created_at'] . '<p><hr />'?>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php print_pre(session()->get('global')); ?>
</div>
