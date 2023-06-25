<?php

namespace App\Services;

use App\Traits\ConsumesExternalService;

class BooksService {
     use ConsumesExternalService;
     /*
     *@var string

     */
     public $secret;
     public $baseUri;

     public function __construct() {
          $this->baseUri = config('services.books.base_uri');
          $this->secret = config('services.books.secret');
     }


     /*
     *@return string
     */

     public function showall() {
          return $this->performRequest('GET', 'api/books');
     }

     public function showBook($id) {
          return $this->performRequest('GET', "api/books/{$id}");
     }


     public function addBook($data) {
          return $this->performRequest('POST', 'api/books/', $data);
     }

     public function updateBook($data, $id) {
          return $this->performRequest('PATCH', "api/books/{$id}", $data);
     }

     public function deleteBook($id) {
          return $this->performRequest('DELETE', "api/books/{$id}");
     }

}