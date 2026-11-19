import * as faceapi from '@vladmandic/face-api/dist/face-api.esm.js';

const root = document.getElementById('face-root');

if (root) {
    const mode = root.dataset.mode;          // 'enroll' atau 'verify'
    const url = root.dataset.url;
    const video = document.getElementById('video');
    const statusEl = document.getElementById('status');
    const btn = document.getElementById('btn');
    const csrf = document.querySelector('meta[name="csrf-token"]').content;
    const setStatus = (t) => (statusEl.textContent = t);
    const opts = new faceapi.TinyFaceDetectorOptions({ inputSize: 320, scoreThreshold: 0.5 });
    let stream;

    async function init() {
        setStatus('Memuat model...');
        await faceapi.tf.ready();
        await faceapi.nets.tinyFaceDetector.loadFromUri('/models');
        await faceapi.nets.faceLandmark68Net.loadFromUri('/models');   
        await faceapi.nets.faceRecognitionNet.loadFromUri('/models');

        stream = await navigator.mediaDevices.getUserMedia({
            video: { width: 480, height: 360, facingMode: 'user' },
        });
        video.srcObject = stream;
        await video.play();

        setStatus('Kamera siap. Hadapkan wajah ke kamera, lalu klik tombol.');
        btn.disabled = false;
    }

    async function sample() {
        const r = await faceapi
            .detectSingleFace(video, opts)
            .withFaceLandmarks()
            .withFaceDescriptor();
        return r ? Array.from(r.descriptor) : null;
    }

    btn.addEventListener('click', async () => {
        btn.disabled = true;
        const n = mode === 'enroll' ? 5 : 1;   // saat daftar: 3 sampel dirata-rata
        const samples = [];

        for (let i = 0; i < n; i++) {
            setStatus(`Mengambil sampel ${i + 1}/${n}...`);
            const d = await sample();
            if (!d) {
                setStatus('Wajah tidak terdeteksi. Pastikan cahaya cukup dan hanya satu wajah.');
                btn.disabled = false;
                return;
            }
            samples.push(d);
            await new Promise((r) => setTimeout(r, 600));
        }

        const avg = samples[0].map((_, i) => samples.reduce((s, d) => s + d[i], 0) / samples.length);

        const res = await fetch(url, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'Accept': 'application/json',
                'X-CSRF-TOKEN': csrf,
            },
            body: JSON.stringify({ descriptor: avg }),
        });
        const data = await res.json().catch(() => ({}));

        if (res.ok && data.ok) {
            setStatus('Berhasil. Mengalihkan...');
            stream?.getTracks().forEach((t) => t.stop());
            window.location.href = data.redirect;
        } else {
            setStatus(data.message || 'Verifikasi gagal.');
            btn.disabled = false;
        }
    });

    init().catch((e) => setStatus('Gagal memulai kamera/model: ' + e.message));
}