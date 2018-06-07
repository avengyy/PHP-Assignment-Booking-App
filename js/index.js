window.addEventListener('load', function() {
  const dropdown = document.querySelector('#open-dropdown');
  const dropdownMenu = document.querySelector('.dropdown');
  if (dropdown) {
    dropdown.addEventListener('click', function() {
      dropdownMenu.classList.toggle('open');
    });
  }
});
