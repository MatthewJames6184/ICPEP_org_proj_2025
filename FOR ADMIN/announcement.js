document.addEventListener("DOMContentLoaded", () => {
  const announcements = [
    {
      title: "Reminder: Exam Week!",
      content: "Exams start next Monday. Please check your schedule and arrive early."
    },
    {
      title: "School Fair This Friday",
      content: "Don’t miss the school fair! Booths, food, and games from 10am–4pm."
    },
    {
      title: "Library Renovation",
      content: "The library will be closed for renovation until next month. Visit the digital library instead."
    }
  ];

  const container = document.querySelector(".announcement-container");

  function renderAnnouncements() {
    container.innerHTML = ""; // Clear all

    // Main announcement (first one)
    const main = document.createElement("div");
    main.className = "announcement large";
    main.innerHTML = `
      <h2>${announcements[0].title}</h2>
      <p>${announcements[0].content}</p>
      <button class="delete-btn" onclick="deleteAnnouncement(0)">Delete</button>
    `;
    container.appendChild(main);

    // Row for smaller announcements
    const row = document.createElement("div");
    row.className = "announcement-row";

    for (let i = 1; i < announcements.length; i++) {
      const ann = document.createElement("div");
      ann.className = "announcement small";
      ann.innerHTML = `
        <h3>${announcements[i].title}</h3>
        <p>${announcements[i].content}</p>
        <button class="delete-btn" onclick="deleteAnnouncement(${i})">Delete</button>
      `;
      row.appendChild(ann);
    }

    container.appendChild(row);
  }

  window.deleteAnnouncement = function(index) {
    announcements.splice(index, 1);
    renderAnnouncements();
  };

  document.getElementById("addForm").addEventListener("submit", (e) => {
    e.preventDefault();
    const title = document.getElementById("title").value.trim();
    const content = document.getElementById("content").value.trim();

    if (title && content) {
      announcements.push({ title, content });
      renderAnnouncements();
      e.target.reset();
    }
  });

  renderAnnouncements();
});
