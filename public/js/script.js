/* ------------------ MenuBurger ------------------*/
function toggleMenu() {
    var navbarList = document.querySelector('.navbar-list');
    navbarList.classList.toggle('show');
}


/* ------------------ Seance ------------------*/

var seanceContainer = document.querySelector('.seanceContainer');

  // Ajoutez un écouteur d'événements pour le clic
seanceContainer.addEventListener('click', function() {
  toggleDivs();
});

function toggleDivs() {
  var seanceInfo = document.querySelector('.seanceInfo');
  var seanceDesc = document.querySelector('.seanceDesc');

  // Vérifie si div1 est actuellement visible
  if (seanceInfo.style.display !== 'none') {
    seanceInfo.style.display = 'none';
    seanceDesc.style.display = 'block'; // ou 'inline' ou 'inline-block' selon vos besoins
  } else {
    seanceInfo.style.display = 'block'; // ou 'inline' ou 'inline-block'
    seanceDesc.style.display = 'none';
  }
}

/* ------------------ Modal ------------------*/
// $(document).ready(function () {
//   // Lorsque le lien est cliqué
//     $("#ajouterSeance").click(function () {
//       // Afficher la modal
//     $("#modalAddSeance").show();
//     });

//   // Ajouter un écouteur d'événements pour les clics à l'extérieur de la modal
//     $(document).on('mouseup', function (e) {
//         var modal = $("#modalAddSeance");

//       // Vérifier si l'élément cliqué n'est pas à l'intérieur de la modal
//         if (!modal.is(e.target) && modal.has(e.target).length === 0) {
//           // Cacher la modal
//             modal.hide();
//     }
// });
// });

