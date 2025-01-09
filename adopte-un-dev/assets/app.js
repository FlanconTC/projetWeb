import './styles/app.css';


document.addEventListener("DOMContentLoaded", () => {
    if (window.location.pathname == '/') {

        const dev = document.getElementById("dev");
        const poste = document.getElementById("poste");

        dev.addEventListener("click", () => toggleCheckboxes(dev, poste));
        poste.addEventListener("click", () => toggleCheckboxes(poste, dev));

        function toggleCheckboxes(current, other) {
            if (current.checked) {
                other.checked = false;
            }



            async function fetchUserRoles() {
                try {
                    const response = await fetch('/api/user/role'); // Attendre la réponse
                    const data = await response.json(); // Décoder le JSON
                    const userRoles = data.roles;
            
                    console.log(userRoles); // Affiche les rôles
                    if(!userRoles.role == 'userDev')
                    {
                        const lblFiche = document.getElementById("lblFiche");
                        const choixFiche = document.getElementById("choixFiche");
                        choixFiche.style.display = current == dev ? "block" : "none";
                        lblFiche.style.display = current == dev ? "block" : "none";
                    }
                } catch (error) {
                    console.error("Erreur lors de la récupération des rôles :", error);
                }
            }
            fetchUserRoles();

           
                
         

           
            const labelSalaire = document.getElementById("salaireSouhait");
            labelSalaire.textContent = current == dev ? "Salaire souhaité (max) :" : "Salaire proposé (min) :";

           
            
           
        }

        const button = document.getElementById("valFiltre");
        const ratingInput = document.getElementById("ratingInput");
        const ratingValue = document.getElementById("ratingValue");

        ratingInput.addEventListener("input", () => {
            ratingValue.textContent = ratingInput.value;
        });

        button.addEventListener("click", () => {
            paramOk();
        });
    }
});

