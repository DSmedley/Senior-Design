<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Route;
use Laravel\Passport\CLient;

Class LoginController extends Controller
{
	use IssueTokenTrait;

		private $CLient;

		public function __construct() {
			$this->client = Client::find(1);
		
		}

	public function login(Request $request){

		$this->validate($request, [

				'email' => 'required',
				'password' => 'required'

			]);

			return $this->issueToken($request, 'password');

		}

	public function refresh(Request $request){

		$this->Validate($requenst, [

				'refresh_token' => 'required'
			]);

			return $this->issueToken($request, 'refresh_token');

		}
	public function logout(Request $request){

		$accessToken = Auth::user()->token();

		DB::table('oauth_refresh_tokens')
			->where('access_token_id', $accessToken->id)
			->update(['revoked' => true]);

		$accessToken->revoke();

		return response()->json([], 204);
	
	
	}
}