// AVOID FORM RESUBMISSION
document.addEventListener('DOMContentLoaded', function() {
      if (window.history.replaceState) {
        window.history.replaceState(null, null, window.location.href);
    }
})




let selectedOptionLabel = document.getElementById('selected-option');
let optionLabels = document.querySelectorAll('.custom-select-options .delicate-type');
let customSelectOptions = document.querySelector('.custom-select-options');
let delicateSelect = document.getElementById('declared-delicate');
let modeTranspoPrice = document.getElementById('mode-transpo');

delicateSelect.addEventListener('change', function () {
    let selectedValue = delicateSelect.value;
    selectedOptionLabel.setAttribute('value', selectedValue);
    selectedOptionLabel.textContent = delicateSelect.options[delicateSelect.selectedIndex].textContent;
});

document.body.addEventListener('click', function (event) {
    if (!customSelectOptions.contains(event.target)) {
        customSelectOptions.style.display = 'none';
    }
});


// CALCULATE BUTTON
function calculateTotalPrice() {
    let itemWeight = parseFloat(document.getElementById('item-weight').value);
    let delicateType = delicateSelect.value;
    let modeTranspoPriceValue = modeTranspoPrice.value; // Corrected variable name
    let totalPrice = 0;

    // Calculate delicateType price
    if (delicateType === 'Sturdy') {
        totalPrice = itemWeight * 45.00;
    } else if (delicateType === 'Fragile') {
        totalPrice = itemWeight * (45.00 + 15.00);
    }

    // Add transportation mode price
    switch (modeTranspoPriceValue) {
        case 'Inland':
            totalPrice += 250.00;
            break;
        case 'Vessel':
            totalPrice += 500.00;
            break;
        case 'Plane':
            totalPrice += 750.00;
            break;
        default:
            // Handle default case if needed
            break;
    }

    // Display the total price
    document.getElementById('display-full-price').textContent = totalPrice.toFixed(2);
    document.getElementById('display-full-price1').textContent = totalPrice.toFixed(2);

    let labelElement = document.getElementById('display-full-price1');
    let inputElement = document.getElementById('shipment-price1');

    let labelText = labelElement.textContent;
    inputElement.value = labelText;
}

document.getElementById('calculate-button').addEventListener('click', function () {
    calculateTotalPrice();
});


