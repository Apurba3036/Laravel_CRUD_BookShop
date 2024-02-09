<?php

namespace App\Http\Controllers;

use App\Models\book;
use Illuminate\Http\Request;

class BookController extends Controller
{
        public function index(){
        $books = Book::all();
    
        $formattedBooks = $books->map(function($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'genre'=>$book->genre,
                'price'=> $book->price
            ];
        });
    
        return response()->json($formattedBooks, 200);
    }
    public function show($id){
        $book = Book::find($id);
    
        if (!$book) {
            return response()->json(['error' => 'Book not found'], 404);
        }
    
        $formattedBook = [
            'id' => $book->id,
            'title' => $book->title,
            'author' => $book->author,
            'genre' => $book->genre,
            'price' => $book->price
        ];
    
        return response()->json($formattedBook, 200);
    }
    
    public function search(){
        $title = request('title');
    
        // Use $title in your query or logic to filter books
    
        $books = Book::where('title', $title)->get();
    
        $formattedBooks = $books->map(function($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'genre' => $book->genre,
                'price' => $book->price
            ];
        });
    
        return response()->json(['books' => $formattedBooks], 200);
    }
    
public function Author(){
        $author = request('author');
        $sort = request('sort', 'title');
    
        $booksQuery = Book::where('author', 'like', '%' . $author . '%');
    
        switch ($sort) {
            case 'price':
                $booksQuery->orderBy('price', 'desc');
                break;
            default:
                $booksQuery->orderBy('title');
                break;
        }
    
        $books = $booksQuery->get();
    
        $formattedBooks = $books->map(function($book) {
            return [
                'id' => $book->id,
                'title' => $book->title,
                'author' => $book->author,
                'genre' => $book->genre,
                'price' => $book->price
            ];
        });
    
        return response()->json(['books' => $formattedBooks], 200);
    }
    


    public function store(Request $request){
        $request->validate([
            "title"=>'required|max:191',
        ]);
        $book = new book;
        $book->title = $request->title;
        $book->author = $request->author;
        $book->genre = $request->genre;
        $book->price = $request->price;
        $book->save();
        return response()->json(['message'=>'Created'],201);
       

    }
    public function update(Request $request,$id){
        $request->validate([
            "title"=>'required|max:191',
        ]);
        $book = Book::find($id);
    if($book){
        $book->title = $request->title;
        $book->author = $request->author;
        $book->genre = $request->genre;
        $book->price = $request->price;
        $book->update();
        return response()->json(['message'=>'Created'],201);
       }
        else{
                   return response()->json(['message'=> 'no book'],404);
       }

    }

    public function delete($id)
    {
        $book=book::find($id);
        if($book){
            $book->delete();
            return response()->json(['message'=> 'Delete successfully'],);
       }
       else{
          return response()->json(['message'=> 'Not found'],404);
       }
    }




}


