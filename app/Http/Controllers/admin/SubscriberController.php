<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Jobs\SendSubscriberMail;
use App\Model\ContactUs;
use App\Model\Subscriber;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

/**
 * Class SubscriberController
 */
class SubscriberController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function subscriberList(Request $request)
    {
        $data['title'] = __('Subscriber List');
        if($request->ajax()){
            $data['subscribers'] = Subscriber::query();
            return datatables()->of($data['subscribers'])
                ->editColumn('status', function($item) {
                    if($item->status == 1) {
                        return __('Active');
                    }
                    else {
                        return __('Inactive');
                    }
                })
                ->editColumn('created_at',function ($item){
                    return Carbon::parse($item->created_at)->diffForHumans();
                })
                ->addColumn('action', function ($item) {
//                    return '<button type="button" class="border-0 bg-info user-list-actions-icon"><i class="fas fa-paper-plane"></i></button>';
                    return '<a href="'.route('admin_subscriber_mail', encrypt($item->id)).'" class="border-0 bg-info user-list-actions-icon"><i class="fas fa-paper-plane"></i></a>';
                })
                ->make(true);
        }
        return view('admin.subscribers.list',$data);
    }

    public function subscriberMail($id)
    {
        $id = decrypt($id);
        $subscriber =  Subscriber::whereId($id)->first();
        return view('admin.subscribers.send-mail', ['title' => __('Mail Subscriber'), 'subscriber' => $subscriber]);
    }

    public function subscriberMailReply(Request $request)
    {
        $data['userName'] = $request->email;
        $data['userEmail'] = $request->email;
        $data['subject'] = __('Mail From Nftzai');
        $data['data'] = $request->reply;
        $data['template'] = 'email.subscriberMail';
        dispatch(new SendSubscriberMail($data))->onQueue('email-send');
        return redirect()->back()->with('success', __('Mail Successfully send'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Exception
     */
    public function contactList(Request $request)
    {
        $data['title'] = __('Contact List');
        if($request->ajax()){
            $data['contacts'] = ContactUs::query();
            return datatables()->of($data['contacts'])
                ->editColumn('file', function ($item) {
                    if($item->file == null || $item->file == '') {
                        return __('N/A');
                    }
                    else{
                        return '<a href="'.asset(FILE_PATH.$item->file).'" download>'.__('Click Here').'</a>';
                    }
                })
                ->rawColumns(['file'])
                ->make(true);
        }
        return view('admin.contact.list',$data);
    }
}
