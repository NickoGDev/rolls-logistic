let shippingStatusImage = document.getElementById('shipping-statusI');
let shippingStatusText = document.getElementById('shipping-statusT');

let shippingArrivalDateI = document.getElementById('shipping-arrival-dateI');
let shippingArrivalDateT = document.getElementById('shipping-arrival-dateT');

let shippingCurrentLocationI = document.getElementById('shipping-current-locationI');
let shippingCurrentLocationT = document.getElementById('shipping-current-locationT');

let shippingCarrierNameI = document.getElementById('shipping-carrier-nameI');
let shippingCarrierNameT = document.getElementById('shipping-carrier-nameT');

// Receipt pickup and arrival time

let receiptPickupTime = document.getElementById('receipt-pickup-time');
let receiptArrivalTime = document.getElementById('receipt-arrival-time');

// Movement time
let adminTimeFormat = document.querySelectorAll('.admin-time-format');
let updateDelayTime = document.querySelectorAll('#update-delay-time');

// Data's coming from admins

// Old TIME SECTION
let oldPickuptime = document.getElementById('old-pickup-time');
let oldDepartureTime = document.getElementById('old-departure-time');
let oldArrivalTime = document.getElementById('old-arrival-time');
// OLD TIME FORMAT SECTION
let  oldPickupType = document.getElementById('old-pickup-type');
let  oldDepartureType = document.getElementById('old-departure-type');
let  oldArrivalType = document.getElementById('old-arrival-type');

// NEW TIME SECTION
let inputPickupTime = "2";
let inputPickupTimeFormat = "pm"; 

let inputDepartureTime = "7"
let inputDepartureTimeFormat = "am";

let inputArrivalTime = "8";
let inputArrivalTimeFormat = "pm";

let inputShipmentStatus = "On board";


  // Your Display Text

    // PICKUP TIME
    let newPickupTime = document.getElementById('new-time-pickup');
    let newPickupTimeF = document.getElementById('new-time-pickupF');
    let pickupTimeNew = document.getElementById('pickup-time-new');

    // DEPARTURE TIME
    let newTimeDeparture = document.getElementById('new-time-departure');
    let newTimeDepartureF = document.getElementById('new-time-departureF');
    let departureTimeNew = document.getElementById('departure-time-new');

    // ARRIVAL TIME
    let newTimeArrival = document.getElementById('new-time-arrival');
    let newTimeArrivalF = document.getElementById('new-time-arrivalF');
    let arrivalTimeNew = document.getElementById('arrival-time-new')

    // Styling spacing var
    let timeClockCon = document.querySelectorAll('.administrative-section');


    // Shipment Updates
shippingCarrierNameT.textContent = "Booing 9242"

receiptPickupTime.textContent = "Pickup time: 1 pm";
receiptArrivalTime.textContent = "Arrival time 6 pm";

let shipmentStatusD = document.getElementById('shipment-status');

let timeFormatSeperator = document.querySelectorAll('.time-format-seperator');

let shipmentApproved = false;
let shipmentDelay = false;
let shipmentStatus = false;
let shipmentStatusCase = "On board";
let shipmentPending = true;

    
if (shipmentStatus) {
    if(shipmentStatusCase.toLowerCase().trim() === "on board") {
        shipmentStatusD.textContent = "On board";
    } 
}
if(shipmentApproved) {
        administrativeApproved(timeFormatSeperator)
        modifyNewTime(newPickupTime, newTimeDeparture, newTimeArrival,
            newPickupTimeF, newTimeDepartureF, newTimeArrivalF);
            timeFormatSeperator.forEach(seperator=> {
                seperator.classList.add('active');
            })
        const link = document.querySelector('.modification-container');
        link.classList.add('disabled');
        link.addEventListener('click', function(event) {
            event.preventDefault();
        });

        timeFormatSeperator.forEach(orderEle => {
            let updateTimeFormat = orderEle.querySelector('#update-delay-time')
            if(updateTimeFormat) {
            updateTimeFormat.classList.add('order-2');
            }
            })
}
 if(shipmentDelay) {
    administrativeDelay(shippingStatusText, shippingStatusImage, shippingArrivalDateT, shippingArrivalDateI)
    delayTimeStyle(adminTimeFormat, updateDelayTime)
    // Old time setup
    delayOldTime(oldPickuptime, oldDepartureTime, oldArrivalTime,
                    oldPickupType, oldDepartureType, oldArrivalType)
    // new time setup
    modifyNewTime(newPickupTime, newTimeDeparture, newTimeArrival,
        newPickupTimeF, newTimeDepartureF, newTimeArrivalF);
} 
if (shipmentPending) {
    removeImg(shippingStatusImage, 
            shippingArrivalDateI, 
            shippingCurrentLocationI, 
            shippingCarrierNameI);

    adminPending(shippingStatusText, 
                shippingArrivalDateT,
                shippingCurrentLocationT,
                shippingCarrierNameT,
                adminTimeFormat)

                timeFormatSeperator.forEach(seperator=> {
                    seperator.classList.add('active');
                })
} 

