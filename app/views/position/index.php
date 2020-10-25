<?php if (\app\models\User::isAdmin()): ?>
    <div class="btn-group mb-3" role="group" aria-label="Кнопки управления">
        <a href="/position/create" class="btn btn-primary">Добавить</a>
    </div>
<?php endif; ?>

<?php if (empty($positions)) : ?>
    <div class="alert alert-primary" role="alert">
        Добавьте должности.
    </div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th></th>
                    <th>Название</th>
                    <th>Код должности</th>
                    <th>Управление</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($positions as $position) : ?>
                    <tr>
                        <td></td>
                        <td><?= $position['name'] ?></td>
                        <td><?= $position['position_code'] ?></td>
                        <td>
                            <a href="/position/<?= $position['id'] ?>/delete" class="btn btn-danger">Удалить</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php $paginator->render() ?>
<?php endif; ?>