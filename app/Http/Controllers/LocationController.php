<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Location;
use JWTAuth;
use App\Client;
use Tymon\JWTAuth\Exceptions\JWTException;
class LocationController extends Controller
{
  public function __construct()
  {
      // We set the guard api as default driver
      auth()->setDefaultDriver('client_api');
  }

     public function test(Request $request)
     {
       if ($request->location['title'] == 'value') {
         return response()->json([
           'message' => 'this is a temporary location'
         ], 200);
       }else {
         return response()->json([
           'message'   =>  'this is a new location'
         ], 200);
       }
     }
     /* send the client locations to flutter app */
    public function index(Request $request)
    {
      try {

               if (!$client = JWTAuth::toUser($request->token)) {
                   return response()->json(['code' => 404, 'message' => 'client_not_found']);
               } else {

                   $client = JWTAuth::toUser($request->token);
                   return response()->json(['code' => 200, 'data' => [
                     'locations' => $client->locations
                     ]]);
               }
           } catch (Exception $e) {

               return response()->json(['code' => 404, 'message' => 'Something went wrong']);

           }
    }
    /* store the new location created by the client */
    public function store(Request $request)
    {
      $this->validate($request, [
          'title' => 'required|max:25',
          'lat' => 'required',
          'lang' => 'required'
      ]);
      $token = $request->bearerToken();
      $client = JWTAuth::toUser($token);
      $location = new Location;
      $location->title = $request->title;
      $location->lat = $request->lat;
      $location->lang = $request->lang;
      $location->client_id = $client->id;
      $location->save();
      return response()->json([
        'success'   =>  true,
      ], 200);
    }

    public function update(Request $request)
    {
        $this->validate($request, [
          'title' => 'required|max:25',
          'lat' => 'required',
          'lang' => 'required'
        ]);
        $token = $request->bearerToken();

        try {
          if (!$client = JWTAuth::toUser($token)) { return response()->json(['code' => 404, 'message' => 'client_not_found']); }
          else {
            $location = Location::find($request->id);
            $location->title = $request->title;
            $location->lat = $request->lat;
            $location->lang = $request->lang;
            $location->save();
            return response()->json([ 'location' => $location ]);
          }
        } catch (Exception $e) {return response()->json(['code' => 404, 'message' => 'Something went wrong']);}

    }

    public function destroy(Request $request)
    {

        $location = Location::find($request->id);
        $location->delete();
        return response()->json([
          'success' => 'the location deleted successfully ! '
        ]);
    }
}
