// document.addEventListener("turbo:load", () => {
 window.addEventListener("load", () => {
     initReactionButtons(document);
});


// js qui réagit a l'event click sur les pouces pour remplir / vider le svg
// et comptabiliser le nombre de like - le nombre de dislike
// Ceci est en requete AJAX (requete asynchrone HTTP ) qui permet d'actualiser la page sans la rafraichir
function initReactionButtons(container) {
    let buttons = container.querySelectorAll("[data-make-reaction]");

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            fetch(button.dataset.makeReaction, {method: 'POST'})
                .then((response) => {
                    if (response.status === 200) {
                        return response.json();
                    }
                })
                .then((jsonContent) => {
                    if (jsonContent.login) {
                        // TODO : faire ton sweetalert ici pour indiquer la connection nécessaire
                        // Faire le href dans le confirm de l'alert
                        window.location.href = jsonContent.login;
                    }

                    const containerLikes = document.querySelector('[data-block-likes="'+jsonContent.messageId+'"]');
                    if (containerLikes) {
                        containerLikes.innerHTML = jsonContent.block;
                        initReactionButtons(containerLikes);
                    }

                });
        });
    });
}
