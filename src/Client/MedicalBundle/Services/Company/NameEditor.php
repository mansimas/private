<?php

namespace Client\MedicalBundle\Services\Company;

class NameEditor {

    public function addDashBetweenWords($text)
    {
        $text = explode(' ', $text);
        $newWord = '';
        foreach ($text as $word) {
            if ($newWord != '') {
                $newWord = $newWord . '-' . $word;
            } else {
                $newWord = $word;
            }
        }

        return $newWord;
    }
}
