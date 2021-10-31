<?php

class Checked{
    private $checker;
    
    public function __construct(IChecker $checker) {
        $this->checker = $checker;
    }
    
    public function checked($array = array()){
        $this->checker->isChecked($array);
    }
}
