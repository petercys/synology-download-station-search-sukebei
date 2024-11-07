<?php

class SynoDLMSearchSukebei {
    public function prepare($curl, $query) {
        $url = "https://sukebei.nyaa.si/" . "?" . http_build_query(array(
            "page" => "rss",
            "c" => "0_0",
            "f" => "0",
            "q" => $query
        ));

        curl_setopt($curl, CURLOPT_URL, $url);
    }

    public function parse($plugin, $response) {
        $xml = simplexml_load_string($response);

        $count = 0;

        foreach ($xml->xpath("channel/item") as $item) {
            $nyaa = $item->children('nyaa', true);

            $plugin->addResult(
                strval($item->title),
                strval($item->link),
                self::parseSize(strval($nyaa->size)),
                strval($item->pubDate),
                strval($item->guid),
                strval($nyaa->infoHash),
                strval($nyaa->seeders),
                strval($nyaa->leechers),
                strval($nyaa->category),
            );

            $count += 1;
        }

        return $count;
    }

    private static function parseSize(string $str): float {
        preg_match("/^(\d+(?:\.\d+)) (B|KiB|MiB|GiB|TiB)$/", $str, $matches);

        $size = (float)$matches[1];

        switch ($matches[2]) {
            case "TiB": $size *= 1024;
            case "GiB": $size *= 1024;
            case "MiB": $size *= 1024;
            case "KiB": {
                $size *= 1024;
                break;
            }
        }

        return $size;
    }
}
