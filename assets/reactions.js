// document.addEventListener("turbo:load", () => {
 window.addEventListener("load", () => {
     initReactionButtons(document);
});
// js qui réagit a l'event click sur les pouces pour remplir / vider le svg
// et comptabiliser le nombre de like - le nombre de dislike
// Ceci est en requete AJAX en javascript
// cela permet d'interroguer une route externe ( API ou controller ) , cette route externe
// peut rendre ou non des informations en json, et dans ce cas , cela permet avec la réponse d'actualiser l'html
// en temps réel sans rafraichir la page
//  **tu envoie une requete au serveur php, et le code attend la réponse avant d'executer la suite**
function initReactionButtons(container) {
    let buttons = container.querySelectorAll("[data-make-reaction]");

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            const url = button.dataset.makeReaction

            fetch(url, {method: 'POST'})
                .then((response) => {
                    if (response.status === 200) {
                        return response.json();
                    }
                })
                .then((jsonContent) => {
                    if (jsonContent.login) {
                        // FUTURE sweetAlert
                        // Faire le href dans le confirm de l'alert
                        window.location.href = jsonContent.login;
                    }

                    const containerLikes = document.querySelector('[data-block-likes="'+jsonContent.messageId+'"]');
                    if (containerLikes) {
                        containerLikes.innerHTML = jsonContent.block;
                        // on réinitialise l'html pour que les like et dislike sois a jour et ensuite
                        initReactionButtons(containerLikes);
                        // on repasse dans la méthode pour remettre l'event listener au click sur les boutons
                    }

                });
        });
    });
}
