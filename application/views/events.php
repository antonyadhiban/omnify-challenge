<?php 
echo "<h1>Events</h1>";
// echo "<h1>$count</h1>";

if(isset($events_find_all)){
    foreach ($events_find_all as $each_event){
        echo "<h3>$each_event->name</h3>";
        echo "<p>$each_event->description</p>";
    }
}

// print_r($events_find_all);

// if($ca_data){
//     foreach ($ca_data['items'] as &$each_event) {
//         print_r(array_keys($each_event));
//         print_r("*****************");
//         if(array_key_exists('summary', $each_event)){
//             print_r($each_event['summary']);
//         }
//         // $event_creator = $each_event['creator'];
//         // if($each_event)
//         // print_r($each_event['summary']);
//         if($each_event){
//         print_r($each_event);
//         // print_r($event_creator[0]['displayName']);
//         // echo $each_event['description'];
//         }
//         else
//         echo "<p>no name</p>";
//         // if(in_array('summary', $each_event))
//         // print_r($each_event['created']);
//         // else
//         // print_r("not available");
//         echo "************************************************************\n\n";
//     }
// }

// print_r($ca_data['items']);

?>