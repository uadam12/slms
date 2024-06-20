<?php

    function redirect_to(string $url = '/') : void {
        header("location: $url");
    }

    function refresh(int $delay = 0) : void {
        header("refresh: $delay");
    }

    function is_post_request() : bool {
        return $_SERVER['REQUEST_METHOD'] == 'POST';
    }

    function get_posted(string $key) : string {
        $value = $_POST[$key]??'';
        $value = htmlspecialchars($value);
        $value = trim($value);

        return $value;
    }

    function get(string $key, bool $is_required = true) : string {
        $value = $_REQUEST[$key] ?? '';

        if($is_required && $value == '') die(
            "*$key is required but not found"
        );

        return $value;
    }

    function get_id(string $key = 'id') : int {
        return intval(get($key));
    }

    function display_amount(string|float|int $amount) : string {
        $amount = floatval($amount);

        return '₦ '. number_format($amount, 2);
    }

    function display_date(string|null $date, string $format = 'Y-m-d') : string {
        if($date == null) return '----';
        return date($format, strtotime($date));
    }
?>