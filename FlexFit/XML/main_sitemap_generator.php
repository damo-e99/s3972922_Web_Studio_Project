<?php

function main_sitemap_generator($sitemaps) {
    $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
    <sitemapindex
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9"
      xmlns:mobile="http://www.google.com/schemas/sitemap-mobile/1.0"
      xmlns:xhtml="http://www.w3.org/1999/xhtml"
      xmlns:video="http://www.google.com/schemas/sitemap-video/1.1"
      xmlns:news="http://www.google.com/schemas/sitemap-news/0.9">';

    //iterate over sitemap array, adds to sitemap index with modification dates
    foreach($sitemaps as $key => $sitemap) {
        $xmlString .= '<sitemap><loc>'.$sitemap.'</loc><lastmod>'.date('c').'</lastmod></sitemap>';
    }

    $xmlString .= '</sitemapindex>';

    //saves then load one level above directory
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = false;
    $dom->loadXML($xmlString);
    $dom->save("../generated_sitemaps/sitemap.xml");
}
 
?>