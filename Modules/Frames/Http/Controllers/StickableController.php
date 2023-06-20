<?php

namespace Modules\Frames\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Transformers\FaqResource;
use Modules\Faq\Http\Requests\FaqRequest;
use Modules\Frames\Http\Requests\StickableFrameRequest;
use Modules\Frames\Entities\StickableFrame;
use Modules\Frames\Transformers\StickableFrameResource;

class StickableController extends Controller
{
    private $uploadDir = 'frames/stickable';
    public function index()
    {
        return view('frames::stickable.index');
    }

    public function create()
    {
        return view('frames::stickable.create');
    }

    public function edit(StickableFrame $stickable)
    {   
        return view('frames::stickable.edit', [
            'stickable' => $stickable,
        ]);
    }

    public function list(Request $request)
    {
        $allGet = $request->all();
        $data = [];
        $countTable = 0;
        $headerCode = 200;
        $returnErrors = null;

        try {
            $columnIndex = $allGet['order'][0]['column'];
            $searchValue = $allGet['search']['value'];
            $startDate = $allGet['startDate'];
            $endDate = $allGet['endDate'];
            $title = $allGet['title'];
            $status = $allGet['status'];

            $model = StickableFrame::query();
            if ($columnIndex == 0) {
                $model->orderBy('id', $allGet['order'][0]['dir']);
            } else {
                $model->orderBy($allGet['columns'][$columnIndex]['data'], $allGet['order'][0]['dir']);
            }
            
            if($title){
                $likeSearch = "%{$title}%";
                $model->whereRaw(' ( title like ? ) ', [$likeSearch]);
            }
            if($status){
                $model->where('status', $status);
            }
            if ($startDate && $endDate) {
                $model->whereRaw('DATE(faqs.created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }

            $countTable = $model->count();
            $preData = $model
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();

            $data = StickableFrameResource::collection($preData);
        } catch (\Exception $e) {
            $returnErrors = [['field' => 'database', 'message' => 'Internal Server Error ' . $e->getMessage()]];
            $headerCode = 500;
        }

        return response()->json(
            [
                'data' => $data,
                'draw' => $allGet['draw'],
                'recordsFiltered' => $countTable,
                'recordsTotal' => $countTable,
                'old_start' => ((int) $allGet['start']),
                'errors' => $returnErrors,
            ],
            $headerCode
        );
    }

    public function store(StickableFrameRequest $request)
    {
        $post = $request->all();
        $image = '';
        $sub = strtotime(date('Y-m-d'));
        if($request->file('image') && $request->file('image')->isValid()){
            $image = $request->file('image')->store("public/{$this->uploadDir}/{$sub}");
        }
        
        StickableFrame::create([
            'title' => $post['title'],
            'slug' => $post['slug'],
            'class' => $post['class'],
            'order' => $post['order'],
            'status' => $post['status'],
            'image' => $image,
            'created_by_id' => loggedInUser('id')
        ]);
        $request->session()->flash('message', __('frames::messages.create_success'));
        return redirect()->route('stickableframe.index');
    }

    public function update(StickableFrame $stickable, Request $request)
    {
        
        $post = $request->all();
        $stickable->title = $post['title'];
        $stickable->slug = $post['slug'];
        $stickable->class = $post['class'];
        $stickable->order = $post['order'];
        $stickable->status = $post['status'];
        $stickable->updated_by_id = loggedInUser('id');
        $stickable->save();

        $request->session()->flash('message', __('frames::messages.update_success'));
        return redirect()->route('stickableframe.index');
    }

    public function delete(StickableFrame $stickable, Request $request)
    {
        
        $stickable->delete();
        // $request->session()->flash('message', __('faq::messages.delete_success'));
        return redirect()->route('stickableframe.index');
    }
}
