<?php if (\app\lib\Auth::check()): ?>
    <div class="btn-group mb-3" role="group" aria-label="Кнопки управления">
        <a href="/workplace/create" class="btn btn-primary">Добавить</a>
    </div>
<?php endif; ?>

<?php if (empty($workplaces)) : ?>
    <div class="alert alert-primary" role="alert">
        Добавьте рабочие места.
    </div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th></th>
                    <th>Отдел</th>
                    <th>Должность / Рабочее место</th>
                    <th>Ставка</th>
                    <th>Ф.И.О.</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($workplaces as $workplace) : ?>
                    <tr>
                        <td></td>
                        <td><?= $workplace['department'] ?></td>
                        <td><?= $workplace['pos'] ?></td>
                        <td><?= $workplace['rate'] ?></td>
                        <?php if ($workplace['surname'] === null) : ?>
                            <td>ВАКАНТ</td>
                        <?php else : ?>
                            <td><?= $workplace['surname'] ?> <?= $workplace['firstname'] ?> <?= $workplace['patronymic'] ?></td>
                        <?php endif; ?>
                        <td>
                            <div class="btn-group" role="group" aria-label="Кнопки управления">
                                <a href="/workplace/<?= $workplace['id'] ?>" class="btn btn-primary">Просмотр</a>
                                <?php if (\app\lib\Auth::check()): ?>
                                    <a href="/workplace/<?= $workplace['id'] ?>/edit" class="btn btn-primary">Редактировать</a>
                                <?php endif; ?>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php $paginator->render() ?>
<?php endif; ?>