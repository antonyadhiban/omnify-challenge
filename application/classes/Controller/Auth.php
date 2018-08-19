<?php defined('SYSPATH') or die('No direct script access.');

class Controller_Auth extends Controller {

	public function action_index()
	{
        // Holds the Google application Client Id, Client Secret and Redirect Url
		require_once __DIR__ . '/../../settings.php';

        require_once __DIR__ . '/../../../modules/google-api-php-client/vendor/autoload.php';

        $events = ORM::factory('event');

        $user = ORM::factory('user');
        // try {
        //     //loading model
        //     $myModel = ORM::factory('user')->where('email', '=', $);
        //     //more logic
        //  } catch ($e) { //or you can define exception which throws ORM::factory
        //     //doesn't exist
        //  }
        
        $parameter = $_GET['code'];
        $request1 = Request::factory('https://accounts.google.com/o/oauth2/token')->method(Request::POST)->post(array('code' => $parameter, 'client_id' => CLIENT_ID, 'client_secret' => CLIENT_SECRET, 'redirect_uri' => CLIENT_REDIRECT_URL, 'grant_type' => 'authorization_code'));
        $response1 = $request1->execute();

        $request = Request::factory('https://accounts.google.com/o/oauth2/token')->method(Request::POST)->post(array('client_id' => CLIENT_ID, 'client_secret' => CLIENT_SECRET, 'refresh_token' => '1/gSmgjuOFcjvyF7ah46qMw0JK1wj6j-Kt0UzcZLruxdc',  'grant_type' => 'refresh_token'));
        $response = $request->execute();

        $data = json_decode($response, TRUE);
        $access_token = $data['access_token'];

        $requests = Request::factory('https://www.googleapis.com/calendar/v3/calendars/primary/events/')->headers('Authorization', "Bearer $access_token");
        $responses = $requests->execute();
        $ca_data = json_decode($responses, TRUE);

        // foreach($ca_data['items'] as &$each_event){
        //     $events = ORM::factory('event');
        //     if(isset($each_event['summary']))
        //     $events->name = $each_event['summary'];
        //     if(isset($each_event['description']))
        //     $events->description = $each_event['description'];
        //     $events->save();
        // }
        $events_find_all = ORM::factory('event')->find_all();
        // $event_count = $events_find_all->count();
        $view = View::factory('events')->bind('ca_data', $ca_data)->bind('count', $event_count)->bind('events_find_all', $events_find_all);
        // $view = View::factory('events')->bind('count', $event_count);
    

        
        // $request_cal = Request::factory('https://www.googleapis.com/calendar/v3/calendars/primary/events/')->headers('Authorization', "Bearer $access_token");
        // $response_cal = $request_cal->execute();
        
        // $this->response->body($view);
        $this->response->body("$response1");
    }

} // End Auth

// { "access_token" : "ya29.Glv9BSuXsAoiZZVxO0_d89V574VXxx-JpVYWfNjCUhxNqfBumRYiDVa8eaxMSP7fuuDCWshf6B0kpmZhxDuH3b8ˀ1fbPfZR_gm3OuzY62XAdscvNWoHpO1FEVfyx4", "expires_in" : 3600, "id_token" : "eyJhbGciOiJSUzI1NiIsImtpZCI6ImJhNGFlYWU4YjIwOGFkOWFlMTJiNjYxMDg2NWY2Mzk2MTI4N2I2ZDYifQ.eyJhenAiOiI5ODg1NjgyNTc0NTEtdmxsNmJpbXA2NGM4NzAxamZmbHVxMGNvYjc0ZHI1cmcuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJhdWQiOiI5ODg1NjgyNTc0NTEtdmxsNmJpbXA2NGM4NzAxamZmbHVxMGNvYjc0ZHI1cmcuYXBwcy5nb29nbGV1c2VyY29udGVudC5jb20iLCJzdWIiOiIxMDE0ODUzNzk0MzkyMDIyMDQzNzIiLCJlbWFpbCI6Imd0YWRoaWJAZ21haWwuY29tIiwiZW1haWxfdmVyaWZpZWQiOnRydWUsImF0X2hhc2giOiJDdHdxZXh6aWlKelJTdjF1cmRkMUt3IiwiZXhwIjoxNTM0NTY5NTQzLCJpc3MiOiJhY2NvdW50cy5nb29nbGUuY29tIiwiaWF0IjoxNTM0NTY1OTQzfQ.QeAw-kQBSWKqcj5TWrXxQF7svS990S3taHfOTbpouH2PiFLhPE6QjJtm6p5sbTklST7XEFaRG-qZrPdq9eAFE5HZ8eRd91S4sL58QCrSCa-ffFDJc6USExi2rCcscaJNdENGQ5aqL-vjRgqI7Pl-GzYhiDwmR_HhtZ1pyNjriDC65AasqgoYYCe3EKDBRfXD2l88uF-gwuYzUqh8HOqH9X0WvjmBmqzQtPwUs1eH_w9qfGaKpM1iwUgkfjUkGNMA4h7UpjQHm21V_GcZ5dH00lIDvRCwTNwbRcaiOeangEzahIUPAbj4CRswUDUKjjzDpdXHejdSrWrjEFjh5M1Qew", "refresh_token" : "1/gSmgjuOFcjvyF7ah46qMw0JK1wj6j-Kt0UzcZLruxdc", "scope" : "https://www.googleapis.com/auth/userinfo.profile https://www.googleapis.com/auth/userinfo.email https://www.googleapis.com/auth/calendar https://www.googleapis.com/auth/plus.profile.agerange.read https://www.googleapis.com/auth/plus.profile.language.read https://www.googleapis.com/auth/plus.me", "token_type" : "Bearer" }