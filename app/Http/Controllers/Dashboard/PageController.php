<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Requests\PageRequest;
use App\Http\Controllers\Controller;
use App\Services\Dashboard\PageService;
use Illuminate\Support\Facades\Session;

class PageController extends Controller
{

    protected $pageService;
    public function __construct(PageService $pageService)
    {
        $this->pageService = $pageService;
    }

    public function index()
    {
        return view('dashboard.pages.index');
    }

    public function getAll()
    {
        return $this->pageService->getPagesForDatatables();
    }

    public function create()
    {
        return view('dashboard.pages.create');
    }

    public function store(PageRequest $request)
    {
        $data = $request->only(['title', 'content','image']);
        $page = $this->pageService->createPage($data);

        if(!$page){
            Session::flash('error' , trans('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , trans('dashboard.success_msg'));
        return redirect()->back();

    }

    public function edit($id)
    {
        $page = $this->pageService->getPage($id) ?? abort(404);
        return view('dashboard.pages.edit',compact('page'));
    }

    public function update(PageRequest $request,$id)
    {
        $data   = $request->only(['title', 'content','image']);
        $page = $this->pageService->updatePage($data,$id);
        if(!$page){
            Session::flash('error' , trans('dashboard.error_msg'));
            return redirect()->back();
        }
        Session::flash('success' , trans('dashboard.success_msg'));
        return redirect()->back();
    }

    public function destroy(string $id)
    {
        if(!$this->pageService->deletePage($id)){
            return response()->json([
                'status'=>'error',
                'message'=>__('dashboard.error_msg'),
            ],404);
        }
        return response()->json([
            'status'=>'success',
            'message'=>__('dashboard.success_msg'),
        ],200);

    }
}