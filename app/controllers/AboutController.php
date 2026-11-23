<?php

class AboutController {
    private $about;

    public function __construct($about) {
        $this->about = $about;
    }

    public function about() {
        $sections = $this->about->getSections();
        require_once __DIR__ . "/../views/about.php";
    }
}