<div class="container">
    <?php if (!empty($post)): ?>
        <h1>Show <?php echo $post['title']; ?></h1>
            <h5>
                <a href="posts/<?= $post['slug'] ?>"><?php echo $post['title']; ?></a>&nbsp;|&nbsp;
                <a href="<?= base_url('/posts/edit?id='.$post['id'])?>">Edit</a>&nbsp;|&nbsp;
                <a href="<?= base_url('/posts/delete?id='.$post['id'])?>">Delete</a>
            </h5>
            <?php echo '<p>' . $post['content'] . '<p>'?>
            <?php echo '<p>' . $post['created_at'] . '<p><hr />'?>
    <?php endif; ?>
    <?php /*print_pre(session()->get('global'));*/ ?>
</div>