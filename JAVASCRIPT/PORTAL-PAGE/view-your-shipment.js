let bodyShippingSection = document.getElementById('body-shipping-section');

function bodySection(bodySection) {
    if(bodySection.getAttribute('value') === "1") {
        bodySection.style.display = 'none';
    } else {
        bodySection.style.display = 'flex';
    }
}
bodySection(bodyShippingSection);