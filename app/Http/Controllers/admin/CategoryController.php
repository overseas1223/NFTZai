<?php
namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryStoreRequest;
use App\Model\Category;
use Illuminate\Http\Request;

/**
 * Class CategoryController
 */
class CategoryController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\JsonResponse|\Illuminate\View\View|mixed
     * @throws \Exception
     */
    public function categoryList(Request $request)
    {
        $data['title'] = __('Category List');
        if($request->ajax()) {
            $coin = Category::query();

            return datatables($coin)
                ->addColumn('action', function ($item) {
                    return '
                            <div class="activity-icon">
                                <ul>
                                    <li>
                                        <a href="'.route('admin_edit_category', encrypt($item->id)).'" class="user-list-actions-icon"><i class="fas fa-pencil-alt"></i></a>
                                    </li>
                                    <li>
                                        <a href="'.route('admin_delete_category', encrypt($item->id)).'" class="user-list-actions-icon bg-danger"><i class="fas fa-trash-alt"></i></a>
                                    </li>
                                </ul>
                            </div>
                            ';
                })
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.categories.list', $data);
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function addCategory()
    {
        $data['title'] = __('Add Category');
        return view('admin.categories.add', $data);
    }

    /**
     * @param CategoryStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function storeCategory(CategoryStoreRequest $request)
    {
        $action = Category::create([
            'title' => $request->title,
            'description' => $request->description,
        ]);

        if(!empty($action)) {
            return redirect()->back()->with('success', __('Category Successfully Created!'));
        }
        return redirect()->back()->with('dismiss', __('Something went wrong'));
    }

    /**
     * @param $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function editCategory($id)
    {
        $data['title'] = __('Edit Category');
        $id = decrypt($id);
        $data['category'] = Category::whereId($id)->first();
        return view('admin.categories.edit', $data);

    }

    /**
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function updateCategory(Request $request, $id)
    {
        $id = decrypt($id);
        $category = Category::whereId($id)->first();
        $action = Category::whereId($id)->update([
            'title' => is_null($request->title) ? $category->title : $request->title,
            'description' => is_null($request->description) ? $category->description : $request->description,
        ]);

        if(!empty($action)) {
            return redirect()->back()->with('success', __('Category Successfully Updated!'));
        }
        return redirect()->back()->with('dismiss', __('Something went wrong'));
    }

    /**
     * @param $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function deleteCategory($id)
    {
        $id = decrypt($id);
        $action = Category::whereId($id)->first()->delete();
        if(!empty($action)) {
            return redirect()->back()->with('success', __('Category Deleted!'));
        }
        return redirect()->back()->with('dismiss', __('Something went wrong'));
    }
}
