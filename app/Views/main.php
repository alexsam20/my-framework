<div class="container">
    <h1>Main page</h1>
    <?php if (!empty($posts)): ?>
    <?php foreach ($posts as $post): ?>
        <h3>
            <a href="#"><?php echo $post['title']; ?></a>&nbsp;|&nbsp;
            <a href="<?= base_url('/posts/edit?id='.$post['id'])?>">Edit</a>&nbsp;|&nbsp;
            <a href="<?= base_url('/posts/delete?id='.$post['id'])?>">Delete</a>
        </h3>
        <?php echo '<p>' . $post['content'] . '<p>'?>
        <?php echo '<p>' . $post['created_at'] . '<p><hr />'?>
    <?php endforeach; ?>
    <?php endif; ?>
    <?php print_pre(session()->get('global')); ?>
</div>
