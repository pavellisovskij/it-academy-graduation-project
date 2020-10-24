<div class="container-fluid">
    <form action="/workplace/<?= $workplace['id'] ?>/update" method="post">
        <div class="form-group col-md-6">
            <label for="department">Отдел</label>
            <select class="form-control" id="department" name="department" required>
                <?php foreach ($departments as $department) : ?>
                    <?php if ($department['id'] === $workplace['department_id']) : ?>
                        <option value="<?= $department['id'] ?>" selected><?=$department['short_name'] ?></option>
                    <?php else : ?>
                        <option value="<?= $department['id'] ?>"><?=$department['short_name'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-6">
            <label for="position">Должность / Профессия</label>
            <select class="form-control" id="position" name="position" required>
                <?php foreach ($positions as $position) : ?>
                    <?php if ($position['id'] === $workplace['position_id']) : ?>
                        <option value="<?= $position['id'] ?>" selected><?= $position['name'] ?></option>
                    <?php else : ?>
                        <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                    <?php endif; ?>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-md-2">
            <label for="rate" class="form-label">Ставка</label>
            <input type="number" name="rate" class="form-control" id="rate" required max="1.0" min="0.1" step="0.05" value="<?= $workplace['rate'] ?>">
        </div>

        <div class="col-md-2">
            <button class="btn btn-primary btn-block" type="submit">Обновить</button>
        </div>
    </form>
</div>