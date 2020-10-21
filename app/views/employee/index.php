<div class="container-fluid">
    <div class="btn-group" role="group" aria-label="Кнопки управления">
        <a href="/employee/create" class="btn btn-primary">Добавить</a>
    </div>

    <br><br>

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
                        <th>Отдел</th>
                        <th>Действия</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($employees as $employee) : ?>
                        <tr>
                            <td></td>
                            <td><?= $employee['surname'] ?> <?= $employee['firstname'] ?> <?= $employee['patronymic'] ?></td>
                            <td><?= $employee['birthday'] ?></td>
                            <td></td>
                            <td>
                                <a href="/employee/<?= $employee['id'] ?>" class="btn btn-primary">Просмотр</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php $paginator->render() ?>
    <?php endif; ?>
</div>
