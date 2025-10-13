<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="<?= URL_ROOT . DS ?>assets/bootstrap/css/bootstrap.min.css">
    <link rel="icon" href="<?= URL_ROOT . DS ?>images/coding.png">
    <title>Default :: <?= $title ?? '' ?></title>
</head>
<body>
<?= $this->content ?>
<script src="<?= URL_ROOT . DS ?>assets/bootstrap/js/bootstrap.min.js"></script>
</body>
</html>
