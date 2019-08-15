<?php

require_once __DIR__.'/app/TestApi.php';

try {
    $api = new TestApi();
    echo $api->start();
} catch (Exception $e) {
    echo json_encode(Array('error' => $e->getMessage()));
}
