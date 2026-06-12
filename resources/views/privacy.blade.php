@extends('layouts.app')

@section('title', 'Privacy Policy / Dasar Privasi — ClinicCare')
@section('meta_description', 'ClinicCare privacy policy in line with the Malaysian Personal Data Protection Act 2010 (PDPA). Dasar privasi mengikut Akta Perlindungan Data Peribadi 2010.')

@php
    // Single source of truth for both languages — keeps EN/BM sections in lock-step.
    $sections = [
        [
            'en' => [
                'title' => '1. Introduction',
                'body' => '<p>ClinicCare ("we", "us", "our") respects your privacy and is committed to protecting your personal data. This Privacy Policy explains how we collect, use, disclose, store and protect your personal data in accordance with the <strong>Personal Data Protection Act 2010 (Act 709) of Malaysia ("PDPA")</strong>.</p><p>By registering an account, booking an appointment, or otherwise providing your personal data to us, you acknowledge that you have read and understood this Privacy Policy.</p>',
            ],
            'ms' => [
                'title' => '1. Pengenalan',
                'body' => '<p>ClinicCare ("kami") menghormati privasi anda dan komited untuk melindungi data peribadi anda. Dasar Privasi ini menerangkan cara kami mengumpul, menggunakan, mendedahkan, menyimpan dan melindungi data peribadi anda selaras dengan <strong>Akta Perlindungan Data Peribadi 2010 (Akta 709) Malaysia ("APDP")</strong>.</p><p>Dengan mendaftar akaun, menempah temujanji, atau memberikan data peribadi anda kepada kami, anda mengakui bahawa anda telah membaca dan memahami Dasar Privasi ini.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '2. Personal Data We Collect',
                'body' => '<p>We may collect and process the following personal data:</p><ul><li>Full name and basic profile details;</li><li>Email address (used for OTP verification and notifications);</li><li>Mobile phone number, including your <strong>WhatsApp number</strong>;</li><li>Appointment details such as chosen service, date and time;</li><li><strong>Sensitive personal data</strong> — information about your physical or mental health and medical conditions provided for the purpose of treatment.</li></ul><p>Health and medical information is classified as <em>sensitive personal data</em> under the PDPA and is handled with additional care.</p>',
            ],
            'ms' => [
                'title' => '2. Data Peribadi Yang Kami Kumpul',
                'body' => '<p>Kami mungkin mengumpul dan memproses data peribadi berikut:</p><ul><li>Nama penuh dan butiran profil asas;</li><li>Alamat e-mel (digunakan untuk pengesahan OTP dan pemberitahuan);</li><li>Nombor telefon bimbit, termasuk <strong>nombor WhatsApp</strong> anda;</li><li>Butiran temujanji seperti perkhidmatan yang dipilih, tarikh dan masa;</li><li><strong>Data peribadi sensitif</strong> — maklumat mengenai kesihatan fizikal atau mental serta keadaan perubatan anda yang diberikan untuk tujuan rawatan.</li></ul><p>Maklumat kesihatan dan perubatan dikelaskan sebagai <em>data peribadi sensitif</em> di bawah APDP dan dikendalikan dengan berhati-hati.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '3. Purpose of Processing',
                'body' => '<p>Your personal data is processed for the following purposes:</p><ul><li>Creating and managing your patient account;</li><li>Verifying your identity through email OTP;</li><li>Processing, confirming and managing appointment bookings;</li><li>Sending appointment reminders and follow-up notifications;</li><li>Contacting you via phone or WhatsApp regarding your appointments;</li><li>Maintaining patient records and improving our services.</li></ul>',
            ],
            'ms' => [
                'title' => '3. Tujuan Pemprosesan',
                'body' => '<p>Data peribadi anda diproses untuk tujuan berikut:</p><ul><li>Mewujudkan dan menguruskan akaun pesakit anda;</li><li>Mengesahkan identiti anda melalui OTP e-mel;</li><li>Memproses, mengesahkan dan menguruskan tempahan temujanji;</li><li>Menghantar peringatan temujanji dan pemberitahuan susulan;</li><li>Menghubungi anda melalui telefon atau WhatsApp berkenaan temujanji anda;</li><li>Menyelenggara rekod pesakit dan menambah baik perkhidmatan kami.</li></ul>',
            ],
        ],
        [
            'en' => [
                'title' => '4. Consent',
                'body' => '<p>We process your personal data based on your consent. For <strong>sensitive personal data</strong> such as health and medical information, we rely on your <strong>explicit consent</strong> as required under the PDPA.</p><p>Providing certain data (for example your name, email and contact number) is necessary to create an account and book an appointment; without it we may be unable to provide the service. You may withdraw your consent at any time by contacting us using the details below, although this may affect our ability to serve you.</p>',
            ],
            'ms' => [
                'title' => '4. Persetujuan',
                'body' => '<p>Kami memproses data peribadi anda berdasarkan persetujuan anda. Bagi <strong>data peribadi sensitif</strong> seperti maklumat kesihatan dan perubatan, kami bergantung pada <strong>persetujuan nyata (explicit consent)</strong> anda sebagaimana yang dikehendaki di bawah APDP.</p><p>Pemberian data tertentu (contohnya nama, e-mel dan nombor telefon) adalah perlu untuk mewujudkan akaun dan menempah temujanji; tanpanya kami mungkin tidak dapat menyediakan perkhidmatan. Anda boleh menarik balik persetujuan anda pada bila-bila masa dengan menghubungi kami melalui butiran di bawah, walaupun ini mungkin menjejaskan keupayaan kami untuk memberi perkhidmatan kepada anda.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '5. Disclosure of Personal Data',
                'body' => '<p>We <strong>do not sell or rent</strong> your personal data. We may disclose it only to:</p><ul><li>Our clinic doctors, nurses and authorised staff who handle your appointment and treatment;</li><li>Service providers who help operate our system (for example email/OTP delivery), bound by confidentiality;</li><li>Parties where disclosure is required by law or a lawful authority.</li></ul>',
            ],
            'ms' => [
                'title' => '5. Pendedahan Data Peribadi',
                'body' => '<p>Kami <strong>tidak menjual atau menyewakan</strong> data peribadi anda. Kami hanya boleh mendedahkannya kepada:</p><ul><li>Doktor, jururawat dan kakitangan klinik yang diberi kuasa yang mengendalikan temujanji dan rawatan anda;</li><li>Pembekal perkhidmatan yang membantu mengendalikan sistem kami (contohnya penghantaran e-mel/OTP), yang terikat dengan kerahsiaan;</li><li>Pihak yang pendedahannya dikehendaki oleh undang-undang atau pihak berkuasa yang sah.</li></ul>',
            ],
        ],
        [
            'en' => [
                'title' => '6. Security',
                'body' => '<p>We take reasonable practical steps to protect your personal data from loss, misuse, unauthorised access, modification or disclosure — including email OTP verification, access controls, and restricting access to authorised personnel only.</p>',
            ],
            'ms' => [
                'title' => '6. Keselamatan',
                'body' => '<p>Kami mengambil langkah praktikal yang munasabah untuk melindungi data peribadi anda daripada kehilangan, penyalahgunaan, akses tanpa kebenaran, pengubahsuaian atau pendedahan — termasuk pengesahan OTP e-mel, kawalan akses, dan menghadkan akses kepada kakitangan yang diberi kuasa sahaja.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '7. Retention',
                'body' => '<p>We retain your personal data only for as long as necessary to fulfil the purposes set out in this policy, or as required by applicable laws and medical record-keeping requirements. When no longer needed, your data will be securely deleted or anonymised.</p>',
            ],
            'ms' => [
                'title' => '7. Penyimpanan',
                'body' => '<p>Kami menyimpan data peribadi anda hanya selama yang perlu untuk memenuhi tujuan yang dinyatakan dalam dasar ini, atau sebagaimana yang dikehendaki oleh undang-undang yang terpakai dan keperluan penyimpanan rekod perubatan. Apabila tidak lagi diperlukan, data anda akan dipadamkan atau dilindungi identiti secara selamat.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '8. Data Integrity',
                'body' => '<p>We take reasonable steps to ensure your personal data is accurate, complete, not misleading and kept up to date. You can help by keeping your profile details current and informing us of any changes.</p>',
            ],
            'ms' => [
                'title' => '8. Integriti Data',
                'body' => '<p>Kami mengambil langkah munasabah untuk memastikan data peribadi anda adalah tepat, lengkap, tidak mengelirukan dan dikemas kini. Anda boleh membantu dengan mengemas kini butiran profil anda dan memaklumkan kami sebarang perubahan.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '9. Your Rights',
                'body' => '<p>Under the PDPA, you have the right to:</p><ul><li><strong>Access</strong> your personal data held by us;</li><li><strong>Correct</strong> inaccurate, incomplete or out-of-date data;</li><li>Withdraw consent or request that we limit the processing of your data.</li></ul><p>To exercise any of these rights, please contact us using the details in the "Contact Us" section. We may need to verify your identity before acting on your request, and a reasonable fee may apply for data access in accordance with the PDPA.</p>',
            ],
            'ms' => [
                'title' => '9. Hak Anda',
                'body' => '<p>Di bawah APDP, anda berhak untuk:</p><ul><li><strong>Mengakses</strong> data peribadi anda yang disimpan oleh kami;</li><li><strong>Membetulkan</strong> data yang tidak tepat, tidak lengkap atau lapuk;</li><li>Menarik balik persetujuan atau meminta kami menghadkan pemprosesan data anda.</li></ul><p>Untuk melaksanakan mana-mana hak ini, sila hubungi kami melalui butiran dalam bahagian "Hubungi Kami". Kami mungkin perlu mengesahkan identiti anda sebelum bertindak atas permintaan anda, dan bayaran yang munasabah mungkin dikenakan untuk akses data selaras dengan APDP.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '10. Cookies & Third-Party Services',
                'body' => '<p>Our website uses minimal third-party resources (for example a web-font service) needed to display the page. We do not use advertising or cross-site tracking cookies. Any essential cookies are used solely to keep the site functioning.</p>',
            ],
            'ms' => [
                'title' => '10. Kuki & Perkhidmatan Pihak Ketiga',
                'body' => '<p>Laman web kami menggunakan sumber pihak ketiga yang minimum (contohnya perkhidmatan fon web) yang diperlukan untuk memaparkan halaman. Kami tidak menggunakan kuki pengiklanan atau penjejakan merentas tapak. Sebarang kuki penting digunakan semata-mata untuk memastikan laman web berfungsi.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '11. Changes to This Policy',
                'body' => '<p>We may update this Privacy Policy from time to time. Any changes will be posted on this page with a revised "Last updated" date. We encourage you to review it periodically.</p>',
            ],
            'ms' => [
                'title' => '11. Pindaan kepada Dasar Ini',
                'body' => '<p>Kami mungkin mengemas kini Dasar Privasi ini dari semasa ke semasa. Sebarang perubahan akan disiarkan di halaman ini dengan tarikh "Kemas kini terakhir" yang disemak. Kami menggalakkan anda menyemaknya secara berkala.</p>',
            ],
        ],
        [
            'en' => [
                'title' => '12. Contact Us',
                'body' => '<p>If you have any questions about this Privacy Policy, wish to access or correct your data, or want to make a complaint, please contact us:</p><ul><li><strong>ClinicCare</strong></li><li>123 Wellness Ave, City Center</li><li>Email: hello@cliniccare.example</li><li>WhatsApp: +60 12-345 6789</li></ul>',
            ],
            'ms' => [
                'title' => '12. Hubungi Kami',
                'body' => '<p>Jika anda mempunyai sebarang pertanyaan mengenai Dasar Privasi ini, ingin mengakses atau membetulkan data anda, atau ingin membuat aduan, sila hubungi kami:</p><ul><li><strong>ClinicCare</strong></li><li>123 Wellness Ave, City Center</li><li>E-mel: hello@cliniccare.example</li><li>WhatsApp: +60 12-345 6789</li></ul>',
            ],
        ],
    ];

    $labels = [
        'en' => ['eyebrow' => 'Legal', 'heading' => 'Privacy Policy', 'updated' => 'Last updated: 12 June 2026', 'back' => 'Back to Home'],
        'ms' => ['eyebrow' => 'Perundangan', 'heading' => 'Dasar Privasi', 'updated' => 'Kemas kini terakhir: 12 Jun 2026', 'back' => 'Kembali ke Laman Utama'],
    ];
