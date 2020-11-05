<?php
// Last-modified
// Etag

$etag = md5("Thu, 05 Nov 2020 16:20:44 GMT");

if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE']) && $_SERVER['HTTP_IF_MODIFIED_SINCE'] == "Thu, 05 Nov 2020 16:20:44 GMT") {
    http_response_code(304);
    exit;
}

echo "coucou";
