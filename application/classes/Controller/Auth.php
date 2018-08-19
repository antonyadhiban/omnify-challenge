<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller {
  
	public function action_index()
	{
        // Holds the Google application Client Id, Client Secret and Redirect Url
		require_once __DIR__ . '/../../settings.php';

        require_once __DIR__ . '/../../../modules/google-api-php-client/vendor/autoload.php';

        $events = ORM::factory('event');

        $users = ORM::factory('user');

        $parameter = $_GET['code'];

        $request = Request::factory('https://accounts.google.com/o/oauth2/token')->method(Request::POST)->post(array('code' => $parameter, 'client_id' => CLIENT_ID, 'client_secret' => CLIENT_SECRET, 'redirect_uri' => CLIENT_REDIRECT_URL, 'grant_type' => 'authorization_code'));
        $response = $request->execute();

        $data = json_decode($response, TRUE);

        if(isset($data['refresh_token'])){

            $request_access = Request::factory('https://accounts.google.com/o/oauth2/token')->method(Request::POST)->post(array('client_id' => CLIENT_ID, 'client_secret' => CLIENT_SECRET, 'refresh_token' => $data['refresh_token'],  'grant_type' => 'refresh_token'));
            $response_access = $request_access->execute();

            $data_access = json_decode($response_access, TRUE);

            $request_email = Request::factory('https://www.googleapis.com/oauth2/v1/userinfo')->headers('Authorization', 'Bearer '.$data['access_token']);
            $response_email = $request_email->execute();

            $data_email = json_decode($response_email, TRUE);

            $users->email = $data_email['email'];
            $users->id_token = $data['id_token'];
            $users->refresh_token = $data['refresh_token'];
            $users->save();

        }
        else {
            $request_email = Request::factory('https://www.googleapis.com/oauth2/v1/userinfo')->headers('Authorization', 'Bearer '.$data['access_token']);
            $response_email = $request_email->execute();

            $data_email = json_decode($response_email, TRUE);

            $current_user = ORM::factory('user')->where('email','=',$data_email['email'])->find_all();
        }

        
        $email = $data_email['email'];
        // $current_user = ORM::factory('user')->where('email','=',$email)->find_all();

        // $request_access = Request::factory('https://accounts.google.com/o/oauth2/token')->method(Request::POST)->post(array('client_id' => CLIENT_ID, 'client_secret' => CLIENT_SECRET, 'refresh_token' => $current_user->refresh_token,  'grant_type' => 'refresh_token'));
        // $response_access = $request_access->execute();


        // $this->response->body();

        // $current_user = ORM::factory('user')->where('id_token','=',$data['id_token'])->find_all();
        // $columns = $current_user->as_array('id', 'id_token');
        // $request1 = Request::factory('https://accounts.google.com/o/oauth2/token')->method(Request::POST)->post(array('client_id' => CLIENT_ID, 'client_secret' => CLIENT_SECRET, 'refresh_token' => '$current_user->refresh_token',  'grant_type' => 'refresh_token'));
        // $response1 = $request1->execute();

        // $data_email = json_decode($response_email, TRUE);

        // $this->response->body(print_r($data_email));
        // $this->response->body(print_r($data_email['email']));
        // $this->response->body("$current_user");

        // $response = Request::factory('/events/$email);
        $this->redirect('http://localhost/events/'.$email);
        // $this->response->redirect('/events/$email');
        

    }
}