<h1>Инструкция по запуску</h1>
<h2>1 выкачать проект командой<h2>
<h4>git clone git@github.com:eduardkarpow/EquipGroup.git && cd EquipGroup</h4>
<h2>2 создать файл .env и заполнить данными</h2>
<h4>тестовый файл здесь <a href="https://pastebin.com/8u2fsJre">https://pastebin.com/8u2fsJre</a></h4>
<h2>3 Подгрузить PHP зависимости</h2>
<h4>composer install</h4>
<h2>4 Поднять докер с бэкендом</h2>
<h4>docker compose --build -d</h4>
<h2>5 Провести миграцию данных</h2>
<h4>docker compose exec app php artisan migrate:fresh --seed</h4>
<h2>6 Проверить на работоспосоность открыв тестовый эндпоинт http://localhost:8000/</h2>

<h2>7 Загрузить фронтунд</h2>
<h4><a href="https://github.com/eduardkarpow/EquipGroupFrontend">https://github.com/eduardkarpow/EquipGroupFrontend</a></h4>
