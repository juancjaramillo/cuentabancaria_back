<?php

namespace App\Http\Controllers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
	 
	   public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        if (Auth::attempt($credentials)) {
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json(['token' => $token, 'user' => $user], 200);
        }

        return response()->json(['error' => 'Unauthorized'], 401);
    }
	 
	 
	 
	 
    public function index()
    {
        return User::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $inputs=$request->input();
        $inputs["password"]=Hash::make(trim($request->password));  
        $e=User::create($inputs);
        return response()->json([
         'data'=>$e,
         'mensaje'=>" creado con exito.",
 ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    { $e=User::find($id);
        if(isset($e)){
            return response()->json([
                'data'=>$e,
                'mensaje'=>"User encontrado.",
    ]);

        }else{

            return response()->json([
                'error'=>true,
                'mensaje'=>"No existe User.",
    ]);

        }   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $e=User::find($id);
        if(isset($e)){
            $e->first_name=$request->first_name;
            $e->last_name=$request->last_name;
            $e->email=$request->email;
            $e->password=Hash::make($request->password);  
            if($e->save()){
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>"User actualizado.",
        ]);

            }else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>"No se logró actualizar User.",
        ]);

            };
        }else{
                return response()->json([
                    'error'=>true,
                    'mensaje'=>"No existe el User.",
        ]);

        };
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $e=User::find($id);
        if(isset($e)){
            $res=User::destroy($id);
          if($res){
            return response()->json([
                'data'=>$e,
                'mensaje'=>"User Eliminado.",
    ]);
          }else{
                return response()->json([
                    'data'=>$e,
                    'mensaje'=>"No existe el User.",
        ]);

        }
    }else{
        return response()->json([
            'error'=>true,
            'mensaje'=>"No existe el User.",
]);
    };
    }
}
