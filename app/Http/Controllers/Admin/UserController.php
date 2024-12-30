<?php

namespace App\Http\Controllers\Admin;

use App\Enums\KycStatus;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CreateUserRequest;
use App\Http\Requests\Admin\UpdateUserRequest;
use App\Models\Permission;
use App\Models\User;
use App\Models\UserPermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Input;
use Auth;
use Validator;
use Session;
use File;
use DB;
use App\Library\MailService;
use App\Models\Office;
use App\Models\Attachment;
use Illuminate\Support\Facades\Hash;
use Yajra\DataTables\DataTables;

class UserController extends Controller {
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    private $__avatarPath = 'uploads/avatar';

    private $__mailService;

    public function __construct(MailService $mailService)
    {
        $this->__mailService = $mailService;
    }

    public function index(Request $request) {
        $userId = \Illuminate\Support\Facades\Auth::id();
        $users = User::where('id', '>', 0)->where('id','<>',$userId)->orderBy('id', 'DESC');
        $q = $request->input('q');
        $status = $request->input('status');

        if ($q) {

            $users->where('email', 'LIKE', '%' . $q . '%')
                ->orWhere('name', 'LIKE', '%' . $q . '%');
        }


        if ($status) {
            $users->where('status', $status);
        }

        $users = $users->paginate(15)->appends($request->all());

        return view('admin.user.index', [
            'users' => $users, 'q' => $q,
            'status' => $status
        ]);
    }

    public function show(Request $request, User $user) {
        $id = $user->id;
        // $album = Attachment::where('user_id',$id)
        //                 ->where('module_id',$id)
        //                 ->where('module','avatar')
        //                 ->orderBy('sort','ASC')
        //                 ->get();

        return view('admin.user.show', ['user' => $user]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $permission = new Permission();
        $permission = $permission->getAll();
        $permission = collect($permission)->groupBy('module_name');

        return view('admin.user.add',[
            'permission' => $permission
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateUserRequest $request) {
        $data = $request->all();
        $data['service_fee_percentage'] = 0;
        $data['password'] = bcrypt($request->password);
        $permission = [];
        if (isset($data['permission'])){
            $permission = $data['permission'];
            unset($data['permission']);
        }

        $user = User::create($data);

        $this->handleAddPermissionUser($user->id,$permission);

        session()->flash('success', __('general.createUserSuccessfully'));
        return redirect()->route('admin.user.index');
    }

    public function handleAddPermissionUser($user_id,$permission)
    {
        $userPermission = new UserPermission();
        if (count($permission) != 0){
            $list = [];
            foreach ($permission as $key => $item){
                $list[$key]['permission_id'] = $item;
                $list[$key]['user_id'] = $user_id;
            }

            $userPermission->insertData($list);
        }
        return true;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function edit(User $user) {
        $permission = new Permission();
        $userPermissionModel = new UserPermission();
        $permission = $permission->getAll();
        $permission = collect($permission)->groupBy('module_name');

        $userPermission = $userPermissionModel->getListPermissionUser($user->id);

        if (count($userPermission) != 0){
            $userPermission = collect($userPermission)->keyBy('permission_id');
        }


        return view('admin.user.edit')->with([
            'user' => $user,
            'permission' => $permission,
            'userPermission' => $userPermission
        ]);
    }

    public function changePass($id) {

        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.user.index');
        }
        return view('admin.user.edit')->with(['user' => $user]);
    }


    public function setting(Request $request, $id) {
        $user = User::findOrFail($id);

        $user->lang_id = $request->lang;
        $user->status = $request->status;
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;

        if ($user->save()) {
            session()->flash('success', trans('general.updateSuccessfully'));
        } else {
            session()->flash('error', trans('validation.updateError'));
        }

        return Redirect::to('admin/user/edit/' . $user->id . '#tab_content2');
    }

    public function updatePass(Request $request, $id) {
        $user = User::find($id);
        $password = $request->password;
        $repassword = $request->repassword;
        $oldpassword = $request->oldpassword;

        if (!$password || ($password != $repassword)) {
            session()->flash('error', __('Notice Password Match'));
        } elseif (strlen($password) < 5) {
            session()->flash('error', __('Password Require 5 Characters'));
        } elseif (!$oldpassword) {
            session()->flash('error', __('Enter Current Password'));
        } elseif (!Hash::check($oldpassword, $user->password)) {
            session()->flash('error', __('Password Missing'));
        } else {
            $user->password = bcrypt($password);
            session()->flash('success', __('Password Updated Sucessfully'));
            $user->save();
        }
        return Redirect::to('admin/user/edit/' . $user->id . '#tab_content3');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateUserRequest $request, $id) {
        $userPermission = new UserPermission();
        $data = $request->all();
        $user = User::find($id);
        $user->fill($request->except('password'));

        $permission = [];
        if (isset($data['permission'])){
            $permission = $data['permission'];
            unset($data['permission']);
        }

        // if ($request->input('password')) {
        //     $user->password = bcrypt($request->input('password'));
        // }

        if ($request->input('phone')) {
            $user->phone = $request->input('phone');
        }

        if ($request->input('status')) {
            $user->status = $request->input('status');
        }


        $user->save();

        $userPermission->removeByUserId($id);

        $this->handleAddPermissionUser($id,$permission);

        session()->flash('success', trans('user.updateSuccessfully'));
        return redirect()->route('admin.user.index');
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id) {

        $userPermission = new UserPermission();
        $user = User::find($id);
        if (!$user) {
            return redirect()->route('admin.user.index');
        }

        $user->delete();
        $userPermission->removeByUserId($id);
        session()->flash('success', trans('user.deleteSuccessfully'));
        return redirect()->route('admin.user.index');
    }

    public function uploadImage(Request $request, $id) {

        $data = array();
        $data['status'] = 0;
        $data['msg'] = '';
        $data['src'] = '';
        if ($request->hasFile('file')) {
            $rules = $rules = array('image' => 'mimes:jpeg,jpg,png,gif|required|max:1500');
            $files = array('image' => $request->file('file'));
            $validator = Validator::make($files, $rules);

            if ($validator->fails()) {
                $data['status'] = 0;
                $data['msg'] = trans('general.allowUploadFile');
                return response()->json($data, 401);
            }

            $file = $request->file('file');
            $fileName = time() . $file->getClientOriginalName();

            //Move Uploaded File
            $destinationPath = $this->__avatarPath;
            $avatar = $destinationPath . '/' . $fileName;
            // exit;
            $user = new User;
            $user = $user->find($id);
            $user->avatar = $avatar;
            $user->save();
            $data['status'] = 1;
            $data['src'] = url($avatar);
            $data['msg'] = trans('general.updateAvatarSuccessfully');
            $file->move($destinationPath, $fileName);
            return response()->json($data, 200);
        }
    }
}
