document.addEventListener("turbo:load", () => {

    let buttons = document.querySelectorAll("[data-make-reaction]");

    buttons.forEach((button) => {
        button.addEventListener('click', () => {
            fetch(button.dataset.makeReaction, {method: 'POST'})
                .then((response) => {
                    if (response.status === 200) {
                        return response.json();
                    }
                })
                .then((jsonContent) => {
                    // 'add' => utilisateur n'a jamais liké ce message ; la première fois est un 'up'
                    // 'remove' => utilisateur n'a jamais liké ce message ; la première fois est un 'down'
                    // 'remove:update' => utilisateur a liké ce message en "up" ; maintenant il le "down"
                    // 'add:update' => utilisateur a liké ce message en "down" ; maintenant il le "up"
                    console.log(jsonContent);
                });
        });
        button.removeAttribute('data-wishlist'); // Sécurité pour ne pas communiquer d'informations sur nos routes AJAX
    });

});
