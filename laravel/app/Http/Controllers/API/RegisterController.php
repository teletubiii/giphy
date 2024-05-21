<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\BaseController as BaseController;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Database\QueryException;



class RegisterController extends BaseController
{
    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'email' => 'required|email|unique:users',
                'password' => 'required',
            ], [
                'email.unique' => 'El correo electrónico ya está en uso.',
            ]);

            if ($validator->fails()) {
                return $this->sendError('Error de validación.', $validator->errors());
            }

            $input = $request->all();
            $input['password'] = bcrypt($input['password']);
            $user = User::create($input);
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['user_id'] = $user->id;

            return $this->sendResponse($success, 'Usuario registrado exitosamente.');
        } catch (QueryException $e) {
            $errorCode = $e->errorInfo[1];
            if ($errorCode == 1062) {
                return $this->sendError('Error de validación.', ['email' => ['El correo electrónico ya está en uso.']]);
            }
            return $this->sendError('Error de servidor.', ['error' => 'Ha ocurrido un error en el servidor. Por favor, inténtelo de nuevo más tarde.']);
        }
    }

    /**
     * Login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request): JsonResponse
    {
        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            $success['token'] =  $user->createToken('MyApp')->accessToken;
            $success['name'] =  $user->name;
            $success['user_id'] = $user->id;

            return $this->sendResponse($success, 'User login successfully.');
        } else {
            return $this->sendError('Verifique el email o la contraseña', ['error' => 'Unauthorized']);
        }
    }
}
