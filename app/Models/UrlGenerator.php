<?php
namespace App\Models;

Class UrlGenerator {
   protected $url;
   protected $generated_url;

   public function __construct($url)
   {
       $this->url = $url;
   }

   public function generateUrl () {
       $this->generated_url = crypt($this->url, 'rl');
   }

   public function getGeneratedUrl () {
       return $this->generated_url;
   }
}
