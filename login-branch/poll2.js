document.addEventListener('DOMContentLoaded', () => {
  const showAddPollBtn = document.getElementById('showAddPollBtn');
  const addPollForm = document.getElementById('addPollForm');
  const cancelAddPoll = document.getElementById('cancelAddPoll');

  showAddPollBtn.addEventListener('click', () => {
    addPollForm.style.display = 'block';
    showAddPollBtn.style.display = 'none';
  });

  cancelAddPoll.addEventListener('click', () => {
    addPollForm.style.display = 'none';
    showAddPollBtn.style.display = 'inline-block';
  });
});
// Open and close modal logic
const openModalBtn = document.getElementById('openModalBtn');
const modal = document.getElementById('editModal');
const closeModalBtn = document.getElementById('closeModal');

openModalBtn.addEventListener('click', () => {
    modal.style.display = 'block';
});

closeModalBtn.addEventListener('click', () => {
    modal.style.display = 'none';
});

// Close modal on clicking outside the modal content
window.addEventListener('click', (e) => {
    if (e.target === modal) {
        modal.style.display = 'none';
    }
});

