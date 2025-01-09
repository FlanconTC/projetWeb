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
        document.getElementById('user-name').textContent = '';
        document.getElementById('user-email').textContent = '';
        document.getElementById('user-location').textContent = '';
        document.getElementById('user-prog').textContent = '';
        document.getElementById('user-exp').textContent = '';
        document.getElementById('user-minS').textContent = '';
        document.getElementById('user-bio').textContent = '';
        document.getElementById('user-icon').src = '/avatars/empty.jpg';
        document.getElementById('user-nameE').textContent = '';

        if (users.length > 0 && index < users.length) {
            const user = users[index];
            const affich = shouldDisplayUser(user);

            if (affich) {
                document.getElementById('user-name').textContent = user.nom ? 'Username : ' + user.nom : 'Nom non renseigné.';
                document.getElementById('user-email').textContent = user.email ? 'Email : ' + user.email : 'Email non disponible ou privé".';
                document.getElementById('user-location').textContent = user.location ? 'Localisation : ' + user.location : 'Localisation non renseignée ou privée.';
                document.getElementById('user-prog').textContent = user.prog ? 'Langages : ' + user.prog : 'Langages non renseignés.';
                document.getElementById('user-exp').textContent = user.exp ? 'Experience pro : ' + user.exp : 'Experience pro non renseignée.';
                document.getElementById('user-bio').textContent = user.bio ? 'Biographie : ' + user.bio : 'Biographie non renseignée.';
                document.getElementById('user-icon').src = user.icon ? '/avatars/' + user.icon : '/avatars/empty.jpg';
                document.getElementById('user-minS').textContent = user.minS ? 'Salaire minimum voulu : ' + user.minS : 'Salaire non disponible ou privé.';
            }
            else
            {
                showUser(index + 1);
            }
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
            document.getElementById('user-icon').src = '/avatars/empty.jpg' ;
        }
    });

    fetchUsers();
}
