<?php namespace App\Http\Controllers\Admin;

use App\Http\Controllers\AdminController;
use App\User;
use App\Http\Requests\Admin\UserRequest;
use App\Http\Requests\Admin\UserEditRequest;
use App\Http\Requests\Admin\DeleteRequest;
use Datatables;
use DB;


class UserController extends AdminController {

    /*
    * Display a listing of the resource.
    *
    * @return Response
    */
    public function index()
    {
        // Show the page
        return view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function getCreate() {
        $title = 'Novo usuário';
        return view('admin.users.create_edit', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function postCreate(UserRequest $request) {

        $user = new User ();
        $user->name = $request->name;
		$user->username = $request->username;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->confirmation_code = str_random(32);
        $user->confirmed = $request->confirmed;
        $user->admin = $request->admin;
        $user->save();
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param $user
     * @return Response
     */
    public function getEdit($id) {
        $title = 'Editar usuário';
        $user = User::find($id);
        return view('admin.users.create_edit', compact('user','title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param $user
     * @return Response
     */
    public function postEdit(UserEditRequest $request, $id) {

        $user = User::find($id);
        $user->name         = $request->name;
        $user->confirmed    = $request->confirmed;
        $user->admin        = $request->admin;

        $password = $request->password;
        $passwordConfirmation = $request->password_confirmation;

        if (!empty($password)) {
            if ($password === $passwordConfirmation) {
                $user -> password = bcrypt($password);
            }
        }
        $user -> save();
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return Response
     */

    public function getDelete($id)
    {
        $user = User::find($id);
        $title = 'Remover usuário';
        // Show the page
        return view('admin.users.delete', compact('user','title'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $user
     * @return Response
     */
    public function postDelete(DeleteRequest $request,$id)
    {
        $user= User::find($id);
        $user->delete();
    }

    /**
     * Show a list of all the languages posts formatted for Datatables.
     *
     * @return Datatables JSON
     */
    public function data()
    {
        $users = User::select(array('users.id','users.name','users.email','users.confirmed', DB::raw('DATE_FORMAT(users.created_at,\'%d/%m/%Y %H:%i\') as criado_em') ));

        return Datatables::of($users)
            ->edit_column('confirmed', '@if ($confirmed=="1") <span class="glyphicon glyphicon-ok"></span> @else <span class=\'glyphicon glyphicon-remove\'></span> @endif')
            ->add_column('actions', '@if ($id!="1")<a href="{{{ URL::to(\'admin/users/\' . $id . \'/edit\' ) }}}" class="btn btn-success btn-sm iframe" title="{{ trans("admin/modal.edit") }}" ><span class="glyphicon glyphicon-pencil"></span> </a>
                    <a href="{{{ URL::to(\'admin/users/\' . $id . \'/delete\' ) }}}" class="btn btn-sm btn-danger iframe" title="{{ trans("admin/modal.delete") }}"><span class="glyphicon glyphicon-trash"></span> </a>
                @endif')
            ->remove_column('id')

            ->make();
    }

}
