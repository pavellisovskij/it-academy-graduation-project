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
                        <td></td>
                        <td>
                            <a href="/department/<?= $department['id'] ?>" class="btn btn-primary">Просмотр</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <?php $paginator->render() ?>
<?php endif; ?>