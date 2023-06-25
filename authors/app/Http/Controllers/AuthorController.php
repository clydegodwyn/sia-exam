<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request; //Handling http request from lumen
use App\Models\UserJob; //USERJOB MODEL
use App\Models\Author; //My Model
use App\Traits\ApiResponser; //Standard API response
use Illuminate\Http\Response;


Class AuthorController extends Controller {
    use ApiResponser;

    private $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    public function index(){
        $authors = Author::all();
        return $this -> successResponse($authors);
    }
    
    // ADD FUNCTION
    public function addAuthor(Request $request){
        
        $rules = [
            'fullname' => 'required|max:150',
            'gender' => 'required|in:Male,Female',
            'birthday' => 'required|date',
        ];

        $this->validate($request,$rules);
        // $userjob = UserJob::findOrFail($request->jobid);
        $authors = Author::create($request->all());
        return $this -> successResponse($authors, Response::HTTP_CREATED);
    }

    public function show($id){

        $authors = Author::findOrFail($id);
        return $this -> successResponse($authors);

    }

     // UPDATE FUNCTION
    public function updateAuthor(Request $request, $id)
    {
        $rules = [
            'fullname' => 'required|max:150',
            'gender' => 'required|in:Male,Female',
            'birthday' => 'required|date|date_format:m/d/Y',
        ];

        $this->validate($request,$rules);
        // $userjob = UserJob::findOrFail($request->jobid);
        $authors = Author::where('id', $id)->firstOrFail();
        $authors->fill($request->all());
        
    //  IF NO CHANGE HAPPENED
        if ($authors->isClean()){
        return $this->errorResponse('At least one value must change', Response::HTTP_UNPROCESSABLE_ENTITY);
        }
        $authors->save();
        return $this -> successResponse($authors);
    } 
//  DELETE FUNCTION
    public function deleteAuthor($id) {
        $authors = Author::findOrFail($id);
        $authors->delete();
        return $this -> successResponse('Deleted Successfully!');

    }
    
}


