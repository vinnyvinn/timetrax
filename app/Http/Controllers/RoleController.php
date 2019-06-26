<?php

namespace App\Http\Controllers;

use App\company;
use App\Role;
use App\User;
use Illuminate\Http\Request;

use App\Http\Requests;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (!hasPermission(Role::PERM_ROLE_VIEW_ALL))
        {
            abort(403);
        }
        $roles = Role::orderBy('id','desc')
            ->paginate(10);
        return view('role.index')->with('roles', $roles);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('role.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $permissions = $this->getPermissions($request);
//       dd($request->all());

        Role::create([
            'name' => $request->get('name'),
            'permissions' => $permissions
        ]);
        flash('You have successfully created a new role');

        return redirect()->route('role.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $update=Role::where('id',$id)->update(['role_status'=>1]);
        $role = Role::findOrFail($id);
        $role->permissions = json_decode($role->permissions);
        return view('role.edit')->withDetails($role)->with('companies', company::all());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $permissions = $this->getPermissions($request);

        Role::findOrFail($id)->update(['permissions' => $permissions, 'name' => $request->name]);

        flash('You have successfully edited the role');
        return redirect()->route('role.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Role $role
     * @return \Illuminate\Http\Response
     * @internal param int $id
     */
    public function destroy(Role $role)
    {
        if ($role->user()->count()) {
            flash('sorry you cannot delete a role with active members');
            return redirect()->back();
        }
        $role->delete();
        flash('You have successfully deleted the role');

       return redirect()->route('role.index');
    }

    private function getPermissions(Request $request)
    {
        return collect($request->get('permissions'))
            ->reject(function ($value) {
                return preg_match('/[0-9]+$/', $value) == 0;
            })
            ->map(function ($value) {
                return (int) $value;
            })
            ->values()
            ->toJson();
    }

}
