/**
 * Script JavaScript pour BioFarm
 * Fonctionnalités simples pour améliorer l'expérience utilisateur
 */

// Attendre que le DOM soit complètement chargé
document.addEventListener('DOMContentLoaded', function() {
    
    // Animation d'apparition des cartes produits
    animateCards();
    
    // Validation du formulaire d'ajout
    validateForm();
    
    // Gestion des images qui ne se chargent pas
    handleImageErrors();
    
    // Animation de scroll smooth pour les liens
    smoothScroll();
});

/**
 * Animation d'apparition progressive des cartes produits
 */
function animateCards() {
    const cards = document.querySelectorAll('.card');
    
    cards.forEach((card, index) => {
        // Ajouter un délai progressif pour chaque carte
        setTimeout(() => {
            card.style.opacity = '0';
            card.style.transform = 'translateY(20px)';
            card.style.transition = 'all 0.5s ease';
            
            // Animation d'apparition
            setTimeout(() => {
                card.style.opacity = '1';
                card.style.transform = 'translateY(0)';
            }, 100);
        }, index * 100);
    });
}

/**
 * Validation côté client du formulaire d'ajout de produit
 */
function validateForm() {
    const form = document.querySelector('form');
    
    if (form) {
        form.addEventListener('submit', function(e) {
            const nom = document.getElementById('nom');
            const prix = document.getElementById('prix');
            const quantite = document.getElementById('quantite');
            const description = document.getElementById('description');
            
            let isValid = true;
            let errorMessage = '';
            
            // Validation du nom
            if (nom && nom.value.trim().length < 2) {
                errorMessage += 'Le nom du produit doit contenir au moins 2 caractères.\n';
                isValid = false;
            }
            
            // Validation du prix
            if (prix && (prix.value <= 0 || prix.value > 1000)) {
                errorMessage += 'Le prix doit être entre 0.01 DH et 1000 DH.\n';
                isValid = false;
            }
            
            // Validation de la quantité
            if (quantite && (quantite.value < 0 || quantite.value > 10000)) {
                errorMessage += 'La quantité doit être entre 0 et 10000.\n';
                isValid = false;
            }
            
            // Validation de la description
            if (description && description.value.trim().length < 10) {
                errorMessage += 'La description doit contenir au moins 10 caractères.\n';
                isValid = false;
            }
            
            // Si la validation échoue, empêcher l'envoi et afficher les erreurs
            if (!isValid) {
                e.preventDefault();
                alert('Erreurs de validation :\n\n' + errorMessage);
            }
        });
    }
}

/**
 * Gestion des images qui ne se chargent pas
 */
function handleImageErrors() {
    const images = document.querySelectorAll('img');
    
    images.forEach(img => {
        img.addEventListener('error', function() {
            // Remplacer par une image par défaut si l'image ne se charge pas
            this.src = 'images/default-product.jpg';
            this.alt = 'Image non disponible';
            
            // Ajouter une classe pour styliser différemment
            this.classList.add('image-error');
        });
    });
}

/**
 * Scroll fluide pour les liens internes
 */
function smoothScroll() {
    const links = document.querySelectorAll('a[href^="#"]');
    
    links.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href').substring(1);
            const targetElement = document.getElementById(targetId);
            
            if (targetElement) {
                targetElement.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
}

/**
 * Fonction pour formater les prix (utilisable dans d'autres parties)
 */
function formatPrice(price) {
    return new Intl.NumberFormat('fr-FR', {
        minimumFractionDigits: 2,
        maximumFractionDigits: 2
    }).format(price) + ' DH';
}

/**
 * Fonction pour afficher des notifications toast (Bootstrap)
 */
function showToast(message, type = 'success') {
    // Créer un toast Bootstrap dynamiquement
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${type} border-0" role="alert">
            <div class="d-flex">
                <div class="toast-body">
                    ${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        </div>
    `;
    
    // Ajouter le toast au DOM
    const toastContainer = document.querySelector('.toast-container') || createToastContainer();
    toastContainer.insertAdjacentHTML('beforeend', toastHtml);
    
    // Initialiser et afficher le toast
    const toastElement = toastContainer.lastElementChild;
    const toast = new bootstrap.Toast(toastElement);
    toast.show();
    
    // Supprimer le toast après qu'il soit caché
    toastElement.addEventListener('hidden.bs.toast', function() {
        this.remove();
    });
}

/**
 * Créer un conteneur pour les toasts s'il n'existe pas
 */
function createToastContainer() {
    const container = document.createElement('div');
    container.className = 'toast-container position-fixed top-0 end-0 p-3';
    container.style.zIndex = '1055';
    document.body.appendChild(container);
    return container;
}

/**
 * Fonction utilitaire pour déboguer (à supprimer en production)
 */
function debug(message, data = null) {
    if (console && console.log) {
        console.log('🌱 BioFarm Debug:', message, data);
    }
}