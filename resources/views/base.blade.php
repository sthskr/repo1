<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Aylo Assignment</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-[#000000] [&_.main-container]:max-w-[1320px] [&_.main-container]:mx-auto px-[15px] grid gap-y-[10px]">
  <header class="py-[10px]">
    <h1 class="text-white text-[52px] font-bold max-w-[1320px] mx-auto">Aylo Assignment</h1>
  </header>
  @yield('content')
  <footer class="py-[30px]">
    <h2 class="max-w-[1320px] mx-auto text-left text-white">Aylo Assignment Footer</h2>
  </footer>
</body>
</html>