let leftSectionDashboard = document.getElementById('left-section-dashboard');
let leftOccupation = leftSectionDashboard.getAttribute('left-section-occupation');


// form links
let adminRegisterLink = document.querySelector('.admin-register');
let adminLoginLink = document.querySelector('.admin-login');

// roll fill
let rollFill = document.getElementById('admin-role-container')

if(leftOccupation.trim().toLowerCase() === "occupied") {
    occupiedAdminRole(adminRegisterLink);
    occupiedAdminRole(adminLoginLink);
} else {
    removeStyleClassList(leftSectionDashboard, 'occupied');
}

// REUSABLE FUNCTIONS
    function styleClassList(className, styleName) {
        className.classList.add(styleName);
    }

    function removeStyleClassList(className, styleName) {
        className.classList.remove(styleName);
    }

    // REMOVING ELEMENT FUNCTIONALITIES
    function occupiedAdminRole(linkBtn) {
        if(linkBtn) {
            styleClassList(leftSectionDashboard, 'occupied');
            
            styleClassList(rollFill, 'active');

            styleClassList(adminRegisterLink, 'underlined');
            styleClassList(adminLoginLink, 'underlined');
            linkBtn.addEventListener('click', function(event) {
                event.preventDefault();
            })
        }
    }
