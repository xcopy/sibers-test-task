<?php /** @var array $result */ ?>

<div class="row">
    <?php foreach ($result['items'] as $item) : ?>
        <div class="col-md-6">
            <?php if (!empty($item['thumbnail'])) : ?>
                <img src="<?= escape($item['thumbnail']) ?>" class="img-fluid rounded border d-block" alt="" style="height: 200px;">
            <?php endif; ?>

            <a href="<?= escape($item['url']) ?>"><?= escape($item['title']) ?></a>

            <?php if (!empty($item['description'])) : ?>
                <p><?= escape($item['description']) ?></p>
            <?php endif; ?>
        </div>
    <?php endforeach; ?>
</div>
