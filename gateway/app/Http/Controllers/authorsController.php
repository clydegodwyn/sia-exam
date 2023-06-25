<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Traits\ApiResponser;
use App\Services\AuthorsService;

class AuthorsController extends Controller
{
     use ApiResponser;

    /**
     * Create a new controller instance.
     *
     * @var site2Service
     */

     public $authorsService;

    public function __construct(AuthorsService $authorsService)
    {
        $this->authorsService = $authorsService;
    }

    public function showAuthors() 
    {
        return $this->successResponse($this->authorsService->showall());
    }

    public function showAuthor($id) 
    {
        return $this->successResponse($this->authorsService->showAuthor($id));
    }

    public function createAuthor(Request $request) {
        return $this->successResponse($this->authorsService->addAuthor($request->all()));
    }
    
    public function deleteAuthor($id) {
        return $this->successResponse($this->authorsService->deleteAuthor($id));
    }

    public function patchAuthor(Request $data, $id) {
        return $this->successResponse($this->authorsService->updateAuthor($data->all(), $id));
    }
}
