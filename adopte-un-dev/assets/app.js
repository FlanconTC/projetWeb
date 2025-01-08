/*
 * Welcome to your app's main JavaScript file!
 *
 * This file will be included onto the page via the importmap() Twig function,
 * which should already be in your base.html.twig.
 */
import './styles/app.css';

document.addEventListener('DOMContentLoaded', () => {
    let currentUserIndex = 0; 
    let users = []; 

    // Fonction pour récupérer les utilisateurs
    async function fetchUsers() {
        try {
            const response = await fetch('/date');
            const data = await response.json();
            users = data.users; // Stocke les utilisateurs dans le tableau
            showUser(currentUserIndex); // Affiche le premier utilisateur
        } catch (error) {
            console.error('Erreur lors de la récupération des utilisateurs :', error);
        }
    }

    // Fonction pour afficher un utilisateur
    function showUser(index) {
        if (users.length > 0 && index < users.length) {
            const user = users[index];
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

    // Gère l'événement "Suivant"
    document.getElementById('next-user-btn').addEventListener('click', () => {
        // Incrémenter l'index et afficher le suivant
        if (currentUserIndex < users.length - 1) {
            currentUserIndex++;
            showUser(currentUserIndex);
        } else {
            alert('Fin de la liste des utilisateurs!');
        }
    });

    // Récupérer les utilisateurs au démarrage
    fetchUsers();
});
