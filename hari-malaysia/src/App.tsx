import { useEffect, useMemo, useState } from 'react'

/* ------------------------------------------------------------------ */
/*  Helpers                                                            */
/* ------------------------------------------------------------------ */

function starPoints(n: number, cx: number, cy: number, outer: number, inner: number) {
  const pts: string[] = []
  for (let i = 0; i < n * 2; i++) {
    const r = i % 2 === 0 ? outer : inner
    const a = -Math.PI / 2 + (i * Math.PI) / n
    pts.push(`${(cx + r * Math.cos(a)).toFixed(2)},${(cy + r * Math.sin(a)).toFixed(2)}`)
  }
  return pts.join(' ')
}

const RED = '#C8102E'
const BLUE = '#012169'
const YELLOW = '#FFCD00'

/* ------------------------------------------------------------------ */
/*  Jalur Gemilang — drawn in code                                     */
/* ------------------------------------------------------------------ */

function JalurGemilang({ className }: { className?: string }) {
  return (
    <div
      className={`relative flex flex-col overflow-hidden ${className ?? ''}`}
      style={{ aspectRatio: '1 / 2', background: '#fff' }}
      role="img"
      aria-label="Bendera Malaysia — Jalur Gemilang"
    >
      {Array.from({ length: 14 }, (_, i) => (
        <div key={i} className="flex-1" style={{ background: i % 2 === 0 ? RED : '#fff' }} />
      ))}
      <svg
        className="absolute left-0 top-0"
        width="50%"
        height="50%"
        viewBox="0 0 200 100"
        preserveAspectRatio="none"
        aria-hidden
      >
        <rect x="0" y="0" width="200" height="100" fill={BLUE} />
        {/* yellow disk, then a blue bite taken out to form the crescent */}
        <circle cx="84" cy="50" r="30" fill={YELLOW} />
        <circle cx="58" cy="50" r="27" fill={BLUE} />
        <polygon points={starPoints(14, 138, 50, 26, 11)} fill={YELLOW} />
      </svg>
    </div>
  )
}

function Stripes({ className }: { className?: string }) {
  return (
    <div className={`flex w-full ${className ?? ''}`} aria-hidden>
      {Array.from({ length: 14 }, (_, i) => (
        <div key={i} className="flex-1" style={{ background: i % 2 === 0 ? RED : '#fff' }} />
      ))}
    </div>
  )
}

/* ------------------------------------------------------------------ */
/*  Copy — BM / EN                                                     */
/* ------------------------------------------------------------------ */

interface Copy {
  kicker: string
  title: string
  sub: string
  cta1: string
  cta2: string
  s01: string
  s01title: string
  q: string
  qsrc: string
  c02: string
  c02title: string
  today: string
  d: string
  h: string
  m: string
  s: string
  s03: string
  s03title: string
  s03sub: string
  plus: string
  s04: string
  s04title: string
  s04Cards: [string, string][]
  footnote: string
  credit: string
}

const EN: Copy = {
  kicker: 'Since 16 September 1963',
  title: 'Happy Malaysia Day',
  sub: `On 16 September 1963 the Federation of Malaysia came into being — Sabah, Sarawak and Singapore joined Malaya to birth a new nation from one family. Every year we mark that day: Hari Malaysia.`,
  cta1: 'Read the story',
  cta2: 'The 16 states',
  s01: '01 — Story',
  s01title: 'A nation is born',
  q: `"Today, 16 September 1963, a free and sovereign nation takes its place among the nations of the world."`,
  qsrc: 'The Malaysia Proclamation, 16 September 1963',
  c02: '02 — Countdown',
  c02title: 'Next 16 September',
  today: "It's Hari Malaysia today!",
  d: 'Days', h: 'Hours', m: 'Minutes', s: 'Seconds',
  s03: '03 — States',
  s03title: '16 states, one nation',
  s03sub: 'Tap a state to reveal a line about it.',
  plus: 'Open your map and find them all.',
  s04: '04 — Celebrate',
  s04title: 'Ways to celebrate',
  s04Cards: [
    ['Kibar the flag', 'Fly the Jalur Gemilang from homes, offices and streets all through September.'],
    ['Peoples’ parade', 'Parades, concerts and community events mark the day in towns across the country.'],
    ['Open house', 'Neighbours and strangers gather over one long table — Malaysian food, one family.'],
    ['Mind over Malaysia', 'Watch a documentary, read a page of history, share a story of Sabah & Sarawak.'],
  ],
  footnote: 'A page celebrating the formation of Malaysia — 16 September 1963.',
  credit: 'Set in the colours of the Jalur Gemilang',
}

