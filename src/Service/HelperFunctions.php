<?php

namespace App\Service;


use App\Repository\CoachRepository;

class HelperFunctions
{
    public function isAssoc(array $arr)
    {
        if (array() === $arr) return false;
        return array_keys($arr) !== range(0, count($arr) - 1);
    }

    public function fetchCoachRating($coaches){

        //Array of coach IDs and array of Ratings
        $id_array = array();
        $rating_array = array();
        foreach ($coaches as $c){
            $id_array[] = $c->getId();
            $rating_array []= $c->getRating();
        }

        return array_combine($id_array, $rating_array);
    }

    public function json_encode_advanced(array $arr, $sequential_keys = false, $quotes = false, $beautiful_json = false) {

        $output =  $this->isAssoc($arr) ? "{" : "[";
        $count = 0;
        foreach ($arr as $key => $value) {

            if ($this->isAssoc($arr) || (!$this->isAssoc($arr) && $sequential_keys == true )) {
                $output .= ($quotes ? '"' : '') . $key . ($quotes ? '"' : '') . ' : ';
            }

            if (is_array($value)) {
                $output .= $this->json_encode_advanced($value, $sequential_keys, $quotes, $beautiful_json);
            }
            else if (is_bool($value)) {
                $output .= ($value ? 'true' : 'false');
            }
            else if (is_numeric($value)) {
                $output .= $value;
            }
            else {
                $output .= ($quotes || $beautiful_json ? '"' : '') . $value . ($quotes || $beautiful_json ? '"' : '');
            }

            if (++$count < count($arr)) {
                $output .= ', ';
            }
        }

        $output .= $this->isAssoc($arr) ? "}" : "]";

        return $output;
    }
}
