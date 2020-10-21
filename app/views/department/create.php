<div class="container-fluid">
    <form action="/department/store" method="post">
        <div class="form-group">
            <label for="name" class="form-label">Полное название отдела</label>
            <input type="text" name="name" class="form-control" id="name" required max="100" min="4">
        </div>

        <div class="form-group">
            <label for="short_name" class="form-label">Короткое название отдела</label>
            <input type="text" name="short_name" class="form-control" id="short_name" required max="10" min="2">
        </div>

        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-lg btn-primary btn-block" type="submit">Создать</button>
            </div>
        </div>
    </form>
</div>