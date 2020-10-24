<div class="btn-group mb-3" role="group" aria-label="Кнопки управления">
    <a href="/department/create" class="btn btn-primary">Добавить</a>
</div>

<?php if (empty($departments)) : ?>
    <div class="alert alert-primary" role="alert">
        Добавьте отделы.
    </div>
<?php else : ?>
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <th>Название отдела</th>
                    <th>Короткое название</th>
                    <th>Рабочих мест</th>
                    <th>Действия</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($departments as $department) : ?>
                    <tr>
                        <td><?= $department['name'] ?></td>
                        <td><?= $department['short_name'] ?></td>
                        <td><?= $department['num'] ?></td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Кнопки управления">
                                <a href="/department/<?= $department['id'] ?>" class="btn btn-primary">Просмотр</a>
                                <a href="/department/<?= $department['id'] ?>/delete" class="btn btn-danger">Удалить</a>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php $paginator->render() ?>
<?php endif; ?>