<?xml version="1.0" encoding="UTF-8"?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9" xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance">

    @foreach($job_category as $jc)
        @foreach($employment_status as $es)
            @foreach($business_type as $bt)
    <url>
        <loc>https://education-career.jp/job?job_category={{ $jc['id'] }}&amp;employment_status={{ $es['id'] }}&amp;business_type={{ $bt['id'] }}&amp;prefecture={{ $pref }}&amp;keyword=</loc>
        <priority>0.8</priority>
        <changefreq>daily</changefreq>
    </url>
            @endforeach
        @endforeach
    @endforeach

</urlset>