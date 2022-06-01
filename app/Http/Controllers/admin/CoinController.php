<?php
namespace App\Http\Controllers\admin;
use App\Http\Requests\CoinRequest;
use App\Http\Requests\ApiSettingRequest;
use App\Model\Coin;
use App\Model\CoinSetting;
use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

/**
 * Class CoinController
 */
class CoinController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|mixed
     * @throws Exception
     */
    public function adminCoinList(Request $request){
        if($request->ajax()) {
            $coin = Coin::query();
            return datatables($coin)
                ->addColumn('coin_icon', function ($item) {
                    return '<img style="width: 30px;" src="'. (!empty($item->coin_icon) ?
                            getImageUrl(coinIconPath() . $item->coin_icon) : '') . '" >';
                })->editColumn('minimum_withdrawal', function ($item) {
                    return visual_number_format($item->minimum_withdrawal);
                })->editColumn('maximum_withdrawal', function ($item) {
                    return visual_number_format($item->maximum_withdrawal);
                })->addColumn('api_service', function ($item) {
                    return isset($item->coin_settings) ? $item->coin_settings->api_service : '';
                })
                ->addColumn('deposit_status', function ($item) {
                    return statusAction($item->deposit_status);
                })
                ->addColumn('withdrawal_status', function ($item) {
                    return statusAction($item->withdrawal_status);
                })
                ->addColumn('earnings', function ($item) {
                    return coinEarnings($item->id);
                })
                ->addColumn('active_status', function ($item) {
                    return statusAction($item->active_status);
                })
                ->addColumn('action', function ($item) {
                    return '<ul class="d-flex activity-menu">
                                <li class="viewuser"><a href="' . route('coin_edit', encrypt($item->id)) . '">
                                    <span class="user-list-actions-icon" title="Edit"><i class="fas fa-pencil-alt"></i></span>
                                    </li>
                                </ul>';
                })
                ->rawColumns(['action', 'coin_icon'])
                ->make(true);
        }
        return view('admin.coin.list');
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function adminCoinEdit($id) {
        $coinId = decryptId($id);
        if(is_array($coinId)) {
            return redirect()->back()->with(['dismiss' => __('Coin not found')]);
        }
        $item = Coin::where(['id'=>$coinId])->first();
        return view('admin.coin.addEdit',
            ['item' => $item, 'title' => __('Update Coin'), 'button_title' => __('Update')]);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminCoinAdd() {
        $data['title'] = __('Add Coin');
        $data['button_title'] = __('Add');
        return view('admin.coin.addEdit', $data);
    }

    /**
     * @param CoinRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminCoinSave(CoinRequest $request) {
        $coin_id = '';
        $input['coin_type'] = strtoupper($request->ctype);
        $input['full_name'] = $request->coin_full_name;
        $input['deposit_status'] = isset($request->deposit_status) ? 1 : 0;
        $input['withdrawal_status'] = isset($request->withdrawal_status) ? 1 : 0;
        $input['active_status'] = isset($request->active_status) ? 1 : 0;
        $input['is_currency'] = isset($request->is_currency) ? 1 : 0;
        $input['minimum_buy_amount'] = $request->minimum_buy_amount;
        if (!empty($request->coin_icon)) {
            $icon = uploadimage($request->coin_icon, coinIconPath());
            if ($icon != false) {
                $input['coin_icon'] = $icon;
            }
        }
        if($request->coin_id) {
            $coin_id = decryptId($request->coin_id);
        }
        if(!Coin::where(['coin_type' => strtoupper($request->ctype)])->exists()) {
            $input['coin_type'] = strtoupper($request->ctype);
        }
        try {
            DB::beginTransaction();
            if(!empty($coin_id)){
                Coin::where(['id'=>$coin_id])->update($input);
                $is_wallet_create = wallet_create($coin_id);
                if (!$is_wallet_create) {
                    DB::rollBack();
                    return redirect()->back()->with(['dismiss' => 'Wallet Create Failed']);
                }
            }else{
                $coin = Coin::create($input);
                $is_wallet_create = wallet_create($coin->id);
                if (!$is_wallet_create) {
                   DB::rollBack();
                   return redirect()->back()->with(['dismiss' => 'Wallet Create Failed']);
                }
            }
            DB::commit();
            return redirect()->back()->with(['success' => 'Coin save or update successfully']);
        }catch (Exception $e){
            DB::rollBack();
            return redirect()->back()->with(['dismiss' => $e->getMessage()]);
        }
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminApiSettings()
    {
        $data['coins'] = Coin::leftjoin('coin_settings', 'coin_settings.coin_id', '=', 'coins.id')
            ->select('coins.coin_type', 'coins.id', 'coin_settings.api_service', 'coin_settings.withdrawal_fee_percent', 'coin_settings.withdrawal_fee_fixed', 'coin_settings.withdrawal_fee_method')
            ->where(['active_status' => 1])->get();
        return view('admin.coin.api-settings', $data);
    }

    /**
     * @param ApiSettingRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function adminApiSettingsSave(ApiSettingRequest $request) {
        $data = $request->all();
        try {
            DB::beginTransaction();
            if (isset($data['coin_id'][0])) {
                for ($i = 0; $i < count($data['coin_id']); $i++) {
                    if (!empty($data['coin_id'][$i])) {
                        $coin_id = decryptId($data['coin_id'][$i]);
                        if (is_numeric($coin_id) && is_numeric($data['withdrawal_fee_method'][$i]) && is_numeric($data['withdrawal_fee_percent'][$i]) && is_numeric($data['withdrawal_fee_fixed'][$i])) {
                            CoinSetting::updateOrCreate(['coin_id' => $coin_id],
                            [
                                'coin_id' => $coin_id,
                                'api_service' => $data['api_service'][$i],
                                'withdrawal_fee_method' => $data['withdrawal_fee_method'][$i],
                                'withdrawal_fee_percent' => $data['withdrawal_fee_percent'][$i],
                                'withdrawal_fee_fixed' => $data['withdrawal_fee_fixed'][$i]
                            ]);
                        }
                    }
                }
                DB::commit();
                return redirect()->back()->with(['success' => __('Updated Successfully')]);
            } else {
                DB::rollBack();
                return redirect()->back()->with(['dismiss' => __('Coin Not Valid')]);
            }
        } catch (Exception $e) {
            DB::rollBack();
            return redirect()->back()->with(['dismiss' => __('Something Went wrong.')]);
        }
    }
}