// Administrative Delay
function administrativeDelay(shippingStatusText, shippingStatusImage, shippingArrivalDateT, shippingArrivalDateI) {
    
    shippingStatusText.textContent = "Delay";
    shippingStatusImage.src = "../../../IMAGES/GENERAL/delay.png";
    shippingStatusText.classList.add('delay-shipment');

    shippingArrivalDateT.classList = "delay-shipment";
    shippingArrivalDateI.src = "../../../IMAGES/GENERAL/delay.png";
    shippingArrivalDateT.textContent = "Delayed";
} 

function delayOldTime(oldPickupTime, oldDepartureTime, oldArrivalTime,
    oldPickupType, oldDepartureType, oldArrivalType) {
// Update old time
        let attPickupTime = oldPickupTime.getAttribute('old-pickup-time');
        let attDepartureTime = oldDepartureTime.getAttribute('old-departure-time');
        let attArrivalTime = oldArrivalTime.getAttribute('old-arrival-time');

        let attPickupType = oldPickupType.getAttribute('old-pickup-type');
        let attDepartureType = oldDepartureType.getAttribute('old-departure-type');
        let attArrivalType = oldArrivalType.getAttribute('old-arrival-type');

        delayChangeTime(oldPickupTime, attPickupTime, oldPickupType, attPickupType);
        delayChangeTime(oldDepartureTime, attDepartureTime, oldDepartureType, attDepartureType);
        delayChangeTime(oldArrivalTime, attArrivalTime, oldArrivalType, attArrivalType);
}

function modifyNewTime(newPickupTime, newDepartureTime, newArrivalTime,
    newPickupType, newDepartureType, newArrivalType) {

// Update new time
        let attNewPickupTime = newPickupTime.getAttribute('new-time-pickup');
        let attNewDepartureTime = newDepartureTime.getAttribute('new-time-departure');
        let attNewArrivalTime = newArrivalTime.getAttribute('new-time-arrival');

        let attNewPickupType = newPickupType.getAttribute('new-time-pickupF');
        let attNewDepartureType = newDepartureType.getAttribute('new-time-departureF');
        let attNewArrivalType = newArrivalType.getAttribute('new-time-arrivalF');

        delayChangeTime(newPickupTime, attNewPickupTime, newPickupType, attNewPickupType);
        delayChangeTime(newDepartureTime, attNewDepartureTime, newDepartureType, attNewDepartureType);
        delayChangeTime(newArrivalTime, attNewArrivalTime, newArrivalType, attNewArrivalType);
}
// Administrative Pending
function removeImg(shippingStatusImage, shippingArrivalDateI, shippingCurrentLocationI, shippingCarrierNameI) {
    let images = [shippingStatusImage, shippingArrivalDateI, shippingCurrentLocationI, shippingCarrierNameI];
    images.forEach(image => image.style.display = "none");
}
function adminPending(shippingStatusText, shippingArrivalDateT, shippingCurrentLocationT, shippingCarrierNameT,
    adminTimeFormat ) {
    let text = [shippingStatusText, shippingArrivalDateT, shippingCurrentLocationT, shippingCarrierNameT]
    text.forEach(text => {
        text.classList.add("pending-shipment"); 
        text.textContent = "Pending"
    });
    adminTimeFormat.forEach((time, timeFormat, shipmentStatusD) => {
        pendingTimeIcon(time, timeFormat, shipmentStatusD)
    })
}
// Administrative Approved
function administrativeApproved(timeFormatSeperators) {

    timeFormatSeperators.forEach(orderEle => {
    let updateTimeFormat = orderEle.querySelector('#update-delay-time')

    if(updateTimeFormat) {
    updateTimeFormat.classList.add("order-2");
    }
    })
}

// Administrative settle status 
function administrativeStatus(shipmentStatus, shipmentStatusCase) {
    if(shipmentStatusCase.toLowerCase().trim() === "on board");
    shipmentStatus.textContent = "On board";
}



// * Reusable styles

// Pending icon
function pendingTimeIcon(time, timeFormat, shipmentStatusD) {
    time.textContent = "- -";
    timeFormat.textContent = "- -";
    shipmentStatusD.textContent = "- -"
}

function delayChangeTime(   time, attTime,
    timeType, attType) {

    time.textContent = attTime;
    timeType.textContent = attType;
}

