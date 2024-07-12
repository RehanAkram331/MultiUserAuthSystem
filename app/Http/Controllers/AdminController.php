<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\AdminService;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use PragmaRX\Google2FALaravel\Support\Google2FA;

class AdminController extends Controller
{
    use AuthorizesRequests;
    protected $adminService;

    public function __construct(AdminService $adminService)
    {
        $this->adminService = $adminService;
    }



    public function dashboard()
    {
        $data = $this->adminService->getDashboardData();
        return view('admin.dashboard', compact('data'));
    }

    public function index(){
        $users = User::all();
        return view('admin.index', compact('users'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function userStore(Request $request)
    {
        // Validate the request data
        $data = $request->validate([
            'user_type' => 'required|string|in:admin,teacher,student',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => [
                'required',
                'string',
                'min:8',
                'confirmed',
                'regex:/[a-z]/',      // must contain at least one lowercase letter
                'regex:/[A-Z]/',      // must contain at least one uppercase letter
                'regex:/[0-9]/',      // must contain at least one digit
                'regex:/[@$!%*#?&]/'  // must contain a special character
            ],
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $this->adminService->storeProfilePicture($request->file('profile_picture'));
        }

        // Use the UserService to create the user
        $user = $this->adminService->createUser($data);

        return redirect()->back()->with('success', ucfirst($data['user_type']) . ' created successfully.');
    }

    public function Profile(){
        $user = Auth::user();
        return view('admin.profile.index', compact('user'));
    }

    public function editProfile()
    {
        $user = Auth::user();
        return view('admin.profile.edit', compact('user'));
    }

    public function edit($type, $id)
    {

        $user = $this->adminService->GetUser($type, $id);
        return view('admin.edit', compact('user', 'type'));
    }

    public function update(Request $request, $id)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'nullable|string|min:8|confirmed',
            'bio' => 'nullable|string',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'user_type' => 'required|string|in:admin,teacher,student',
        ]);

        if ($request->hasFile('profile_picture')) {
            $data['profile_picture'] = $this->adminService->storeProfilePicture($request->file('profile_picture'));
        }

        $this->adminService->UpdateUser($data, $id);
        return redirect()->route($data['user_type'])->with('success', 'User updated successfully.');

    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();
        $this->adminService->updateProfile($user, $request->all());
        activity('profile_update')
        ->causedBy($user)
        ->withProperties(['attributes' => $request->all()])
        ->log('Profile updated');
        return back()->with('success', 'Profile updated successfully.');
    }

    private function getTableName($userType)
    {
        switch ($userType) {
            case 'admin':
                return 'users';
            case 'teacher':
                return 'teachers';
            case 'student':
                return 'students';
            default:
                throw new \InvalidArgumentException('Invalid user type');
        }
    }

    public function check(Request $request){
        $data = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string',
            'id'=>'nullable|numeric',
            'type'=>'nullable|string'
        ]);
        return response()->json($this->adminService->check($data));
    }

    public function destroy($type,$id)
    {
        switch ($type) {
            case 'admin':
                $user = User::findOrFail($id);
                break;
            case 'teacher':
                $user = Teacher::findOrFail($id);
                break;
            case 'student':
                $user = Student::findOrFail($id);
                break;
            default:
                abort(404);
        }
        $user->delete();
        return redirect()->back()->with('success', 'User deleted successfully.');
    }

}
