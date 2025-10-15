<div class="container">

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Create Post</h1>
            <form action="<?= base_url('/posts/store')?>" method="post">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title"
                           class="form-control <?= get_validation_class('title', $errors ?? []) ?>" id="title"
                           placeholder="Title" value="<?= old('title') ?>">
                    <?= get_errors('title', $errors ?? []) ?>
                </div>
                <div class="mb-3">
                    <label for="content" class="form-label">Content</label>
                    <textarea name="content" class="form-control <?= get_validation_class('content', $errors ?? []) ?>"
                              id="content" rows="3"><?= old('content') ?></textarea>
                    <?= get_errors('content', $errors ?? []) ?>
                </div>
                <input type="submit" class="btn btn-primary" value="Send">
            </form>
        </div>
    </div>
</div>