function paramOk() {
    const dev = document.getElementById("dev");
    let urlpath = '/date/dev';
    let currentUserIndex = 0;
    let users = [];

    if (!dev.checked) {
        urlpath = '/date/company';
    }

    async function fetchUsers() {
        try {
            const response = await fetch(urlpath);
            const data = await response.json();
            users = data.users;
            showUser(currentUserIndex);
        } catch (error) {
            console.error('Erreur lors de la récupération des utilisateurs :', error);
        }
    }

    function shouldDisplayUser(user) {
        const salaire = document.getElementById("salaire").value;
        const location = document.getElementById("localisation").value;
        const note = document.getElementById("ratingInput").value;
        const tech = document.getElementById("multiSelect");
        const selectedTechnologies = Array.from(tech.selectedOptions).map(option => option.value);
    
        // Vérifier si les technologies sélectionnées sont incluses dans celles de l'utilisateur
        const techMatch = selectedTechnologies.length === 0 || selectedTechnologies.every(tech => user.prog.includes(tech));
    
        // Vérifier si la localisation correspond
        const locationMatch = location === '' || user.location.includes(location);
    
        // Vérifier si la note est suffisante
        const noteMatch = user.note >= note;
    
        // Vérifier le salaire en fonction du type d'utilisateur (dev ou company)
        const devChecked = document.getElementById("dev").checked;
        const salaryMatch = devChecked 
            ? (salaire === '' || user.minS <= parseFloat(salaire)) 
            : (salaire === '' || user.minS >= parseFloat(salaire));
    
        // Retourner true si toutes les conditions sont respectées
        return techMatch && locationMatch && noteMatch && salaryMatch;
    }
    
    function showUser(index) {
        const userContainer = document.getElementById('user-info-container');
        userContainer.innerHTML = ''; // Réinitialise l'affichage
        var head = '';
        var tail = '';
        if (users.length > 0 && index < users.length) {
            const user = users[index];
            if(!document.getElementById("dev").checked)
            {
                head = `<h2><u>${user.nomE}</u></h2>`
                if(user.ftl != "dev")
                {
                   tail = `<button id="next-user-btn" class="btn btn-danger">Swipez</button>`
                }
                else
                {
                    tail = ` <button id="next-user-btn" class="btn btn-danger">Swipez</button><button id="like-user-btn" class="btn btn-success">Jobez</button>`
                }
            }
            else
            {
                head = `<img src="${user.icon ? '/avatars/' + user.icon : '/avatars/empty.png'}" 
                alt="Avatar" 
                class="img-fluid rounded-circle shadow" 
                style="width: 150px; height: 150px;">`
                if(user.ftl == "dev")
                {
                   tail = `<button id="next-user-btn" class="btn btn-danger">Swipez</button>`
                }
                else
                {
                    tail = ` <button id="next-user-btn" class="btn btn-danger">Swipez</button><button id="like-user-btn" class="btn btn-success">Jobez</button>`
                }
            }
            if (shouldDisplayUser(user)) {
                const card = `
                    <div class="card mb-3 shadow-lg">
                        <div class="card-header text-center">
                            `+head+`
                        </div>
                        <div class="card-body text-center">
                            <h5 class="card-title mb-3">${user.nom || 'Nom non renseigné'}</h5>
                            <p class="card-text"><strong>Email :</strong> ${user.email || 'Non disponible'}</p>
                            <p class="card-text"><strong>Localisation :</strong> ${user.location || 'Non renseignée'}</p>
                            <p class="card-text"><strong>Langages :</strong> ${user.prog || 'Non renseignés'}</p>
                            <p class="card-text"><strong>Expérience :</strong> ${user.exp || 'Non renseignée'}</p>
                            <p class="card-text"><strong>Salaire :</strong> ${user.minS ? user.minS + ' €' : 'Non disponible'}</p>
                            <p class="card-text"><strong>Biographie :</strong> ${user.bio || 'Non renseignée'}</p>
                        </div>
                        <div class="card-footer text-center bg-light">
                            `+tail+`
                        </div>
                    </div>`;
                userContainer.innerHTML = card;
                
                document.getElementById('next-user-btn').addEventListener('click', () => {
                    if (currentUserIndex < users.length - 1) {
                        currentUserIndex++;
                        showUser(currentUserIndex);
                    } else {
                        userContainer.innerHTML = `
                            <div class="alert alert-info text-center" role="alert">
                                Vous avez vu toutes les offres.
                            </div>`;
                    }
                });
                document.getElementById('like-user-btn').addEventListener('click', () => {
                    try {
                        const choixFiche = document.getElementById("choixFiche");
                        var $url = `/like/${choixFiche.value}/${user.id}`;
                        const response =  fetch($url);
                        const data = response.json();
                    }
                    catch (error) {
                        console.error('Erreur lors de la récupération des utilisateurs :', error);
                    }
                    if (currentUserIndex < users.length - 1) {
                        currentUserIndex++;
                        showUser(currentUserIndex);
                    } else {
                        userContainer.innerHTML = `
                            <div class="alert alert-info text-center" role="alert">
                                Vous avez vu toutes les offres.
                            </div>`;
                    }
                });
            }
            else
            {
                showUser(index + 1);
            }
        } else {
            userContainer.innerHTML = `<p class="text-center">Aucun utilisateur correspondant aux critères n'a été trouvé.</p>`;
        }
    }
    
    document.getElementById('next-user-btn').addEventListener('click', () => {
        if (currentUserIndex < users.length - 1) {
            currentUserIndex++;
            showUser(currentUserIndex);
        } else {
            document.getElementById('user-nameE').textContent = 'Vous avez vu toutes les offres.';
            document.getElementById('user-name').textContent = '';
            document.getElementById('user-email').textContent = '';
            document.getElementById('user-location').textContent = '' ;
            document.getElementById('user-prog').textContent = '' ;
            document.getElementById('user-exp').textContent = '';
            document.getElementById('user-minS').textContent = '';
            document.getElementById('user-bio').textContent = '';
            document.getElementById('user-icon').src = '/avatars/empty.png' ;
        }
    });

    fetchUsers();
}