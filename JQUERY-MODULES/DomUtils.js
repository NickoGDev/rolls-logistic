import FormValidator from "./FormValidator.js";
class DomUtils{
    constructor() {
        this.formValidator = new FormValidator();
    }

    // STYLES MODULE
    addClass($element, $className) {
        $element.addClass($className)
    }
    removeClass($element, $className) {
        $element.removeClass($className)
    }

    
    // DISPLAY TEXT MODULE
    addText($displayText, $message) {
        $displayText.text($message);
    }
    removeText($displayText) {
        $displayText.text('');
    }
}
export default DomUtils;
