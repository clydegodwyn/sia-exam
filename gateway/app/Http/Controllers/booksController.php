<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Services\BooksService;

class BooksController extends Controller
{
    use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @var siteService
     */

    public $booksService;

    public function __construct(BooksService $booksService)
    {
        $this->booksService = $booksService;
    }


    public function showBooks() 
    {
        return $this->successResponse($this->booksService->showall());
    }

    public function showBook($id) 
    {
        return $this->successResponse($this->booksService->showBook($id));
    }

    public function createBook(Request $request) {
        return $this->successResponse($this->booksService->addBook($request->all()));
    }
    
    public function deleteBook($id) {
        return $this->successResponse($this->booksService->deleteBook($id));
    }

    public function patchBook(Request $data, $id) {
        return $this->successResponse($this->booksService->updateBook($data->all(), $id));
    }
}