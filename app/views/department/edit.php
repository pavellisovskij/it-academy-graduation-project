<div class="container-fluid">
    <form action="/department/<?= $department['id'] ?>/update" method="post">
        <div class="form-group">
            <label for="name" class="form-label">Полное название отдела</label>
            <input type="text" name="name" class="form-control" id="name" required max="100" min="4" value="<?= $department['name'] ?>">
        </div>

        <div class="form-group">
            <label for="short_name" class="form-label">Короткое название отдела</label>
            <input type="text" name="short_name" class="form-control" id="short_name" required max="10" min="2" value="<?= $department['short_name'] ?>">
        </div>

        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Обновить</button>
            </div>
        </div>
    </form>
</div>