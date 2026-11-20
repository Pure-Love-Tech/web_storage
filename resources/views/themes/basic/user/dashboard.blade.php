@extends('themes.basic.user.layouts.app')
@section('title', translate('Dashboard', 'dashboard'))
@section('content')


    <div class="arahlink-compact">
        <div class="arahlink-compact-icon">
            <svg width="25" height="25" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M10 13a5 5 0 0 0 7.07 0l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71" />
                <path d="M14 11a5 5 0 0 0-7.07 0l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71" />
            </svg>
        </div>

        <div class="arahlink-compact-content">
            <div class="arahlink-compact-title">
                Punya Banyak Traffic?
                <span>Ubah Jadi Cuan dengan ArahLink!</span>
            </div>
            <p>Persingkat URL dan dapatkan penghasilan dari kunjungan valid.</p>
        </div>

        <a href="https://arahlink.com" class="arahlink-compact-button" _target="blank">
            Mulai Cuan
            <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"
                stroke-linecap="round" stroke-linejoin="round" aria-hidden="true">
                <path d="M5 12h14" />
                <path d="m12 5 7 7-7 7" />
            </svg>
        </a>
    </div>

    <style>
        .arahlink-compact {
            display: flex;
            align-items: center;
            gap: 14px;
            width: 100%;
            margin-bottom: 20px;
            padding: 15px 20px;
            box-sizing: border-box;
            border: 1px solid #2d85f9;
            border-radius: 12px;
            background: linear-gradient(100deg, #f4f9ff, #eaf5ff);
        }

        .arahlink-compact-icon {
            display: flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            width: 44px;
            height: 44px;
            border-radius: 10px;
            background: #ffffff;
            color: #35b936;
            border: 1px solid #e0edfa;
        }

        .arahlink-compact-content {
            flex: 1;
            min-width: 0;
        }

        .arahlink-compact-title {
            color: #163f7b;
            font-size: 17px;
            font-weight: 800;
            line-height: 1.4;
        }

        .arahlink-compact-title span {
            color: #0878df;
        }

        .arahlink-compact-content p {
            margin: 3px 0 0;
            color: #60748d;
            font-size: 12px;
            line-height: 1.5;
        }

        .arahlink-compact-button {
            display: inline-flex;
            flex-shrink: 0;
            align-items: center;
            justify-content: center;
            gap: 8px;
            padding: 11px 16px;
            border-radius: 8px;
            background: #2eae36;
            color: #fff !important;
            font-size: 13px;
            font-weight: 700;
            text-decoration: none !important;
            transition: background .2s ease;
        }

        .arahlink-compact-button:hover {
            background: #218c2b;
            color: #fff !important;
        }

        @media (max-width: 576px) {
            .arahlink-compact {
                gap: 10px;
                padding: 12px;
            }

            .arahlink-compact-icon {
                width: 36px;
                height: 36px;
            }

            .arahlink-compact-icon svg {
                width: 21px;
                height: 21px;
            }

            .arahlink-compact-title {
                font-size: 13px;
            }

            .arahlink-compact-content p {
                font-size: 11px;
            }

            .arahlink-compact-button {
                padding: 9px 10px;
                gap: 4px;
                font-size: 11px;
            }

            .arahlink-compact-button svg {
                width: 13px;
                height: 13px;
            }
        }

        @media (max-width: 380px) {
            .arahlink-compact {
                flex-wrap: wrap;
            }

            .arahlink-compact-content {
                flex-basis: calc(100% - 52px);
            }

            .arahlink-compact-button {
                width: 100%;
                box-sizing: border-box;
            }
        }
    </style>


    {{-- Announcement Popup --}}
    <div class="dashboard-announcement">
        <div class="announcement-icon">
            <svg width="22" height="22" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <circle cx="12" cy="12" r="10" stroke="currentColor" stroke-width="1.7" />
                <path d="M12 11V16" stroke="currentColor" stroke-width="1.7" stroke-linecap="round" />
                <circle cx="12" cy="8" r="1" fill="currentColor" />
            </svg>
        </div>

        <div class="announcement-content">
            <div class="announcement-heading">
                <strong>Informasi Penting</strong>
                <span class="announcement-badge">Kebijakan Penyimpanan File</span>
            </div>

            <p>
                Setiap file yang diunggah akan tetap tersedia selama maksimal <b>6 bulan sejak unduhan terakhir</b>. Setelah
                periode tersebut berakhir, file akan memasuki masa tenggang selama <b>1 bulan sebelum dihapus secara
                    permanen</b>.
            </p>
            <br>
            <p>
                Kami sedang mempersiapkan fitur <b>langganan berbayar</b> yang nantinya memungkinkan Anda menyimpan file
                dengan
                opsi Lifetime serta mendapatkan kapasitas penyimpanan yang lebih besar.

                <br>Fitur ini akan segera hadir. Pantau terus informasi terbaru dari ArahCloud agar Anda tidak melewatkan
                pembaruan penting.
            </p>
        </div>
    </div>

    <style>
        .dashboard-announcement {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            width: 100%;
            margin-bottom: 20px;
            padding: 14px 16px;
            background: #ffecb2;
            border: 1px solid #d5e7ff;
            border-left: 4px solid #f6c73b;
            border-radius: 10px;
            color: #1e3a5f;
            box-sizing: border-box;
        }

        .dashboard-announcement .announcement-icon {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #f67d3b;
            margin-top: 1px;
        }

        .dashboard-announcement .announcement-content {
            flex: 1;
            min-width: 0;
        }

        .dashboard-announcement .announcement-heading {
            display: flex;
            align-items: center;
            flex-wrap: wrap;
            gap: 8px;
            margin-bottom: 5px;
            font-size: 16px;
        }

        .dashboard-announcement .announcement-badge {
            padding: 2px 7px;
            border-radius: 4px;
            background: #dbeafe;
            color: #1d4ed8;
            font-size: 12px;
            font-weight: 700;
            letter-spacing: .5px;
        }

        .dashboard-announcement p {
            margin: 0;
            color: #526780;
            font-size: 14px;
            line-height: 1.6;
            overflow-wrap: anywhere;
        }

        @media (max-width: 576px) {
            .dashboard-announcement {
                padding: 12px;
                gap: 9px;
            }

            .dashboard-announcement .announcement-heading {
                font-size: 13px;
            }

            .dashboard-announcement p {
                font-size: 12px;
            }
        }

        #eventAnnouncementModal .event-modal-dialog {
            max-width: 520px;
            margin: 1.25rem auto;
        }

        #eventAnnouncementModal .event-modal-content {
            border: 0;
            border-radius: 16px;
            overflow: hidden;
        }

        #eventAnnouncementModal .event-poster {
            display: block;
            width: 100%;
            height: auto;
            max-height: 420px;
            object-fit: inherit;
            border-radius: 10px;
            margin-bottom: 20px;
        }

        #eventAnnouncementModal .event-title {
            text-align: center;
            font-weight: 700;
            /* margin-bottom: 12px; */
        }

        #eventAnnouncementModal .event-description {
            text-align: center;
            line-height: 1.7;
            margin-bottom: 24px;
        }

        #eventAnnouncementModal .event-close-button {
            display: block;
            width: 100%;
            border-radius: 8px;
            padding: 11px 16px;
        }

        @media (max-width: 576px) {
            #eventAnnouncementModal .event-modal-dialog {
                margin: 1rem;
            }

            #eventAnnouncementModal .event-poster {
                max-height: 55vh;
            }
        }
    </style>
    <div class="modal fade" id="eventAnnouncementModal" tabindex="-1" aria-labelledby="eventAnnouncementTitle"
        aria-hidden="true">

        <div class="modal-dialog modal-dialog-centered event-modal-dialog">
            <div class="modal-content event-modal-content">

                <div class="modal-header event-modal-header">
                    <span class="event-label">EVENT ARAH CLOUD</span>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Tutup"></button>
                </div>

                <div class="event-modal-body">

                    <img src="{{ asset('themes/basic/assets/images/event/event_1_pemenang.png') }}"
                        alt="Poster Event Arah Cloud" class="event-poster">
                    <!--
                            <h4 id="eventAnnouncementTitle" class="event-title">
                                Raih Bonus Tambahan!
                            </h4>

                            <p class="event-subtitle">
                                Kumpulkan download valid selama 7 hari.
                            </p> -->

                    <!-- Bonus dan aturan: kiri-kanan -->
                    <!-- <div class="event-info-grid">

                                <section class="event-rewards h-100">
                                    <h6>Target & Bonus</h6>

                                    <div class="event-reward-list">
                                        <div class="event-reward-item">
                                            <span>100 download</span>
                                            <strong>Rp5.000</strong>
                                        </div>

                                        <div class="event-reward-item">
                                            <span>300 download</span>
                                            <strong>Rp15.000</strong>
                                        </div>

                                        <div class="event-reward-item">
                                            <span>650 download</span>
                                            <strong>Rp30.000</strong>
                                        </div>

                                        <div class="event-reward-item">
                                            <span>1.000 download</span>
                                            <strong>Rp50.000</strong>
                                        </div>
                                    </div>
                                </section>

                                <section class="event-rules">
                                    <h6>Ketentuan</h6>

                                    <ul>
                                        <li>Bonus berdasarkan level tertinggi, tidak dijumlahkan.</li>
                                        <li>Semua member yang mencapai target berhak mendapat bonus.</li>
                                        <li>Penghasilan reguler tetap berjalan.</li>
                                        <li>Hanya download valid yang dihitung.</li>
                                        <li>Hadiah ditransfer ke metode WD terdaftar maksimal 3 hari setelah event berakhir.</li>
                                    </ul>
                                </section>

                            </div>

                            <div class="event-period">
                                <span style="color: #111827"><b>Periode Event</b></span>

                                <strong>
                                    26 Oct 2026
                                    –
                                    01 Nov 2026
                                </strong>
                            </div> -->

                </div>

                <div class="event-modal-footer">
                    <button type="button" class="btn event-close-button" data-bs-dismiss="modal">
                        Mengerti, Tutup
                    </button>
                </div>

            </div>
        </div>
    </div>

    <style>
        .event-modal-dialog {
            width: calc(100% - 24px);
            max-width: 520px;
            margin: 12px auto;
        }

        .event-modal-content {
            display: flex;
            flex-direction: column;
            max-height: calc(100dvh - 24px);
            overflow: hidden;
            border: 0;
            border-radius: 15px;
            background: #fff;
            color: #1f2937;
            box-shadow: 0 16px 48px rgba(0, 0, 0, .18);
        }

        .event-modal-header {
            flex-shrink: 0;
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 12px 16px 8px;
            border: 0;
        }

        .event-label {
            font-size: 10px;
            font-weight: 700;
            letter-spacing: 1px;
            color: #6b7280;
        }

        .event-modal-body {
            min-height: 0;
            overflow-y: auto;
            overscroll-behavior: contain;
            padding: 0 16px 14px;
        }

        /* Poster persegi */
        /* .event-poster {
                    display: block;
                    width: min(100%, 290px);
                    aspect-ratio: 1 / 1;
                    object-fit: inherit;
                    margin: 0 auto 12px;
                    border-radius: 9px;
                    background: #f3f4f6;
                } */

        .event-title {
            margin: 0;
            text-align: center;
            font-size: 20px;
            font-weight: 750;
            line-height: 1.3;
            color: #111827;
        }

        .event-subtitle {
            /* margin: 5px 0 16px; */
            text-align: center;
            font-size: 12px;
            color: #6b7280;
        }

        /* Dua kolom */
        .event-info-grid {
            display: grid;
            grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
            gap: 12px;
            align-items: start;
        }

        .event-rewards,
        .event-rules {
            min-width: 0;
            padding: 12px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            background: #fff;
        }

        .event-rewards h6,
        .event-rules h6 {
            margin: 0 0 10px;
            font-size: 13px;
            font-weight: 700;
            color: #111827;
        }

        .event-reward-list {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .event-reward-item {
            display: flex;
            flex-direction: column;
            gap: 2px;
        }

        .event-reward-item span {
            font-size: 11px;
            line-height: 1.4;
            color: #6b7280;
        }

        .event-reward-item strong {
            font-size: 15px;
            line-height: 1.35;
            color: #15803d;
            overflow-wrap: anywhere;
        }

        .event-rules ul {
            margin: 0;
            padding-left: 15px;
            font-size: 11px;
            line-height: 1.5;
            color: #4b5563;
        }

        .event-rules li {
            margin-bottom: 7px;
            padding-left: 1px;
        }

        .event-rules li:last-child {
            margin-bottom: 0;
        }

        .event-period {
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 4px 10px;
            margin-top: 12px;
            padding: 10px 12px;
            border-radius: 8px;
            background: #f3f4f6;
        }

        .event-period span {
            font-size: 11px;
            color: #6b7280;
        }

        .event-period strong {
            font-size: 12px;
            color: #111827;
        }

        .event-modal-footer {
            flex-shrink: 0;
            padding: 10px 16px 14px;
            border-top: 1px solid #f3f4f6;
            background: #fff;
        }

        .event-close-button {
            display: block;
            width: 100%;
            padding: 10px 14px;
            border: 0;
            border-radius: 8px;
            background: #eb3c25;
            color: #fff;
            font-size: 13px;
            font-weight: 650;
        }

        .event-close-button:hover,
        .event-close-button:focus {
            background: #ac1103;
            color: #fff;
        }

        /* HP */
        @media (max-width: 480px) {
            .event-modal-dialog {
                width: calc(100% - 20px);
                margin: 10px auto;
            }

            .event-modal-content {
                max-height: calc(100dvh - 20px);
                border-radius: 13px;
            }

            .event-modal-body {
                padding: 0 12px 12px;
            }

            .event-poster {
                width: min(100%, 240px);
                margin-bottom: 10px;
            }

            .event-title {
                font-size: 18px;
            }

            .event-subtitle {
                margin-bottom: 12px;
            }

            .event-info-grid {
                gap: 8px;
            }

            .event-rewards,
            .event-rules {
                padding: 9px;
            }

            .event-rewards h6,
            .event-rules h6 {
                font-size: 12px;
            }

            .event-reward-item strong {
                font-size: 13px;
            }

            .event-reward-item span,
            .event-rules ul {
                font-size: 10px;
            }

            .event-rules ul {
                padding-left: 13px;
            }

            .event-period {
                align-items: flex-start;
                flex-direction: column;
            }
        }

        /* Layar pendek: kurangi ukuran poster agar informasi lebih cepat terlihat */
        @media (max-height: 760px) {
            .event-poster {
                width: min(100%, 190px);
            }

            .event-title {
                font-size: 18px;
            }

            .event-subtitle {
                margin-bottom: 10px;
            }

            .event-rewards,
            .event-rules {
                padding: 9px;
            }

            .event-reward-list {
                gap: 7px;
            }
        }
    </style>
    <div class="row row-cols-1 row-cols-sm-2 row-cols-xl-2 row-cols-xxl-4 g-3 mb-4">
        <div class="col">
            <div class="counter counter-secondary">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Downloads', 'dashboard') }}</h6>
                        <p class="counter-number">{{ number_format($counters['downloads']) }}</p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M20 15V18C20 19.1046 19.1046 20 18 20H6C4.89543 20 4 19.1046 4 18L4 15M8 11L12 15M12 15L16 11M12 15V3"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-green">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Downloads Earnings', 'dashboard') }}</h6>
                        <p class="counter-number">
                            {{ earnings($counters['earnings']) }}
                        </p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M9.5 13.75C9.5 14.72 10.25 15.5 11.17 15.5H13.05C13.85 15.5 14.5 14.82 14.5 13.97C14.5 13.06 14.1 12.73 13.51 12.52L10.5 11.47C9.91 11.26 9.51001 10.94 9.51001 10.02C9.51001 9.17999 10.16 8.48999 10.96 8.48999H12.84C13.76 8.48999 14.51 9.26999 14.51 10.24"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M12 7.5V16.5" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 12C22 17.52 17.52 22 12 22C6.48 22 2 17.52 2 12C2 6.48 6.48 2 12 2"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M17 3V7H21" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            <path d="M22 2L17 7" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-yellow">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Average CPM', 'dashboard') }}</h6>
                        <p class="counter-number">
                            {{ earnings($counters['cpm']) }}
                        </p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <g id="Interface / Chart_Line">
                                <path id="Vector"
                                    d="M3 15.0002V16.8C3 17.9201 3 18.4798 3.21799 18.9076C3.40973 19.2839 3.71547 19.5905 4.0918 19.7822C4.5192 20 5.07899 20 6.19691 20H21.0002M3 15.0002V5M3 15.0002L6.8534 11.7891L6.85658 11.7865C7.55366 11.2056 7.90288 10.9146 8.28154 10.7964C8.72887 10.6567 9.21071 10.6788 9.64355 10.8584C10.0105 11.0106 10.3323 11.3324 10.9758 11.9759L10.9822 11.9823C11.6357 12.6358 11.9633 12.9635 12.3362 13.1153C12.7774 13.2951 13.2685 13.3106 13.7207 13.1606C14.1041 13.0334 14.4542 12.7275 15.1543 12.115L21 7"
                                    stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                            </g>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
        <div class="col">
            <div class="counter counter-primary">
                <div class="card-v">
                    <div class="counter-info">
                        <h6 class="counter-title">{{ translate('Referral Earnings', 'dashboard') }}</h6>
                        <p class="counter-number">
                            {{ earnings($counters['referral_earnings']) }}
                        </p>
                    </div>
                    <div class="counter-icon">
                        <svg width="70px" height="70px" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M19 14C21.2091 14 23 16 23 17.5C23 18.3284 22.3284 19 21.5 19H21M17 11C18.6569 11 20 9.65685 20 8C20 6.34315 18.6569 5 17 5M5 14C2.79086 14 1 16 1 17.5C1 18.3284 1.67157 19 2.5 19H3M7 11C5.34315 11 4 9.65685 4 8C4 6.34315 5.34315 5 7 5M16.5 19H7.5C6.67157 19 6 18.3284 6 17.5C6 15 9 14 12 14C15 14 18 15 18 17.5C18 18.3284 17.3284 19 16.5 19ZM15 8C15 9.65685 13.6569 11 12 11C10.3431 11 9 9.65685 9 8C9 6.34315 10.3431 5 12 5C13.6569 5 15 6.34315 15 8Z"
                                stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-v mb-3">
        <h5 class="mb-3">{{ translate('Statistics', 'dashboard') }}</h5>
        <div class="dash-chart">
            <canvas id="statistics-chart"></canvas>
        </div>
    </div>
    <div class="card-v">
        <div class="dash-table dash-table-hiehgt">
            <table class="table text-center table-borderless">
                <thead>
                    <tr>
                        <th>{{ translate('Date', 'dashboard') }}</th>
                        <th>{{ translate('Downloads', 'dashboard') }}</th>
                        <th>{{ translate('Downloads Earnings', 'dashboard') }}</th>
                        <th>{{ translate('Daily CPM', 'dashboard') }}</th>
                        <th>{{ translate('Referrals Earnings', 'dashboard') }}</th>
                    </tr>
                </thead>
                <tbody class="text-muted">
                    @foreach ($tableData as $key => $data)
                        <tr>
                            <td>{{ $key }}</td>
                            <td>{{ number_format($data['downloads']) }}</td>
                            <td>{{ earnings($data['download_earnings']) }}</td>
                            <td>{{ earnings($data['cpm']) }}</td>
                            <td>{{ earnings($data['referral_earnings']) }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @push('top_scripts')
        <script>
            "use strict";
            const chartConfig = {!! json_encode([
                'line' => [
                    'title' => translate('Downloads', 'dashboard'),
                    'labels' => $chart['labels'],
                    'data' => $chart['data'],
                    'max' => $chart['max'],
                ],
            ]) !!};
        </script>
    @endpush
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const eventModal = document.getElementById(
                    'eventAnnouncementModal'
                );

                if (!eventModal || !window.bootstrap) {
                    return;
                }

                const eventConfig = {
                    enabled: @json((bool) config('event.announcement_enabled')),
                    startDate: @json(config('event.start_date')),
                    endDate: @json(config('event.end_date')),
                    today: @json(now(config('app.timezone'))->toDateString())
                };

                // Jangan tampilkan jika event dinonaktifkan.
                if (!eventConfig.enabled) {
                    return;
                }

                // Pastikan konfigurasi tanggal tersedia.
                if (!eventConfig.startDate || !eventConfig.endDate) {
                    return;
                }

                // Pastikan format tanggal valid.
                const isValidDate = (value) => {
                    if (!/^\d{4}-\d{2}-\d{2}$/.test(value)) {
                        return false;
                    }

                    const date = new Date(value + 'T00:00:00Z');

                    return !Number.isNaN(date.getTime()) &&
                        date.toISOString().slice(0, 10) === value;
                };

                if (
                    !isValidDate(eventConfig.startDate) ||
                    !isValidDate(eventConfig.endDate) ||
                    eventConfig.startDate > eventConfig.endDate
                ) {
                    console.warn('Konfigurasi periode event tidak valid.');
                    return;
                }

                // Event hanya aktif dalam rentang tanggal yang ditentukan.
                const isWithinEventPeriod =
                    eventConfig.today >= eventConfig.startDate &&
                    eventConfig.today <= eventConfig.endDate;

                if (!isWithinEventPeriod) {
                    return;
                }

                // Tampilkan modal jika event aktif dan masih dalam periode.
                const modal = bootstrap.Modal.getOrCreateInstance(eventModal);
                modal.show();
            });
        </script>
    @endpush

    @push('scripts_libs')
        <script src="{{ asset('vendor/libs/chartjs/chart.min.js') }}"></script>
        <script src="{{ theme_asset('assets/js/charts.js') }}"></script>
    @endpush
@endsection
