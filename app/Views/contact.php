<div class="container">

    <div class="row">
        <div class="col-md-6 offset-md-3">
            <h1>Contact Form Page</h1>
            <form action="/contact" method="post">
                <div class="mb-3">
                    <label for="name" class="form-label">Name</label>
                    <input type="text" name="name"
                           class="form-control <?= get_validation_class('name', $errors ?? []) ?>" id="name"
                           placeholder="Name" value="<?= old('name') ?>">
                    <?= get_errors('name', $errors ?? []) ?>
                </div>
                <div class="mb-3">
                    <label for="user_name" class="form-label">User Name</label>
                    <input type="text" name="user_name"
                           class="form-control <?= get_validation_class('user_name', $errors ?? []) ?>" id="user_name"
                           placeholder="User " value="<?= old('user_name') ?>">
                    <?= get_errors('user_name', $errors ?? []) ?>
                </div>
                <div class="mb-3">
                    <label for="email" class="form-label">Email</label>
                    <input type="text" name="email"
                           class="form-control <?= get_validation_class('email', $errors ?? []) ?>" id="email"
                           placeholder="name@example.com" value="<?= old('email') ?>">
                    <?= get_errors('email', $errors ?? []) ?>
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
