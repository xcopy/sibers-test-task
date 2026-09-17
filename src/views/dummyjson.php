<?php /** @var array $result */ ?>

<div class="row">
    <?php foreach ($result['items'] as $item) : ?>
        <div class="col-md-6">
            <?php if (isset($item['thumbnail'])) : ?>
                <img src="<?= $item['thumbnail'] ?>" class="img-fluid rounded border" alt="<?= $item['title'] ?>" style="height: 200px;">
            <?php endif; ?>

            <a href="<?= $item['url'] ?>"><?= $item['title'] ?></a>

            <?php if (!empty($item['description'])) : ?>
                <p><?= $item['description'] ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
