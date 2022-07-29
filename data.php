<?php 

    $url =$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

    if (strpos($url,'demo-data') !== false) {
        $forecastData = json_decode(file_get_contents('defaultForecast.json'),true);
    } else {
        $curl = curl_init();

        curl_setopt_array($curl, array(
        CURLOPT_URL => "https://api.openweathermap.org/data/2.5/onecall?lat=43.2107917&lon=27.9276083&appid=1c318343e6d45307fd2737f8f0f1d179",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
            "cache-control: no-cache"
        ),
        ));
    
        $response = curl_exec($curl);
        $err = curl_error($curl);
    
        curl_close($curl);
    
        $response = json_decode($response, true); //because of true, it's in an array
        $json = json_encode(array('data' => $response));
        file_put_contents("lastForecast.json", $json);
        $forecastData = json_decode(file_get_contents('lastForecast.json'),true);
    }

    foreach ($forecastData as $forecast ) {
    
        //Data 

            //Current Forecast

            $lat = $forecast['lat'];
            $lon = $forecast['lon'];
            $timezone = $forecast['timezone'];
            $timezone_offset = $forecast['timezone_offset'];

            //Current Weather

            $currentForecast = $forecast['current'];
            
            $cur_sunrise = date('H:i:s',($forecast['current']['sunrise'] + $timezone_offset));
            $cur_sunset = date('H:i:s',($forecast['current']['sunset'] + $timezone_offset)); 
            $cur_temp = $forecast['current']['temp'] - 273.15;
            $cur_feels_like = $forecast['current']['feels_like'] - 273.15;
            $cur_pressure = $forecast['current']['pressure'];
            $cur_humidity = $forecast['current']['humidity'];
            $cur_currentTime = date('H:i:s',$forecast['current']['dt']);
        
            //Minutely Forecast 

            $minuteForecast = $forecast['minutely'];

            //Hourly Forecast

            $hourlyForecast = $forecast['hourly'];


            //Daily

            $dailyForecast = $forecast['daily'];

            //Alerts

            $alertsForecast = $forecast['alerts'];
    }

?>