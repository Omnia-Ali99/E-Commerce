<?php

namespace App\Services\Dashboard;

use App\Utils\ImageManger;
use Illuminate\Support\Str;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Dashboard\PageRepository;

class PageService
{
    protected $pageRepository, $imageManger;

    public function __construct(PageRepository $pageRepository , ImageManger $imageManger)
    {
        $this->pageRepository = $pageRepository;
        $this->imageManger = $imageManger;
    }
    public function getPages() // new
    {
        return $this->pageRepository->getPages();
    }
    public function getPagesForDatatables()
    {

        $pages = $this->getPages();
        return DataTables::of($pages)
            ->addIndexColumn()
            ->addColumn('title', function ($page) {
                return $page->getTranslation('title', app()->getLocale());
            })
            ->addColumn('content', function ($page) {
                return view('dashboard.pages.datatables.content', compact('page'));
            })

            ->addColumn('image', function ($page) {
                return $page->image != null ?  view('dashboard.pages.datatables.image', compact('page')) : __('dashboard.no_image');

            })

            ->addColumn('action', function ($page) {
                return view('dashboard.pages.datatables.action', compact('page'));
            })
            ->rawColumns(['image', 'action'])
            ->make(true);
    }

    public function getPage($id)
    {
        return $this->pageRepository->getPage($id);
    }

    public function createPage($data)
    {
        if(array_key_exists('image', $data)  && $data['image'] != null){
            $image = $this->imageManger->uploadSingleImage('/' , $data['image'] , 'pages');
            $data['image'] = $image;
        }
        $data['slug'] = Str::slug($data['title']['en']);
        return $this->pageRepository->createPage($data);
    }
    public function updatePage($data, $id)
    {
        $page = $this->getPage($id);
        if(array_key_exists('image', $data)  && $data['image'] != null){
            $this->imageManger->deleteImageFromLocal('uploads/pages/' . $page->image);
            $image = $this->imageManger->uploadSingleImage('/' , $data['image'] , 'pages');
            $data['image'] = $image;
        }
        $data['slug'] = Str::slug($data['title']['en']);
        return $this->pageRepository->updatePage($page, $data);
    }



    public function deletePage($id)
    {
       if(!$page = $this->getPage($id)){
           return false;
        };

        if ($page->image != null) {
            $this->imageManger->deleteImageFromLocal('uploads/pages/'.$page->image);
        }

        return $this->pageRepository->deletePage($page);

    }
}