<div class="container">
    <form action="/workplace/store" method="post">
        <div class="form-group col-6">
            <label for="department">Отдел</label>
            <select class="form-control" id="department" name="department" required>
                <?php foreach ($departments as $department) : ?>
                    <option value="<?= $department['id'] ?>"><?=$department['short_name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-6">
            <label for="position">Должность / Профессия</label>
            <select class="form-control" id="position" name="position" required>
                <?php foreach ($positions as $position) : ?>
                    <option value="<?= $position['id'] ?>"><?= $position['name'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="form-group col-2">
            <label for="rate" class="form-label">Ставка</label>
            <input type="number" name="rate" class="form-control" id="rate" required max="1.0" min="0.1" step="0.05" value="0.1">
        </div>


        <div class="col-2">
            <button class="btn btn-primary btn-block" type="submit">Создать</button>
        </div>
    </form>
</div>