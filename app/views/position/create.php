<div class="container-fluid">
    <form action="/position/store" method="post">
        <div class="col-md-6">
            <div class="form-group">
                <label for="name" class="form-label">Название должности</label>
                <input type="text" name="name" class="form-control" id="name" required max="50" min="4">
            </div>

            <div class="form-group">
                <label for="position_code" class="form-label">Код дожности</label>
                <input type="text" name="position_code" class="form-control" id="position_code" required max="8" min="8">
            </div>

            <button class="btn btn-primary btn-block" type="submit">Создать</button>
        </div>
    </form>
</div>