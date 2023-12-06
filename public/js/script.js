function toggleMenu() {
  var navbarLinks = document.querySelector('.navbar-links');
  if (navbarLinks.style.display === 'flex') {
      navbarLinks.style.display = 'none';
  } else {
      navbarLinks.style.display = 'flex';
  }
}
$(document).ready(function () {
  // Lorsque le lien est cliqué
  $("#ajouterSeance").click(function () {
      // Afficher la modal
      $("#modalAddSeance").show();
  });

  // Ajouter un écouteur d'événements pour les clics à l'extérieur de la modal
  $(document).on('mouseup', function (e) {
      var modal = $("#modalAddSeance");

      // Vérifier si l'élément cliqué n'est pas à l'intérieur de la modal
      if (!modal.is(e.target) && modal.has(e.target).length === 0) {
          // Cacher la modal
          modal.hide();
      }
  });
});