const BM: Copy = {
  kicker: 'Sejak 16 September 1963',
  title: 'Selamat Hari Malaysia',
  sub: `Pada 16 September 1963, Persekutuan Malaysia terbentuk — Sabah, Sarawak dan Singapura menyertai Tanah Melayu, melahirkan sebuah negara baharu daripada rumpun yang sama. Setiap tahun kita meraikannya: Hari Malaysia.`,
  cta1: 'Baca Sejarah',
  cta2: '16 Negeri',
  s01: '01 — Sejarah',
  s01title: 'Sebuah negara dilahirkan',
  q: `"Hari ini, 16 September 1963, sebuah negara yang merdeka dan berdaulat muncul di kalangan negara-negara dunia."`,
  qsrc: 'Proklamasi Malaysia, 16 September 1963',
  c02: '02 — Kiraan',
  c02title: '16 September berikutnya',
  today: 'Hari ini Hari Malaysia!',
  d: 'Hari', h: 'Jam', m: 'Minit', s: 'Saat',
  s03: '03 — Negeri',
  s03title: '16 negeri, satu negara',
  s03sub: 'Ketuk mana-mana negeri untuk membaca sepatah tentangnya.',
  plus: 'Buka peta dan cari kesemuanya.',
  s04: '04 — Sambutan',
  s04title: 'Cara meraikan',
  s04Cards: [
    ['Kibar Jalur Gemilang', 'Kibarkan bendera di rumah, pejabat dan jalan raya sepanjang bulan September.'],
    ['Perarakan rakyat', 'Perarakan, konsert dan acara komuniti diadakan di merata bandar.'],
    ['Rumah terbuka', 'Jiran tetangga berkumpul di satu meja panjang — makanan Malaysia, satu keluarga.'],
    ['Minda Malaysia', 'Tonton dokumentari, baca helaian sejarah, kongsi cerita tentang Sabah & Sarawak.'],
  ],
  footnote: 'Sebuah halaman meraikan pembentukan Malaysia — 16 September 1963.',
  credit: 'Diwarna dengan warna Jalur Gemilang',
}

/* ------------------------------------------------------------------ */
/*  Data                                                               */
/* ------------------------------------------------------------------ */

const SEJARAH = [
  {
    year: '1957',
    bm: 'Persekutuan Tanah Melayu mencapai kemerdekaan pada 31 Ogos dari British.',
    en: 'The Federation of Malaya gains independence from Britain on 31 August.',
  },
  {
    year: '1961',
    bm: 'Tunku Abdul Rahman mencadangkan idea Malaysia — Melayu, Borneo dan Singapura bersatu.',
    en: 'Tunku Abdul Rahman proposes the Malaysia idea — Malaya, Borneo and Singapore together.',
  },
  {
    year: '1963',
    bm: '16 September: Malaysia dibentuk. Sabah, Sarawak dan Singapura menyertai Tanah Melayu.',
    en: '16 September: Malaysia is formed. Sabah, Sarawak and Singapore join Malaya.',
  },
  {
    year: '1965',
    bm: 'Singapura berpisah dan menjadi republik merdeka.',
    en: 'Singapore separates and becomes an independent republic.',
  },
  {
    year: 'Kini',
    bm: '13 negeri dan 3 wilayah persekutuan — 16 entiti, satu negara.',
    en: '13 states and 3 federal territories — 16 entities, one nation.',
  },
]

