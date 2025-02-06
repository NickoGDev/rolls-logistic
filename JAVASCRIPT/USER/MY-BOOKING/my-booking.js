let deleteTriggers = document.querySelectorAll('#delete-trigger');
let deletePrompts = document.querySelectorAll('.delete-prompt-container');
let darkenBody = document.getElementById('darken-body');
let deleteButton = document.getElementById('delete-button');
let cancelButton = document.getElementById('cancel-button');

deleteTriggers.forEach(function(trigger) {
    trigger.addEventListener('click', function(event) {
        event.stopPropagation(); 
        const deleteCounter = trigger.getAttribute('delete-counter');
        const deletePrompt = document.querySelector('[delete-counter="' + deleteCounter + '"]');
        
        if (deletePrompt) {
            toggleRemovePrompt(deletePrompt);
        }
    });
});

document.addEventListener('click', function(event) {
    const target = event.target;

    if (target === darkenBody || target === cancelButton || target.closest('.cancel-btn')) {
        deletePrompts.forEach(function(deletePrompt) {
            hidePrompt(deletePrompt);
        });
        darkenBody.style.display = 'none';
    }
});

function toggleRemovePrompt(prompt) {
    if (isPromptVisible(prompt)) {
        hidePrompt(prompt);
    } else {
        showPrompt(prompt);
    }

    const isAnyPromptVisible = Array.from(deletePrompts).some(function(deletePrompt) {
        return isPromptVisible(deletePrompt);
    });

    darkenBody.style.display = isAnyPromptVisible ? 'flex' : 'none';
}

function isPromptVisible(prompt) {
    return prompt.classList.contains('visible');
}

function showPrompt(prompt) {
    prompt.classList.add('visible');
}

function hidePrompt(prompt) {
    prompt.classList.remove('visible');
}
