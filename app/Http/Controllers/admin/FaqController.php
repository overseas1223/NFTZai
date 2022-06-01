<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\FaqContentStoreRequest;
use App\Model\Faq;
use App\Model\FaqHead;
use App\Model\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * Class FaqController
 */
class FaqController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function faqHeading(Request $request)
    {
        $data['title'] = __('Subscriber List');
        if($request->ajax()){
            $data['heading'] = FaqHead::query();
            return datatables()->of($data['heading'])
                ->editColumn('icon',function ($item){
                    return $item->icon;
                })
                ->addColumn('action', function ($item) {
                    return '<a href="'.route('admin_faq_heading_edit', encrypt($item->id)).'" class="user-list-actions-icon"><i class="fas fa-pencil-alt"></i></a>';
                })
                ->rawColumns(['icon', 'action'])
                ->make(true);
        }
        return view('admin.faq.heading.list',$data);
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faqHeadingEdit($id)
    {
        $id = decrypt($id);
        $heading = FaqHead::whereId($id)->first();
        return view('admin.faq.heading.edit', ['title' => __('Edit FAQ Heading'), 'heading' => $heading]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function faqHeadingUpdate(Request $request, $id)
    {
        $id = decrypt($id);
        $heading = FaqHead::whereId($id)->first();
        $action = FaqHead::whereId($id)->update([
            'title' => is_null($request->title) ? $heading->title : $request->title,
            'icon' => is_null($request->icon) ? $heading->icon : $request->icon,
        ]);

        if(!empty($action)) {
            return redirect()->back()->with('success', __('FAQ Heading successfully updated!'));
        }
        return redirect()->back()->with('dismiss', __('Something went wrong!'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function faqContent(Request $request)
    {
        $data['title'] = __('FAQ Content List');
        if($request->ajax()){
            $data['content'] = Faq::query();
            return datatables()->of($data['content'])
                ->editColumn('heading',function ($item){
                    return $item->faq_head->title;
                })
                ->addColumn('action', function ($item) {
                    return '<a href="'.route('admin_faq_content_edit', encrypt($item->id)).'" class="user-list-actions-icon"><i class="fas fa-pencil-alt"></i></a>';
                })
                ->rawColumns(['icon', 'action'])
                ->make(true);
        }
        return view('admin.faq.contents.list',$data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faqContentAdd()
    {
        $headings = FaqHead::get();
        return view('admin.faq.contents.add', ['title' => __('FAQ Content Settings'),'headings' => $headings]);
    }

    /**
     * @param FaqContentStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function faqContentStore(FaqContentStoreRequest $request)
    {
        $action = Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'fh_id' => $request->fh_id,
        ]);
        if(!empty($action)) {
            return redirect()->back()->with('success', __('FAQ successfully added!'));
        }
        return redirect()->back()->with('dismiss', __('Something went wrong!'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function faqContentEdit($id)
    {
        $id = decrypt($id);
        $faq = Faq::whereId($id)->first();
        $headings = FaqHead::get();
        return view('admin.faq.contents.edit', ['title' => __('FAQ Content Settings'),'faq' => $faq,'headings' => $headings]);
    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function faqContentUpdate(Request $request, $id)
    {
        $id = decrypt($id);
        $faq = Faq::whereId($id)->first();
        $action = Faq::whereId($id)->update([
            'question' => is_null($request->question) ? $faq->question : $request->question,
            'answer' => is_null($request->answer) ? $faq->answer : $request->answer,
            'fh_id' => is_null($request->fh_id) ? $faq->fh_id : $request->fh_id,
        ]);
        if(!empty($action)) {
            return redirect()->back()->with('success', __('FAQ successfully added!'));
        }
        return redirect()->back()->with('dismiss', __('Something went wrong!'));
    }
}