function delayTimeStyle(adminTimeFormat) {
    adminTimeFormat.forEach(element => {
        let time = element.querySelector('.administrative-pickup-timeT');
        let timeFormat = element.querySelector('.time-type');
        if(time && timeFormat) {
            time.classList = 'delay-time-matter';
            timeFormat.classList = 'delay-time-matter';
        }
    })

  

    if(inputPickupTime && inputPickupTimeFormat) {
        adjustedTime(newPickupTime, newPickupTimeF, pickupTimeNew,
                    inputPickupTime,  inputPickupTimeFormat);
    }
    if(inputDepartureTime && inputDepartureTimeFormat) {
        adjustedTime(newTimeDeparture, newTimeDepartureF, departureTimeNew,
                    inputDepartureTime, inputDepartureTimeFormat);
    }
    if(inputArrivalTime && inputArrivalTimeFormat) {
        adjustedTime(newTimeArrival, newTimeArrivalF, arrivalTimeNew,
        inputArrivalTime, inputArrivalTimeFormat);
        }

    function adjustedTime(displayTime, displayTimeFormat, displayNewText,
                         inputTime, inputFormat) {

        displayTime.textContent = inputTime;
        displayTimeFormat.textContent = inputFormat;
        displayNewText.textContent = "new";

        timeClockCon.forEach((clockConn) => {
            clockConn.classList.add('active');
        })
        updateDelayTime.forEach(updateDelayTime => {
            updateDelayTime.classList.add('display');
        })
        timeFormatSeperator.forEach(timeFormatSeperator => {
            timeFormatSeperator.classList.add('padding');
        })
    }
   
}


// Weather app

         
let weatherAnalysis= document.getElementById('weather-analysis-container');
let weatherAnalysis1 = document.getElementById('weather-analysis-container1');

let weatherInput = document.getElementById('weather-inputs');
let pickupCountryInput = weatherInput.getAttribute('pickup-country');
let deliveryCountryInput = weatherInput.getAttribute('delivery-country');


countryWeatherState(pickupCountryInput, deliveryCountryInput)
function countryWeatherState(pickupCountryInput, deliveryCountryInput) {
    getData(pickupCountryInput, '#weather-city', '#current-time', '#temp', '#min-max-temp', '#wind-direction', '#weather-description', '#weather-icon', '#current-date', weatherAnalysis);
    getData(deliveryCountryInput, '#weather-city1', '#current-time1', '#temp1', '#min-max-temp1', '#wind-direction1', '#weather-description1', '#weather-icon1', '#current-date1', 
    weatherAnalysis1);
}

function getData(value, citySelector, currentTime, tempSelector, minMaxTempSelector, windDirectionSelector, weatherDescriptionSelector, weatherIconSelector, dateSelector, weatherAnalysis) {
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
            let weatherDescriptionStyle = document.querySelector(weatherDescriptionSelector);
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
            let modifiedWindSpeed = (windSpeed * 3.6).toFixed(2)
            // console.log(modifiedWindSpeed)
            let newlyTimeClock = document.querySelectorAll('.newly-time-clock');
            let testSpeed =  1;

            if (!shipmentDelay 
                && modifiedWindSpeed > 23) {
                // Origal metric is 65
                administrativeDelay(shippingStatusText, shippingStatusImage, shippingArrivalDateT, shippingArrivalDateI)
                
                // Old time setup
                delayOldTime(oldPickuptime, oldDepartureTime, oldArrivalTime,
                                oldPickupType, oldDepartureType, oldArrivalType)
                oldWeatherDelay(adminTimeFormat) 
                function oldWeatherDelay(adminTimeFormat) {
                    adminTimeFormat.forEach(ele => {
                        let time = ele.querySelector('.administrative-pickup-timeT');
                        let timeFormat = ele.querySelector('.time-type');

                        if(time && timeFormat) {
                            time.classList = 'delay-time-matter';
                            timeFormat.classList = 'delay-time-matter';
                        }
                    })
                }
                weatherDescriptionStyle.classList.add('weather-header-notice');
                // new time (weather)setup
                newWeatherDelay(newlyTimeClock);
                function newWeatherDelay(newlyTimeClock) {
                    newlyTimeClock.forEach(ele => {
                        let delayText = ele.querySelector('.new-time-matter');
                        let delayFormat = ele.querySelector('.new-format-matter');
                        if(delayText && delayFormat) {
                            delayText.textContent = "delayed";
                            delayText.classList.add('new-delay-weather')
                            delayFormat.textContent = "";
                        }
                    })}
                // new time here
                
                
                    
                

                // Weather prompt notice    
                  weatherAnalysis.classList.add('active');
                    shipmentApproved = false;
                    console.log(shipmentApproved);
                                    
                    timeFormatSeperator.forEach(orderEle => {
                        let updateTimeFormat = orderEle.querySelector('#update-delay-time')
                        if(updateTimeFormat) {
                        updateTimeFormat.classList.add('order-2');
                        }
                        })
            }
            windDirection.textContent = "Wind speed: " + modifiedWindSpeed + " km/h";

            // Set weather icon
            let iconUrl = 'http://openweathermap.org/img/wn/' + weatherIconCode + '.png';
            weatherIcon.src = iconUrl;
            weatherIcon.alt = weatherDescription;

        })
        .catch(function(err) {
            console.log(err);
        });
}