/*BOOK VALidation*/
document.addEventListener('DOMContentLoaded', function () {
    document.getElementById('booking-form').addEventListener('submit', function (event) {
        let hasError = false;
        //inputs
        let declaredItem = document.getElementById('declared-items');
        let declaredWeight = document.getElementById('item-weight')
        let declaredDelicate =document.getElementById('declared-delicate');
        let declaredPackage = document.getElementById('declared-package');
        let modeTransport = document.getElementById('mode-transpo')
        let pickupCountry = document.getElementById('pickup-country');
        let pickupAddress = document.getElementById('pickup-address');
        let deliveryCountry = document.getElementById('delivery-country');
        let deliveryAddress = document.getElementById('delivery-address');
        let declaredPickupdate = document.getElementById('declared-pickup');
        let declaredArrival = document.getElementById('declared-arrival');

        // current date
        const currentDate = new Date().toISOString().split('T')[0];
        
        //error prompts
        let errorDeclaredWeight = document.getElementById('error-declared-weight');
        let errorDeclaredItems = document.getElementById('error-declared-items');
        let errorDeclaredDelicate = document.getElementById('error-declared-delicate');
        let errorDeclaredPackage = document.getElementById('error-declared-package');
        let errorModeTranspo = document.getElementById('error-mode-transpo');
        let errorPickupCountry = document.getElementById('error-pickup-country');
        let errorPickupAddress = document.getElementById('error-pickup-address');
        let errorDeliveryCountry = document.getElementById('error-delivery-country');
        let errorDeliveryAddress = document.getElementById('error-delivery-address');
        let errorDeclaredPickupDate = document.getElementById('error-declared-pickup');
        let errorDeclaredArrival = document.getElementById('error-declared-arrival');


        // validation styles & prevent default
        function validationEvent(input, message, errorMessage) {
            input.style.border = '1px solid rgb(240, 66, 66)';
            input.style.boxShadow = "none";
            message.textContent = errorMessage;
            hasError = true;
            return { input, message };
        }
        function removeValidationEvent(input, message) {
            input.style.border = '1px solid lightgray';
            message.textContent = '';
            scrollTo(input)
            return { input, message };

        }
        // invalid hover 
        function scrollTo(input) {
            if (input.value.trim() === '') {
                input.focus();
                setTimeout(() => {
                    window.scrollTo({
                        top: input.offsetTop - 600,
                        behavior: 'smooth'
                    });
                }, 100); 
            }
        }
        
        if (declaredItem.value.trim() === '') {
            const { input } = validationEvent(declaredItem, errorDeclaredItems, 'Declared items must not be empty');
            
            scrollTo(input);
        } else {
            removeValidationEvent(declaredItem, errorDeclaredItems)
        }
    
        if(declaredWeight.value.trim() === "") {
            const { input } = validationEvent(declaredWeight, errorDeclaredWeight, 'Declared weight must not be empty.');
    
            scrollTo(input);
        }  else {
            removeValidationEvent(declaredWeight, errorDeclaredWeight)
        }
    
        if(declaredDelicate.selectedIndex < 1) {
            const {input} = validationEvent(declaredDelicate, errorDeclaredDelicate, 'Declared delicate must pick atleast one.');
          
            scrollTo(input);
        } else {
            removeValidationEvent(declaredDelicate, errorDeclaredDelicate)
        }
    
        if(declaredPackage.selectedIndex < 1) {
            const {input} = validationEvent(declaredPackage, errorDeclaredPackage, 'Declared package must pick atleast one.');
            
            scrollTo(input);
        } else {
            removeValidationEvent(declaredPackage, errorDeclaredPackage)
        }

        if(pickupCountry.selectedIndex < 1) {
            const {input} = validationEvent(pickupCountry, errorPickupCountry, 'Must pick atleast country one.');
          
            scrollTo(input);
        } else {
            removeValidationEvent(pickupCountry, errorPickupCountry)
        }
    
        if(modeTransport.selectedIndex < 1) {
            const {input} = validationEvent(modeTransport, errorModeTranspo, 'Must pick atleast mode of transport one.');
          
            scrollTo(input);
        } else {
            removeValidationEvent(modeTransport, errorModeTranspo)
        }

        if(pickupAddress.value.trim() === "") {
            const {input} = validationEvent(pickupAddress, errorPickupAddress, 'Must not be empty.');
          
            scrollTo(input);
        } else {
            removeValidationEvent(pickupAddress, errorPickupAddress)
        }

        if(deliveryCountry.selectedIndex < 1) {
            const {input} = validationEvent(deliveryCountry, errorDeliveryCountry, 'Must pick atleast country one.');
          
            scrollTo(input);
        } else {
            removeValidationEvent(deliveryCountry, errorDeliveryCountry)
        }

        if(deliveryAddress.value.trim() === "") {
            const {input} = validationEvent(deliveryAddress, errorDeliveryAddress, 'Must not be empty.');
          
            scrollTo(input);
        } else {
            removeValidationEvent(deliveryAddress, errorDeliveryAddress)
        }

        if (declaredPickupdate.value.trim() === "") {
            const { input } = validationEvent(declaredPickupdate, errorDeclaredPickupDate, 'Must set an Pickup date.');
            scrollTo(input);
        } else {
            removeValidationEvent(declaredPickupdate, errorDeclaredPickupDate);
        }

        if (declaredArrival.value.trim() === "") {
            const { input } = validationEvent(declaredArrival, errorDeclaredArrival, 'Must set an arrival date.');
            scrollTo(input);
        } 
        else if(declaredArrival.value.trim() <= currentDate) {
            const { input } = validationEvent(declaredArrival, errorDeclaredArrival, 'Must pick a date after the current date.');
            scrollTo(input);

        } else {
            removeValidationEvent(declaredArrival, errorDeclaredArrival);
        }
        
        if(hasError) {
            console.log('Stoped')
            event.preventDefault();
        } else {
            
        }
    });
});


  


