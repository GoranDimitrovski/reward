<?php

class StringHelper {

    public static function stripXSS($input) {
        return trim(strip_tags(preg_replace('#<script(.*?)>(.*?)</script>#is', '', $input)));
    }

}
