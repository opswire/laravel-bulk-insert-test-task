<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>User Import</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        <style>
            body {
                font-family: sans-serif;
                text-align: center;
            }

            .import-button {
                background-color: #8B00FF;
                border: none;
                border-radius: 10px;
                color: white;
                padding: 10px 25px;
                text-align: center;
                text-decoration: none;
                display: inline-block;
                font-size: 14px;
                margin: 8px 4px;
                cursor: pointer;
                height: 40px;
            }

            h1 {
                font-size: 36px;
                color: #8B00FF;
            }

            p {
                font-size: 18px;
                margin-right: 10px;
            }

            p span {
                font-weight: bold;
            }

            .container {
                display: flex;
                justify-content: center;
            }

            #totalUsers, #addedUsers, #updatedUsers {
                font-weight: 600;
            }

            #error {
                color: red;
            }
        </style>
    </head>
    <body>
    <h1>User Import</h1>
    <div class="container">
        <button id="importButton" class="import-button">Импортировать пользователей</button>
        <p>Всего: <span id="totalUsers">0</span>,</p>
        <p>Добавлено: <span id="addedUsers">0</span>,</p>
        <p>Обновлено: <span id="updatedUsers">0</span>,</p>
    </div>
    <div>
        <span id="error"></span>
    </div>

    <script>
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        const importButton = document.getElementById('importButton');
        const totalUsers = document.getElementById('totalUsers');
        const addedUsers = document.getElementById('addedUsers');
        const updatedUsers = document.getElementById('updatedUsers');
        const error = document.getElementById('error');

        importButton.addEventListener('click', async () => {
            const response = await fetch('/import', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': csrfToken,
                    'Content-Type': 'application/json',
                },
            });
            const data = await response.json();
            console.log(data);

            totalUsers.textContent = data.total;
            addedUsers.textContent = data.added;
            updatedUsers.textContent = data.updated;
            error.textContent = data.error;
        });
    </script>
    </body>
</html>