const NEGERI: {
  j: string
  n: string
  k: 'NEGERI' | 'W.P.'
  b: string
  hot?: boolean
}[] = [
  { j: 'PLS', n: 'Perlis', k: 'NEGERI', b: 'Negeri paling kecil di Malaysia; seiring saiznya, besar budayanya.' },
  { j: 'KDH', n: 'Kedah', k: 'NEGERI', b: 'Digelar “Jelapang Padi” — jelapang beras negara.' },
  { j: 'PNG', n: 'Pulau Pinang', k: 'NEGERI', b: 'Pulau Mutiara, masyhur dengan makanan jalanan dan seni dinding.' },
  { j: 'PRK', n: 'Perak', k: 'NEGERI', b: 'Namanya daripada timah — “perak” — pusat lombong era silam.' },
  { j: 'SGR', n: 'Selangor', k: 'NEGERI', b: 'Paling maju dan paling padat penduduknya di Malaysia.' },
  { j: 'NSN', n: 'Negeri Sembilan', k: 'NEGERI', b: 'Nama daripada "sembilan" — sembilan daerah asal.' },
  { j: 'MLK', n: 'Melaka', k: 'NEGERI', b: 'Bandaraya bersejarah yang diiktiraf UNESCO.' },
  { j: 'JHR', n: 'Johor', k: 'NEGERI', b: 'Pintu selatan negara, bersebelahan Singapura.' },
  { j: 'KTN', n: 'Kelantan', k: 'NEGERI', b: 'Kubu tradisi Melayu di Pantai Timur.' },
  { j: 'TRG', n: 'Terengganu', k: 'NEGERI', b: 'Terkenal dengan batik dan kain tenun yang halus.' },
  { j: 'PHG', n: 'Pahang', k: 'NEGERI', b: 'Negeri terbesar di Semenanjung Malaysia.' },
  { j: 'SBH', n: 'Sabah', k: 'NEGERI', b: 'Negeri Di Bawah Bayu — rumah Gunung Kinabalu.', hot: true },
  { j: 'SWK', n: 'Sarawak', k: 'NEGERI', b: 'Bumi Kenyalang — negeri terbesar di Malaysia.', hot: true },
  { j: 'KUL', n: 'Kuala Lumpur', k: 'W.P.', b: 'Ibu negara; simpang segala bangsa dan bahasa.' },
  { j: 'PJY', n: 'Putrajaya', k: 'W.P.', b: 'Pusat pentadbiran Kerajaan Persekutuan.' },
  { j: 'LBN', n: 'Labuan', k: 'W.P.', b: 'Pulau pusat perniagaan dan kewangan antarabangsa.' },
]

/* ------------------------------------------------------------------ */
/*  Countdown                                                          */
/* ------------------------------------------------------------------ */

function useCountdown() {
  const [now, setNow] = useState(() => Date.now())
  useEffect(() => {
    const id = setInterval(() => setNow(Date.now()), 1000)
    return () => clearInterval(id)
  }, [])

  const isToday = useMemo(() => {
    const d = new Date(now)
    return d.getMonth() === 8 && d.getDate() === 16
  }, [now])

  const target = useMemo(() => {
    const d = new Date(now)
    const t = new Date(d.getFullYear(), 8, 16)
    if (d.getTime() > t.getTime()) t.setFullYear(d.getFullYear() + 1)
    return t
  }, [now])

  const diff = Math.max(0, target.getTime() - now)
  return {
    isToday,
    days: Math.floor(diff / 86400000),
    hours: Math.floor(diff / 3600000) % 24,
    mins: Math.floor(diff / 60000) % 60,
    secs: Math.floor(diff / 1000) % 60,
  }
}

function Cell({ v, l }: { v: number; l: string }) {
  return (
    <div className="border border-white/25 px-2 py-4 md:py-6 text-center">
      <div className="font-display text-3xl md:text-6xl leading-none tabular-nums">
        {String(v).padStart(2, '0')}
      </div>
      <div className="mt-2 font-label text-[10px] text-jalur-yellow/90">{l}</div>
    </div>
  )
}

