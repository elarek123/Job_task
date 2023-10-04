<!DOCTYPE html>
<html>
<head>
    <title>Фильтрация</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body {
            background-color: #f5f5f5; /* Светло-серый фон */
            display: flex;
            flex-direction: column;
            min-height: 100vh;
        }
        .container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            flex-wrap: wrap;
            padding: 20px;
        }
        .filter-card {
            width: 300px;
            margin: 10px;
            padding: 20px;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
        }
        h1 {
            font-size: 24px;
            font-weight: bold;
            margin-bottom: 20px;
            color: #fff; /* Добавленный синий цвет */
        }
        footer {
            background-color: #1da1f2; /* Добавленный синий цвет */
            padding: 10px;
            color: #fff;
            text-align: center;
        }
        .btn-primary {
            background-color: #1da1f2;
            border-color: #1da1f2;
        }
        .btn-primary:hover {
            background-color: #0d86d7;
            border-color: #0d86d7;
        }
    </style>
</head>
<body>

    <header style="background-color: #0d86d7; padding: 10px; text-align: center;">
        <h1>AppFilter</h1>
    </header>
    <div class="container">
        <!-- Форма фильтрации -->
        <form id="filterForm">

            <!-- Чекбоксы -->
            <fieldset class="form-group">
                @foreach ($categories as $category)
                    <legend>{{ $category->name }}</legend>
                    @foreach ($category->subcategories as $object)
                        <div class="form-check">
                            <input class="form-check-input" {{ in_array($object->id, $subCategoryIdList) ? 'checked' : ''}} type="{{$category->button_category}}" id="{{ $object->id }}" name="{{ $category->name }}" data-alias="{{ $object->slug }}" data-category ="{{ $category->button_category }}">
                            <label class="form-check-label" for="{{ $object->name }}">{{ $object->name }}</label>
                        </div>
                    @endforeach
                @endforeach
            </fieldset>
            <!-- Кнопка "Submit" -->
            <button type="sumbit" class="btn btn-primary">Sumbit</button>

        </form>

        <!-- Карточки с содержимым -->
        <div class="container" id = "apps">
           @include('Object', ['objectList' => $objectList])
        </div>

        <!-- Добавьте другие карточки с содержимым по вашему усмотрению -->

    </div>

    <footer>
        &copy; 2021 Ваше приложение | Все права защищены
    </footer>
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/js/all.js" integrity="sha256-2JRzNxMJiS0aHOJjG+liqsEOuBb6++9cY4dSOyiijX4=" crossorigin="anonymous"></script>
    <script>
        const checkboxes = document.querySelectorAll('.form-check-input');
        const form = document.getElementById('filterForm');
        function getSelectedUrl() {
            const selectedCheckboxes = document.querySelectorAll('.form-check-input:checked');
            if (selectedCheckboxes.length > 0) {
                const slugs = Array.from(selectedCheckboxes).map(function(checkbox) {
                    return [checkbox.dataset.alias, checkbox.dataset.category];
                });
                return separateSlugs(slugs);
            }
        }
        function separateSlugs(slugs) {
            let url = "/" + slugs[0][0];
            for(let i = 1; i < slugs.length; i++){
                if (slugs[i - 1][1] == "radio") {
                    url += "\/" + slugs[i][0];
                }
                if(slugs[i - 1][1] == "checkbox" && slugs[i][1] == "checkbox"){ 
                    url += "-" + slugs[i][0];
                }
                if (slugs[i - 1][1] == "checkbox" && slugs[i][1] == "radio") {
                    url += "\/" + slugs[i][0];
                }
            }
            return url;
        }
        
        form.addEventListener('submit', function(event) {
            event.preventDefault();
            const formData = new FormData(form);
            const url = getSelectedUrl();
            // Нужно поменять Url от выбранных checkbox и radio на свой
            history.pushState(null, null, url);
            const selectedCheckboxes = document.querySelectorAll('.form-check-input:checked');
            let dataId = [];
            selectedCheckboxes.forEach(function(checkbox) {
                dataId.push(checkbox.id);
            })
            $.ajax({
                type: 'POST',
                url: '/api/filter',
                data: {dataId: dataId},
                success: function(response) {
                    let apps = document.getElementById('apps');
                    apps.innerHTML = response.Objects;
                }
            });
        });

       
    </script>
</body>
</html>