@endphp

@section('content')
    <div x-data="{ lang: 'en' }">
        {{-- Header band --}}
        <section class="relative overflow-hidden bg-gradient-to-b from-brand-50 to-white">
            <div class="mx-auto max-w-3xl px-4 py-16 sm:px-6 lg:py-20">
                <span class="inline-block rounded-full bg-brand-50 px-3 py-1 text-xs font-semibold uppercase tracking-wide text-brand-700">
                    <span x-show="lang === 'en'">{{ $labels['en']['eyebrow'] }}</span>
                    <span x-show="lang === 'ms'" x-cloak>{{ $labels['ms']['eyebrow'] }}</span>
                </span>

                <h1 class="mt-4 text-3xl font-bold tracking-tight text-slate-900 sm:text-4xl">
                    <span x-show="lang === 'en'">{{ $labels['en']['heading'] }}</span>
                    <span x-show="lang === 'ms'" x-cloak>{{ $labels['ms']['heading'] }}</span>
                </h1>

                <p class="mt-3 text-sm text-slate-500">
                    <span x-show="lang === 'en'">{{ $labels['en']['updated'] }}</span>
                    <span x-show="lang === 'ms'" x-cloak>{{ $labels['ms']['updated'] }}</span>
                </p>

                {{-- Language toggle --}}
                <div class="mt-6 inline-flex rounded-xl border border-slate-200 bg-white p-1 shadow-sm">
                    <button type="button" @click="lang = 'en'"
                        class="rounded-lg px-4 py-1.5 text-sm font-semibold transition"
                        :class="lang === 'en' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:text-brand-700'">
                        English
                    </button>
                    <button type="button" @click="lang = 'ms'"
                        class="rounded-lg px-4 py-1.5 text-sm font-semibold transition"
                        :class="lang === 'ms' ? 'bg-brand-600 text-white shadow-sm' : 'text-slate-600 hover:text-brand-700'">
                        Bahasa Malaysia
                    </button>
                </div>
            </div>
        </section>

        {{-- Body --}}
        <section class="bg-white pb-20">
            <div class="mx-auto max-w-3xl px-4 sm:px-6">
                @foreach (['en', 'ms'] as $lang)
                    <div @if ($lang === 'ms') x-cloak @endif x-show="lang === '{{ $lang }}'" class="space-y-8">
                        @foreach ($sections as $section)
                            <article class="rounded-2xl border border-slate-100 bg-white p-6 shadow-sm sm:p-8">
                                <h2 class="text-lg font-semibold text-slate-900">{{ $section[$lang]['title'] }}</h2>
                                <div class="pdpa-prose mt-3 space-y-3 text-sm leading-relaxed text-slate-600">
                                    {!! $section[$lang]['body'] !!}
                                </div>
                            </article>
                        @endforeach

                        <div class="pt-2">
                            <a href="{{ route('home') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-brand-700 transition hover:gap-3">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M19 12H5M11 18l-6-6 6-6"/></svg>
                                {{ $labels[$lang]['back'] }}
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    </div>
@endsection
