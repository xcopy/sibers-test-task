<?php

/** @var array $sources */
/** @var string|null $source */
/** @var array|null $result */
/** @var string|null $error */

function buildPageUrl(string $source, int $page): string
{
    return '?' . http_build_query(compact('source', 'page'));
}

function escape(string $value): string
{
    return htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
}

?>

<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Sibers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-sRIl4kxILFvY47J16cr9ZwB07vP4J8+LH7qKQnuqkuIAvNWLzeN8tE5YBujZqJLB" crossorigin="anonymous">
</head>

<body class="p-3">

  <form method="get" action="" class="mb-3">
    <div class="row">
      <div class="col-md-3">
        <select name="source" id="source" class="form-select">
          <option value="">-- Choose a source --</option>
          <?php foreach ($sources as $id => $name) : ?>
            <option value="<?= $id ?>"<?= $source === $id ? ' selected' : '' ?>><?= $name ?></option>
          <?php endforeach; ?>
        </select>
      </div>
      <div class="col-auto">
        <button type="submit" class="btn btn-success">Submit</button>
      </div>
    </div>
  </form>

  <?php if ($error) : ?>
    <div class="alert alert-info text-center"><?= $error ?></div>
  <?php endif; ?>

  <?php if ($result) : ?>
    <p>
      Total items: <strong><?= $result['total'] ?></strong> |
      Page <strong><?= $result['page'] ?></strong>
      of <strong><?= $result['totalPages'] ?></strong>
    </p>

    <?php if (empty($result['items'])) : ?>
      <p class="alert alert-info text-center">No items found for the current page.</p>
    <?php else : ?>
      <hr>

      <?php $viewFile = __DIR__ . '/' . $source . '.php' ?>

      <?php if (file_exists($viewFile)) : ?>
        <?php include $viewFile ?>
      <?php else : ?>
        <?php foreach ($result['items'] as $item) : ?>
          <div>
            <a href="<?= $item['url'] ?>"><?= escape($item['title']) ?></a>

            <?php if (!empty($item['description'])) : ?>
              <p><?= escape($item['description']) ?></p>
            <?php endif; ?>
          </div>
        <?php endforeach; ?>
      <?php endif; ?>
    <?php endif; ?>

    <?php if ($result['totalPages'] > 1) : ?>
      <hr>
      <nav class="pagination">
        <span class="page-item">
          <a href="<?= buildPageUrl($source, 1) ?>" class="page-link">First</a>
        </span>

        <?php if ($result['page'] > 1) : ?>
          <span class="page-item">
            <a href="<?= buildPageUrl($source, $result['page'] - 1) ?>" class="page-link">Prev</a>
          </span>
        <?php endif; ?>

        <?php $start = max(1, $result['page'] - 2) ?>
        <?php $end = min($result['totalPages'], $result['page'] + 2) ?>

        <?php for ($i = $start; $i <= $end; $i++) : ?>
          <?php if ($i === $result['page']) : ?>
            <span class="page-item active">
              <span class="page-link"><?= $i ?></span>
            </span>
          <?php else : ?>
            <span class="page-item">
              <a href="<?= buildPageUrl($source, $i) ?>" class="page-link">
                <?= $i ?>
              </a>
            </span>
          <?php endif; ?>
        <?php endfor; ?>

        <?php if ($result['page'] < $result['totalPages']) : ?>
          <span class="page-item">
            <a href="<?= buildPageUrl($source, $result['page'] + 1) ?>" class="page-link">Next</a>
          </span>
        <?php endif; ?>

        <span class="page-item">
          <a href="<?= buildPageUrl($source, $result['totalPages']) ?>" class="page-link">Last</a>
        </span>
      </nav>
    <?php endif; ?>
  <?php endif; ?>
</body>

</html>