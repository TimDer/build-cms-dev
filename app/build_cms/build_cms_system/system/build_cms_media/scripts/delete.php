<?php

$query_array = array(
    "DROP TABLE `media`;",

    "DROP TABLE `page_img_block`;"
);

foreach ($query_array AS $query) {
    database::query($query);
}