// Theme toggle functionality
function toggleTheme() {
    const html = document.documentElement;
    const currentTheme = html.getAttribute('data-theme') || 'dark';
    const themes = ['dark', 'light', 'blue', 'purple'];
    const currentIndex = themes.indexOf(currentTheme);
    const nextIndex = (currentIndex + 1) % themes.length;
    const newTheme = themes[nextIndex];
    html.setAttribute('data-theme', newTheme);
    localStorage.setItem('theme', newTheme);
}

// Load saved theme on page load
document.addEventListener('DOMContentLoaded', function() {
    const savedTheme = localStorage.getItem('theme') || 'dark';
    document.documentElement.setAttribute('data-theme', savedTheme);
});

// Toggle sidebar section
function toggleSection(header) {
    const content = header.nextElementSibling;
    const arrow = header.querySelector('.arrow');
    content.classList.toggle('collapsed');
    arrow.classList.toggle('rotated');
}

// Sidebar item click handler
document.querySelectorAll('.sidebar .item').forEach(item => {
    item.addEventListener('click', function() {
        // Remove active class from all items
        document.querySelectorAll('.sidebar .item').forEach(i => i.classList.remove('active'));
        // Add active class to clicked item
        this.classList.add('active');
    });
});

// Search functionality (basic)
document.querySelector('.search-section button').addEventListener('click', function() {
    const query = document.querySelector('.search-section input').value;
    if (query) {
        alert('Ricerca per: ' + query);
    }
});

// Toggle sidebar for mobile
function toggleSidebar() {
    const sidebar = document.querySelector('.sidebar');
    sidebar.classList.toggle('open');
}

// Close sidebar when clicking outside on mobile
document.addEventListener('click', function(event) {
    const sidebar = document.querySelector('.sidebar');
    const menuIcon = document.querySelector('.menu-icon');
    if (!sidebar.contains(event.target) && !menuIcon.contains(event.target) && window.innerWidth <= 768) {
        sidebar.classList.remove('open');
    }
});

// Show more description
document.querySelectorAll('.show-more').forEach(btn => {
    btn.addEventListener('click', function() {
        const desc = this.previousElementSibling;
        if (desc.style.maxHeight) {
            desc.style.maxHeight = null;
            this.textContent = 'Mostra altro';
        } else {
            desc.style.maxHeight = desc.scrollHeight + 'px';
            this.textContent = 'Mostra meno';
        }
    });
});

// 1. Database finto dei video
const videos = [
    { title: "Come imparare HTML e CSS", channel: "WebDev Ita", views: "10k", time: "2 ore fa", color: "#FF5733" },
    { title: "I segreti di JavaScript", channel: "JS Master", views: "50k", time: "1 giorno fa", color: "#33FF57" },
    { title: "Intervista a un Senior Dev", channel: "Coding Life", views: "120k", time: "5 ore fa", color: "#3357FF" },
    { title: "Recensione MacBook Pro 2026", channel: "Tech Guru", views: "2M", time: "10 min fa", color: "#F333FF" },
    { title: "Cucinare la pasta perfetta", channel: "Chef Online", views: "5k", time: "3 giorni fa", color: "#FFB833" },
    { title: "Viaggio in Giappone 4K", channel: "Traveler", views: "300k", time: "1 ora fa", color: "#33FFF3" }
];

const videoGrid = document.getElementById('videoGrid');
const searchInput = document.getElementById('searchInput');

// 2. Funzione per creare il codice HTML di ogni video
function renderVideos(videoList) {
    videoGrid.innerHTML = ''; // Pulisce la griglia
    
    videoList.forEach(video => {
        const card = `
            <div class="video-card">
                <div class="thumbnail" style="background-color: ${video.color}"></div>
                <div class="video-info">
                    <div class="channel-icon"></div>
                    <div class="text">
                        <h3>${video.title}</h3>
                        <p>${video.channel} • ${video.views} visualizzazioni</p>
                        <p>${video.time}</p>
                    </div>
                </div>
            </div>
        `;
        videoGrid.innerHTML += card;
    });
}

// 3. Logica di ricerca
searchInput.addEventListener('input', (e) => {
    const term = e.target.value.toLowerCase();
    const filtered = videos.filter(v => 
        v.title.toLowerCase().includes(term) || 
        v.channel.toLowerCase().includes(term)
    );
    renderVideos(filtered);
});

// Carica tutti i video all'inizio
renderVideos(videos);