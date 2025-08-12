<?php

namespace App\Services\Dashboard;

use App\Utils\ImageManger;
use Yajra\DataTables\Facades\DataTables;
use App\Repositories\Dashboard\SliderRepository;

class SliderService
{
    protected $sliderRepository, $imageManger;

    public function __construct(SliderRepository $sliderRepository , ImageManger $imageManger)
    {
        $this->sliderRepository = $sliderRepository;
        $this->imageManger = $imageManger;
    }
    public function getSliders() // new
    {
        return $this->sliderRepository->getSliders();
    }
    public function getSlidersForDatatables()
    {

        $sliders = $this->sliderRepository->getSliders();
        return DataTables::of($sliders)
            ->addIndexColumn()
            ->addColumn('note', function ($slider) {
                return $slider->getTranslation('note', app()->getLocale());
            })
            ->addColumn('file_name', function ($slider) {
                return view('dashboard.sliders.datatables.image', compact('slider'));
            })

            ->addColumn('action', function ($slider) {
                return view('dashboard.sliders.datatables.action', compact('slider'));
            })
            ->rawColumns(['file_name', 'action'])
            ->make(true);
    }

    public function getSlider($id)
    {
        return $this->sliderRepository->getSlider($id);
    }

    public function createSlider($data)
    {
        if(array_key_exists('file_name', $data)  && $data['file_name'] != null){
            $file_name = $this->imageManger->uploadSingleImage('/' , $data['file_name'] , 'sliders');
            $data['file_name'] = $file_name;
        }
        return $this->sliderRepository->createSlider($data);
    }


    public function deleteSlider($id)
    {
       if(!$slider = $this->getSlider($id)){
           return false;
        };

        if ($slider->file_name != null) {
            $this->imageManger->deleteImageFromLocal($slider->file_name);
        }

        return $this->sliderRepository->deleteSlider($slider);

    }

}