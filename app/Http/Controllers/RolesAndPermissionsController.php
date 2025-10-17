<?php

namespace App\Http\Controllers;

use App\Http\Resources\RolesAndPermissionResource;
use App\Http\Responses\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller
{

    public function index()
    {
        $roles = Role::with('permissions')->get();

        return ApiResponse::success(RolesAndPermissionResource::collection($roles));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string:255',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            $permissions = $request->permissions;
            $role = Role::create(['name' => $request->get('name')]);

            foreach ($permissions as $permissionName) {
                Permission::firstOrCreate(['name' => $permissionName]);
            }

            $role->syncPermissions($permissions);

            return ApiResponse::success(['message' => 'Role created successfully'], 201);

        } catch (\Exception $e) {
            Log::error('Create  Role', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An error occurred while creating role', 500);
        }

    }


    public function permissions(Request $request)
    {
        return ApiResponse::success(Permission::all());
    }

    public function updatePermissions(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string:255|exists:roles,name',
        ]);

        if ($validator->fails()) {
            return ApiResponse::error('validation error', $validator->errors()->all(), 422);
        }

        try {
            $role = Role::findByName($request->get('name'));
            $role->syncPermissions([]); // remove all permissions
            $role->syncPermissions($request->get('permissions'));

            return ApiResponse::success(['message' => 'Role updated successfully'], 201);


        } catch (\Exception $e) {
            Log::error('Create user Role', ['exception' => $e->getMessage()]);
            return ApiResponse::error('An error occurred while creating role', 500);
        }


    }

}
