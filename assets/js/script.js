// ======================================
// Element Selection
// ======================================
const pinBtn = document.getElementById("pinSidebar");
const sidebar = document.getElementById("sidebar");
const searchInput = document.getElementById("searchInput");
const searchBtn = document.getElementById("searchBtn");
const scheduleTable = document.getElementById("scheduleTable");
const toggleSidebar = document.getElementById("toggleSidebar");
let currentHighlight = null;

// ======================================
// Sidebar Toggle Desktop 📌
// ======================================
if (pinBtn && sidebar) {
    pinBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        sidebar.classList.toggle("collapsed");
        const main = document.querySelector(".main");
        if (main) main.classList.toggle("collapsed");
    });
}

// ======================================
// Search Helpers
// ======================================
function clearHighlight() {
    if (currentHighlight) {
        currentHighlight.classList.remove("highlight");
        currentHighlight = null;
    }
}

// ======================================
// Search Functionality 🔍
// ======================================
function doSearch() {
    const q = (searchInput?.value || '').trim().toLowerCase();
    clearHighlight();
    if (!q) return;

    const tbody = scheduleTable?.tBodies[0];
    if (!tbody) return;

    const rows = Array.from(tbody.rows);
    let foundRow = null;

    for (const r of rows) {
        const matched = Array.from(r.cells)
            .some(c => c.textContent.toLowerCase().includes(q));
        if (matched) {
            foundRow = r;
            break;
        }
    }

    if (foundRow) {
        // highlight first visible cell (nama)
        const nameCell = foundRow.cells[0] || foundRow.cells[1] || null;
        if (nameCell) {
            nameCell.classList.add("highlight");
            currentHighlight = nameCell;
        }
        foundRow.scrollIntoView({ behavior: "smooth", block: "center" });
    } else {
        if (searchInput) {
            searchInput.focus();
            searchInput.style.transition = "box-shadow .18s";
            searchInput.style.boxShadow = "0 0 0 3px rgba(255,200,0,0.25)";
            setTimeout(() => { if (searchInput) searchInput.style.boxShadow = ""; }, 500);
        }
    }
}

if (searchBtn && searchInput) {
    searchBtn.addEventListener("click", (ev) => {
        ev.preventDefault();
        ev.stopPropagation();
        doSearch();
    });

    searchInput.addEventListener("keydown", (e) => {
        if (e.key === "Enter") {
            e.preventDefault();
            doSearch();
        }
    });
}

// ======================================
// File Button Handling
// ======================================
function initFileButtons() {
    document.querySelectorAll(".file-btn").forEach((btn) => {
        btn.addEventListener("click", (ev) => {
            ev.stopPropagation();
            const input = btn.nextElementSibling;
            if (input && input.type === "file") {
                input.click();
            }
        });
    });
}

// ======================================
// Table Rendering 
// ======================================
function loadTableData() {
    fetch("api.php")
        .then(res => {
            if (!res.ok) throw new Error("HTTP error " + res.status);
            return res.json();
        })
        .then(data => {
            const tbody = document.getElementById("scheduleBody");
            if (!tbody) return;

            tbody.innerHTML = "";

            data.forEach(k => {
                const tr = document.createElement("tr");
                tr.innerHTML = `
                    <td>${k.nip}</td>
                    <td class="name-cell">${k.nama}</td>
                    <td>${k.shift}</td>
                    <td>${k.jam}</td>
                    <td>${k.pekerjaan}</td>
                    <td class="desc-col">
                        <label class="file-input">
                            <span class="file-btn">Choose File</span>
                            <input type="file" accept="image/*,application/pdf" />
                        </label>
                    </td>
                `;
                tbody.appendChild(tr);
            });

            initFileButtons();
        })
        .catch(err => {
            console.error("Gagal memuat data:", err);
        });
}

// ======================================
// Mobile Sidebar Toggle 📱 (CORRECTED)
// ======================================
function setupMobileSidebar() {
    if (!toggleSidebar || !sidebar) return;

    // Pastikan toggle punya z-index lebih rendah daripada sidebar oleh CSS.
    // Di sini hanya toggle kelas active pada sidebar dan body (no-scroll).
    toggleSidebar.addEventListener("click", (e) => {
        e.stopPropagation();
        const wasActive = sidebar.classList.contains("active");

        if (wasActive) {
            sidebar.classList.remove("active");
            document.body.classList.remove("no-scroll");
        } else {
            sidebar.classList.add("active");
            document.body.classList.add("no-scroll");
        }
    });

    // Klik area luar sidebar untuk menutup (UX)
    document.addEventListener("click", (e) => {
        if (
            window.innerWidth <= 768 &&
            sidebar.classList.contains("active") &&
            !sidebar.contains(e.target) &&
            !e.target.closest("#toggleSidebar")
        ) {
            sidebar.classList.remove("active");
            document.body.classList.remove("no-scroll");
        }
    });

    // Tutup sidebar jika resize ke desktop
    window.addEventListener("resize", () => {
        if (window.innerWidth > 768) {
            sidebar.classList.remove("active");
            document.body.classList.remove("no-scroll");
        }
    });
}

// ======================================
// Initialize All
// ======================================
document.addEventListener("DOMContentLoaded", () => {
    loadTableData();
    setupMobileSidebar();
});
