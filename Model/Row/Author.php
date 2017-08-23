<?php

/**
 *
 */
class Model_Row_Author extends Model_Row_Abstract
{
        public function getFullName()
        {
            $fullName = $this->firstName . ' ' . $this->nickName . ' ' . $this->lastName;
            $fullName = str_replace('  ', ' ', $fullName);
            $fullName = trim($fullName);
            return $fullName;
        }
}