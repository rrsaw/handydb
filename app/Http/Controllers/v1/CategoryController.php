<?php

namespace handy\Http\Controllers\v1;

use Illuminate\Http\Request;
use handy\Http\Controllers\Controller;

use handy\Services\v1\CategoryService;

class CategoryController extends Controller
{
    protected $Categories;
    public function __construct(CategoryService $service)
    {
        $this->categories = $service;

        $this->middleware('auth:api', ['only' => ['store', 'update', 'destroy']]);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $parameters = request()->input();
        $data = $this->categories->getCategories($parameters);

        return response()->json($data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->categories->validate($request->all());
        try {
            $category = $this->categories->createCategory($request);
            return response()->json($category, 201);
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $data = $this->categories->getCategory($id);
        return response()->json($data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->categories->validate($request->all());

        try {
            $category = $this->categories->updateCategory($request, $id);
            return response()->json($category, 200);
        } catch (ModelNotFoundException $ex) {
            throw $ex;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $category = $this->categories->deleteCategory($id);
            return response()->make('', 204);
        } catch (ModelNotFoundException $ex) {
            throw $ex;
        } catch (Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
