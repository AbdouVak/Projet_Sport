/* ------------------ MenuBurger ------------------*/
function toggleMenu() {
  var navbarList = document.querySelector('.navbar-list');
  navbarList.classList.toggle('show');
}

$(document).ready(function () {
  $('#openSeanceModal').click(function () {
      $('#seanceModal').addClass('modal-opened').modal('show');
  });
});

document.addEventListener("DOMContentLoaded", function () {
  const container = document.querySelector(".carousel-container");
  const slides = document.querySelectorAll(".carousel-slide");

  let counter = 1;

  function slide() {
      if (counter >= slides.length) counter = 0;
      container.style.transform = "translateX(" + -counter * 100 + "%)";
      counter++;
  }

  setInterval(slide, 3000); // Change slide every 3 seconds (adjust as needed)
});


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

