

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather @ my location</title>
    
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Roboto+Condensed:wght@300;400;700&display=swap" rel="stylesheet">
    
    <script src="jquery-3.6.0.min.js"></script>

    <!-- Owl Carousel Start--> 
   
    <script src="OwlCarousel2/dist/owl.carousel.min.js"></script>
    <script src="scripts.js"></script>
    <link rel="stylesheet" href="OwlCarousel2/dist/assets/owl.carousel.min.css">
    <link rel="stylesheet" href="OwlCarousel2/dist/assets/owl.theme.default.min.css">

    <!-- Owl Carousel End-->

    <link rel="stylesheet" href="style.css">
</head>
<body>


<?php
$url =$_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'];

if (strpos($url,'demo-data') == false && strpos($url,'real-data') == false  ) {?>
    
<div id="pickData">
    <div class="wrapper">
        <a href="?demo-data">use demo data</a> 
        <a href="?real-data">use real data</a>
        <div id="disclaimer"><strong>Note:</strong> Real data is limited for 50 requests daily</div>
    </div>
</div>

<?php
} else {include("data.php"); ?> 
  
    <div id="app-wrapper">
        <!-- Navigation start -->
        <div id="navigation-wrapper">
            <a class="navigation-item" href="#current">Current weather</a>
            <a class="navigation-item" href="#foremin">Forecast by minute</a>
            <a class="navigation-item" href="#forehrs">Forecast by hours</a>
            <a class="navigation-item" href="#foredays">Forecast by days</a>
            <a class="navigation-item" href="#livemap">Live map</a>
        </div>
        <!-- Navigation end -->

        <!-- Current weather start -->
        <div id="current">
                <p class="current weather">
                    It is <strong><?php echo $cur_currentTime ?></strong> EEST<br>
                    The temperature is <strong> <?php echo round($cur_temp); ?>C</strong>, but it feels like <strong> <?php echo round($cur_feels_like) ?>C</strong>. <br>
                    Atmospheric pressure is <strong> <?php echo $cur_pressure; ?> </strong> hPa and the humidity is <strong> <?php echo $cur_humidity;?></strong>. <br>
                    The sunrise
                    <?php if ($cur_currentTime > $cur_sunrise){?>
                    was at
                    <?php } else { ?>
                    will be at
                    <?php } ?>
                    <strong><?php echo $cur_sunrise; ?></strong>
                    and the sunset 
                    <?php if ($cur_currentTime > $cur_sunset){?>
                    was at
                    <?php } else { ?>
                    will be at
                    <?php } ?>
                    <strong><?php echo $cur_sunset;?></strong>
                </p>
            </div>
        <!-- Current weather end -->

        <!-- Forecast by minute start -->
        <div id="foremin">
            <p class="label">Will it rain soon?</p>
            <div id="precipitation-bar-wrapper">
                <div class="precipitation-bar-wrapper owl-carousel owl-theme">
                    <?php   
                        foreach($minuteForecast as $minF){
                            echo "<span class='precipitationBar' style='height:".$minF['precipitation']."%;'> <span class='min-date'>" .  date('H:i',$minF['dt']) . "</span> <span class='min-percent'>" .  $minF['precipitation'] . "%</span></span>";   
                        }
                    ?>
                </div>
            </div>
        </div>
        <!-- Forecast by minute end -->

        <!-- Forecast by hours start -->
        <div id="forehrs">
                <p class="label">Forecast by hours</p>
                    <div id="hrs-wrapper">
                        <div class="hrs-wrapper owl-carousel owl-theme">
                            <?php    
                                foreach($hourlyForecast as $hrsF){
                                    $hrs_weather='';
                                    foreach($hrsF['weather'] as $weather){$hrs_weather=$weather['description'];}
                                    echo '
                                    <div class="hrs-block-wrapper">
                                    <div class="hrs-block item">
                                        <p class="hrs-time">'.date('H:i',($hrsF['dt'] + $timezone_offset)).'</p>
                                        <div class="hrs-temp-wrap">
                                            <p class="hrs-temp">'.round($hrsF['temp']- 273.15).'C<br><span class="label">Real Temperature</span></p>
                                            <p class="hrs-temp">'.round($hrsF['feels_like']- 273.15).'C<br><span class="label">Feels like</span></p>
                                        </div>
                                        <p class="hrs-weather">'.$hrs_weather.'<br></p>
                                        <p class="hrs-wind">'.$hrsF['wind_speed'].'m/s<br><span class="label">Winds</span></p>
                                        <p class="hrs-clouds">'.$hrsF['clouds'].'%<br><span class="label">Clouds</span></p>
                                        <p class="hrs-humidity">'.$hrsF['humidity'].'%<br><span class="label">Humidity</span></p>
                                        
                                    </div>
                                    </div>
                                    ';   
                                }
                            ?>
                        </div>
                    </div>
        </div>
        <!-- Forecast by hours end -->

        <!-- Forecast by days start -->
        <div id="foredays">
            <p class="label">Forecast by days</p>
            <div id="days">
                        <div class="day-wrapper owl-carousel owl-theme">
                            <?php    
                                foreach($dailyForecast as $dayF){
                                    $day_weather='';
                                    foreach($dayF['weather'] as $weather){
                                        $day_weather=$weather['description'];
                                    }
                                    echo '<div class="day-block-wrapper"><div class="day-block">
                                            <div class="day-weather">
                                                <p class="day-time">'.date('d F - (D)',($dayF['dt'] + $timezone_offset)).'</p>              
                                            </div>
                                            <div class="day-temp-wrapper">';

                                                echo '<span class="day-temp">' . round($dayF['temp']['day']-273.15) . 'C<br><span class="label">Daily</span></span>';
                                                echo '<span class="day-temp">' . round($dayF['temp']['min']-273.15) . 'C<br><span class="label">Min</span></span>';
                                                echo '<span class="day-temp">' . round($dayF['temp']['max']-273.15) . 'C<br><span class="label">Max</span></span>';
                                                echo '<span class="day-temp">' . round($dayF['temp']['night']-273.15) . 'C<br><span class="label">Night</span></span>';
                                                echo '<span class="day-temp">' . round($dayF['temp']['eve']-273.15) . 'C<br><span class="label">Evening</span></span>';
                                                echo '<span class="day-temp">' . round($dayF['temp']['morn']-273.15) . 'C<br><span class="label">Morning</span></span>';
                                                
                                            echo '</div>';
                                            
                                            echo '<div class="day-feels-wrapper"> <span class="title">Feels like</span>';
                                                echo '<span class="day-temp">' . round($dayF['feels_like']['day']-273.15) . 'C<br><span class="label">Daily</span></span>';
                                                echo '<span class="day-temp">' . round($dayF['feels_like']['night']-273.15) . 'C<br><span class="label">Night</span></span>';
                                                echo '<span class="day-temp">' . round($dayF['feels_like']['eve']-273.15) . 'C<br><span class="label">Evening</span></span>';
                                                echo '<span class="day-temp">' . round($dayF['feels_like']['morn']-273.15) . 'C<br><span class="label">Morning</span></span>'; 
                                            echo '</div>';

                                            //Close the div
                                    echo '</div></div>';
                                }
                            ?>
                        </div>
                    </div>
        </div>
        <!-- Forecast by days end -->

        <!-- Live map start -->
        <div id="livemap">
            <p class="label">Livemap around me</p>
            <div class="livemap-wrapper">
                <iframe src="https://openweathermap.org/weathermap?basemap=map&cities=true&layer=temperature&lat=43.2210&lon=27.9708&zoom=5" width="80%" height="800px" allow-top-navigation="false" title="Weather @ my place"></iframe>
            </div>
        </div>
        <!-- Live map end -->
    </div>
   <?php } ?>
    
    


    
</body>
</html>