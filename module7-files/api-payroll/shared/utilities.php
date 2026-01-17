<?php
class Utils {
    public static function respond($code, $data){
        http_response_code($code);
        echo json_encode($data);
        exit;
    }
}

?>
