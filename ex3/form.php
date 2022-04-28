<!DOCTYPE html>
<html lang="">
<head>
    <meta name="viewport" content="width=device.width, intial-scale=1">
    <meta charset="utf-8">
    <link rel="stylesheet" href="./style.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" />
    <script src="index.js" defer></script>
    <title>EX 3</title>
</head>
<body>
    <div class="form-container">
        <div class="form-title">
            Форма
        </div>
        <form method="POST" action="">
            <div class="input-group">
                <span class="input-group-text" id="basic-addon1">Имя</span>
                <input type="text" class="form-control" name="name" aria-describedby="basic-addon1" placeholder="name" />
            </div>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon2">Email</span>
                <input type="text" class="form-control" name="email" aria-describedby="basic-addon2" placeholder="example@mail.ru" />
            </div>
            <div class="input-group">
                <span class="input-group-text" id="basic-addon3">Дата рождения</span>
                <input type="date" class="form-control" aria-describedby="basic-addon3" placeholder="example@mail.ru" name="date"/>
            </div>
            <div class="form-check" id="gender-block">
                <span class="input-group-text">Пол</span>
                <div class="male-radio">
                    <input class="form-check-input" type="radio" name="gender" value="m" />
                    <label class="form-check-label" for="male">Мужской</label>
                </div>
                <div class="female-radio">
                    <input class="form-check-input" type="radio" name="gender" value="f" />
                    <label class="form-check-label" for="female">Женский</label>
                </div>
            </div>
            <div class="form-check" id="limbs-block">
                <span class="input-group-text block-title">Количество конечностей</span>
                <div class="limbs-radio">
                    <input class="form-check-input" type="radio" name="limbs" value="1"/>
                    <label class="form-check-label" for="male">1</label>
                </div>
                <div class="limbs-radio">
                    <input class="form-check-input" type="radio" name="limbs" value="2"/>
                    <label class="form-check-label" for="female">2</label>
                </div>
                <div class="limbs-radio">
                    <input class="form-check-input" type="radio" name="limbs" value="3"/>
                    <label class="form-check-label" for="female">3</label>
                </div>
                <div class="limbs-radio">
                    <input class="form-check-input" type="radio" name="limbs" value="4"/>
                    <label class="form-check-label" for="female">4</label>
                </div>
            </div>
            <select class="form-select form-select-lg mb-2" name="select[]" multiple>
                <option value="inf" selected>Бессмертие</option>
                <option value="through">Прохождение сквозь стены</option>
                <option value="levitation">Левитация</option>
            </select>
            <div class="input-group">
                <textarea class="form-control" placeholder="Расскажите о себе..." name="bio"></textarea>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="checkbox" value="y" id="policy" name="policy"/>
                <label class="form-check-label" for="policy">Согласен с <a href="./task3.html">политикой обработки данных*</a>.</label>
            </div>
            <button class="btn btn-primary" type="submit" id="send-btn">Отправить</button>
        </form>
    </div>
</body>
</html>