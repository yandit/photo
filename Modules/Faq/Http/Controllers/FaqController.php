<?php

namespace Modules\Faq\Http\Controllers;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Faq\Entities\Faq;
use Modules\Faq\Transformers\FaqResource;
use Modules\Faq\Http\Requests\FaqRequest;

class FaqController extends Controller
{
    public function index()
    {
        return view('faq::index');
    }

    public function create()
    {
        return view('faq::create');
    }

    public function edit(Faq $faq)
    {   
        return view('faq::edit', [
            'faq' => $faq,
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
            $question = $allGet['question'];
            $status = $allGet['status'];

            $faqModel = Faq::query();
            if ($columnIndex == 0) {
                $faqModel->orderBy('id', $allGet['order'][0]['dir']);
            } else {
                $faqModel->orderBy($allGet['columns'][$columnIndex]['data'], $allGet['order'][0]['dir']);
            }
            
            if($question){
                $likeSearch = "%{$question}%";
                $faqModel->whereRaw(' ( question like ? ) ', [$likeSearch]);
            }
            if($status){
                $faqModel->where('status', $status);
            }
            if ($startDate && $endDate) {
                $faqModel->whereRaw('DATE(faqs.created_at) BETWEEN ? AND ?', [$startDate, $endDate]);
            }

            $countTable = $faqModel->count();
            $preData = $faqModel
                ->limit($allGet['length'])
                ->offset($allGet['start'])
                ->get();

            $data = FaqResource::collection($preData);
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

    public function store(FaqRequest $request)
    {
        $post = $request->all();
        Faq::create([
            'question' => $post['question'],
            'answer' => $post['answer'],
            'order' => $post['order'],
            'status' => $post['status'],
            'created_by_id' => loggedInUser('id')
        ]);
        $request->session()->flash('message', __('faq::messages.create_success'));
        return redirect()->route('faq.index');
    }

    public function update(Faq $faq, Request $request)
    {
        
        $post = $request->all();
        $faq->question = $post['question'];
        $faq->answer = $post['answer'];
        $faq->order = $post['order'];
        $faq->status = $post['status'];
        $faq->updated_by_id = loggedInUser('id');
        $faq->save();

        $request->session()->flash('message', __('faq::messages.update_success'));
        return redirect()->route('faq.index');
    }

    public function delete(Faq $faq, Request $request)
    {
        
        $faq->delete();
        // $request->session()->flash('message', __('faq::messages.delete_success'));
        return redirect()->route('faq.index');
    }
}
