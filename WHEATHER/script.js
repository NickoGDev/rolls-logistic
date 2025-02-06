    let searchCountry = document.querySelector('#search-country');

    let searchCountry1 = document.querySelector('#search-country1');
    let invalidCountry = document.querySelector('#invalid-country');


    searchCountry.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            getData(searchCountry.value, '#weather-city', '#current-time', '#temp', '#min-max-temp', '#wind-direction', '#weather-description', '#weather-icon', '#current-date');
        }
    });

    searchCountry1.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            getData(searchCountry1.value, '#weather-city1', '#current-time1', '#temp1', '#min-max-temp1', '#wind-direction1', '#weather-description1', '#weather-icon1', '#current-date1');
        }
    });

    function getData(value, citySelector, currentTime, tempSelector, minMaxTempSelector, windDirectionSelector, weatherDescriptionSelector, weatherIconSelector, dateSelector) {
        fetch('https://api.openweathermap.org/data/2.5/weather?q=' + value + '&appid=f9686f57321fd566289a625949842429')
            .then(function(response) {
                return response.json();
            })
            .then(function(weather) {
                // API data
                let kelvin = weather.main.temp;
                let minKelvin = weather.main.temp_min;
                let maxKelvin = weather.main.temp_max;
                let windSpeed = weather.wind.speed;
                let weatherDescription = weather.weather[0].description;
                let weatherIconCode = weather.weather[0].icon;
                let timeStamp = weather.dt;

                let timeObject = new Date(timeStamp * 1000);
                let formattedTime = timeObject.toLocaleTimeString(undefined, { hour12: true,
                                                                               hour: 'numeric',
                                                                               minute: 'numeric'
                                                                                });
                // Display
                document.querySelector(citySelector).textContent = weather.name;
                document.querySelector(currentTime).textContent = formattedTime;
                let temp = document.querySelector(tempSelector);
                let minMaxTemp = document.querySelector(minMaxTempSelector);
                document.querySelector(weatherDescriptionSelector).textContent = weatherDescription;
                let windDirection = document.querySelector(windDirectionSelector);
                let weatherIcon = document.querySelector(weatherIconSelector);
                let date = document.querySelector(dateSelector);

                // Date display
                let currentDate = new Date();
                let daysOfWeek = ['Sunday', 'Monday', 'Tuesday', 'Wednesday', 'Thursday', 'Friday', 'Saturday'];
                let monthsOfYear = ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September',
                    'November', 'December'
                ];

            
                let dateObject = new Date (timeStamp * 1000);
                date.textContent = `${daysOfWeek[dateObject.getDay()]}, ${monthsOfYear[dateObject.getMonth()]} ${dateObject.getDate()}, ${dateObject.getFullYear()}`;

                // Convert temperature from Kelvin to Fahrenheit
                function kelvinToFahrenheit(kelvin) {
                    return Math.round((kelvin - 273.15) * 9 / 5 + 32) + "°F";
                }

                temp.textContent = kelvinToFahrenheit(kelvin);
                minMaxTemp.textContent = "Min: " + kelvinToFahrenheit(minKelvin) + " / Max: " + kelvinToFahrenheit(maxKelvin);
                windDirection.textContent = "Wind speed: " + (windSpeed * 3.6).toFixed(2) + " km/h";

                // Set weather icon
                let iconUrl = 'http://openweathermap.org/img/wn/' + weatherIconCode + '.png';
                weatherIcon.src = iconUrl;
                weatherIcon.alt = weatherDescription;

            })
            .catch(function(err) {
                console.log(err);
            });
    }
