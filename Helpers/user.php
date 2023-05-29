<?php 
    namespace Helpers;

    class user{
        public static function age($currentTime) {
            $date = new \DateTime();
            $currentTime = new \DateTime($currentTime);
            $diff = $currentTime->diff($date);

            return $diff->y;
        }
    }
?>