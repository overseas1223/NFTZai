<?php
namespace App\Http\Controllers;
use App\Http\Requests\ContactStoreRequest;
use App\Http\Requests\SubscriberStoreRequest;
use App\Model\ContactUs;
use App\Model\Subscriber;
use Illuminate\Http\Request;

/**
 * Class CommonController
 */
class CommonController extends Controller
{
    /**
     * @param SubscriberStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function subscriberStore(SubscriberStoreRequest $request)
    {
        $action = Subscriber::create([
            'email_address' => $request->email_address,
        ]);
        if(!empty($action)) {
            return response()->json(['status' => true, 'message' => __('You are successfully subscribed!')]);
        }
        return response()->json(['status' => false, 'message' => __('Something went wrong')]);
    }

    /**
     * @param ContactStoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function contactStore(ContactStoreRequest $request)
    {
        if (!empty($request->filename)) {
            $fileName = time().'.'.$request->filename->getClientOriginalExtension();

            $request->filename->move(public_path(FILE_PATH), $fileName);
        }
        else {
            $fileName = '';
        }
        $action = ContactUs::create([
            'title' => $request->title,
            'email' => $request->email,
            'message' => $request->message,
            'file' => $fileName,
        ]);
        if(!empty($action)) {
            return response()->json(['status' => true, 'message' => __('Message send!')]);
        }
        return response()->json(['status' => false, 'message' => __('Something went wrong')]);
    }
}
