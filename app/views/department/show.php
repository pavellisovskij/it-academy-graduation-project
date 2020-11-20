<?php if (\app\lib\Auth::check()): ?>
    <div class="btn-group mb-3" role="group" aria-label="Кнопки управления">
        <a href="/department/<?= $department['id'] ?>/edit" class="btn btn-primary">Редактировать</a>
        <a href="/department/<?= $department['id'] ?>/delete" class="btn btn-danger">Удалить</a>
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
                    <th>Должность/профессия</th>
                    <th>Ставка</th>
                    <th>Ф.И.О.</th>
                </tr>
            </thead>
            <tbody>
            <?php foreach ($workplaces as $workplace) : ?>
                <tr>
                    <td><?= $workplace['pos'] ?></td>
                    <td><?= $workplace['rate'] ?></td>
                    <td>
                        <?php if ($workplace['firstname'] === null): ?>
                            ВАКАНТ
                        <?php else: ?>
                            <?= $workplace['surname'] ?> <?= $workplace['firstname'] ?> <?= $workplace['patronymic'] ?>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    </div>
<?php endif; ?>