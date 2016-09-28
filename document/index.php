<?php

require('../global.php');
require('main.php');

class Myclass {

    public function __construct() {
        $c_document = new Cls_document();
        $c_document->htmlindex();
        san();
    }

}

$Myclass = new Myclass();


