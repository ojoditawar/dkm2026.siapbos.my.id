import Chart from "chart.js/auto";

async function loadFinance() {
  const res = await fetch("/finance/summary", { headers: { Accept: "application/json" } });
  if (!res.ok) return;

  const data = await res.json();

  const periodeEl = document.getElementById("periodeLabel");
  if (periodeEl) periodeEl.textContent = `Periode: ${data.periode}`;

  const labels = data.labels ?? [];
  const anggaran = data.anggaran ?? [];
  const realisasi = data.realisasi ?? [];

  const budgetEl = document.getElementById("budgetChart");
  if (budgetEl) {
    new Chart(budgetEl, {
      type: "line",
      data: {
        labels,
        datasets: [
          { label: "Anggaran (Rp)", data: anggaran, tension: 0.3, fill: false },
          { label: "Realisasi (Rp)", data: realisasi, tension: 0.3, fill: false },
        ],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
          tooltip: {
            callbacks: {
              label: (c) => `${c.dataset.label}: Rp ${Number(c.raw).toLocaleString("id-ID")}`,
            },
          },
        },
      },
    });
  }

  const absorption = labels.map((_, i) => {
    const a = Number(anggaran[i] ?? 0);
    const r = Number(realisasi[i] ?? 0);
    return a > 0 ? Math.round((r / a) * 100) : 0;
  });

  const absEl = document.getElementById("absorptionChart");
  if (absEl) {
    new Chart(absEl, {
      type: "bar",
      data: {
        labels,
        datasets: [{ label: "Serapan (%)", data: absorption }],
      },
      options: {
        responsive: true,
        maintainAspectRatio: false,
        scales: { y: { beginAtZero: true, max: 100 } },
        plugins: {
          tooltip: {
            callbacks: {
              label: (c) => `${c.dataset.label}: ${Number(c.raw).toLocaleString("id-ID")}%`,
            },
          },
        },
      },
    });
  }
}

document.addEventListener("DOMContentLoaded", () => {
  // Hanya jalan kalau canvas ada di halaman ini
  if (document.getElementById("budgetChart")) loadFinance().catch(() => {});
});
