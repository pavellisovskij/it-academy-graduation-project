<div class="container-fluid">
    <?php if (\app\lib\Auth::check()): ?>
        <div class="btn-group pb-3" role="group" aria-label="Кнопки управления">
            <a href="/workplace/<?= $workplace['id'] ?>/edit" class="btn btn-primary">Редактировать</a>
            <a href="/workplace/<?= $workplace['id'] ?>/delete" class="btn btn-danger">Удалить</a>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-header"><?= $workplace['pos'] ?></div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-sm">
                    <tbody>
                        <tr>
                            <td>Отдел:</td>
                            <td><?= $workplace['department'] ?></td>
                        </tr>
                        <tr>
                            <td>Ставка:</td>
                            <td><?= $workplace['rate'] ?></td>
                        </tr>
                        <tr>
                            <?php if ($workplace['surname'] === null) : ?>
                                <td colspan="2" class="text-center">ВАКАНТНО</td>
                            <?php else : ?>
                                <td>Ф.И.О.:</td>
                                <td><?= $workplace['surname'] ?> <?= $workplace['firstname'] ?> <?= $workplace['patronymic'] ?></td>
                            <?php endif; ?>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>