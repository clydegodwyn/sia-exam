<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; //Handling http request from lumen
use App\Models\Author; //USERJOB MODEL
use App\Models\Books; //My Model
use App\Traits\ApiResponser; //Standard API response
use Illuminate\Http\Response;


Class BooksController extends Controller {
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(){
        $books = Books::all();
        return $this -> successResponse($books);
    }
    
    // ADD FUNCTION
    public function addBook(Request $request){
        
        $rules = [
            'bookname' => 'required|max:150',
            'yearpublished' => 'required|numeric|min:1|not_in:0',
            'authorid' => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request,$rules);
        $authors = Author::findOrFail($request->authorid);
        $books = Books::create($request->all());
        return $this -> successResponse($books, Response::HTTP_CREATED);
    }

    public function show($id){

        $books = Books::findOrFail($id);
        return $this -> successResponse($books);


        // $users = User::where('userId', $id)->first();
        // if ($users){
        //     return $this -> successReponse($users);
        // }
        // {
        //     return $this-> errorResponse('User Does Not Exist', Response::HTTP_NOT_FOUND);
        // }
        
    }

     // UPDATE FUNCTION
    public function updateBook(Request $request, $id)
    {
        $rules = [
            'bookname' => 'required|max:150',
            'yearpublished' => 'required|numeric|min:1|not_in:0',
            'authorid' => 'required|numeric|min:1|not_in:0',
        ];

        $this->validate($request,$rules);
        $authors = Author::findOrFail($request->authorid);
        $books = Books::where('id', $id)->firstOrFail();
        $books->fill($request->all());
        
    //  IF NO CHANGE HAPPENED
        if ($books->isClean()){
        return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $books->save();
        return $this -> successResponse($books);
    } 
    //  DELETE FUNCTION
    public function deleteBook($id) {
        $books = Books::findOrFail($id);
        $books->delete();
        return $this -> successResponse('Deleted Successfully!');

        // $users = User::where('userId', $id)->delete();

        // if($users){
        //     return $this -> successReponse($users);
        // }
        // else{
        //     return $this->errorResponse('User ID Does Not Exists', Response::HTTP_NOT_FOUND);
        // }
    }
    
}


