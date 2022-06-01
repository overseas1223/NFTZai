<?php
namespace App\Http\Controllers\admin;
use App\Http\Services\CommonService;
use App\Jobs\SendMail;
use App\Model\Deposit;
use App\Model\Service;
use App\Model\Withdrawal;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

/**
 * Class DashboardController
 */
class DashboardController extends Controller
{
    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function adminDashboard()
    {
        $data['title'] = __('Admin Dashboard');
        $data['total_coin'] = 0;
        $data['total_deposit_coin'] = Deposit::sum('doller');
        $data['total_withdrawal_coin'] = Withdrawal::sum('doller');
        $data['total_user'] = User::where(['role' => 2])->count();
        $data['earnings'] = Service::count();
        $total_active_user = User::where('status', STATUS_ACTIVE)->count();
        $total_inactive_user = User::where('status','<>', STATUS_ACTIVE)->count();
        $data['active_percentage'] = ($total_active_user*100)/$data['total_user'];
        $data['inactive_percentage'] = ($total_inactive_user*100)/$data['total_user'];
        $allMonths = all_months();
        // deposit
        $monthlyDeposits = Deposit::select(DB::raw('sum(amount) as totalDepo'), DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', STATUS_SUCCESS)
            ->groupBy('months')
            ->get();

        if (isset($monthlyDeposits[0])) {
            foreach ($monthlyDeposits as $depsit) {
                $data['deposit'][$depsit->months] = $depsit->totalDepo;
            }
        }
        $allDeposits = [];
        foreach ($allMonths as $month) {
            $allDeposits[] =  isset($data['deposit'][$month]) ? $data['deposit'][$month] : 0;
        }
        $data['monthly_deposit'] = $allDeposits;
        // withdrawal
        $monthlyWithdrawals = Withdrawal::select(DB::raw('sum(amount) as totalWithdraw'), DB::raw('MONTH(created_at) as months'))
            ->whereYear('created_at', Carbon::now()->year)
            ->where('status', STATUS_SUCCESS)
            ->groupBy('months')
            ->get();
        if (isset($monthlyWithdrawals[0])) {
            foreach ($monthlyWithdrawals as $withdraw) {
                $data['withdrawal'][$withdraw->months] = $withdraw->totalWithdraw;
            }
        }
        $allWithdrawal = [];
        foreach ($allMonths as $month) {
            $allWithdrawal[] =  isset($data['withdrawal'][$month]) ? $data['withdrawal'][$month] : 0;
        }
        $data['monthly_withdrawal'] = $allWithdrawal;
        return view('admin.dashboard', $data);
    }

}
