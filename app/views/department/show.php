<div class="container-fluid">
    <div class="btn-group" role="group" aria-label="Кнопки управления">
        <a href="/department/<?= $department['id'] ?>/edit" class="btn btn-primary">Редактировать</a>
        <a href="/department/<?= $department['id'] ?>/delete" class="btn btn-danger">Удалить</a>
    </div>


    <?php if (empty($workplaces)) : ?>
        <div class="alert alert-primary" role="alert">
            Добавьте рабочие места.
        </div>
    <?php else : ?>
        <div class="table-responsive">
            <table class="table table-striped table-sm">
                <thead>
                <tr>
                    <th>Название отдела</th>
                    <th>Короткое название</th>
                    <th>Рабочих мест</th>
                </tr>
                </thead>
                <tbody>
                <?php foreach ($departments as $department) : ?>
                    <tr>
                        <td><?= $department['name'] ?></td>
                        <td><?= $department['short_name'] ?></td>
                        <td></td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <?php $paginator->render() ?>
    <?php endif; ?>
</div>