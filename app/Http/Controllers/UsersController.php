<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests\UserRequest;
use App\Http\Requests\ChangePasswordRequest;
use App\Http\Requests\UserEditRequest;
use App\User;
use App\Role;
use Illuminate\Support\Facades\Validator;
class UsersController extends Controller
{
    protected function index(Request $request){
        $users=User::SearchUserName($request->name)->where('role_id','<>',5)->orderBy('name','ASC')->paginate(10);
       
        return view('admin.users.index')->with('users',$users);
    
    
    }


   protected function create(){
    $roles=Role::orderBy('name','ASC')->pluck('name','id')->ToArray();
    return view('admin.users.create')->with('roles',$roles);
   }


   protected function store(UserRequest $request){
 
    $user=new User($request->all());
    $user->fill($request->all());
    $user->password=bcrypt($request->password);
    $user->status='activo';
     if($request->file('photo')){
                 $file =$request->file('photo');
                 $extension=$file->getClientOriginalName();
                 $path=public_path().'/images/users/';
                 $file->move($path,$extension);
                $user->name_photo=$extension;
                }
     else{
      $user->photo_name='profile.jpg';
     }
    $user->save();
    flash("El usuario ". $user->name . " ha sido creado con éxito" , 'success')->important();
    return redirect()->route('users.index');
      
   }

   public function edit($id){
    $user=User::find($id);
     $roles=Role::orderBy('name','ASC')->pluck('name','id')->ToArray();
        return view('admin.users.edit')->with('user',$user)
                                       ->with('roles',$roles);  
     }
   
   public function update(Request $request,$id){
    
    $user=User::find($id);
    $user->fill($request->all());
   
     if($request->file('photo')){
                 $file =$request->file('photo');
                 $name=$file->getClientOriginalName();
                 if ($name!=$user->photo_name){
                       $path=public_path().'/images/users/';
                       $file->move($path,$name);
                      $user->photo_name=$name;
                    }
          }
    $user->save();
    flash("El usuario ". $user->name . " ha sido modificada/o con exito" , 'success')->important();
     return view('admin.users.perfil');
   }


   public function modifyMyPassword(){
    return view('admin.users.changePassword');
   }


   public function show(){
   return view('admin.users.changePassword');
   
   }

  protected function register(){
    return view('admin.users.register');
  }

   public function changeMyPassword(ChangePasswordRequest $request){
    $user=\Auth::user();
     $user->password=bcrypt($request->newpassword);
     $user->save();
     \Auth::logout();
        
       return redirect()->route('login');
   }
   
   public function profile(){
 
    return view('admin.users.perfil');
   }

   public function editDatas(){
    return view('admin.users.changeDatas');
   }

   public function changeMyDatas(UserEditRequest $request){

   $user=\Auth::user();
  
    $user->fill($request->all());
   
      if($request->file('photo')){
                 $file =$request->file('photo');
                 $name=$file->getClientOriginalName();
                 if ($name!=$user->photo_name){
                       $path=public_path().'/images/users/';
                       $file->move($path,$name);
                      $user->photo_name=$name;
                    }
          }

    $user->save();
    flash("Sus datos se cambiaron correctamente ", 'success')->important();
     
       return redirect()->route('profile');
   
   }

    public function destroy($id)
    {
        User::destroy($id);
        return redirect()->route('users.index');
    }
}