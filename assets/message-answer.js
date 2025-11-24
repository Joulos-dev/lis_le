

// js qui créé l'event qui réagit au click des bouton ajouter un message,
// qui affiche le form et le place au bon endroit (supprime class hidden + insertion html *closest post* )
function initFormMessage() {
    const buttons = document.querySelectorAll('[data-message-response]');
    buttons.forEach((btn) => {
        const containerForm = document.querySelector('.add-message');
        const form = containerForm.querySelector('form');
        btn.addEventListener('click', () => {
            containerForm.remove();
            form.setAttribute('action', btn.getAttribute('data-message-response'));
            const containerPost = btn.closest('.post');
            containerPost.after(containerForm);
            containerForm.classList.remove('hidden');
        });
    });
}

window.addEventListener('load', () => {
    initFormMessage();
});
