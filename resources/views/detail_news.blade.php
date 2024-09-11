<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalhes da Notícia</title>
    <link rel="stylesheet" href="{{ asset('css/detail_news.css') }}">
</head>

<body>
    <div class="container">
        <div class="news-article">
            <h2>{{ $title }}</h2>
            <img src="{{ $urlToImage }}" alt="Imagem da noticia">
            <p><strong>Fonte:</strong> {{ $name }}</p>
            <p><strong>Autor:</strong> {{ $author }}</p>
            <p>{{ $description }}</p>
            <a href="{{ $url }}" target="_blank" style="font-family: emoji;
    font-weight: 600;">Ver notícias completa</a>
            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($publishedAt)->format('d/m/Y H:i') }}</p>
            <p>{{ $content }}</p>
        </div>
    </div>
</body>

</html>