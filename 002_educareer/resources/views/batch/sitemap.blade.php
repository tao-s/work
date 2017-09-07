<?xml version="1.0" encoding="UTF-8"?>
<sitemapindex xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    <sitemap>
        <loc>https://education-career.jp/misc.xml</loc>
    </sitemap>
    <sitemap>
        <loc>https://education-career.jp/jobs.xml</loc>
    </sitemap>
    <sitemap>
        <loc>https://education-career.jp/companies.xml</loc>
    </sitemap>
    <sitemap>
        <loc>https://education-career.jp/magazine.xml</loc>
    </sitemap>
    @foreach($prefecture as $pref)
    <sitemap>
        <loc>https://education-career.jp/search{{$pref}}.xml</loc>
    </sitemap>
    @endforeach

</sitemapindex>