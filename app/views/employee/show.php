<?php if (\app\lib\Auth::check()) : ?>
    <div class="btn-group mb-3" role="group" aria-label="Кнопки управления">
        <a href="/employee/<?= $employee['id'] ?>/edit" class="btn btn-primary">Редактировать</a>
        <a href="/employee/<?= $employee['id'] ?>/delete" class="btn btn-danger">Удалить</a>
    </div>
<?php endif; ?>

<div class="row">
    <div class="col">
        <div class="card">
            <div class="card-header">Личные данные</div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-sm">
                        <tbody>
                            <tr>
                                <td>День рождения</td>
                                <td><?= $employee['birthday'] ?></td>
                            </tr>
                            <tr>
                                <td>Нанят</td>
                                <td><?= $employee['hired'] ?></td>
                            </tr>
                            <tr>
                                <td>Медицинская комиссия</td>
                                <td><?= $employee['medical_exam'] ?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <div class="card">
            <div class="card-header">Рабочее место</div>
            <?php foreach ($workplaces as $workplace) : ?>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-sm">
                            <tbody>
                            <tr>
                                <td>Отдел</td>
                                <td><?= $workplace['department'] ?></td>
                            </tr>
                            <tr>
                                <td>Должность/профессия</td>
                                <td><?= $workplace['pos'] ?></td>
                            </tr>
                            <tr>
                                <td>Ставка</td>
                                <td><?= $workplace['rate'] ?></td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>