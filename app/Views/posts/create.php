<div class="container">

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Create Post</h1>
            <form action="<?= base_url('/posts/store')?>" method="post" enctype="multipart/form-data">
                <div class="mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title"
                           class="form-control <?= get_validation_class('title', $errors ?? []) ?>" id="title"
                           placeholder="Title" value="<?= old('title') ?>">
                    <?= get_errors('title', $errors ?? []) ?>
                </div>
                <div class="mb-3">
                    <label for="slug" class="form-label">Slug</label>
                    <input type="text" name="slug"
                           class="form-control <?= get_validation_class('slug', $errors ?? []) ?>" id="slug"
                           placeholder="Slug" value="<?= old('slug') ?>">
                    <?= get_errors('slug', $errors ?? []) ?>
                </div>
                <div class="mb-3">
                    <label for="thumbnail" class="form-label">Thumbnail</label>
                    <input type="file" name="thumbnail"
                           class="form-control <?= get_validation_class('thumbnail', $errors ?? []) ?>" id="thumbnail">
                    <?= get_errors('thumbnail', $errors ?? []) ?>
                </div>
                <div class="mb-3">
                    <label for="thumbnails" class="form-label">Thumbnails</label>
                    <input type="file" name="thumbnails[]" multiple
                           class="form-control <?= get_validation_class('thumbnails', $errors ?? []) ?>" id="thumbnails">
                    <?= get_errors('thumbnails', $errors ?? []) ?>
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
