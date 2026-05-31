/**
 * Script JavaScript pour BioFarm
 * Alignement strict sur les Chapitres 8 & 9 (Structures itératives de base)
 */
document.addEventListener('DOMContentLoaded', function() {
    // Lancement de l'animation d'apparition
    animateProductCards();
});

/**
 * Animation d'apparition progressive des cartes produits
 * Utilise scrupuleusement la boucle FOR classique enseignée au Chapitre 9 (Page 9)
 */
function animateProductCards() {
    let cards = document.querySelectorAll('.card');
    
    // Remplacement de .forEach par la structure de boucle itérative classique du cours
    for (let i = 0; i < cards.length; i++) {
        let card = cards[i];
        
        card.style.opacity = '0';
        card.style.transform = 'translateY(15px)';
        card.style.transition = 'all 0.4s ease';
        
        setTimeout(function() {
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, i * 100);
    }
}