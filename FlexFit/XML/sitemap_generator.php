<?php

function sitemap_generator($name, $urls) {
    $xmlString = '<?xml version="1.0" encoding="UTF-8"?>
    <urlset
      xmlns:xsi="http://www.w3.org/2001/XMLSchema-instance"
      xmlns:image="http://www.google.com/schemas/sitemap-image/1.1"
      xsi:schemaLocation="http://www.sitemaps.org/schemas/sitemap/0.9 http://www.sitemaps.org/schemas/sitemap/0.9/sitemap.xsd"
      xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">';

    //loop through $url array -> append (add) each url to loc element
    foreach ($urls as $key => $url) {
        $xmlString .= '<url><loc>'.$url.'</loc></url>';
    }

    $xmlString .= '</urlset>';

    //create new DOM object - load xml string into - formatting (not whitespace)
    $dom = new DOMDocument;
    $dom->preserveWhiteSpace = false;
    $dom->loadXML($xmlString);
    $dom->save(
        "../generated_sitemaps/$name.xml"
    );

    return "$name.xml";
}

?>