/* ------------------------------------------------------------------ */
/*  App                                                                */
/* ------------------------------------------------------------------ */

export default function App() {
  const [lang, setLang] = useState<'bm' | 'en'>('bm')
  const [open, setOpen] = useState<number | null>(3) // Sabah
  const t = lang === 'bm' ? BM : EN
  const cd = useCountdown()

  const marquee = ['SELAMAT HARI MALAYSIA', '16 SEPTEMBER', 'BANGSA SATU, KELUARGA SATU', 'BERSEKUTU BERTAMBAH MUTU']

  return (
    <div className="min-h-screen bg-paper text-ink selection:bg-jalur-yellow selection:text-ink">
      <Stripes className="h-3" />

      {/* ------------------------------------------------ header */}
      <header className="sticky top-0 z-50 border-b border-ink/15 bg-paper/90 backdrop-blur">
        <div className="mx-auto flex h-16 max-w-7xl items-center justify-between px-4 md:px-8">
          <a href="#top" className="flex items-center gap-3">
            <JalurGemilang className="h-6 w-12 ring-1 ring-ink/20" />
            <span className="font-display text-lg leading-none tracking-tight">
              HARI<span className="text-jalur-red">.</span>MALAYSIA
            </span>
          </a>
          <nav className="hidden items-center gap-8 font-label text-[11px] md:flex">
            <a href="#sejarah" className="hover:text-jalur-red">
              Sejarah
            </a>
            <a href="#countdown" className="hover:text-jalur-red">
              Kiraan
            </a>
            <a href="#negeri" className="hover:text-jalur-red">
              16 Negeri
            </a>
            <a href="#sambutan" className="hover:text-jalur-red">
              Sambutan
            </a>
          </nav>
          <button
            onClick={() => setLang(lang === 'bm' ? 'en' : 'bm')}
            className="border border-ink bg-paper px-3 py-1.5 font-label text-[11px] transition-colors hover:bg-jalur-red hover:text-white"
            aria-label="Tukar bahasa"
          >
            {lang === 'bm' ? 'English →' : '← Bahasa'}
          </button>
        </div>
      </header>

      {/* ------------------------------------------------ hero */}
      <section id="top" className="relative overflow-hidden">
        <div className="mx-auto grid max-w-7xl gap-10 px-4 pb-16 pt-12 md:grid-cols-12 md:px-8 md:pb-24 md:pt-20">
          <div className="md:col-span-7">
            <div className="hm-pop flex items-center gap-3 font-label text-xs text-jalur-red">
              <span className="h-px w-10 bg-jalur-red" />
              {t.kicker}
            </div>

            <h1 className="hm-pop mt-6 font-display leading-[0.92]" style={{ fontSize: 'clamp(3.4rem, 9vw, 8.2rem)' }}>
              {t.title.split(' ')[0]}
              <br />
              {t.title.split(' ').slice(1).join(' ')}
              <span className="text-jalur-red">.</span>
            </h1>

            <p className="hm-pop mt-8 max-w-md text-base leading-relaxed text-ink/70 md:text-lg">{t.sub}</p>

            <div className="mt-10 flex flex-wrap items-center gap-3">
              <a
                href="#sejarah"
                className="bg-jalur-blue px-6 py-3.5 font-label text-xs text-white transition-colors hover:bg-jalur-red"
              >
                {t.cta1} ↓
              </a>
              <a
                href="#negeri"
                className="border border-ink px-6 py-3.5 font-label text-xs transition-colors hover:bg-ink hover:text-paper"
              >
                {t.cta2}
              </a>
            </div>
          </div>

          {/* right column — stamp + outlined 63 */}
          <div className="relative md:col-span-5">
            <div
              className="pointer-events-none absolute -left-4 -top-10 select-none font-display leading-none text-transparent"
              style={{
                fontSize: 'clamp(12rem, 22vw, 20rem)',
                WebkitTextStroke: `3px ${RED}`,
              }}
              aria-hidden
            >
              63
            </div>
            <div className="hm-stamp relative ml-auto w-56 rotate-[4deg] bg-white md:w-64 md:mt-20">
              <div className="hm-stamp-frame p-3">
                <JalurGemilang className="w-full" />
              </div>
              <div className="flex items-center justify-between px-3 py-2 font-label text-[10px] text-ink/70">
                <span>HARI MALAYSIA</span>
                <span className="text-jalur-red">RM16·09</span>
              </div>
            </div>
            <p className="relative mt-14 max-w-[220px] font-label text-[11px] leading-relaxed text-ink/50">
              N 02°–N 07° · B 100°–B 119° — satu kepulauan, satu bangsa.
            </p>
          </div>
        </div>
      </section>

      {/* ------------------------------------------------ marquee */}
      <div className="overflow-hidden border-y border-ink bg-jalur-red py-3 text-white">
        <div className="hm-marquee font-label text-sm">
          {[0, 1].map((k) => (
            <span key={k}>
              {marquee.map((m) => (
                <span key={m + k} className="mx-6">
                  {m} <span className="text-jalur-yellow">✦</span>
                </span>
              ))}
            </span>
          ))}
        </div>
      </div>

      {/* ------------------------------------------------ sejarah */}
      <section id="sejarah" className="border-b border-ink/15 bg-white py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 md:px-8">
          <div className="grid gap-10 md:grid-cols-12">
            <div className="md:col-span-5">
              <div className="font-label text-xs text-jalur-red">{t.s01}</div>
              <h2 className="mt-4 font-display text-4xl leading-[1.02] md:text-6xl">{t.s01title}</h2>

              <blockquote className="mt-12 border-l-4 border-jalur-yellow pl-5">
                <p className="font-display text-xl leading-snug text-ink/85 md:text-2xl">{t.q}</p>
                <cite className="mt-3 block font-label text-[11px] not-italic text-ink/50">{t.qsrc}</cite>
              </blockquote>
            </div>

            <div className="md:col-span-7">
              {SEJARAH.map((row, i) => (
                <div key={row.year + i} className="flex gap-5 border-t border-ink/10 py-6 md:gap-8">
                  <span className="w-20 shrink-0 font-display text-3xl leading-none text-jalur-red md:w-24">
                    {row.year}
                  </span>
                  <p className="max-w-xl pt-1 leading-relaxed text-ink/75">
                    {lang === 'bm' ? row.bm : row.en}
                  </p>
                </div>
              ))}
              <div className="border-t border-ink/10 pt-4 text-right font-label text-[11px] text-ink/40">
                {t.plus}
              </div>
            </div>
          </div>
        </div>
      </section>

      {/* ------------------------------------------------ countdown */}
      <section id="countdown" className="bg-jalur-blue py-16 text-white md:py-20">
        <div className="mx-auto grid max-w-7xl items-center gap-8 px-4 md:grid-cols-12 md:px-8">
          <div className="md:col-span-5">
            <div className="font-label text-xs text-jalur-yellow">{t.c02}</div>
            <h2 className="mt-3 font-display text-4xl md:text-5xl">{t.c02title}</h2>
            {cd.isToday && (
              <p className="mt-4 inline-block bg-jalur-red px-3 py-1.5 font-label text-xs">{t.today}</p>
            )}
          </div>
          <div className="grid grid-cols-4 gap-3 md:col-span-7">
            <Cell v={cd.days} l={t.d as string} />
            <Cell v={cd.hours} l={t.h as string} />
            <Cell v={cd.mins} l={t.m as string} />
            <Cell v={cd.secs} l={t.s as string} />
          </div>
        </div>
      </section>

      {/* ------------------------------------------------ negeri */}
      <section id="negeri" className="py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 md:px-8">
          <div className="flex flex-wrap items-end justify-between gap-4">
            <div>
              <div className="font-label text-xs text-jalur-red">{t.s03}</div>
              <h2 className="mt-3 font-display text-4xl md:text-6xl">{t.s03title}</h2>
            </div>
            <p className="max-w-xs pb-2 text-sm text-ink/60">{t.s03sub}</p>
          </div>

          <div className="mt-10 grid gap-px border border-ink/20 bg-ink/20 sm:grid-cols-2 lg:grid-cols-4">
            {NEGERI.map((n, i) => {
              const active = open === i
              return (
                <button
                  key={n.j}
                  onClick={() => setOpen(active ? null : i)}
                  className={`group relative flex min-h-[150px] flex-col justify-between p-5 text-left transition-colors ${
                    active ? 'bg-jalur-red text-white' : 'bg-paper text-ink hover:bg-ink hover:text-paper'
                  }`}
                >
                  <div className="flex items-start justify-between">
                    <span
                      className={`font-display text-xl ${
                        active ? 'text-white' : 'text-jalur-red group-hover:text-jalur-yellow'
                      }`}
                    >
                      {n.j}
                    </span>
                    <span className="font-label text-[10px] opacity-60">
                      {String(i + 1).padStart(2, '0')} · {n.k}
                    </span>
                  </div>

                  {active ? (
                    <p className="leading-snug text-[13px] text-white/95">{n.b}</p>
                  ) : (
                    <div>
                      <span className="block font-display text-2xl leading-tight">{n.n}</span>
                      {n.hot && (
                        <span
                          className={`mt-1 inline-block px-1.5 py-0.5 font-label text-[9px] ${
                            active
                              ? 'bg-white/20 text-white'
                              : 'bg-jalur-yellow text-ink group-hover:bg-jalur-yellow'
                          }`}
                        >
                          BORNEO · 1963
                        </span>
                      )}
                    </div>
                  )}
                </button>
              )
            })}
          </div>

          <p className="mt-5 font-label text-[11px] text-ink/45">
            Sabah &amp; Sarawak — rakan Borneo sejak hari pertama, 16 September 1963.
          </p>
        </div>
      </section>

      {/* ------------------------------------------------ sambutan */}
      <section id="sambutan" className="border-t border-ink/15 bg-white py-16 md:py-24">
        <div className="mx-auto max-w-7xl px-4 md:px-8">
          <div className="font-label text-xs text-jalur-red">{t.s04}</div>
          <h2 className="mt-3 font-display text-4xl md:text-6xl">{t.s04title}</h2>

          <div className="mt-12 grid gap-5 md:grid-cols-2 lg:grid-cols-4">
            {(t.s04Cards).map((card, i) => {
              const palettes = [
                'bg-jalur-red text-white',
                'bg-paper border border-ink/20',
                'bg-jalur-yellow text-ink',
                'bg-jalur-blue text-white',
              ]
              return (
                <div key={i} className={`relative border border-ink/20 p-6 ${palettes[i]}`}>
                  <span className="font-display text-5xl opacity-20">0{i + 1}</span>
                  <h3 className="mt-10 font-display text-xl leading-tight">{card[0]}</h3>
                  <p className="mt-3 text-sm leading-relaxed opacity-80">{card[1]}</p>
                </div>
              )
            })}
          </div>
        </div>
      </section>

      {/* ------------------------------------------------ footer */}
      <footer className="bg-jalur-blue text-white">
        <div className="mx-auto max-w-7xl px-4 pb-14 pt-16 md:px-8 md:pt-24">
          <div className="font-label text-xs text-jalur-yellow">16 · 09 · 1963</div>
          <h2
            className="mt-4 font-display leading-[0.92]"
            style={{ fontSize: 'clamp(3.4rem, 10vw, 9rem)' }}
          >
            SELAMAT
            <br />
            HARI <span className="text-jalur-yellow">MALAYSIA</span>!
          </h2>

          <div className="mt-14 flex flex-wrap items-end justify-between gap-6 border-t border-white/25 pt-6 text-sm text-white/70">
            <p className="max-w-sm leading-relaxed">{t.footnote}</p>
            <p className="font-label text-[11px] text-white/50">
              {t.credit} · Merdeka
            </p>
          </div>
        </div>
        <Stripes className="h-4" />
      </footer>
    </div>
  )
}