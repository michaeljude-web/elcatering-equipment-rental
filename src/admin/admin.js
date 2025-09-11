document.addEventListener("DOMContentLoaded", () => {
    const modal = document.getElementById("categoryModal");
    const openModal = document.getElementById("openModal");
    const closeModal = document.getElementById("closeModal");
  
    openModal.addEventListener("click", () => {
      modal.classList.remove("hidden");
      modal.classList.add("flex");
      modal.querySelector('input[name="category_name"]').focus();
    });
  
    closeModal.addEventListener("click", () => {
      modal.classList.remove("flex");
      modal.classList.add("hidden");
    });
  
    window.addEventListener("click", (e) => {
      if (e.target === modal) {
        modal.classList.remove("flex");
        modal.classList.add("hidden");
      }
    });
  });