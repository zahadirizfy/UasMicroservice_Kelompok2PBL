<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cari Rute ke Sekretariat Porlempika</title>
  <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
  <style>
    body {
      margin: 0;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      background-color: #f9f9f9;
    }
    #map {
      height: 70vh;
      width: 100%;
    }
    #form-area {
      padding: 20px;
      background: #fff;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      text-align: center;
    }
    input {
      width: 100%;
      max-width: 500px;
      padding: 10px;
      font-size: 16px;
      border: 1px solid #ddd;
      border-radius: 5px;
    }
    ul#suggestions {
      list-style: none;
      margin: 0 auto;
      padding: 0;
      max-width: 500px;
      text-align: left;
      border: 1px solid #ccc;
      border-radius: 5px;
      background: #fff;
      max-height: 160px;
      overflow-y: auto;
    }
    ul#suggestions li {
      padding: 10px;
      cursor: pointer;
      border-bottom: 1px solid #eee;
    }
    ul#suggestions li:hover {
      background: #f1f1f1;
    }
    #info {
      margin-top: 10px;
      font-size: 16px;
    }
    .btn-kembali {
      margin-top: 20px;
      display: inline-block;
      background-color: #007bff;
      color: #fff;
      padding: 10px 18px;
      border: none;
      border-radius: 5px;
      text-decoration: none;
      font-weight: bold;
      transition: background 0.3s ease;
    }
    .btn-kembali:hover {
      background-color: #0056b3;
    }
  </style>

  <script>
    const ORS_API_KEY = "{{ config('services.ors.key') }}";
    // ambil dari database melalui Blade
    const destination = [{{ $contact->longitude ?? 100.4599084 }}, {{ $contact->latitude ?? -0.9315817 }}];
  </script>
</head>
<body>

<div id="map"></div>

<div id="form-area">
  <h2>🔍 Cari Rute ke Sekretariat Porlempika</h2>
  <input type="text" id="alamat" placeholder="Ketik nama lokasi, contoh: Masjid, Pasar" oninput="cariSaran()" autocomplete="off" />
  <ul id="suggestions"></ul>
  <div id="info">📍 Tujuan: {{ $contact->address ?? 'Komp Sinar Limau Manis D13, Kel. Koto Luar, Kec. Pauh.' }}</div>
  <a href="{{ url('/') }}" class="btn-kembali">⬅ Kembali ke Menu Awal</a>
</div>

<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
const map = L.map('map').setView([destination[1], destination[0]], 13);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
  attribution: '&copy; OpenStreetMap contributors'
}).addTo(map);

L.marker([destination[1], destination[0]]).addTo(map)
  .bindPopup("Sekretariat Porlempika").openPopup();

let userMarker, ruteLayer;

function cariSaran() {
  const keyword = document.getElementById("alamat").value;
  const list = document.getElementById("suggestions");
  list.innerHTML = "";
  if (keyword.length < 3) return;

  fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${encodeURIComponent(keyword + ' Padang')}`)
    .then(res => res.json())
    .then(data => {
      data.slice(0, 5).forEach(item => {
        const li = document.createElement("li");
        li.textContent = item.display_name;
        li.onclick = () => pilihSaran(item);
        list.appendChild(li);
      });
    });
}

function pilihSaran(item) {
  document.getElementById("alamat").value = item.display_name;
  document.getElementById("suggestions").innerHTML = "";
  hitungRute(parseFloat(item.lon), parseFloat(item.lat));
}

function hitungRute(lon, lat) {
  const user = [lon, lat];

  if (userMarker) map.removeLayer(userMarker);
  if (ruteLayer) map.removeLayer(ruteLayer);

  userMarker = L.marker([lat, lon]).addTo(map).bindPopup("Lokasi Anda").openPopup();
  map.fitBounds([[lat, lon], [destination[1], destination[0]]]);

  document.getElementById("info").innerText = "🔄 Menghitung rute...";

  fetch("https://api.openrouteservice.org/v2/directions/driving-car/geojson", {
    method: "POST",
    headers: {
      "Content-Type": "application/json",
      "Authorization": ORS_API_KEY
    },
    body: JSON.stringify({
      coordinates: [user, destination]
    })
  })
  .then(res => res.json())
  .then(data => {
    const coords = data.features[0].geometry.coordinates.map(c => [c[1], c[0]]);
    const distance = data.features[0].properties.summary.distance;
    const duration = data.features[0].properties.summary.duration;

    const km = (distance / 1000).toFixed(2);
    const menit = Math.round(duration / 60);

    ruteLayer = L.polyline(coords, { color: 'blue', weight: 4 }).addTo(map);

    document.getElementById("info").innerHTML = `
      ✅ <b>Jarak:</b> ${km} km<br>
      🕒 <b>Estimasi waktu:</b> ${menit} menit
    `;
  })
  .catch(err => {
    console.error(err);
    document.getElementById("info").innerText = "❌ Gagal menghitung rute.";
  });
}
</script>

</body>
</html>
