<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

    @foreach($uris as $uri)
    <url>
        <loc>https://education-career.jp/magazine/{{ $uri->uri }}</loc>
        <priority>0.8</priority>
        <changefreq>daily</changefreq>
    </url>
    @endforeach

</urlset>