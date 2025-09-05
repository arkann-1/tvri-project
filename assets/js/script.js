// ======================================
// Element Selection
// ======================================
const pinBtn = document.getElementById("pinSidebar");
const sidebar = document.getElementById("sidebar");
const searchInput = document.getElementById("searchInput");
const searchBtn = document.getElementById("searchBtn");
const scheduleTable = document.getElementById("scheduleTable");
let currentHighlight = null;

// ======================================
// Sidebar Toggle 📌
// ======================================
if (pinBtn && sidebar) {
    pinBtn.addEventListener("click", (e) => {
        e.stopPropagation();
        sidebar.classList.toggle("collapsed");
        pinBtn.classList.toggle("active");
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
// Search Functionality
// ======================================
function doSearch() {
    const q = searchInput.value.trim().toLowerCase();
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
        const nameCell = foundRow.cells[1];
        if (nameCell) {
            nameCell.classList.add("highlight");
            currentHighlight = nameCell;
        }
        foundRow.scrollIntoView({ behavior: "smooth", block: "center" });
    } else {
        searchInput.focus();
        searchInput.style.transition = "box-shadow .18s";
        searchInput.style.boxShadow = "0 0 0 3px rgba(255,200,0,0.15)";
        setTimeout(() => searchInput.style.boxShadow = "", 500);
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
// Initialize
// ======================================
document.addEventListener("DOMContentLoaded", () => {
    loadTableData();
});
