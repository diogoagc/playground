<!doctype html>
<html lang="en">
<head>
<meta charset="utf-8" />
<title>Arcade Synth — Seeded Music</title>
<meta name="viewport" content="width=device-width, initial-scale=1" />
<style>
  :root{
    --bg:#0b0e13; --cab:#121722; --bezel:#0e131d; --screen:#0a111b; --ink:#dbe7ff;
    --accent:#ff3b30; --lime:#50ffb2; --aqua:#57d0ff; --vio:#b28bff; --yellow:#ffe56f;
  }
  *{box-sizing:border-box}
  body{margin:0; background:
       radial-gradient(1000px 600px at 10% -10%, #0d1521, #0b0e13 60%),
       radial-gradient(900px 700px at 130% 20%, #10192a, transparent 40%);
       color:var(--ink); font-family: "Inter", ui-rounded, system-ui, -apple-system, Segoe UI, Roboto, sans-serif;}
  .wrap{max-width:1100px; margin:40px auto; padding:0 16px;}
  .cabinet{
    background:linear-gradient(180deg,#151b2a,#0e1624);
    border-radius:24px; box-shadow: 0 30px 80px rgba(0,0,0,.55), inset 0 0 0 2px #0008;
    padding:18px; position:relative;
  }
  .marquee{
    border-radius:16px; padding:12px; background:
      linear-gradient(180deg,#0b1321,#060c14);
    box-shadow: inset 0 0 0 1px #22314a, 0 0 50px #00f6ff08;
  }
  .marquee .brand{font-weight:900; letter-spacing:.3px; color:#8ec9ff; text-transform:uppercase;}
  .seedbar{
    margin-top:10px; display:grid; grid-template-columns:1fr auto; gap:10px;
    background:linear-gradient(180deg,#0a111b,#050a11); border-radius:12px; padding:10px 12px;
    box-shadow: inset 0 0 0 1px #1f2c43, 0 0 30px #00ffff10;
  }
  .seedbox{
    display:flex; gap:8px; align-items:center; background:#02070f; border-radius:10px; padding:8px 10px;
    box-shadow: inset 0 0 0 1px #173351;
  }
  .seedbox label{font-size:.85rem; color:#80a8d1; letter-spacing:.2px}
  #seed{
    flex:1; border:none; outline:none; background:transparent; color:#eaf3ff; font-size:1.05rem; letter-spacing:.2px;
  }
  /* Toggle switch */
  .toggle{
    display:flex; align-items:center; gap:10px;
    background:#02070f; border-radius:10px; padding:8px 10px; box-shadow: inset 0 0 0 1px #173351;
  }
  .switch{
    width:56px; height:30px; border-radius:999px; background:#0a141f; position:relative;
    box-shadow: inset 0 0 0 1px #29415e;
  }
  .knob{
    position:absolute; top:3px; left:3px; width:24px; height:24px; border-radius:50%;
    background:linear-gradient(180deg,#fff,#bde1ff); box-shadow:0 2px 6px #0008;
    transition:left .18s ease;
  }
  .switch.on .knob{ left:29px; }
  .lamp{width:10px; height:10px; border-radius:50%; background:#54222a; box-shadow:0 0 10px transparent;}
  .lamp.on{background:#61ffa9; box-shadow:0 0 12px #61ffa9;}

  /* Play surface */
  .surface{
    margin-top:16px; display:grid; grid-template-columns:1fr 420px; gap:16px;
  }
  .screen{
    background: radial-gradient(800px 280px at 50% -30%, #0af 0, #05101e 70%), var(--screen);
    border-radius:16px; padding:14px; box-shadow: inset 0 0 0 1px #1a2d47, 0 0 80px #00b7ff12;
    display:flex; flex-direction:column; gap:10px;
  }
  .meta{font-size:.92rem; color:#97bfe9; display:flex; justify-content:space-between; align-items:center;}
  .dial{position:relative; height:54px; border-radius:12px; background:linear-gradient(180deg,#0a1421,#07101b);
        box-shadow: inset 0 0 0 1px #21324b;}
  .tick{position:absolute; top:8px; bottom:8px; width:2px; background:#244469;}
  .needle{position:absolute; top:0; bottom:0; width:3px; background:var(--yellow); box-shadow:0 0 10px var(--yellow);}

  .controls{
    background:linear-gradient(180deg,#0a1421,#060c15);
    border-radius:16px; padding:12px; display:grid; grid-template-columns:repeat(4,1fr); gap:10px;
    box-shadow: inset 0 0 0 1px #1b2c45;
  }
  /* Arcade buttons */
  .btn{
    border:none; border-radius:14px; padding:12px 10px; cursor:pointer; font-weight:900; letter-spacing:.5px; color:#0a0d12;
    text-transform:uppercase; box-shadow: 0 4px 0 #0007, inset 0 0 0 1px #0003;
  }
  .btn:active{transform: translateY(1px)}
  .btn-red{ background: radial-gradient(circle at 30% 25%, #ff8a7f, #ff3b30); color:#120b0b; }
  .btn-lime{background: radial-gradient(circle at 30% 25%, #a7ffde, #50ffb2);}
  .btn-aqua{background: radial-gradient(circle at 30% 25%, #b9e8ff, #57d0ff);}
  .btn-vio{ background: radial-gradient(circle at 30% 25%, #e2d3ff, #b28bff);}
  .btn:disabled{opacity:.6; cursor:not-allowed}

  /* Pad matrix */
  .pads{
    background:linear-gradient(180deg,#0a1421,#060c15); border-radius:16px; padding:12px;
    box-shadow: inset 0 0 0 1px #1b2c45;
  }
  .grid{display:grid; grid-template-columns:repeat(4,1fr); gap:10px;}
  .pad{
    height:60px; border-radius:12px; background:linear-gradient(180deg,#121c2b,#0b1320);
    box-shadow: inset 0 0 0 1px #1f3350, 0 6px 20px #00ffff08; cursor:pointer; position:relative; overflow:hidden;
  }
  .pad::after{
    content:""; position:absolute; inset:0; background:conic-gradient(from 0deg, transparent 0 330deg, #00eaff22 360deg);
    mix-blend-mode:screen; opacity:.0; transition:opacity .12s;
  }
  .pad.active::after{opacity:.6}

  /* Tape section */
  .tape{
    border-radius:16px; padding:12px; background:linear-gradient(180deg,#0a1421,#060c15);
    box-shadow: inset 0 0 0 1px #1b2c45; display:flex; flex-direction:column; gap:10px;
  }
  .wheels{display:flex; gap:18px; justify-content:center; margin-top:6px}
  .wheel{
    width:68px; height:68px; border-radius:50%;
    background:radial-gradient(circle at 35% 35%, #1b2738, #0f1624 60%, #07101a 61%);
    box-shadow: inset 0 0 0 2px #1b2c45;
  }
  audio{width:100%}
</style>
</head>
<body>
  <div class="wrap">
    <div class="cabinet">
      <div class="marquee">
        <div class="brand">Arcade Synth</div>
        <div class="seedbar">
          <div class="seedbox">
            <label for="seed">SEED</label>
            <input id="seed" type="text" value="insert coin for groove" placeholder="Type your seed… (always visible & editable)">
          </div>
          <div class="toggle">
            <span style="font-size:.85rem;color:#80a8d1">POWER</span>
            <div id="switch" class="switch"><div class="knob"></div></div>
            <div id="lamp" class="lamp"></div>
          </div>
        </div>
      </div>

      <div class="surface">
        <div class="screen">
          <div class="meta">
            <div id="meta">—</div>
            <div style="display:flex;gap:8px;align-items:center">
              <span style="font-size:.85rem;color:#8ec9ff">BPM DIAL</span>
            </div>
          </div>
          <div class="dial" id="dial"><div id="needle" class="needle" style="left:6%"></div></div>

          <div class="controls">
            <button id="play"   class="btn btn-lime">Play</button>
            <button id="stop"   class="btn btn-aqua" disabled>Stop</button>
            <button id="render" class="btn btn-vio">Render 8 bars</button>
            <button id="shuffle" class="btn btn-red">Shuffle pads</button>
          </div>
        </div>

        <div class="pads">
          <div class="grid" id="padGrid">
            <!-- pads via JS -->
          </div>
          <div class="tape">
            <div style="font-size:.9rem;color:#8ec9ff">Rendered loop (in-memory WAV, not saved)</div>
            <div class="wheels"><div id="w1" class="wheel"></div><div id="w2" class="wheel"></div></div>
            <audio id="player" controls style="margin-top:8px; display:none"></audio>
          </div>
        </div>
      </div>
    </div>
  </div>

<script>
/* === Deterministic PRNG === */
function cyrb128(str){let h1=1779033703,h2=3144134277,h3=1013904242,h4=2773480762;
  for(let i=0,k;i<str.length;i++){k=str.charCodeAt(i);
    h1=(h2^Math.imul(h1^k,597399067))>>>0; h2=(h3^Math.imul(h2^k,2869860233))>>>0;
    h3=(h4^Math.imul(h3^k,951274213))>>>0; h4=(h1^Math.imul(h4^k,2716044179))>>>0;}
  h1=Math.imul(h3^(h1>>>18),597399067); h2=Math.imul(h4^(h2>>>22),2869860233);
  h3=Math.imul(h1^(h3>>>17),951274213); h4=Math.imul(h2^(h4>>>19),2716044179);
  return [(h1^h2^h3^h4)>>>0,(h2^h1)>>>0,(h3^h1)>>>0,(h4^h1)>>>0];}
function sfc32(a,b,c,d){return function(){a>>>=0;b>>>=0;c>>>=0;d>>>=0;let t=(a+b)|0;
  a=b^b>>>9; b=c+(c<<3)|0; c=(c<<21|c>>>11); d=d+1|0; t=t+d|0; c=c+t|0; return (t>>>0)/4294967296;};}

/* === Music helpers === */
const NOTES=["C","C#","D","D#","E","F","F#","G","G#","A","A#","B"];
const MODES={ major:[0,2,4,5,7,9,11], minor:[0,2,3,5,7,8,10], dorian:[0,2,3,5,7,9,10], mixo:[0,2,4,5,7,9,10], pentM:[0,2,4,7,9], pentm:[0,3,5,7,10] };
function pick(r,a){return a[Math.floor(r()*a.length)]}
function hz(note,oct=4){const i=NOTES.indexOf(note); const midi=(oct+1)*12+i; return 440*Math.pow(2,(midi-69)/12);}

/* === Seeded song === */
function buildSong(seed){
  const rng=sfc32(...cyrb128(seed||"default"));
  const tempo=Math.floor(84 + rng()*64); // 84–148
  const root=NOTES[Math.floor(rng()*12)];
  const mode=pick(rng,Object.keys(MODES)); const scale=MODES[mode];
  const hatMode=pick(rng,["16ths","offbeat","shuffle"]); const swing=(hatMode==="shuffle")?0.12:(Math.floor(rng()*3)*0.04);

  const chordSets=[[0,4,5,3],[0,5,3,4],[0,2,3,4],[0,1,4,5]]; const chords=pick(rng,chordSets);
  const steps=16, melody=[], bass=[]; let oct = 4 + (rng()<.5?0:1);

  for(let i=0;i<steps;i++){
    const bar=Math.floor(i/4)%4; const deg=chords[bar]%scale.length;
    const croot=(scale[deg]+NOTES.indexOf(root))%12;
    const fifth=(croot+7)%12; const bchoice=(i%8===0)?croot:(rng()<.35?fifth:croot);
    bass.push({note:NOTES[bchoice], octave:2, gate:.22});
    if(rng()<.17){melody.push(null); continue;}
    const chordTones=[0,2,4].map(o=>(scale[(deg+o)%scale.length]+NOTES.indexOf(root))%12);
    const pass=rng()<.3; const nIdx = pass ? (NOTES.indexOf(root)+scale[Math.floor(rng()*scale.length)])%12 : pick(rng,chordTones);
    if(rng()<.15) oct = (oct===4?5:4);
    melody.push({note:NOTES[nIdx], octave:oct, gate: rng()<.8?.22:.1});
  }
  // 8 drum pads: variations seeded
  const pads = Array.from({length:8}, (_,i)=>({ id:i, active: rng()<0.65 }));
  return {tempo, root, mode, scale, hatMode, swing, melody, bass, pads};
}

/* === Audio engine === */
let ctx, master, playing=false, timer=null, step=0, song=null;
const lamp=document.getElementById('lamp'), needle=document.getElementById('needle'), meta=document.getElementById('meta');

function ensureCtx(){
  if(!ctx){
    ctx = new (window.AudioContext||window.webkitAudioContext)();
    master = ctx.createGain(); master.gain.value=.9; master.connect(ctx.destination);
  }
}
function env(g,t,a=.01,d=.1,s=.0){g.gain.setValueAtTime(0,t); g.gain.linearRampToValueAtTime(.28,t+a); g.gain.exponentialRampToValueAtTime(.001,t+a+d+s);}
function kick(t){const o=ctx.createOscillator(), g=ctx.createGain(); o.type='sine'; o.frequency.setValueAtTime(185,t); o.frequency.exponentialRampToValueAtTime(58,t+.07); env(g,t,.002,.09); o.connect(g).connect(master); o.start(t); o.stop(t+.12);}
function snare(t){const b=ctx.createBuffer(1,ctx.sampleRate*.17,ctx.sampleRate), d=b.getChannelData(0); for(let i=0;i<d.length;i++){d[i]=(Math.random()*2-1)*Math.pow(1-i/d.length,2);} const s=ctx.createBufferSource(); s.buffer=b; const hp=ctx.createBiquadFilter(); hp.type='highpass'; hp.frequency.value=1900; const g=ctx.createGain(); g.gain.setValueAtTime(.58,t); g.gain.exponentialRampToValueAtTime(.001,t+.15); s.connect(hp).connect(g).connect(master); s.start(t); s.stop(t+.18);}
function hat(t){const b=ctx.createBuffer(1,ctx.sampleRate*.045,ctx.sampleRate), d=b.getChannelData(0); for(let i=0;i<d.length;i++){d[i]=Math.random()*2-1;} const s=ctx.createBufferSource(); s.buffer=b; const hp=ctx.createBiquadFilter(); hp.type='highpass'; hp.frequency.value=10000; const g=ctx.createGain(); g.gain.setValueAtTime(.16,t); g.gain.exponentialRampToValueAtTime(.001,t+.04); s.connect(hp).connect(g).connect(master); s.start(t); s.stop(t+.05);}
function lead(t,f,gate=.2){const o=ctx.createOscillator(), f1=ctx.createBiquadFilter(), g=ctx.createGain(); o.type='triangle'; o.frequency.value=f; f1.type='lowpass'; f1.frequency.value=1900; env(g,t,.01,.18,gate-.18); o.connect(f1).connect(g).connect(master); o.start(t); o.stop(t+gate+.02);}
function bassNote(t,f){const o=ctx.createOscillator(), g=ctx.createGain(), lp=ctx.createBiquadFilter(); o.type='square'; o.frequency.value=f/2; lp.type='lowpass'; lp.frequency.value=600; env(g,t,.006,.16,.06); o.connect(lp).connect(g).connect(master); o.start(t); o.stop(t+.34);}

function swingDelay(dur,i,swing){ return (swing && i%2===1) ? swing*dur : 0; }

function tick(){
  const spb=60/song.tempo, s16=spb/4;
  const base=ctx.currentTime+0.04;
  const t = base + swingDelay(s16, step, song.swing);

  // drums (pads influence hats on/off per quarter)
  if(step%8===0) kick(t);
  if(step%8===4) snare(t);
  const quarter = Math.floor(step/4)%4;
  const padActive = song.pads[quarter] && song.pads[quarter].active;
  if(song.hatMode==="16ths" || step%2===0 || padActive) hat(t);

  // notes
  const m=song.melody[step%song.melody.length];
  const b=song.bass[step%song.bass.length];
  if(b) bassNote(t, hz(b.note,b.octave));
  if(m) lead(t, hz(m.note,m.octave), m.gate);

  const pct=(song.tempo-84)/(148-84); needle.style.left=(pct*92+4)+'%';
  step=(step+1)%16;
  timer=setTimeout(tick, s16*1000);
}

/* === Render to audio (in-memory) === */
async function renderBars(bars=8){
  const sr=44100; const lengthSec= bars*(60/song.tempo)*4;
  const octx= new OfflineAudioContext(2, Math.ceil(sr*lengthSec), sr);
  const out=octx.createGain(); out.gain.value=.9; out.connect(octx.destination);
  function okick(t){const o=octx.createOscillator(), g=octx.createGain(); o.type='sine'; o.frequency.setValueAtTime(185,t); o.frequency.exponentialRampToValueAtTime(58,t+.07); g.gain.setValueAtTime(1,t); g.gain.exponentialRampToValueAtTime(.001,t+.11); o.connect(g).connect(out); o.start(t); o.stop(t+.12);}
  function osnare(t){const b=octx.createBuffer(1,octx.sampleRate*.17,octx.sampleRate), d=b.getChannelData(0); for(let i=0;i<d.length;i++){d[i]=(Math.random()*2-1)*Math.pow(1-i/d.length,2);} const s=octx.createBufferSource(); s.buffer=b; const hp=octx.createBiquadFilter(); hp.type='highpass'; hp.frequency.value=1900; const g=octx.createGain(); g.gain.setValueAtTime(.58,t); g.gain.exponentialRampToValueAtTime(.001,t+.15); s.connect(hp).connect(g).connect(out); s.start(t); s.stop(t+.18);}
  function ohat(t){const b=octx.createBuffer(1,octx.sampleRate*.045,octx.sampleRate), d=b.getChannelData(0); for(let i=0;i<d.length;i++){d[i]=Math.random()*2-1;} const s=octx.createBufferSource(); s.buffer=b; const hp=octx.createBiquadFilter(); hp.type='highpass'; hp.frequency.value=10000; const g=octx.createGain(); g.gain.setValueAtTime(.16,t); g.gain.exponentialRampToValueAtTime(.001,t+.04); s.connect(hp).connect(g).connect(out); s.start(t); s.stop(t+.05);}
  function olead(t,f,gate=.2){const o=octx.createOscillator(), f1=octx.createBiquadFilter(), g=octx.createGain(); o.type='triangle'; o.frequency.value=f; f1.type='lowpass'; f1.frequency.value=1900; g.gain.setValueAtTime(0,t); g.gain.linearRampToValueAtTime(.28,t+.01); g.gain.exponentialRampToValueAtTime(.001,t+gate); o.connect(f1).connect(g).connect(out); o.start(t); o.stop(t+gate+.02);}
  function obass(t,f){const o=octx.createOscillator(), g=octx.createGain(), lp=octx.createBiquadFilter(); o.type='square'; o.frequency.value=f/2; lp.type='lowpass'; lp.frequency.value=600; g.gain.setValueAtTime(0,t); g.gain.linearRampToValueAtTime(.28,t+.006); g.gain.exponentialRampToValueAtTime(.001,t+.2); o.connect(lp).connect(g).connect(out); o.start(t); o.stop(t+.34);}

  const spb=60/song.tempo, s16=spb/4; const total=Math.floor(lengthSec/s16);
  for(let i=0;i<total;i++){
    const base=i*s16; const t = base + ((song.hatMode==="shuffle" && i%2===1)? 0.12*s16 : 0);
    if(i%8===0) okick(t); if(i%8===4) osnare(t);
    const quarter=Math.floor(i/4)%4; const padActive=song.pads[quarter] && song.pads[quarter].active;
    if(song.hatMode==="16ths" || i%2===0 || padActive) ohat(t);
    const m=song.melody[i%song.melody.length]; const b=song.bass[i%song.bass.length];
    if(b) obass(t, hz(b.note,b.octave));
    if(m) olead(t, hz(m.note,m.octave), m.gate);
  }

  const buf=await octx.startRendering();
  function toWav(b){const ch=2,n=b.length,rate=b.sampleRate; const dv=new DataView(new ArrayBuffer(44+n*ch*2)); let off=0;
    const w4=s=>{for(let i=0;i<s.length;i++) dv.setUint8(off++, s.charCodeAt(i));}, u32=v=>{dv.setUint32(off,v,true); off+=4;}, u16=v=>{dv.setUint16(off,v,true); off+=2;};
    w4('RIFF'); u32(36+n*ch*2); w4('WAVE'); w4('fmt '); u32(16); u16(1); u16(ch); u32(rate); u32(rate*ch*2); u16(ch*2); u16(16);
    w4('data'); u32(n*ch*2);
    const L=b.getChannelData(0), R=b.getChannelData(1);
    for(let i=0;i<n;i++){ dv.setInt16(off, Math.max(-1,Math.min(1,L[i]))*0x7fff|0, true); off+=2;
                          dv.setInt16(off, Math.max(-1,Math.min(1,R[i]))*0x7fff|0, true); off+=2;}
    return new Blob([dv.buffer], {type:'audio/wav'});
  }
  const url=URL.createObjectURL(toWav(buf));
  const player=document.getElementById('player'); player.src=url; player.style.display='block'; player.play();
  const w1=document.getElementById('w1'), w2=document.getElementById('w2');
  let rot=0; const spin=()=>{ if(player.paused) return; rot=(rot+4)%360; w1.style.transform=`rotate(${rot}deg)`; w2.style.transform=`rotate(${-rot}deg)`; requestAnimationFrame(spin); };
  player.onplay=()=>requestAnimationFrame(spin);
}

/* === Pads UI === */
const padGrid=document.getElementById('padGrid');
function drawPads(){
  padGrid.innerHTML='';
  for(let i=0;i<8;i++){
    const p=document.createElement('div'); p.className='pad'; p.dataset.id=i;
    p.onclick=()=>{ song.pads[i].active=!song.pads[i].active; p.classList.toggle('active', song.pads[i].active); };
    p.classList.toggle('active', song?.pads?.[i]?.active);
    padGrid.appendChild(p);
  }
}

/* === Wiring === */
const seedEl=document.getElementById('seed');
const sw=document.getElementById('switch');

function applyMeta(){
  meta.textContent = `${song.root} ${song.mode} • ${song.tempo} BPM • hats: ${song.hatMode}`;
}
function power(on){
  sw.classList.toggle('on', on); document.getElementById('lamp').classList.toggle('on', on);
}
sw.onclick=()=>power(!sw.classList.contains('on'));

document.getElementById('play').onclick=()=>{
  ensureCtx();
  song = buildSong(seedEl.value.trim());
  step=0; applyMeta(); drawPads(); power(true);
  document.getElementById('play').disabled=true; document.getElementById('stop').disabled=false;
  tick();
};
document.getElementById('stop').onclick=()=>{
  clearTimeout(timer); timer=null; power(false);
  document.getElementById('play').disabled=false; document.getElementById('stop').disabled=true;
};
document.getElementById('render').onclick=()=>{ if(!song){ song=buildSong(seedEl.value.trim()); applyMeta(); drawPads(); } renderBars(8); };
document.getElementById('shuffle').onclick=()=>{ if(!song){ song=buildSong(seedEl.value.trim()); } song.pads.forEach(p=>p.active=Math.random()<0.65); drawPads(); };

seedEl.addEventListener('input', ()=>{
  clearTimeout(timer); timer=null; power(false);
  document.getElementById('stop').disabled=true; document.getElementById('play').disabled=false;
});

/* draw dial ticks */
(()=>{const d=document.getElementById('dial'); for(let i=0;i<=20;i++){const t=document.createElement('div'); t.className='tick'; t.style.left=(i*5)+'%'; t.style.opacity=i%5===0?1:.35; d.appendChild(t);} })();
</script>
</body>
</html>
