<div id="player" class="ratio ratio-16x9 mb-3 d-none">
  <iframe id="ytFrame" src="" allowfullscreen></iframe>
</div>

<div id="grid" class="row g-3"></div>

<button id="loadMore" class="btn btn-primary mt-3 d-none">Load more</button>

<script>
let nextPageToken = null;

async function loadVideos() {
  const url = new URL('/api/youtube/gallery', window.location.origin);
  if (nextPageToken) url.searchParams.set('pageToken', nextPageToken);

  const res = await fetch(url);
  const data = await res.json();

  const grid = document.getElementById('grid');
  data.items.forEach(v => {
    const col = document.createElement('div');
    col.className = 'col-6 col-md-4 col-lg-3';
    col.innerHTML = `
      <div class="card h-100" style="cursor:pointer">
        <img src="${v.thumb}" class="card-img-top" alt="">
        <div class="card-body p-2">
          <div class="small fw-semibold">${escapeHtml(v.title)}</div>
        </div>
      </div>
    `;
    col.querySelector('.card').onclick = () => play(v.videoId);
    grid.appendChild(col);
  });

  nextPageToken = data.nextPageToken || null;
  const btn = document.getElementById('loadMore');
  btn.classList.toggle('d-none', !nextPageToken);
}

function play(videoId){
  document.getElementById('player').classList.remove('d-none');
  document.getElementById('ytFrame').src = `https://www.youtube.com/embed/${videoId}?rel=0`;
  window.scrollTo({ top: 0, behavior: 'smooth' });
}

function escapeHtml(str){
  return (str || '').replace(/[&<>"']/g, m => ({
    '&':'&amp;','<':'&lt;','>':'&gt;','"':'&quot;',"'":'&#039;'
  }[m]));
}

document.getElementById('loadMore').onclick = loadVideos;
loadVideos();
</script>
