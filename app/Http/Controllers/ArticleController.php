<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreArticleRequest;
use App\Http\Requests\UpdateArticleRequest;

class ArticleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(DataTables $dataTables)
    {
        //
        if (request()->ajax()) {
            $model = Article::with('users')->where('users_id', Auth::user()->id);

            if(auth()->user()->hasRole('visitor')){
                $model = Article::with('users');
            }

            return $dataTables->eloquent($model)
                ->addColumn('action', function (Article $article) {
                    $btn = '';

                    if(auth()->user()->hasRole('author') || auth()->user()->hasRole('visitor'))
                    {
                        $btn .= '<a href="' . route("article.show", ["article" => $article->id]) . '"> <i class="fas fa-fw fa-eye"></i> </a>';
                    }

                    if (auth()->user()->hasRole('author')) {
                        $btn .= '<a  data-id="' . $article->id . '" class="edit"> <i class="fas fa-fw fa-pencil-alt"></i> </a>';

                        $btn .= '<a href="javascript:void(0)" data-id="' . $article->id . '"
                                        class="delete"><i class="fas fa-fw fa-trash"></i></a>';
                    }

                    return $btn;
                })
                ->rawColumns(['action'])
                ->toJson();
        }
        return view('pages.article.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreArticleRequest $request)
    {
        //

        try {
            //code...
            $store = Article::create([
                'title' => $request->title,
                'content' => $request->content,
                'users_id' => Auth::user()->id
            ]);

            $data = [
                'status' => true,
                'message' => 'success',
                'data' => []
            ];
            return response()->json($data, 201);
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'status' => false,
                'message' => $th->getMessage(),
                'data' => []
            ];
            return response()->json($data, 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Article $article)
    {
        //
        return view('pages.article.show', compact('article'));

    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Article $article)
    {
        //
        try {
            //code...
            $data = [
                'status' => true,
                'message' => 'success',
                'data' => $article
            ];
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'status' => false,
                'message' => $th->getMessage(),
                'data' => []
            ];
            return response()->json($data, 500);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateArticleRequest $request, Article $article)
    {
        //
        try {
            //code...
            $article->update([
                'title' => $request->title,
                'content' => $request->content,
                'users_id' => Auth::user()->id
            ]);
            $data = [
                'status' => true,
                'message' => 'success',
                'data' => []
            ];
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'status' => false,
                'message' => $th->getMessage(),
                'data' => []
            ];
            return response()->json($data, 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Article $article)
    {
        //
        try {
            //code...
            $article->delete();
            $data = [
                'status' => true,
                'message' => 'success',
                'data' => []
            ];
            return response()->json($data);
        } catch (\Throwable $th) {
            //throw $th;
            $data = [
                'status' => false,
                'message' => $th->getMessage(),
                'data' => []
            ];
            return response()->json($data, 500);
        }
    }
}
