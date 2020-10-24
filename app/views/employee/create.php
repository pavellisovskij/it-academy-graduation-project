<div class="container-fluid">
    <form action="/employee/store" method="post">
        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="surname" class="form-label">Фамилия</label>
                    <input type="text" name="surname" class="form-control" id="surname" required max="20" min="1">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="firstname" class="form-label">Имя</label>
                    <input type="text" name="firstname" class="form-control" id="firstname" required max="20" min="1">
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="patronymic" class="form-label">Отчество</label>
                    <input type="text" name="patronymic" class="form-control" id="patronymic" required max="20" min="1">
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col">
                <div class="form-group">
                    <label for="birthday" class="form-label">День рождения</label>
                    <input type="date" name="birthday" class="form-control" id="birthday" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="hired" class="form-label">Нанят</label>
                    <input type="date" name="hired" class="form-control" id="hired" required>
                </div>
            </div>

            <div class="col">
                <div class="form-group">
                    <label for="medical_exam" class="form-label">Медицинский осмотр</label>
                    <input type="date" name="medical_exam" class="form-control" id="medical_exam" required>
                </div>
            </div>
        </div>

        <div class="form-group" id="select-department">
            <label for="workplace">Рабочее место</label>
            <select class="form-control" id="workplace" name="workplace" required>
                <?php foreach ($workplaces as $workplace) : ?>
                    <option value="<?= $workplace['id'] ?>"> <?= $workplace['department'] . ': ' . $workplace['pos'] ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="row">
            <div class="col-md-2">
                <button class="btn btn-primary btn-block" type="submit">Создать</button>
            </div>
        </div>
    </form>
</div>

<script src="/public/js/vue.js"></script>
<script src="https://unpkg.com/axios/dist/axios.min.js"></script>
<script>
    var depPos = new Vue({
        el: '#select-department',
        data: {
            departments: [],
        },
        mounted: function() {
            this.getDepartments();
        },
        methods: {
            getDepartments: function () {
                axios.get('/departments/all')
                .then(function (response) {
                    // console.log(response.data[0].id);
                    // console.log(JSON.parse(response.data));
                    this.departments = response.data;
                })
            }
        }
    })
</script>