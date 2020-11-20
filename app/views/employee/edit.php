<div class="container-fluid">
    <?if (\app\lib\Flash::is_set('error')): ?>
        <div class="alert alert-danger" role="alert">
            <?= \app\lib\Flash::get('error'); ?>
        </div>
    <?php endif; ?>

    <form action="/employee/<?= $employee['id'] ?>/update" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="fired" class="form-label">Уволен</label>
                    <input type="date" name="fired" class="form-control" id="fired">
                </div>
            </div>
        </div>

        <?php if ($workplace != false) : ?>
            <p>Текущее рабочее место: <?= $workplace['short_name'] ?>: <?php $workplace['pos'] ?></p>
        <?php endif;?>

        <div class="form-group" id="select-department">
            <label for="workplace">Рабочее место</label>
            <select class="form-control" id="workplace" name="workplace">
                <?php foreach ($empty_workplaces as $workplace) : ?>
                    <option value="<?= $workplace['id'] ?>"> <?= $workplace['department'] . ': ' . $workplace['pos'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-primary" type="submit">Обновить</button>
            </div>
        </div>
    </form>
</div>