<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use JWTAuth;
use App\Client;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Http\Requests\RegisterClientRequest;
class ClientController extends Controller
{

  public function __construct()
  {
      // We set the guard api as default driver
      auth()->setDefaultDriver('client_api');
  }

  /**
       * @var bool
       */
      public $loginAfterSignUp = true;

      /**
       * @param Request $request
       * @return \Illuminate\Http\JsonResponse
       */
  public function login(Request $request)
      {
          $input = $request->only('email', 'password');
          $token = null;

          if (!$token = JWTAuth::attempt($input)) {
              return response()->json([
                  'error' => 'Invalid phone_number or Password',
              ], 401);
          }

          return response()->json([
              'success' => true,
              'token' => $token,
          ]);
      }

///////////////////////////////////////////////////////////////////get client from token
  public function getclient(Request $request)
  {
   try {

            if (!$client = JWTAuth::toUser($request->token)) {
                return response()->json(['code' => 404, 'message' => 'client_not_found']);
            } else {

                $client = JWTAuth::toUser($request->token);
                return response()->json(['code' => 200, 'data' => ['client' => $client]]);
            }
        } catch (Exception $e) {

            return response()->json(['code' => 404, 'message' => 'Something went wrong']);

        }
  }

      /**
       * @param Request $request
       * @return \Illuminate\Http\JsonResponse
       * @throws \Illuminate\Validation\ValidationException
       */
      public function logout(Request $request)
      {
          $this->validate($request, [
              'token' => 'required'
          ]);

          try {
              JWTAuth::invalidate($request->token);

              return response()->json([
                  'success' => true,
                  'message' => 'User logged out successfully'
              ]);
          } catch (JWTException $exception) {
              return response()->json([
                  'success' => false,
                  'message' => 'Sorry, the user cannot be logged out'
              ], 500);
          }
      }

      /**
       * @param RegistrationFormRequest $request
       * @return \Illuminate\Http\JsonResponse
       */
      public function register(RegisterClientRequest $request)
      {
          $client = new Client();
          $client->first_name = $request->first_name;
          $client->last_name = $request->last_name;
          $client->password = bcrypt($request->password);
          $client->gender = $request->gender;
          $client->birthday = $request->birthday;
          $client->phone_number = $request->phone_number;
          $client->address = $request->address;
          $client->email = $request->email;
          $client->save();

          if ($this->loginAfterSignUp) {
              return $this->login($request);
          }

          return response()->json([
              'success'   =>  true,
              'data'      =>  $client
          ], 200);
      }

}
