<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">

    <title>Himatif Apps</title>

    <!-- Fav Icon -->
    <link rel="icon" href="{{ asset('assets/landing/images/logo-himatif.png') }}" type="image/x-icon">
    <link href="{{ asset('assets/landing/css/apps/cek_khodam.css') }}" rel="stylesheet">
</head>

<body>



    <!-- Content Section -->
    <main>
        @yield('content')
    </main>

    {{-- <div style="text-align: center; margin: 30px 0;">
        <a href="{{ route('home') }}" class="theme-btn btn-one">Back to Homepage</a>
    </div> --}}

     <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script>
    // ==== Data ====
    const KHODAM_NAMES = [
      "Kadal Sakti","Burung Hudhud","Kucing Garong","Monyet Sakti","Ular Naga","Kelinci Ajaib","Tupai Gesit","Katak Beracun","Landak Berduri","Kura-kura Ninja","Harimau Putih","Beruang Kutub","Rubah Ekor Sembilan","Singa Emas","Gajah Biru","Jerapah Terbang","Kangguru Perak","Koala Bermata Satu","Panda Raksasa","Kelelawar Vampir","Burung Merak","Burung Hantu","Burung Kolibri","Burung Bangau","Burung Camar","Ikan Hiu","Ikan Pari","Ikan Mas","Ikan Koi","Ikan Piranha","Laba-laba Tarantula","Kalajengking Raksasa","Lebah Madu","Kupu-kupu Raksasa","Belalang Sembah","Kecoa Terbang","Semut Api","Rayap Pelangi","Kepiting Kenari","Udang Galah","Cacing Besar","Siput Raksasa","Keong Racun","Bekicot Emas","Lipan Biru","Kumbang Badak","Kunang-kunang","Capung Raksasa","Lalat Hijau","Nyamuk Sakti","Kadal Licin","Burung Elang","Kucing Anggora","Monyet Salto","Ular Kobra","Kelinci Terbang","Tupai Ninja","Katak Loncat","Landak Cerdas","Kura-kura Perkasa","Harimau Loreng","Beruang Coklat","Rubah Cerdik","Singa Putih","Gajah Afrika","Jerapah Langit","Kangguru Biru","Koala Lucu","Panda Mini","Kelelawar Gua","Burung Cendrawasih","Burung Kakaktua","Burung Merpati","Burung Pelikan","Burung Nuri","Komodo Perkasa","Orangutan Bijak","Rusa Emas","Babi Hutan Garang","Banteng Liar","Buaya Putih","Berang-berang Cerdas","Landak Jawa","Musang Ajaib","Trenggiling Langka","Kukang Lucu","Tarsius Gesit","Macan Tutul","Kucing Hutan","Ajag Kalimantan","Rusa Timor","Kancil Cerdik","Bekantan Pemalu","Kukabura Cerewet","Angsa Hitam","Merpati Pos","Jalak Bali","Elang Jawa","Merak Hijau","Kuau Kerdil","Sempidan Biru","Trulek Ekor Pita","Pelatuk Jambul","Rangkong Badak","Kakatua Jambul Kuning","Nuri Kepala Hitam","Betet Biasa","Gelatik Jawa","Madu Kelapa","Kuntul Kerbau","Bangau Tongtong","Ikan Belida","Ikan Pesut","Lumba-lumba Hidung Botol","Hiu Martil","Pari Manta","Kura-kura Belimbing","Penyu Sisik","Buaya Muara","Biawak Komodo","Bunglon Raksasa","Tokek Pohon","Ular Sanca Kembang","Ular Welang","Berudu Sakti","Katak Pohon","Bangkong Raksasa","Kodok Buduk","Kosong"
    ];
    const ELEMENTS = [
      { name: 'Api', icon: '🔥' },{ name: 'Air', icon: '💧' },{ name: 'Angin', icon: '🌬️' },{ name: 'Tanah', icon: '⛰️' },{ name: 'Petir', icon: '⚡' },{ name: 'Cahaya', icon: '✨' },{ name: 'Kegelapan', icon: '🌑' }
    ];
    const tierWeights = [{ t:'common',p:.55 },{ t:'rare',p:.25 },{ t:'epic',p:.12 },{ t:'legendary',p:.06 },{ t:'mythic',p:.02 }];

    const stacks = { front:['React','Vue','Svelte','Solid'], back:['Express','Django','Laravel','FastAPI','Spring'], db:['MongoDB','PostgreSQL','MySQL','SQLite','Redis'], extra:['Tailwind','Vite','Docker','Supabase','Prisma'] };

    function xmur3(str){ let h=1779033703^str.length; for(let i=0;i<str.length;i++){ h=Math.imul(h^str.charCodeAt(i),3432918353); h=(h<<13)|(h>>>19);} return function(){ h=Math.imul(h^(h>>>16),2246822507); h=Math.imul(h^(h>>>13),3266489909); return (h^=h>>>16)>>>0; }; }

    function mulberry32(a){ return function(){ let t=(a+=0x6d2b79f5); t=Math.imul(t^(t>>>15),t|1); t^=t+Math.imul(t^(t>>>7),t|61); return ((t^(t>>>14))>>>0)/4294967296; }; }

    function seeded(name){ const seed=xmur3(name)(); return mulberry32(seed); }
    function pickTier(r){ let x=r(); for(const it of tierWeights){ if(x<it.p) return it.t; x-=it.p; } return 'common'; }

    const cap = s => s.charAt(0).toUpperCase()+s.slice(1);
    const pickOne = (arr,r) => arr[Math.floor(r()*arr.length)];
    const pickStack = (r) => `${pickOne(stacks.front,r)} + ${pickOne(stacks.back,r)} + ${pickOne(stacks.db,r)} • ${pickOne(stacks.extra,r)}`;
    function powerFromTier(tier,r){ if(tier==='mythic') return 98 + Math.floor(r()*3); if(tier==='legendary') return 90 + Math.floor(r()*8); if(tier==='epic') return 75 + Math.floor(r()*15); if(tier==='rare') return 55 + Math.floor(r()*20); return 30 + Math.floor(r()*25); }

    const cache = {}; let lastBlob=null, lastCaption='';

    // ==== Flow utama ====
    async function generateKhodamName(){
      const input = document.getElementById('name');
      let name = (input.value||'').trim();
      if(!name) return Swal.fire('Ops','Harap masukkan nama Anda.','info');
      if(name.length<3) return Swal.fire('Ops','Nama terlalu pendek (min. 3 huruf).','info');
      if(/\d/.test(name)) return Swal.fire('Ops','Nama tidak boleh mengandung angka.','info');
      name = cap(name);

      // switch UI: sembunyikan form, tampilkan result
      document.getElementById('stepForm').style.display = 'none';
      document.getElementById('stepResult').style.display = 'block';
      document.getElementById('hello').textContent = `Hai, ${name}`;

      const r = seeded(name);
      const khName = KHODAM_NAMES[Math.floor(r()*KHODAM_NAMES.length)];
      const isEmpty = khName === 'Kosong' || r() < 0.10;
      const tier = isEmpty ? 'common' : pickTier(r);
      const el = ELEMENTS[Math.floor(r()*ELEMENTS.length)];
      const stack = pickStack(r);
      const power = powerFromTier(tier, r);

      document.getElementById('khodamTitle').textContent = isEmpty ? 'Kosong' : khName;
      const pill = document.getElementById('rarityPill'); pill.className = `pill ${tier}`; pill.textContent = `Kelangkaan: ${cap(tier)}`;
      document.getElementById('elementText').textContent = `Elemen: ${el.name} ${el.icon}`;
      document.getElementById('desc').textContent = 'Menanyakan ke alam gaib…';
      document.getElementById('learnGrid').style.display = 'none';
      document.getElementById('powerWrap').style.display = 'block';
      document.getElementById('powerValue').textContent = power;
      document.getElementById('powerBar').style.width = power + '%';
      document.getElementById('stack').textContent = stack;

      if(cache[name]){ renderExplain(cache[name]); return; }

      try{
        Swal.fire({ title: 'Menghubungi alam gaib…', html: 'lagi bisik-bisik ke khodammu…', allowOutsideClick:false, didOpen: ()=>Swal.showLoading() });
        const json = await askGeminiJSON({ name, khodamName: isEmpty?'Kosong':khName, tier, element: el.name });
        cache[name] = json; renderExplain(json);
      }catch(e){
        console.warn(e);
        const fallback = {
          description: `${name} berjiwa ${el.name.toLowerCase()}, lincah dan iseng; ${khName} bikin bug minder dan deadline lebih ramah.`,
          fun_fact: 'Nama lucu memicu retensi memori saat belajar syntax baru.',
          tip: 'Commit kecil tapi sering; pesan singkat “apa & kenapa”.'
        };
        cache[name] = fallback; renderExplain(fallback);
      } finally { Swal.close(); }
    }
    window.generateKhodamName = generateKhodamName;

    function renderExplain(d){
      document.getElementById('desc').textContent = d.description || '—';
      document.getElementById('funFact').textContent = d.fun_fact || '—';
      document.getElementById('tip').textContent = d.tip || d.quick_tip || '—';
      document.getElementById('learnGrid').style.display = 'grid';
    }

    function resetResult(){
      const input=document.getElementById('name');
      input.value='';
      document.getElementById('hello').innerHTML='&nbsp;';
      document.getElementById('khodamTitle').textContent='—';
      const pill=document.getElementById('rarityPill'); pill.className='pill common'; pill.textContent='Kelangkaan: Common';
      document.getElementById('elementText').textContent='Elemen: —';
      document.getElementById('desc').textContent='—';
      document.getElementById('learnGrid').style.display='none';
      const pw=document.getElementById('powerWrap'); if(pw){ pw.style.display='none'; document.getElementById('powerBar').style.width='0%'; document.getElementById('powerValue').textContent='0'; }
      document.getElementById('stack').textContent='—';
      document.getElementById('stepForm').style.display='flex';
      document.getElementById('stepResult').style.display='none';
      lastBlob=null; lastCaption='';
      setTimeout(()=>input.focus(),0);
    }
    window.resetResult = resetResult;

    // ==== Share & Card ====
    function buildCaption(){
      const name = (document.getElementById('hello').textContent.replace('Hai, ','')||'').trim();
      const kh = document.getElementById('khodamTitle').textContent;
      const rarity = document.getElementById('rarityPill').textContent.replace('Kelangkaan: ','');
      const elem = document.getElementById('elementText').textContent;
      const stack = document.getElementById('stack').textContent;
      const power = document.getElementById('powerValue').textContent;
      const desc = document.getElementById('desc').textContent;
      return `Proyeksi Gaib HIMATIF\n\nHai, ${name}\nKhodam: ${kh}\nKelangkaan: ${rarity}\n${elem}\nLucky Stack: ${stack}\nPower Level: ${power}\n\n${desc}\n#HIMATIF #CodingSpirit`;
    }

    function drawCardCanvas(){
      const name = document.getElementById('hello').textContent.replace('Hai, ','');
      const kh = document.getElementById('khodamTitle').textContent;
      const rarity = document.getElementById('rarityPill').textContent.replace('Kelangkaan: ','');
      const elem = document.getElementById('elementText').textContent;
      const desc = document.getElementById('desc').textContent;
      const stack = document.getElementById('stack').textContent;
      const power = document.getElementById('powerValue').textContent;

      const W=1080,H=1920; const c=document.createElement('canvas'); c.width=W; c.height=H; const ctx=c.getContext('2d');
      const grad=ctx.createLinearGradient(0,0,W,H); grad.addColorStop(0,'#0f172a'); grad.addColorStop(1,'#1f2937'); ctx.fillStyle=grad; ctx.fillRect(0,0,W,H);
      ctx.fillStyle='#e5e7eb'; ctx.font='bold 56px Inter, system-ui, sans-serif'; ctx.fillText('Proyeksi Gaib HIMATIF',60,120);
      ctx.fillStyle='#60a5fa'; ctx.font='bold 34px Inter, system-ui, sans-serif'; ctx.fillText(elem,60,170);
      ctx.fillStyle='#ffffff'; ctx.font='bold 72px Inter, system-ui, sans-serif'; wrapText(ctx,`Khodam: ${kh}`,60,260,W-120,78);
      ctx.fillStyle='#cbd5e1'; ctx.font='36px Inter, system-ui, sans-serif'; wrapText(ctx,desc,60,460,W-120,48);
      ctx.fillStyle='#eab308'; ctx.font='bold 34px Inter, system-ui, sans-serif'; ctx.fillText(`Lucky Stack: ${stack}`,60,640);
      ctx.fillStyle='#22d3ee'; ctx.font='bold 34px Inter, system-ui, sans-serif'; ctx.fillText(`Power Level: ${power}`,60,690);
      ctx.fillStyle='#94a3b8'; ctx.font='28px Inter, system-ui, sans-serif'; ctx.fillText('HIMATIF • #CodingSpirit',60,H-120);
      return c;
    }

    function wrapText(ctx,text,x,y,maxWidth,lineHeight){ const words=text.split(' '); let line=''; for(let n=0;n<words.length;n++){ const test=line+words[n]+' '; const w=ctx.measureText(test).width; if(w>maxWidth && n>0){ ctx.fillText(line,x,y); line=words[n]+' '; y+=lineHeight; } else line=test; } ctx.fillText(line,x,y); }

    async function ensureCard(){ if(lastBlob) return; const canvas=drawCardCanvas(); lastBlob=await new Promise(r=>canvas.toBlob(r,'image/png')); lastCaption=buildCaption(); }

    async function downloadCard(){ await ensureCard(); const a=document.createElement('a'); a.download='khodam-card.png'; a.href=URL.createObjectURL(lastBlob); a.click(); }
    async function copyCaption(){ await navigator.clipboard.writeText(buildCaption()); Swal.fire({icon:'success',title:'Teks tersalin!'}); }

    function shareToWhatsApp(){ const text=buildCaption(); window.open(`https://wa.me/?text=${encodeURIComponent(text)}`,'_blank'); }
    function shareToTwitter(){ const text=buildCaption().slice(0,270); window.open(`https://twitter.com/intent/tweet?text=${encodeURIComponent(text)}`,'_blank'); }
    window.downloadCard=downloadCard; window.copyCaption=copyCaption; window.shareToWhatsApp=shareToWhatsApp; window.shareToTwitter=shareToTwitter;

    // ==== Gemini client-side ====
    async function askGeminiJSON({ name, khodamName, tier, element }){
      if(!window.__gemModel) throw new Error('Model Gemini belum siap');
      const prompt = `Tolong hasilkan JSON dengan kunci: description, fun_fact, quick_tip.\n- Bahasa Indonesia lucu & meyakinkan, deskripsi maks 50 kata.\n- Nama: ${name}. Khodam: ${khodamName}. Tier: ${tier}. Elemen: ${element}.\n- fun_fact: 1 kalimat pengetahuan ringan (ngoding/dev tools).\n- quick_tip: 1 kalimat praktis.\nJawab HANYA JSON valid.`;
      const result = await window.__gemModel.generateContent(prompt);
      const text = (result.response && typeof result.response.text === 'function') ? result.response.text() : (result.response?.candidates?.[0]?.content?.parts?.[0]?.text || '');
      const json = safeParseJSON(text); if(!json) throw new Error('JSON tidak valid'); return json;
    }
    function safeParseJSON(s){ try{ const i=s.indexOf('{'), j=s.lastIndexOf('}'); if(i===-1||j===-1) return null; const raw=s.slice(i,j+1).replace(/```json|```/g,''); return JSON.parse(raw);}catch{ return null; } }

    // enter untuk submit
    document.addEventListener('DOMContentLoaded', () => {
      document.getElementById('name').addEventListener('keydown', e=>{ if(e.key==='Enter') generateKhodamName(); });
    });
  </script>

  <!-- Gemini langsung di browser (ingat: key terlihat di front-end) -->
  <script type="module">
    import { GoogleGenerativeAI } from "https://esm.run/@google/generative-ai";
    const API_KEY = "AIzaSyB0DlUxJsagAVrD_l_SOAT9r9L15Eva0RA"; /* <- punyamu */
    const genAI = new GoogleGenerativeAI(API_KEY);
    window.__gemModel = genAI.getGenerativeModel({ model: "gemini-1.5-flash-latest" });
  </script>
</body>

</html>
