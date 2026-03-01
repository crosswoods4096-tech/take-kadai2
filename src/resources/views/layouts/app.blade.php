<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>mogitate</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    @yield('css')
</head>

<body>

    <!-- ヘッダー -->
    <header class="bg-white shadow-sm mb-4">
        <div class="container d-flex justify-content-between align-items-center py-3">

            <!-- ロゴ（左端・黄色） -->
            <a href="/products" class="text-decoration-none">
                <h2 class="fw-bold m-0" style="color: #FFD700;">mogitate</h2>
            </a>

        </div>

    </header>

    <!-- メインコンテンツ -->
    <main>
        @yield('content')
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</body>

</html>