
document.addEventListener("DOMContentLoaded", function() {
  // Get the modal
  var modal = document.getElementById("myModal");

  // Get the button that opens the modal
  var ajouterSeance = document.getElementById("ajouterSeance");

  // Get the <span> element that closes the modal
  var span = document.getElementsByClassName("close")[0];

  // When the user clicks the button, open the modal 
  ajouterSeance.onclick = function() {
    modal.style.display = "block";
  }

  // When the user clicks on <span> (x), close the modal
  span.onclick = function() {
    modal.style.display = "none";
  }

  // When the user clicks anywhere outside of the modal, close it
  window.onclick = function(event) {
    if (event.target == modal) {
      modal.style.display = "none";
    }
  }

  // Votre code JavaScript existant va ici
  const categorieSelect = document.getElementById("categorie-select");
  const topicForm = document.getElementById("topic-form");

  categorieSelect.addEventListener("change", function () {
    topicForm.submit();
  });

  // Get all seance cards
  var seanceCards = document.querySelectorAll('.cardSeance');

  // Add click event listener to each seance card
  seanceCards.forEach(function (card) {
    card.addEventListener('click', function () {
      // Get the corresponding seance content
      var seanceContent = card.querySelector('.seanceContent').innerHTML;

      // Show the modal with the seance content
      showModal(seanceContent);
    });
  });

  // Function to show the modal with content
  function showModal(content) {
    // Get the modal
    var modal = document.getElementById("myModal");

    // Get the modal content element
    var modalContent = modal.querySelector(".modal-content");

    // Set the content of the modal
    modalContent.innerHTML = content;

    // Display the modal
    modal.style.display = "block";
  }
});