/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

document.addEventListener("DOMContentLoaded", () => {
    const dev = document.getElementById("dev");
    const poste = document.getElementById("poste");
  
    dev.addEventListener("click", () => toggleCheckboxes(dev, poste));
    poste.addEventListener("click", () => toggleCheckboxes(poste, dev));
    
    function toggleCheckboxes(current, other) 
    {
        if (current.checked) {
            other.checked = false;
        }
        if (current == dev)
        {
            const labelSalaire = document.getElementById("salaireSouhait");
            labelSalaire.textContent = "Salaire souhaité (max) :"
        }
        else
        {
            const labelSalaire = document.getElementById("salaireSouhait");
            labelSalaire.textContent = "Salaire proposé (min) :"
        }
    }
    const button = document.getElementById("valFiltre");
    const ratingInput = document.getElementById("ratingInput");
    const ratingValue = document.getElementById("ratingValue");
  
    // Met à jour la valeur affichée lors du changement
    ratingInput.addEventListener("input", () => {
      ratingValue.textContent = ratingInput.value;
    });

    button.addEventListener("click", () => {
        paramOk();
      });
});

function paramOk()
{
    const dev = document.getElementById("dev"); 
    let urlpath = '/date/dev';
    let currentUserIndex = 0; 
    let users = []; 
    if(!dev.checked)
    {
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

    function showUser(index) {
        document.getElementById('user-name').textContent = '';
        document.getElementById('user-email').textContent = '';
        document.getElementById('user-location').textContent = '' ;
        document.getElementById('user-prog').textContent = '' ;
        document.getElementById('user-exp').textContent = '';
        document.getElementById('user-minS').textContent = '';
        document.getElementById('user-bio').textContent = '';
        document.getElementById('user-icon').src = '/avatars/empty.jpg' ;

        // ici faire les vérification de filtre
        // tech
        // loc
        // salaire
        // note
        // poste/ dev OK

        if (users.length > 0 && index < users.length) 
        {
            const user = users[index];
            const salaire = document.getElementById("salaire"); 
            if(dev.checked)
            {
                if(salaire.value == '' || user.minS <= salaire.value )
                {
                    document.getElementById('user-name').textContent = user.nom ?  'Nom : ' + user.nom : 'Nom non renseigné.';
                    document.getElementById('user-email').textContent = user.email ? 'Email : ' + user.email : 'Email non renseigné.';
                    document.getElementById('user-location').textContent = user.location ?  'Adresse : ' + user.location : 'Adresse non renseignée.' ;
                    document.getElementById('user-prog').textContent = user.prog ? 'Langages de code: ' + user.prog : 'Langages non renseignés.' ;
                    document.getElementById('user-exp').textContent = user.exp ? 'Experience pro : ' + user.exp : 'Experience pro non renseignée.';
                    document.getElementById('user-minS').textContent = user.minS ? 'Salaire minimum voulu : ' + user.minS : 'Salaire min voulu non renseigné.';
                    document.getElementById('user-bio').textContent = user.bio ? 'Biographie : ' + user.bio : 'Biographie non renseignée.';
                    document.getElementById('user-icon').src = '/avatars/' + user.icon ? '/avatars/' + user.icon : '/avatars/empty.jpg' ;
                }
            }
            else
            {
                if(salaire.value == '' || user.minS >= salaire.value)
                {
                    document.getElementById('user-name').textContent = user.nom ?  'Nom : ' + user.nom : 'Nom non renseigné.';
                    document.getElementById('user-email').textContent = user.email ? 'Email : ' + user.email : 'Email non renseigné.';
                    document.getElementById('user-location').textContent = user.location ?  'Adresse : ' + user.location : 'Adresse non renseignée.' ;
                    document.getElementById('user-prog').textContent = user.prog ? 'Langages de code: ' + user.prog : 'Langages non renseignés.' ;
                    document.getElementById('user-exp').textContent = user.exp ? 'Experience pro : ' + user.exp : 'Experience pro non renseignée.';
                    document.getElementById('user-minS').textContent = user.minS ? 'Salaire minimum voulu : ' + user.minS : 'Salaire min voulu non renseigné.';
                    document.getElementById('user-bio').textContent = user.bio ? 'Biographie : ' + user.bio : 'Biographie non renseignée.';
                    document.getElementById('user-icon').src = '/avatars/' + user.icon ? '/avatars/' + user.icon : '/avatars/empty.jpg' ;
                }
            }
        }
    }

    document.getElementById('next-user-btn').addEventListener('click', () => {
        if (currentUserIndex < users.length - 1) {
            currentUserIndex++;
            showUser(currentUserIndex);
        } else {
            alert('Fin de la liste des utilisateurs!');
        }
    });
    fetchUsers();
};