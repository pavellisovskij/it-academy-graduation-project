<?php if (\app\models\User::isAdmin()) : ?>
    <div class="btn-group mb-3" role="group" aria-label="Кнопки управления">
        <a href="/employee/create" class="btn btn-primary">Добавить</a>
    </div>
<?php endif; ?>

<?php if (empty($employees)) : ?>
    <div class="alert alert-primary" role="alert">
        Добавьте сотрудников.
    </div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>#</th>
                    <th>Ф.И.О.</th>
                    <th>Дата рождения</th>
                    <th>Нанят</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($employees as $employee) : ?>
                    <tr>
                        <td></td>
                        <td><?= $employee['surname'] ?> <?= $employee['firstname'] ?> <?= $employee['patronymic'] ?></td>
                        <td><?= $employee['birthday'] ?></td>
                        <td><?= $employee['hired'] ?></td>
                        <td>
                            <a href="/employee/<?= $employee['id'] ?>" class="btn btn-primary">Просмотр</a>
                            <?php if (\app\models\User::isAdmin()) : ?>
                                <a href="/employee/<?= $employee['id'] ?>/edit" class="btn btn-primary">Редактировать</a>
                            <?php endif; ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php $paginator->render() ?>
<?php endif; ?>