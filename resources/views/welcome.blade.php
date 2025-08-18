<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Alani</title>
        @asset('web/css/styles.css')
        @asset('web/js/basic.js')
    </head>
<body>
    <div class="container">
        <h3>Alani util pack for Laravel</h3>
        Created and distributed for free by <a href="https://bibakis.com/" target="_blank">Bibakis</a> under the MIT License.<br>
        <a href="https://github.com/bibakis/Alani" target="_blank">Github project page</a>

        <br><br>
        <hr>

        <h4>Asset loading helper</h4>
        <p>
            Force the browser to always fetch the latest css/js while still caching files if there are no changes. You may have heard this as "cache busting".
        </p>
        <p>
            Place your css & js files in the /public directory and then simply do the following from any blade file:<br><br>
            @@asset('web/css/styles.css')<br>
            @@asset('web/js/basic.js')
        </p>
        <p>
            This will load the files with the appropriate html tag and auto append a version identifier based on the time the file was last updated.
            For example: <br>https://example.com/web/css/styles.css<b>?v=1755474797</b>
        </p>
    </div>
</body>
</html>