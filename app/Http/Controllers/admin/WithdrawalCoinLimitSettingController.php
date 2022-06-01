<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Model\Coin;
use App\Model\WithdrawalCoinLimitSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class WithdrawalCoinLimitSettingController
 */
class WithdrawalCoinLimitSettingController extends Controller {
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function withdrawalCoinLimit() {
        $data['sendLimits'] = WithdrawalCoinLimitSetting::select('withdrawal_coin_limit_settings.*','coins.*',DB::raw('withdrawal_coin_limit_settings.id as l_id'))->join('coins',['coins.id' => 'withdrawal_coin_limit_settings.coin_id'])
            ->orderBy('coin_id', 'asc')->orderBy('from','asc')->get();
        $data['coins'] = Coin::all();
        return view('admin.coin.withdrawal-coin-limit', $data);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function withdrawalLimitSave(Request $request) {
        if ($request->from >= $request->to) {
            return redirect()->back()->with('dismiss', __('To value must be greater than From value.'));
        }
        if ($request->from == null || $request->to == null) {
            return redirect()->back()->with('dismiss', __('From and To value Required.'));
        }
        $existing_limits = WithdrawalCoinLimitSetting::where(['coin_id' => $request->coin_id])->get();
        if (isset($existing_limits) && ($existing_limits->count() > 0)) {
            foreach ($existing_limits as $existing_limit) {
                if (($request->from > $existing_limit->from && $request->from < $existing_limit->to) ||
                    ($request->to > $existing_limit->from && $request->to <= $existing_limit->to)) {
                    return redirect()->back()->with('dismiss', __('Limit already exists.'));
                }
            }
        }
        $create = [
            'from' => $request->from,
            'to' => $request->to,
            'coin_id' => $request->coin_id,
            'id_verify_status' => 1,
            'google2fa' => isset($request->google2fa) ? 1 : 0,
            'email2fa' => isset($request->email2fa) ? 1 : 0,
            'admin_approval' => isset($request->admin_approval) ? 1 : 0,
            'created_by' => Auth::user()->id
        ];
        if (WithdrawalCoinLimitSetting::create($create)) {
            return redirect()->back()->with('success', __('Withdrawal Limit Settings is Saved Successfully.'));
        }
        return redirect()->back()->with('dismiss', __('Failed to save Withdrawal Limit Settings!'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function updateWithdrawalLimit($id) {
        $id = decrypt($id);
        $data['item'] = WithdrawalCoinLimitSetting::where(['id' => $id])->first();
        return view('admin.coin.update-withdrawal-coin-limit', $data);
    }

    /**
     * @param Request $request
     * @param $limitId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateWithdrawalLimitProcess(Request $request, $limitId) {
        if ($request->from >= $request->to) {
            return redirect()->back()->with('dismiss', __('To value must be greater than From value.'));
        }
        $limitId = decrypt($limitId);
        $sendLimit = WithdrawalCoinLimitSetting::where(['id' => $limitId])->first();
        if (!isset($sendLimit)) {
            return redirect()->back()->with('dismiss', __('Invalid request!'));
        }
        $update = [
            'from' => $request->from,
            'to' => $request->to,
            'coin_id' => $sendLimit->coin_id,
            'id_verify_status' => 1,
            'google2fa' => isset($request->google2fa) ? 1 : 0,
            'email2fa' => isset($request->email2fa) ? 1 : 0,
            'admin_approval' => isset($request->admin_approval) ? 1 : 0,
            'created_by' => Auth::user()->id
        ];
        if ($sendLimit->update($update)) {
            return redirect()->back()->with('success', __('Withdrawal Limit Settings is Updated Successfully.'));
        }
        return redirect()->back()->with('dismiss', __('Failed to update Withdrawal Limit Settings!'));
    }

    /**
     * @param $limitId
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteWithdrawalLimit($limitId)
    {
        $limitId = decrypt($limitId);
        $sendLimit = WithdrawalCoinLimitSetting::where(['id' => $limitId])->first();
        if ($sendLimit->delete()) {
            return redirect()->back()->with('success', __('Withdrawal Limit is deleted successfully.'));
        }
        return redirect()->back()->with('dismiss', __('Something went wrong. Please try again!'));
    }
}
