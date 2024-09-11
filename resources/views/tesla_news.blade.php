<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <link rel="stylesheet" href="{{ asset('css/tesla_news_page.css') }}">
</head>

<body>
    <form action="{{ route('news.search') }}" method="GET" class="search-form">
        <input type="text" name="query" placeholder="Buscar notícias" value="{{ request('query') }}">
        <button type="submit">Buscar</button>
    </form>
    <div class="news-main-container">
        @if(isset($newsData) && $newsData['status'] === 'ok')
            @if(count($newsData['articles']) > 0)
                @foreach($paginator as $index => $article)
                    @php
                        $data = [
                            'title' => $article['title'] ?? 'Título padrão',
                            'name' => $article['source']['name'] ?? 'Fonte desconhecida',
                            'author' => $article['author'] ?? 'Autor desconhecido',
                            'content' => $article['content'] ?? 'Conteúdo padrão',
                            'description' => $article['description'] ?? 'Descrição padrão',
                            'url' => $article['url'] ?? 'URL padrão',
                            'urlToImage' => $article['urlToImage'] ?? 'URL da imagem padrão',
                            'publishedAt' => $article['publishedAt'] ?? 'Data de publicação padrão'
                        ];
                        $encodedData = Crypt::encryptString(json_encode($data));
                    @endphp

                    <a href="{{ route('news.details', ['data' => $encodedData]) }}" class="news-article-container">
                        <img src="{{ $article['urlToImage'] }}" alt="Imagem da notícia">
                        <h2>{{ $article['title'] }}</h2>
                        <div style="color: #101010"><strong>Fonte:</strong> {{ $article['source']['name'] }}</div>
                        <div style="color: #101010"><strong>Autor:</strong> {{ $article['author'] ?? 'Desconhecido' }}</div>
                        <div style="color: #101010"><strong>Data:</strong>
                            {{ \Carbon\Carbon::parse($article['publishedAt'])->format('d/m/Y H:i') }}
                        </div>
                        <div style="font-size: .8rem; color: #454545; font-family: 'Roboto Condensed', sans-serif;">
                            {{ Str::limit($article['description'], 200) }}
                        </div>
                    </a>
                @endforeach
            @else
                <p>Nenhuma notícia encontrada para a sua pesquisa.</p>
            @endif
        @else
            <p>Não foi possível obter as notícias. Tente novamente mais tarde.</p>
        @endif
    </div>

    <div class="pagination-links">
        <ul class="pagination">
            @if ($paginator->onFirstPage())
                <li class="disabled"><span>&laquo;</span></li>
            @else
                <li><a href="{{ $paginator->previousPageUrl() }}" rel="prev">&laquo;</a></li>
            @endif

            @foreach ($paginator->getUrlRange(1, $paginator->lastPage()) as $page => $url)
                @if ($page == $paginator->currentPage())
                    <li class="active"><span>{{ $page }}</span></li>
                @else
                    <li><a href="{{ $url }}">{{ $page }}</a></li>
                @endif
            @endforeach

            @if ($paginator->hasMorePages())
                <li><a href="{{ $paginator->nextPageUrl() }}" rel="next">&raquo;</a></li>
            @else
                <li class="disabled"><span>&raquo;</span></li>
            @endif
        </ul>
    </div>


</body>

</html>