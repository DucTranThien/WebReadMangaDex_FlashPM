<h2>🏆 BẢNG XẾP HẠNG TRUYỆN HOT NHẤT 2025</h2>

<div class="ranking-tabs">
  <button class="tab active" onclick="showTab('week')">Top Tuần</button>
  <button class="tab" onclick="showTab('month')">Top Tháng</button>
  <button class="tab" onclick="showTab('year')">Top Năm</button>
</div>

<div id="ranking-list-container">
  <p class="error" style="color: red;">Lỗi tải bảng xếp hạng.</p>
</div>

<style>
  .tab {
    background: #2c2c2c;
    color: #fff;
    border: none;
    padding: 8px 16px;
    margin: 4px;
    border-radius: 5px;
    cursor: pointer;
  }
  .tab.active {
    background: #ff5722;
    font-weight: bold;
  }
  .ranking-card {
    background: #1f1f1f;
    display: flex;
    padding: 10px;
    margin-bottom: 10px;
    border-radius: 10px;
    gap: 12px;
    box-shadow: 0 2px 6px rgba(0,0,0,0.3);
    transition: transform 0.2s;
    text-decoration: none;
    color: inherit;
  }
  .ranking-card:hover {
    transform: translateY(-2px);
  }
  .ranking-card img {
    width: 85px;
    height: 120px;
    border-radius: 6px;
    object-fit: cover;
  }
  .ranking-card .info {
    flex-grow: 1;
    color: #eee;
  }
  .ranking-card .info h4 {
    margin: 0 0 6px;
    font-size: 16px;
    font-weight: bold;
  }
  .ranking-card .info .meta {
    font-size: 13px;
    color: #bbb;
  }
</style>

<script>
  let currentTab = 'week';
  document.addEventListener('DOMContentLoaded', () => fetchRanking());

  function showTab(tab) {
    document.querySelectorAll('.tab').forEach(btn => btn.classList.remove('active'));
    document.querySelector(`.tab[onclick="showTab('${tab}')"]`).classList.add('active');
    currentTab = tab;
    fetchRanking();
  }

  function fetchRanking() {
    const container = document.getElementById('ranking-list-container');
    container.innerHTML = '<p style="color:#ccc">Đang tải...</p>';

    fetch('/Comic/api/fetch_ranking.php')
      .then(res => res.json())
      .then(json => {
        if (!json || json.result !== 'ok' || !json.ranking || !Array.isArray(json.ranking[currentTab])) {
          container.innerHTML = '<p class="error" style="color: red;">Lỗi tải bảng xếp hạng.</p>';
          return;
        }

        const data = json.ranking[currentTab];
        if (data.length === 0) {
          container.innerHTML = '<p style="color: #aaa;">Không có truyện nào phù hợp.</p>';
          return;
        }

        let html = '';
        data.forEach(m => {
          html += `
            <a href="/Comic/pages/manga_detail.php?id=${m.id}" class="ranking-card">
              <img src="${m.cover}" alt="${m.title}" loading="lazy">
              <div class="info">
                <h4>${m.title}</h4>
                <div class="meta">
                  ⭐ ${m.rating} | 👥 ${m.followed.toLocaleString()}<br>
                  📘 Chương mới cập nhật ${m.chapter_number}<br>
                  🕒 ${timeAgo(m.updatedAt)}
                </div>
              </div>
            </a>`;
        });
        container.innerHTML = html;
      })
      .catch(() => {
        container.innerHTML = '<p class="error" style="color: red;">Lỗi tải bảng xếp hạng.</p>';
      });
  }

  function timeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const diff = Math.floor((now - date) / 1000);

    if (diff < 60) return `${diff} giây trước`;
    if (diff < 3600) return `${Math.floor(diff / 60)} phút trước`;
    if (diff < 86400) return `${Math.floor(diff / 3600)} giờ trước`;
    if (diff < 2592000) return `${Math.floor(diff / 86400)} ngày trước`;
    if (diff < 31536000) return `${Math.floor(diff / 2592000)} tháng trước`;
    return `${Math.floor(diff / 31536000)} năm trước`;
  }
</script>
