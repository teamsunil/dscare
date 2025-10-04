@extends('admin.layouts.app')
@section('content')


    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <meta name="csrf-token" content="{{ csrf_token() }}">


    <style>
        /* Card */
        .dashboard_table {
            width: 100%;
            max-width: var(--max-width);
            border: 1px solid rgba(255, 255, 255, 0.06);
            border-radius: var(--radius-lg)overflow:hidden;
        }




        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(6px)
            }

            to {
                opacity: 1;
                transform: translateY(0)
            }
        }

        .dashboard_table .card-panel {
            background: var(--glass);
            border-radius: 12px;
            padding: 16px;
            border: 1px solid rgba(255, 255, 255, 0.04);
        }

        /* Tab container */
        .dashboard_table .tabs {}

        .dashboard_table .tablist_btns {
            height: calc(var(--tab-height) + 12px);
            background: linear-gradient(135deg, rgba(255, 255, 255, 0.95) 0%, rgba(255, 255, 255, 0.90) 50%, rgba(248, 250, 252, 0.95) 100%);
            width: 100%;
            padding: 0 20px
        }

        .dashboard_table .tablist {
            display: grid;
            grid-template-columns: repeat(7, 1fr);
            gap: 8px;
            border-radius: 0;
            padding: 26px;
            position: relative;
            align-items: center;
            /* max-width: 700px; */
            margin: auto;
        }

        .dashboard_table .tab {
            position: relative;
            z-index: 2;
            height: var(--tab-height);
            display: flex;
            align-items: center;
            gap: 10px;
            justify-content: center;
            text-align: center;
            padding: 11px 10px;
            border-radius: 10px;
            cursor: pointer;
            font-weight: normal;
            color: rgba(230, 238, 248, 0.85);
            background: transparent;
            border: none;
            outline: none;
            transition: color .18s ease;
            user-select: none;
            background: #2c437c;
            overflow: hidden
        }

        .dashboard_table .tab svg {
            width: 18px;
            height: 18px;
            opacity: 0.92;
            z-index: 9;
        }

        .dashboard_table .tab span {
            z-index: 9;
            color: #fff;
        }

        .dashboard_table .tab:hover:after {
            width: 100%;
            height: 100%;
            opacity: 1;
            border-radius: 0;
        }

        .dashboard_table .tab:after {
            content: "";
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            background: rgb(113 141 211 / 54%);
            border-radius: 50%;
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease, opacity 0.6s ease;
            opacity: 0;
        }

        .dashboard_table .tab.active:hover:after {
            opacity: 0;
        }

        /* Selected tab text color */
        .dashboard_table .tab[aria-selected="true"] {
            color: #fff;
        }

        /* Panels */
        .dashboard_table .panels {
            margin-top: 18px;
            min-height: 220px;
            padding: 0px 20px;
        }

        .panel {
            display: none;
            animation: fadeIn .28s ease both;
        }

        .dashboard_table .panel[data-active="true"] {
            display: block;
        }


        .dashboard_table .table-container {
            max-width: 1100px;
            margin: auto;
            background: #fff;
            border-radius: 16px;
            overflow: hiddenll;
            box-shadow: 0 6px 20px rgba(0, 0, 0, 0.08);
        }

        .dashboard_table .table-container table {
            width: 100%;
            border-collapse: collapse;
        }

        .dashboard_table .table-container thead {
            background: #2c437c
        }

        .dashboard_table .table-container th,
        td {
            padding: 16px 18px;
            text-align: left;
            font-size: 15px;
            color: #000;
        }

        .dashboard_table .table-container th {
            font-weight: 600;
            letter-spacing: 0.5px;
            color: #fff;
        }

        .dashboard_table .table-container tbody tr {
            transition: background 0.3s ease;
        }

        .dashboard_table .table-container tbody tr:nth-child(even) {
            background: #f9fbfd;
        }

        .dashboard_table .table-container tbody tr:hover {
            background: #eef7ff;
        }

        .dashboard_table .table-container .plugin-name a {
            font-weight: normal;
            color: #000;
            text-decoration: none;
            transition: color 0.3s;
        }

        .dashboard_table .table-container .plugin-name a:hover {
            color: #f48226;
            text-decoration: underline;
        }

        .dashboard_table .table-container .badge {
            display: inline-block;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
            text-align: center;
            white-space: nowrap;
        }

        .dashboard_table .table-container .active {
            background: #28a745;
            color: #fff;
        }

        .dashboard_table .table-container .inactive {
            background: #6c757d;
            color: #fff;
        }

        .dashboard_table .table-container .update {
            background: #ff9800;
            color: #fff;
        }

        .dashboard_table .table-container .latest {
            background: #2c437c;
            color: #fff;
        }

        .dashboard_table .table-container .version-highlight {
            font-weight: bold;
            color: #0073aa;
        }

        .dashboard_table .table-container img.plugin-icon {
            width: 26px;
            height: 26px;
            border-radius: 6px;
        }

        .dashboard_table .tab.active {
            background: #F48226;
            border-radius: 0;
            border-radius: 10px;
            font-weight: normal;
        }



        .website-details-container {
            min-height: 100vh;
            background:
                radial-gradient(ellipse at top left, rgba(102, 126, 234, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at top right, rgba(240, 147, 251, 0.15) 0%, transparent 50%),
                radial-gradient(ellipse at bottom left, rgba(118, 75, 162, 0.1) 0%, transparent 50%),
                radial-gradient(ellipse at bottom right, rgba(255, 119, 198, 0.1) 0%, transparent 50%),
                linear-gradient(135deg,
                    rgba(248, 250, 252, 0.95) 0%,
                    rgba(241, 245, 249, 0.98) 25%,
                    rgba(226, 232, 240, 0.95) 50%,
                    rgba(203, 213, 225, 0.98) 75%,
                    rgba(148, 163, 184, 0.9) 100%);
            position: relative;
            overflow-x: hidden;
        }

        /* Header Section */
        .page-header {
            background: linear-gradient(145deg, rgba(255, 255, 255, 0.98) 0%, rgba(255, 255, 255, 0.92) 100%);
            backdrop-filter: blur(25px) saturate(180%);
            border-radius: 24px;
            padding: 2rem;
            margin-bottom: 2rem;
            box-shadow:
                0 20px 60px rgba(102, 126, 234, 0.15),
                0 8px 32px rgba(0, 0, 0, 0.1),
                inset 0 1px 0 rgba(255, 255, 255, 0.6);
            border: 1px solid rgba(255, 255, 255, 0.3);
            position: relative;
            overflow: hidden;
            text-align: center;
        }

        .page-header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: linear-gradient(90deg, #2C437C 0%, #405792ff 50%, #F48226 100%);
        }

        .website-logo {
            width: 120px;
            height: 120px;
            border-radius: 30px;
            margin: 0 auto 1.5rem;
            box-shadow: 0 20px 60px rgba(102, 126, 234, 0.2);
            overflow: hidden;
            position: relative;
            background: linear-gradient(145deg, #f8fafc 0%, #e2e8f0 100%);
        }

        .website-logo img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .logo-placeholder {
            width: 100%;
            height: 100%;
            display: flex;
            align-items: center;
            justify-content: center;
            background: #F48226;
            color: white;
            font-size: 2.5rem;
        }

        .website-title {
            font-size: 2.2rem;
            font-weight: 800;
            background: #2C437C;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 0.5rem;
        }

        .website-url {
            color: #6c757d;
            text-decoration: none;
            font-size: 1.1rem;
            font-weight: 500;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 1.5rem;
            transition: all 0.3s ease;
        }

        .website-url:hover {
            color: #667eea;
            transform: translateY(-2px);
        }

        .status-info-bar {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 1rem;
            margin-top: 1rem;
        }

        /* Management Cards Grid */
        .management-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
            margin-top: 2rem;
        }

        .management-card {
            background: linear-gradient(145deg,
                    rgba(255, 255, 255, 0.98) 0%,
                    rgba(255, 255, 255, 0.95) 50%,
                    rgba(248, 250, 252, 0.98) 100%);
            backdrop-filter: blur(25px) saturate(180%);
            border-radius: 24px;
            padding: 2rem;
            box-shadow:
                0 20px 60px rgba(102, 126, 234, 0.08),
                0 8px 32px rgba(0, 0, 0, 0.06),
                inset 0 1px 0 rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.4);
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
            margin-bottom: 2rem;
        }

        .management-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--card-gradient);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .management-card:hover {
            transform: translateY(-8px) scale(1.02);
            box-shadow:
                0 32px 80px rgba(102, 126, 234, 0.12),
                0 20px 60px rgba(240, 147, 251, 0.08),
                0 12px 40px rgba(0, 0, 0, 0.08);
        }

        .management-card:hover::before {
            transform: scaleX(1);
        }

        .card-icon {
            width: 60px;
            height: 60px;
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.8rem;
            color: white;
            margin-bottom: 1.5rem;
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
        }

        .wordpress-card {
            --card-gradient: linear-gradient(135deg, #21759b 0%, #0073aa 100%);
        }

        .wordpress-card .card-icon {
            background: linear-gradient(135deg, #21759b 0%, #0073aa 100%);
        }

        .plugins-card {
            --card-gradient: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .plugins-card .card-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .themes-card {
            --card-gradient: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .themes-card .card-icon {
            background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%);
        }

        .users-card {
            --card-gradient: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .users-card .card-icon {
            background: linear-gradient(135deg, #4ecdc4 0%, #44a08d 100%);
        }

        .card-title {
            font-size: 1.3rem;
            font-weight: 700;
            color: #2d3436;
            margin-bottom: 0.8rem;
        }

        .card-stats {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
            margin-bottom: 1.5rem;
            align-items: center;
        }

        .stat-item {
            display: flex;
            flex-direction: column;
            background: #eff3fb;
            border-radius: 10px;
            padding: 5px 10px;
            border: 1px solid #e0e2ff;
            text-align: center;
        }

        .stat-value {
            font-size: 1rem;
            font-weight: 700;
            color: #2d3436;
        }

        .stat-label {
            font-size: 0.6rem;
            color: #2c437c;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }

        .version-badge {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            padding: 0.4rem 0.8rem;
            border-radius: 15px;
            font-size: 0.85rem;
            font-weight: 600;
            border: 1px solid rgba(102, 126, 234, 0.2);
        }

        .manage-btn {
            background: #2c437c;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 10px;
            color: white;
            font-weight: 600;
            font-size: 0.9rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .manage-btn:hover {
            transform: translateY(-2px);
            color: white;
            background: #f48226;
        }

        .wp-admin-btn {
            background: #f48226;
        }

        .wp-admin-btn:hover {}

        .back-btn {
            background: #2c437c;
            backdrop-filter: blur(15px);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 0.8rem 1.5rem;
            border-radius: 18px;
            color: #667eea;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            transition: all 0.3s ease;
            margin-bottom: 2rem;
        }

        .back-btn:hover {
            background: rgba(102, 126, 234, 0.1);
            color: #667eea;
            transform: translateX(-5px);
        }

        /* Floating Elements */
        .floating-element-1 {
            position: absolute;
            top: 10%;
            right: 10%;
            width: 100px;
            height: 100px;
            background: rgba(102, 126, 234, 0.1);
            border-radius: 30% 70% 70% 30% / 30% 30% 70% 70%;
            animation: float 8s ease-in-out infinite;
        }

        .floating-element-2 {
            position: absolute;
            bottom: 20%;
            left: 5%;
            width: 80px;
            height: 80px;
            background: rgba(240, 147, 251, 0.1);
            border-radius: 63% 37% 54% 46% / 55% 48% 52% 45%;
            animation: float 6s ease-in-out infinite reverse;
        }

        .table thead th {
            font-weight: 600;
            color: #333;
            text-transform: uppercase;
            font-size: 13px;
            border-bottom: 2px solid #eee;
        }

        .table td {
            vertical-align: middle;
            font-size: 14px;
        }

        .table td img {
            border-radius: 8px;
            background: #f8f9fa;
            padding: 4px;
        }

        .badge {
            font-size: 12px;
            padding: 6px 10px;
            border-radius: 12px;
        }

        .badge.bg-success {
            background: #28a745 !important;
        }

        .badge.bg-secondary {
            background: #6c757d !important;
        }

        .badge.bg-warning {
            background: #ffc107 !important;
            color: #000;
            font-weight: 600;
        }

        .badge.bg-info {
            background: #17a2b8 !important;
        }

        .table td a {
            color: #007bff;
            /* Bootstrap primary blue */
            font-size: 13px;
            text-decoration: none;
        }

        .table td a:hover {
            text-decoration: underline;
        }

        .fancybox__container {
            z-index: 2000 !important;
            /* higher than Bootstrap modal */
        }


        @keyframes float {

            0%,
            100% {
                transform: translateY(0px) rotate(0deg);
            }

            50% {
                transform: translateY(-20px) rotate(5deg);
            }
        }

        @media (max-width: 991px) {
            .dashboard_table .tablist {
                overflow: scroll;
                padding: 20px 0;
                width: 800px
            }

            .dashboard_table .table-container {
                overflow: scroll;
            }

            .dashboard_table .tablist_btns {
                overflow: scroll;
            }
        }

        @media (max-width: 768px) {
            .management-grid {
                grid-template-columns: 1fr;
                gap: 1rem;
            }

            .website-title {
                font-size: 1.8rem;
            }

            .management-card {
                padding: 1.5rem;
            }

            .page-header {
                padding: 1.5rem;
            }
        }
    </style>
    @php
    @endphp

    <div class="website-details-container ">
        <!-- Floating Decorative Elements -->
        <div class="floating-element-1"></div>
        <div class="floating-element-2"></div>

        <!-- Beautiful Header -->
        <header class="main-header">

            <!-- Website Details Header -->


            <main class="dashboard_table" role="main">

                <section class="tabs" aria-labelledby="tabs-heading">

                    <!-- Tablist -->
                    <div class="tablist_btns">
                        <div class="tablist" role="tablist" aria-label="Main tabs" id="tablist">

                            <button class="tab tabchnage active" role="tab" data-id="tab-overview" id="tab-overview"
                                aria-controls="panel-overview" aria-selected="true" tabindex="0" data-index="0">
                                <!-- home icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                    <path fill="#ffffff"
                                        d="M125.7 233.4L227.2 511.4C156.2 477 107.3 404.2 107.3 320C107.3 289.1 113.9 259.9 125.7 233.4zM463.6 309.3C463.6 283 454.2 264.8 446.1 250.6C435.3 233.1 425.2 218.2 425.2 200.7C425.2 181.1 440 162.9 460.9 162.9C461.8 162.9 462.7 163 463.7 163.1C425.8 128.4 375.4 107.2 320 107.2C245.7 107.2 180.3 145.3 142.2 203.1C147.2 203.3 151.9 203.4 155.9 203.4C178.1 203.4 212.6 200.7 212.6 200.7C224.1 200 225.4 216.9 214 218.2C214 218.2 202.5 219.5 189.7 220.2L267.2 450.6L313.8 311L280.7 220.2C269.2 219.5 258.4 218.2 258.4 218.2C246.9 217.5 248.3 200 259.7 200.7C259.7 200.7 294.8 203.4 315.7 203.4C337.9 203.4 372.4 200.7 372.4 200.7C383.9 200 385.2 216.9 373.8 218.2C373.8 218.2 362.3 219.5 349.5 220.2L426.4 448.9L447.6 378C456.6 348.6 463.6 327.5 463.6 309.3zM323.7 338.6L259.9 524.1C279 529.7 299.1 532.8 320 532.8C344.8 532.8 368.5 528.5 390.6 520.7C390 519.8 389.5 518.8 389.1 517.8L323.7 338.6zM506.7 217.9C507.6 224.7 508.1 231.9 508.1 239.8C508.1 261.4 504.1 285.6 491.9 316L426.9 503.9C490.2 467 532.7 398.5 532.7 320C532.7 283 523.3 248.2 506.7 217.9zM72 320C72 183 183 72 320 72C457 72 568 183 568 320C568 457 457 568 320 568C183 568 72 457 72 320zM556.6 320C556.6 189.3 450.7 83.4 320 83.4C189.3 83.4 83.4 189.3 83.4 320C83.4 450.7 189.3 556.6 320 556.6C450.7 556.6 556.6 450.7 556.6 320z" />
                                </svg>
                                <span>WordPress</span>
                            </button>


                            <button class="tab tabchnage" role="tab" data-id="tab-plugins" id="tab-plugins"
                                aria-controls="panel-features" aria-selected="false" tabindex="-1" data-index="1"
                                data-plugin-response = '@json(data_get($response, 'plugins', null))' data-plugin-id="{{ $result->id }}">
                                <!-- grid icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                    <path fill="#ffffff"
                                        d="M224 32C241.7 32 256 46.3 256 64L256 160L384 160L384 64C384 46.3 398.3 32 416 32C433.7 32 448 46.3 448 64L448 160L512 160C529.7 160 544 174.3 544 192C544 209.7 529.7 224 512 224L512 288C512 383.1 442.8 462.1 352 477.3L352 544C352 561.7 337.7 576 320 576C302.3 576 288 561.7 288 544L288 477.3C197.2 462.1 128 383.1 128 288L128 224C110.3 224 96 209.7 96 192C96 174.3 110.3 160 128 160L192 160L192 64C192 46.3 206.3 32 224 32z" />
                                </svg>
                                <span>Plugins</span>
                            </button>

                            <button class="tab tabchnage" role="tab" data-id="tab-themes" id="tab-themes"
                                aria-controls="panel-gallery" aria-selected="false" tabindex="-1" data-index="2"
                                data-theme-response = '@json(data_get($response, 'themes', null))' data-theme-id="{{ $result->id }}">
                                <!-- image icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                    <path fill="#ffffff"
                                        d="M576 320C576 320.9 576 321.8 576 322.7C575.6 359.2 542.4 384 505.9 384L408 384C381.5 384 360 405.5 360 432C360 435.4 360.4 438.7 361 441.9C363.1 452.1 367.5 461.9 371.8 471.8C377.9 485.6 383.9 499.3 383.9 513.8C383.9 545.6 362.3 574.5 330.5 575.8C327 575.9 323.5 576 319.9 576C178.5 576 63.9 461.4 63.9 320C63.9 178.6 178.6 64 320 64C461.4 64 576 178.6 576 320zM192 352C192 334.3 177.7 320 160 320C142.3 320 128 334.3 128 352C128 369.7 142.3 384 160 384C177.7 384 192 369.7 192 352zM192 256C209.7 256 224 241.7 224 224C224 206.3 209.7 192 192 192C174.3 192 160 206.3 160 224C160 241.7 174.3 256 192 256zM352 160C352 142.3 337.7 128 320 128C302.3 128 288 142.3 288 160C288 177.7 302.3 192 320 192C337.7 192 352 177.7 352 160zM448 256C465.7 256 480 241.7 480 224C480 206.3 465.7 192 448 192C430.3 192 416 206.3 416 224C416 241.7 430.3 256 448 256z" />
                                </svg>
                                <span>Themes</span>
                            </button>

                            <button class="tab tabchnage" role="tab" data-id="tab-users" id="tab-users"
                                aria-controls="panel-settings" aria-selected="false" tabindex="-1" data-index="3"
                                data-user-response = '@json(data_get($response, 'users', null))' data-user-id="{{ $result->id }}">
                                <!-- settings icon -->
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 640 640">
                                    <path fill="#ffffff"
                                        d="M320 312C386.3 312 440 258.3 440 192C440 125.7 386.3 72 320 72C253.7 72 200 125.7 200 192C200 258.3 253.7 312 320 312zM290.3 368C191.8 368 112 447.8 112 546.3C112 562.7 125.3 576 141.7 576L498.3 576C514.7 576 528 562.7 528 546.3C528 447.8 448.2 368 349.7 368L290.3 368z" />
                                </svg>
                                <span>Users</span>
                            </button>


                            <button class="tab tabchnage" role="tab" data-id="tab-backup" id="tab-backup"
                                aria-controls="panel-features" aria-selected="false" tabindex="-1" data-index="1"
                                data-backup-id="{{ $result->id }}">
                                <!-- grid icon -->
                                <i class="fas fa-cogs"></i>
                                <span>View Backup</span>
                            </button>

                            <a href="{{ route('website.details', $result->id) }}">
                                <button class="tab tabchnage">
                                    <!-- grid icon -->
                                    <i class="fas fa-book"></i>
                                    <span>View Details</span>
                                </button>
                            </a>

                            {{-- <a href="{{ url('admin/website/reload', $result->id) . '/data' }}">
                                <button class="tab" id="refreshPageBtn" type="button">
                                    <!-- grid icon -->
                                    <i class="fas fa-refresh"></i>
                                    <span>Refresh</span>
                                </button>
                            </a> --}}

                            <!-- AJAX Reload button -->
                            <button class="tab" id="ajaxReloadBtn" type="button" title="Reload data via AJAX">
                                <i class="fas fa-sync-alt"></i>
                                <span id="ajaxReloadBtnText">Reload Data</span>
                            </button>


                        </div>
                    </div>

                    <!-- Panels -->
                    <div class="panels" id="panels">
                        <!-- Wordpress panel -->
                        <section id="panel-overview" class="panel" role="tabpanel" aria-labelledby="tab-overview"
                            data-active="true">
                            <div class="container-fluid px-4">
                                <!-- Back Button -->
                                {{-- <a href="{{ url()->previous() }}" class="back-btn">
                                    <i class="fas fa-arrow-left"></i>
                                    Back to Dashboard
                                </a> --}}
                                <div class="page-header">
                                    <div class="website-logo">
                                        @if (!empty($result->pagespeed_screenshot))
                                            <img src="{{ $result->pagespeed_screenshot }}"
                                                alt="{{ $result->title ?? $result->url }}">
                                        @else
                                            <div class="logo-placeholder">
                                                {{ strtoupper(substr($result->title ?? $result->url, 0, 1)) }}</div>
                                        @endif
                                    </div>

                                    <h2 class="website-title">
                                        {{ $result->title ?? (parse_url($result->url ?? '', PHP_URL_HOST) ?? $result->url) }}
                                    </h2>

                                    <div style="margin-bottom:12px;">
                                        @php
                                            $siteHref =
                                                isset($result->url) && strpos($result->url, 'http') === 0
                                                    ? $result->url
                                                    : 'https://' . ($result->url ?? '#');
                                        @endphp
                                        <a class="website-url" href="{{ $siteHref }}"
                                            target="_blank">{{ $result->url ?? '—' }}</a>
                                    </div>

                                    <div class="status-info-bar" style="margin-top:8px; gap:0.75rem;">
                                        @if (isset($result->website_up_down))
                                            @if ($result->website_up_down == 1)
                                                <span class="badge bg-success">Up</span>
                                            @else
                                                <span class="badge bg-secondary">Down</span>
                                            @endif
                                        @endif

                                        @if (!empty($result->website_status))
                                            <span class="badge bg-info">{{ Str::title($result->website_status) }}</span>
                                        @endif

                                        @if (!empty($result->pagespeed_performance))
                                            <span class="badge bg-warning">Performance:
                                                {{ $result->pagespeed_performance }}</span>
                                        @endif

                                        {{-- WordPress & PHP versions (show in header) --}}
                                        @if (!empty(data_get($response, 'wordpress_version')))
                                            <span class="version-badge">WP Current Version: {{ data_get($response, 'wordpress_version') }}</span>
                                        @endif

                                        @if (!empty(data_get($response, 'env.php_version')))
                                            <span class="badge bg-info">PHP: {{ data_get($response, 'env.php_version') }}</span>
                                        @elseif(!empty($result->php_version))
                                            <span class="badge bg-info">PHP: {{ $result->php_version }}</span>
                                        @endif

                                        @if (!empty($result->created_at))
                                            <span style="color:#6c757d; font-size:0.9rem;">Added:
                                                {{ date('d M Y', strtotime($result->created_at)) }}</span>
                                        @endif
                                    </div>

                                    <div style="margin-top:16px; display:flex; gap:12px; justify-content:center;">
                                        <a href="{{ url('website/sso-login', $result->id) }}" target="_blank"
                                            class="manage-btn wp-admin-btn">
                                            <i class="fas fa-cog"></i> WP-Admin
                                        </a>

                                        <a href="{{ $siteHref }}" target="_blank" class="manage-btn"
                                            style="background:#4a5568;">
                                            <i class="fas fa-external-link-alt"></i> Visit Site
                                        </a>

                                        <button class="manage-btn" id="copyUrlBtn" type="button"
                                            onclick="navigator.clipboard && navigator.clipboard.writeText('{{ $siteHref }}')">
                                            <i class="fas fa-link"></i> Copy URL
                                        </button>
                                        @if (data_get($response, 'wordpress_update_available'))
                                            <a class="manage-btn btn-primary  updateBtn" data-type="core"
                                                data-action="update" data-slug="">Update</a>
                                        @endif

                                    </div>

                                    @if (data_get($response, 'site_health.description'))
                                        <div
                                            style="margin-top:14px; color:#2c437c; font-size:0.98rem; max-width:900px; margin-left:auto; margin-right:auto;">
                                            {{ data_get($response, 'site_health.description') }}
                                        </div>
                                    @endif
                                </div>

                                <!-- Management Cards -->
                                <div class="management-grid">
                                    <!-- WordPress Card -->
                                    {{-- <div class="management-card wordpress-card">
                                        <div class="card-icon">
                                            <i class="fab fa-wordpress"></i>
                                        </div>
                                        <h3 class="card-title">WordPress</h3>
                                        <div class="card-stats">
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'wordpress_version', 'N/A') }}</span>
                                                <span class="stat-label">Current Version</span>
                                            </div>
                                            @if (data_get($response, 'wordpress_update_available'))
                                                <div>

                                                    <span class="version-badge">Update Available</span>
                                                </div>
                                            @endif
                                             @if (data_get($response, 'wordpress_update_available'))
                                            <a class="manage-btn btn-primary  updateBtn" data-type="core"
                                                data-action="update" data-slug="">Update</a>
                                        @endif
                                        </div> --}}

                                        {{-- {{dd($response)}} --}}
                                        {{-- <a href="#" class="manage-btn btn-primary updateBtn" data-type="core"
                                            data-action="update" data-slug="">Update</a> --}}


                                    {{-- </div> --}}

                                    <!-- Plugins Card -->
                                    <div class="management-card plugins-card">
                                        <div class="card-icon">
                                            <i class="fas fa-plug"></i>
                                        </div>
                                        <h3 class="card-title">Plugins</h3>
                                        <div class="card-stats">
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'plugins.total', 0) }}</span>
                                                <span class="stat-label">Total</span>
                                            </div>
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'plugins.active', 0) }}</span>
                                                <span class="stat-label">Active</span>
                                            </div>
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'plugins.updates', 0) }}</span>
                                                <span class="stat-label">Updates</span>
                                            </div>
                                        </div>
                                        <button type="button" class="manage-btn btn btn-primary tab tabchnage"
                                            role="tab" data-id="tab-plugins" id="tab-plugins"
                                            aria-controls="panel-features" aria-selected="false" tabindex="-1"
                                            data-index="1" data-plugin-response = '@json(data_get($response, 'plugins', null))'
                                            data-plugin-id="{{ $result->id }}">
                                            <i class="fas fa-cogs"></i> Manage
                                        </button>
                                    </div>

                                    <!-- Themes Card -->
                                    <div class="management-card themes-card">
                                        <div class="card-icon">
                                            <i class="fas fa-palette"></i>
                                        </div>
                                        <h3 class="card-title">Themes</h3>
                                        <div class="card-stats">
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'themes.total', 0) }}</span>
                                                <span class="stat-label">Total</span>
                                            </div>
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'themes.current', 1) }}</span>
                                                <span class="stat-label">Active</span>
                                            </div>
                                        </div>
                                        <button type="button" class=" manage-btn btn btn-primary tab tabchnage"role="tab"
                                            data-id="tab-themes" id="tab-themes" aria-controls="panel-gallery"
                                            aria-selected="false" tabindex="-1" data-index="2"
                                            data-theme-response = '@json(data_get($response, 'themes', null))'
                                            data-theme-id="{{ $result->id }}">
                                            <i class="fas fa-brush"></i> Manage
                                        </button>
                                    </div>

                                    <!-- Users Card -->
                                    <div class="management-card users-card">
                                        <div class="card-icon">
                                            <i class="fas fa-users"></i>
                                        </div>
                                        <h3 class="card-title">Users</h3>
                                        <div class="card-stats">
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'users.total', 0) }}</span>
                                                <span class="stat-label">Total</span>
                                            </div>
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'users.admins', 0) }}</span>
                                                <span class="stat-label">Admins</span>
                                            </div>
                                        </div>
                                        <button type="button" class="manage-btn btn btn-primary tab tabchnage"
                                            role="tab" data-id="tab-users" id="tab-users"
                                            aria-controls="panel-settings" aria-selected="false" tabindex="-1"
                                            data-index="3" data-user-response = '@json(data_get($response, 'users', null))'
                                            data-user-id="{{ $result->id }}">
                                            <i class="fas fa-user-cog"></i> Manage
                                        </button>
                                    </div>


                                    <!-- Speed Data Card -->
                                    <div class="management-card"
                                        style="--card-gradient: linear-gradient(135deg, #f48226 0%, #2c437c 100%);">
                                        <div class="card-icon"
                                            style="background: linear-gradient(135deg, #f48226 0%, #2c437c 100%);">
                                            <i class="fas fa-tachometer-alt"></i>
                                        </div>
                                        <h3 class="card-title">Speed Data</h3>
                                        <div class="card-stats">
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ $result->pagespeed_performance ?? 'N/A' }}</span>
                                                <span class="stat-label">Performance</span>
                                            </div>
                                            <div class="stat-item">
                                                <span class="stat-value">{{ $result->pagespeed_seo ?? 'N/A' }}</span>
                                                <span class="stat-label">SEO</span>
                                            </div>
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ $result->pagespeed_accessibility ?? 'N/A' }}</span>
                                                <span class="stat-label">Accessibility</span>
                                            </div>
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ $result->pagespeed_best_practices ?? 'N/A' }}</span>
                                                <span class="stat-label">Best Practices</span>
                                            </div>
                                        </div>

                                        <button class="manage-btn btn btn-info mt-2" id="runSpeedBtn" type="button">
                                            <i class="fas fa-tachometer-alt"></i> Run Speed Test
                                        </button>
                                    </div>

                                    <!-- Site Health Card -->
                                    <div class="management-card users-card"
                                        style="--card-gradient: linear-gradient(135deg, #44a08d 0%, #4ecdc4 100%);">
                                        <div class="card-icon"
                                            style="background: linear-gradient(135deg, #44a08d 0%, #4ecdc4 100%);">
                                            <i class="fas fa-heartbeat"></i>
                                        </div>
                                        <h3 class="card-title">Site Health</h3>
                                        <div class="card-stats">

                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'site_health.score', 'N/A') }}</span>
                                                <span class="stat-label">Score</span>
                                            </div>
                                            <div class="stat-item">

                                                <span
                                                    class="stat-value">{{ data_get($response, 'site_health.status_summary.critical', 'N/A') }}</span>
                                                <span class="stat-label">Critical</span>
                                            </div>
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'site_health.status_summary.recommended', 'N/A') }}</span>
                                                <span class="stat-label">Recommended</span>
                                            </div>
                                            <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ data_get($response, 'site_health.status_summary.good', 'N/A') }}</span>
                                                <span class="stat-label">Good</span>
                                            </div>


                                        </div>


                                        @if (data_get($response, 'site_health.description'))
                                            <div style="margin-top:1rem; color:#2c437c; font-size:0.95rem;">
                                                {{ data_get($response, 'site_health.description') }}
                                            </div>
                                        @endif
                                    </div>


                                    <!-- Backup Card -->
                                    <div class="management-card plugins-card">
                                        <div class="card-icon">
                                            <i class="fas fa-cogs"></i>
                                        </div>
                                        <h3 class="card-title">Backup</h3>
                                        <div class="card-stats">
                                            <div class="stat-item">
                                                <span class="stat-value">
                                                    @if ($date = data_get($backupdata, 'created_at'))
                                                        {{ date('d M Y', strtotime($date)) }}
                                                    @else
                                                        N/A
                                                    @endif
                                                </span>
                                                <span class="stat-label">Last Backup</span>
                                            </div>
                                            {{-- <div class="stat-item">
                                                <span
                                                    class="stat-value">{{ ucfirst(data_get($backupdata, 'type','N/A')) }}</span>
                                                <span class="stat-label">Type</span>
                                            </div> --}}

                                        </div>
                                        <button type="button" class="manage-btn btn btn-primary" data-toggle="modal"
                                            data-target="#backupTypeModal">
                                            <i class="fas fa-brush"></i> Backup
                                        </button>

                                    </div>

                                </div>
                            </div>
                        </section>

                        <!-- Plugin panel -->
                        <section id="panel-features" class="panel" role="tabpanel" aria-labelledby="tab-plugins"
                            data-active="false">
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Icon</th>
                                            <th>Name</th>
                                            <th>Version</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                            <th>Update</th>
                                        </tr>
                                    </thead>
                                    <tbody id="pluginTableBody">
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a href="https://4divi.com/">4DIVI Masonry
                                                    Gallery</a></td>
                                            <td>2.0.1</td>
                                            <td>Design Green Cat</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge latest">Latest</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://www.advancedcustomfields.com/wp-content/uploads/2020/12/acf-logo.png">
                                            </td>
                                            <td class="plugin-name"><a
                                                    href="https://www.advancedcustomfields.com">Advanced Custom
                                                    Fields</a></td>
                                            <td>6.4.0.1 → <span class="version-highlight">6.5.0</span></td>
                                            <td>WP Engine</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge update">Update to 6.5.0</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a
                                                    href="https://wordpress.org/plugins/tinymce-advanced/">Advanced
                                                    Editor Tools</a></td>
                                            <td>5.9.2</td>
                                            <td>Automattic</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge latest">Latest</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a href="https://servmask.com/">All-in-One WP
                                                    Migration and Backup</a></td>
                                            <td>7.97 → <span class="version-highlight">7.99</span></td>
                                            <td>ServMask</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge update">Update to 7.99</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <!-- Theme panel -->
                        <section id="panel-gallery" class="panel" role="tabpanel" aria-labelledby="tab-themes"
                            data-active="false">
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Screenshot</th>
                                            <th>Name</th>
                                            <th>Slug</th>

                                            <th>Version</th>
                                            <th>Author</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody id="themeTableBody">
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a href="https://4divi.com/">4DIVI Masonry
                                                    Gallery</a></td>
                                            <td>2.0.1</td>
                                            <td>Design Green Cat</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge latest">Latest</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://www.advancedcustomfields.com/wp-content/uploads/2020/12/acf-logo.png">
                                            </td>
                                            <td class="plugin-name"><a
                                                    href="https://www.advancedcustomfields.com">Advanced Custom
                                                    Fields</a></td>
                                            <td>6.4.0.1 → <span class="version-highlight">6.5.0</span></td>
                                            <td>WP Engine</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge update">Update to 6.5.0</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a
                                                    href="https://wordpress.org/plugins/tinymce-advanced/">Advanced
                                                    Editor Tools</a></td>
                                            <td>5.9.2</td>
                                            <td>Automattic</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge latest">Latest</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a href="https://servmask.com/">All-in-One WP
                                                    Migration and Backup</a></td>
                                            <td>7.97 → <span class="version-highlight">7.99</span></td>
                                            <td>ServMask</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge update">Update to 7.99</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>

                        <!-- Users panel -->
                        <section id="panel-settings" class="panel" role="tabpanel" aria-labelledby="tab-users"
                            data-active="false">
                            <div class="table-container">
                                <div class="d-flex justify-content-end mt-2 mb-2">
                                    <input type="text" id="roleSearch" class="form-control w-25"
                                        placeholder="Search by role...">
                                </div>
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Email</th>
                                            <th>Role</th>
                                        </tr>
                                    </thead>
                                    <tbody id="userTableBody">
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a href="https://4divi.com/">4DIVI Masonry
                                                    Gallery</a></td>
                                            <td>2.0.1</td>
                                            <td>Design Green Cat</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge latest">Latest</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://www.advancedcustomfields.com/wp-content/uploads/2020/12/acf-logo.png">
                                            </td>
                                            <td class="plugin-name"><a
                                                    href="https://www.advancedcustomfields.com">Advanced Custom
                                                    Fields</a></td>
                                            <td>6.4.0.1 → <span class="version-highlight">6.5.0</span></td>
                                            <td>WP Engine</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge update">Update to 6.5.0</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a
                                                    href="https://wordpress.org/plugins/tinymce-advanced/">Advanced
                                                    Editor Tools</a></td>
                                            <td>5.9.2</td>
                                            <td>Automattic</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge latest">Latest</span></td>
                                        </tr>
                                        <tr>
                                            <td><img class="plugin-icon"
                                                    src="https://s.w.org/style/images/about/WordPress-logotype-wmark.png">
                                            </td>
                                            <td class="plugin-name"><a href="https://servmask.com/">All-in-One WP
                                                    Migration and Backup</a></td>
                                            <td>7.97 → <span class="version-highlight">7.99</span></td>
                                            <td>ServMask</td>
                                            <td><span class="badge active">Active</span></td>
                                            <td><span class="badge update">Update to 7.99</span></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </section>
                        <!-- Backup panel -->
                        <section id="panel-settings" class="panel" role="tabpanel" aria-labelledby="tab-backup"
                            data-active="false">
                            <div class="table-container">
                                <table>
                                    <thead>
                                        <tr>
                                            <th>Type</th>
                                            <th>Files Name</th>
                                            <th>Date With Time</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="backupTableBody">
                                        @if ($backupAllData->isNotEmpty())

                                            @foreach ($backupAllData as $backup)
                                                @php
                                                    $type1 = explode('.', $backup->file_path);
                                                    $files1 = explode('/', $backup->file_path);

                                                @endphp
                                                <tr>
                                                    <td>
                                                        @if (isset($type1[1]) && $type1[1] === 'sql')
                                                            Database
                                                        @elseif (isset($type1[1]) && $type1[1] === 'zip')
                                                            Zip
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>
                                                    <td>
                                                        @if (isset($files1[2]))
                                                            {{ $files1[2] }}
                                                        @else
                                                            N/A
                                                        @endif
                                                    </td>

                                                    <td>{{ date('d M Y', strtotime($backup->created_at)) }}</td>
                                                    <td><a href="{{ asset('storage/' . $backup->file_path) }}"
                                                            target="_blank"><b class="fas fa-download"></b></a></td>
                                                </tr>
                                            @endforeach
                                        @else
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </section>
                    </div>
                </section>
            </main>
        </header>



    </div>

    <!-- Plugins Modal -->
    <div class="modal fade" id="managePluginModal" tabindex="-1" aria-labelledby="managePluginModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-height: 90vh;">
            <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fs-4">Manage Plugins</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                        <table class="table table-striped align-middle">
                            <thead style="position: sticky; top: 0; z-index: 2; background: #f8f9fa;">
                                <tr>
                                    <th
                                        style="width: 60px; text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Icon
                                    </th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">Name</th>
                                    <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Version
                                    </th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">Author</th>
                                    <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Active
                                    </th>
                                    <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Update
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="pluginTableBodyModal">
                                <!-- Rows injected dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>

    <!-- Themes Modal -->
    <div class="modal fade" id="manageThemesModal" tabindex="-1" aria-labelledby="manageThemesModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-height: 90vh;">
            <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fs-4">Manage Themes</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                        <table class="table table-striped align-middle">
                            <thead style="position: sticky; top: 0; z-index: 2; background: #f8f9fa;">
                                <tr>
                                    <th
                                        style="width: 60px; text-align: left; font-size: 16px; font-weight: bold; color:#000;">
                                        Screenshot
                                    </th>
                                    <th style="text-align: left; font-size: 16px; font-weight: bold; color:#000;">Name
                                    </th>
                                    <th style="text-align: left; font-size: 16px; font-weight: bold; color:#000;">Slug
                                    </th>
                                    <th style="text-align: left; font-size: 16px; font-weight: bold; color:#000;">
                                        Version
                                    </th>
                                    <th style="text-align: left; font-size: 16px; font-weight: bold; color:#000;">
                                        Author</th>
                                    <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Active
                                    </th>
                                </tr>
                            </thead>
                            <tbody id="themeTableBodyModal">
                                <!-- Rows injected dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Users Modal -->
    <div class="modal fade" id="manageUserModal" tabindex="-1" aria-labelledby="manageUserModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-xl" style="max-height: 90vh;">
            <div class="modal-content" style="max-height: 90vh; overflow-y: auto;">
                <div class="modal-header">
                    <h5 class="modal-title fw-bold fs-4">Manage Users</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body p-0">
                    <div class="table-responsive" style="max-height: 70vh; overflow-y: auto;">
                        <div class="d-flex justify-content-end mt-2 mb-2">
                            <input type="text" id="roleSearch" class="form-control w-25"
                                placeholder="Search by role...">
                        </div>
                        <table class="table table-striped align-middle">
                            <thead style="position: sticky; top: 0; z-index: 2; background: #f8f9fa;">
                                <tr>
                                    <th style="width: 60px; font-size: 16px; font-weight: bold; color:#000;">
                                        ID
                                    </th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">Name</th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">
                                        Username
                                    </th>
                                    <th style="font-size: 16px; font-weight: bold; color:#000;">Roles</th>
                                    {{-- <th style="text-align: center; font-size: 16px; font-weight: bold; color:#000;">
                                        Active
                                    </th> --}}
                                </tr>
                            </thead>
                            <tbody id="userTableBodyModal">
                                <!-- Rows injected dynamically -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>


    {{-- -- Modal --> --}}
    <div class="modal fade" id="backupTypeModal" tabindex="-1" role="dialog" aria-labelledby="backupTypeModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="backupTypeModalLabel">Select Backup Type</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <select id="backupTypeSelect" class="form-control">
                        <option value="db">Database Only</option>
                        <option value="files">Files Only</option>
                    </select>
                </div>
                <div id="backupProgressContainer" style="margin: 10px 20px; display:none;">
                    <div style="font-weight:600;">Backup Progress:</div>
                    <div id="backupProgressBar"
                        style="background:#e9ecef; border-radius:8px; height:24px; width:100%; margin-top:6px;">
                        <div id="backupProgressFill"
                            style="background:#2c437c; height:100%; width:0%; border-radius:8px; transition:width 0.5s;">
                        </div>
                    </div>
                    <div id="backupProgressText" style="margin-top:6px; font-size:14px; color:#2c437c;">0% completed</div>
                    <button id="continueBackupBtn" class="btn btn-warning btn-sm mt-2" style="display:none;">Continue
                        Backup</button>
                </div>
                <div class="modal-footer">
                    <button id="confirmBackupBtn" class="btn btn-primary">Confirm Backup</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script>
        var tryDirect = false;
        var issVal = @json($iss ?? '');
        var sigVal = @json($sig ?? '');
        var website_id = @json($result->id ?? '');
        // Try several places for iss/sig (global vars, hidden inputs, data attributes)
        if (window.iss) issVal = window.iss;
        if (window.sig) sigVal = window.sig;
        var ajaxBtn = document.getElementById('ajaxReloadBtn');
        if (!issVal && document.getElementById('iss')) issVal = document.getElementById('iss').value;
        if (!sigVal && document.getElementById('sig')) sigVal = document.getElementById('sig').value;
        if (!issVal && ajaxBtn && ajaxBtn.dataset && ajaxBtn.dataset.iss) issVal = ajaxBtn.dataset.iss;
        if (!sigVal && ajaxBtn && ajaxBtn.dataset && ajaxBtn.dataset.sig) sigVal = ajaxBtn.dataset.sig;
        if (issVal && sigVal) tryDirect = true;
        var myHeaders = new Headers();
        myHeaders.append("iss", issVal);
        myHeaders.append("secret", sigVal);

        function getAuthHeaders() {
            const h = new Headers();
            if (issVal) h.append('iss', issVal);
            if (sigVal) h.append('secret', sigVal);
            return h;
        }
        var autoBackupInterval = null;


        function callBackupApi(auto = false) {
            var $btn = $('#confirmBackupBtn');
            var backupType = $('#backupTypeSelect').val();

            (async function() {
                var wpStatusUrl = '{{ rtrim($result->url, '/') }}/wp-json/laravel-sso/v1/handle_backup';

                var params = new URLSearchParams({
                    type: backupType,
                    website_id: website_id,
                    laravel_url: issVal
                });

                var urlWithParams = wpStatusUrl + '?' + params.toString();

                const requestOptions = {
                    method: "GET",
                    headers: getAuthHeaders(), // must return { iss: "...", secret: "..." }
                    redirect: "follow"
                };

                try {
                    const resp = await fetch(urlWithParams, requestOptions);
                    if (!resp.ok) {
                        alert('WP fetch failed: ' + resp.status + ' ' + resp.statusText);
                        return;
                    }
                    const json = await resp.json();
                    console.log('Direct fetch response:', json);

                    var percent = 0;

                    if (json.status === 'in_progress') {
                        if (json.next_batch && json.total_files > 0) {
                            percent = Math.round((json.next_batch / json.total_files) * 100);
                        }
                        $('#backupProgressFill').css('width', percent + '%');
                        $('#backupProgressText').text(percent + '% completed');

                        // Continue polling
                        if (auto) {
                            autoBackupInterval = setTimeout(function() {
                                callBackupApi(true);
                            }, 2000);
                        }

                    } else if (json.status === 'completed') {
                        percent = 100;
                        swal.fire({
                            title: 'Backup Completed',
                            text: 'The backup process has completed Now Storing the backup inour Server.',
                            icon: 'success',
                            confirmButtonText: 'OK'
                        });
                        $('#backupProgressFill').css('width', percent + '%');
                        $('#backupProgressText').text('Backup Completed');

                        // 🔥 Send files_zip to Laravel controller for DB storage
                        if (json.files) {
                            var file = json.files; // e.g. "backups/backup_12345.zip"
                            fetch('/admin/website/' + website_id + '/store-backup', {
                                method: 'POST',
                                credentials: 'same-origin', // include session cookie for CSRF validation
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                                    'X-Requested-With': 'XMLHttpRequest'
                                },
                                body: JSON.stringify({
                                    type: backupType,
                                    website_id: website_id,
                                    files_zip: file
                                })
                            }).then(r => r.json()).then(function(saveResp) {
                                console.log('Save backup response:', saveResp);
                                if (saveResp.success) {
                                    $('#confirmBackupBtn').text('Backup Created!').addClass('btn-success');

                                    var wpdeletebackup =
                                        '{{ rtrim($result->url, '/') }}/wp-json/laravel-sso/v1/delete-backup';
                                    const requestOptions = {
                                        method: "GET",
                                        headers: getAuthHeaders(), // must return { iss: "...", secret: "..." }
                                        redirect: "follow"
                                    };

                                    fetch(wpdeletebackup, requestOptions)
                                        .then(function(resp) {
                                            console.log('Direct fetch response:', resp);
                                            if (!resp.ok) {
                                                alert('WP fetch failed: ' + resp.status + ' ' + resp
                                                    .statusText);
                                                throw new Error('Network response not ok');
                                            }
                                            return resp.json();
                                        })
                                        .then(function(json) {
                                            if (!json || !json.success) {
                                                alert((json && json.message) ? json.message :
                                                    'Failed to fetch WP data.');
                                                $btn.prop('disabled', false).text('Retry');
                                                return;
                                            }

                                            swal.fire({
                                                title: 'Backup Successful',
                                                text: 'The backup Process has completed.',
                                                icon: 'success',
                                                confirmButtonText: 'OK'
                                            }).then(() => {
                                                location.reload();
                                            });
                                            $btn.prop('disabled', false).text('Update');
                                        })
                                        .catch(function(err) {
                                            console.log('Direct fetch error:', err);
                                            $btn.prop('disabled', false).text('Retry');
                                        });

                                    // setTimeout(function() {
                                    //     $('#confirmBackupBtn').prop('disabled', false).text(
                                    //             'Confirm Backup')
                                    //         .removeClass('btn-success');
                                    //     $('#backupTypeModal').modal('hide');
                                    //     location.reload();
                                    // }, 1500);
                                } else {
                                    alert(saveResp.error || 'Failed to save backup in DB.');
                                }
                            });
                        }

                        clearTimeout(autoBackupInterval);
                    }

                } catch (err) {
                    console.error('Direct fetch error:', err);
                    $('#confirmBackupBtn').text('Error!').addClass('btn-danger');
                    clearTimeout(autoBackupInterval);
                    setTimeout(function() {
                        $('#confirmBackupBtn').prop('disabled', false).text('Confirm Backup')
                            .removeClass('btn-danger');
                    }, 2000);
                }
            })();
        }


        $(document).on('click', '#confirmBackupBtn', function() {
            var $btn = $(this);
            $btn.prop('disabled', true).text('Backing up...');
            $('#backupProgressContainer').show();
            $('#backupProgressFill').css('width', '0%');
            $('#backupProgressText').text('0% completed');
            $('#continueBackupBtn').hide();
            clearInterval(autoBackupInterval);
            callBackupApi(true); // Start auto-continue
        });

        $('#continueBackupBtn').off('click').on('click', function() {
            $('#confirmBackupBtn').prop('disabled', true).text('Continuing...');
            $('#continueBackupBtn').hide();
            clearInterval(autoBackupInterval);
            callBackupApi(true); // Continue auto-continue
        });
    </script>




    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Fancybox JS -->
    <script src="https://cdn.jsdelivr.net/npm/@fancyapps/ui/dist/fancybox.umd.js"></script>





    <script>
        // reload pages then show current tab with dynamic data
        $(document).ready(function() {
            const tabFromUrl = new URLSearchParams(window.location.search).get('tab');
            const savedTabId = tabFromUrl;
            if (savedTabId) {
                const $savedTab = $('.tabchnage[data-id="' + savedTabId + '"]');
                if ($savedTab.length) {
                    $savedTab.addClass('active').attr('aria-selected', 'true');
                    const panel = $('[aria-labelledby="' + savedTabId + '"]');
                    panel.addClass('active').attr('data-active', 'true');

                    loadTabData(savedTabId, $savedTab);
                } else {
                    $('.tabchnage').first().trigger('click');
                }
            } else {
                $('.tabchnage').first().trigger('click');
            }
        });



        $(document).ready(function() {
            // Fancybox initialize
            Fancybox.bind("[data-fancybox='theme-gallery']", {
                Toolbar: {
                    display: [{
                            id: "zoom",
                            position: "center"
                        },
                        {
                            id: "download",
                            position: "center"
                        },
                        {
                            id: "close",
                            position: "right"
                        }
                    ]
                },
                Thumbs: false,
                infinite: false,
                compact: false, // keeps toolbar full width
                animated: true, // smooth animation
            });


            // Add smooth animations on page load
            $('.management-card').each(function(index) {
                $(this).css({
                    'opacity': '0',
                    'transform': 'translateY(30px)'
                });

                setTimeout(() => {
                    $(this).css({
                        'opacity': '1',
                        'transform': 'translateY(0)',
                        'transition': 'all 0.6s cubic-bezier(0.4, 0, 0.2, 1)'
                    });
                }, 100 * (index + 1));
            });

            // Add hover effects for manage buttons
            $('.manage-btn').hover(
                function() {
                    $(this).find('i').css('transform', 'rotate(15deg)');
                },
                function() {
                    $(this).find('i').css('transform', 'rotate(0deg)');
                }
            );

            // Add click animation for buttons
            $('.manage-btn, .back-btn').on('click', function() {
                $(this).css('transform', 'scale(0.95)');
                setTimeout(() => {
                    $(this).css('transform', '');
                }, 150);
            });

            // Animate page header on load
            $('.page-header').css({
                'opacity': '0',
                'transform': 'translateY(-20px)'
            });

            setTimeout(() => {
                $('.page-header').css({
                    'opacity': '1',
                    'transform': 'translateY(0)',
                    'transition': 'all 0.8s cubic-bezier(0.4, 0, 0.2, 1)'
                });
            }, 200);

            // Animate website logo
            $('.website-logo').hover(
                function() {
                    $(this).css('transform', 'scale(1.05) rotate(2deg)');
                },
                function() {
                    $(this).css('transform', 'scale(1) rotate(0deg)');
                }
            );

            // Add ripple effect to cards
            $('.management-card').on('mousedown', function(e) {
                const card = $(this);
                const ripple = $('<div class="ripple"></div>');
                const rect = this.getBoundingClientRect();
                const size = Math.max(rect.width, rect.height);
                const x = e.clientX - rect.left - size / 2;
                const y = e.clientY - rect.top - size / 2;

                ripple.css({
                    width: size,
                    height: size,
                    left: x,
                    top: y,
                    position: 'absolute',
                    borderRadius: '50%',
                    background: 'rgba(102, 126, 234, 0.3)',
                    transform: 'scale(0)',
                    animation: 'ripple 0.6s linear',
                    pointerEvents: 'none',
                    zIndex: 1
                });

                card.css('position', 'relative');
                card.append(ripple);

                setTimeout(() => {
                    ripple.remove();
                }, 600);
            });

            // Add ripple animation CSS
            const rippleCSS = `
                @keyframes ripple {
                    to {
                        transform: scale(4);
                        opacity: 0;
                    }
                }
            `;
            $('<style>').text(rippleCSS).appendTo('head');

            // Add parallax effect to floating elements
            $(window).on('mousemove', function(e) {
                const x = e.clientX / window.innerWidth;
                const y = e.clientY / window.innerHeight;

                $('.floating-element-1').css('transform', `translate(${x * 20}px, ${y * 20}px)`);
                $('.floating-element-2').css('transform', `translate(${-x * 15}px, ${-y * 15}px)`);
            });

            // Manage Plugin Model
            $('#managePluginModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var response = button.data('plugin-response');

                // Parse response safely
                var data = (typeof response === 'string' && response !== '') ? JSON.parse(response) :
                    response;

                var tbody = $('#pluginTableBodyModal');
                tbody.empty(); // Clear old rows

                // Check if data or data.items exists
                if (!data || !data.items || data.items.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <strong>No plugin data found</strong>
                            </td>
                        </tr>
                    `);
                    return;
                }

                $.each(data.items, function(index, plugin) {

                    var row = `
                        <tr>
                            <td>
                                <img src="${plugin.icon_url}"
                                    alt="${plugin.name}"
                                    width="40" height="40"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/wp-default-icon.png') }}';">
                            </td>
                            <td>
                                <strong>${plugin.name}</strong><br>
                                ${plugin.plugin_uri ? `<a href="${plugin.plugin_uri}" target="_blank">${plugin.plugin_uri}</a>` : ''}
                            </td>
                            <td>
                                ${plugin.version} ${plugin.update ? ` <span class="text-muted">→</span> <strong>${plugin.update.new_version}</strong>` : ''}
                            </td>
                            <td>${plugin.author || '-'}</td>
                            <td>
                                ${plugin.is_active
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-secondary">Inactive</span>'}
                            </td>
                            <td>
                                ${plugin.update
                                    ? `<span class="badge bg-warning">Update to ${plugin.update.new_version}</span>`
                                    : '<span class="badge bg-info">Latest</span>'}
                            </td>
                        </tr>
                    `;

                    tbody.append(row);
                });
            });



            // Manage Theme Model
            $('#manageThemesModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var response = button.data('theme-response');

                // Parse response safely
                var data = (typeof response === 'string' && response !== '') ? JSON.parse(response) :
                    response;

                var tbody = $('#themeTableBodyModal');
                tbody.empty(); // Clear old rows

                // Check if data or data.items exists
                if (!data || !data.items || data.items.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <strong>No theme data found</strong>
                            </td>
                        </tr>
                    `);
                    return;
                }
                const themeRoundVersion = (v, decimals = 2) => v.split('.').map(p => {
                    // Check if the part is purely numeric and longer than desired decimals
                    if (/^\d+$/.test(p) && p.length > decimals) {
                        return p.substring(0, decimals);
                    }
                    return p;
                }).join('.');
                $.each(data.items, function(index, theme) {
                    var row = `
                        <tr>
                            <td>
                                <a href="${theme.screenshot}"  data-fancybox="theme-gallery"  data-caption="${theme.name}">
                                    <img src="${theme.screenshot}"
                                        alt="${theme.name}"
                                        width="40" height="40"
                                        onerror="this.onerror=null;this.src='{{ asset('assets/images/wp-default-icon.png') }}';">
                                </a>
                            </td>
                            <td>${theme.slug || '-'}</td>
                            <td>
                                <strong>${theme.name}</strong><br>
                                ${theme.theme_uri ? `<a href="${theme.theme_uri}" target="_blank">${theme.theme_uri}</a>` : ''}
                            </td>
                            <td>
                                ${themeRoundVersion(theme.version)} ${theme.update ? ` <span class="text-muted">→</span> <strong>${theme.update.new_version}</strong>` : ''}
                            </td>
                            <td>${theme.author || '-'}</td>
                            <td>
                                ${theme.is_active
                                    ? '<span class="badge bg-success">Active</span>'
                                    : '<span class="badge bg-secondary">Inactive</span>'}
                            </td>
                        </tr>
                    `;

                    tbody.append(row);
                });
            });



            // Manage User Model
            $('#manageUserModal').on('show.bs.modal', function(event) {
                var button = $(event.relatedTarget);
                var response = button.data('user-response');
                var data = (typeof response === 'string' && response !== '') ? JSON.parse(response) :
                    response;

                var tbody = $('#userTableBodyModal');
                tbody.empty();

                if (!data || !Array.isArray(data.items) || data.items.length === 0) {
                    tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <strong>No user data found</strong>
                            </td>
                        </tr>
                    `);
                    return;
                }

                var allUsers = data.items;

                // Normalize roles to a sorted, comma-separated string
                function normalizeRoles(roles) {
                    if (!roles) return '';
                    // If it's an array, try to extract a name/role string from each element
                    if (Array.isArray(roles)) {
                        var arr = roles.map(function(r) {
                            if (typeof r === 'string') return r;
                            if (r && typeof r === 'object') {
                                // common property names: name, role, roleName
                                return r.name || r.role || r.roleName || '';
                            }
                            return String(r);
                        }).filter(Boolean);
                        // sort alphabetically and join with comma
                        return arr.sort(function(a, b) {
                            return a.localeCompare(b, undefined, {
                                sensitivity: 'base'
                            });
                        }).join(', ');
                    }

                    // If it's an object (like {admin: true, user: false}), join the truthy keys
                    if (typeof roles === 'object') {
                        return Object.keys(roles).filter(function(k) {
                            return roles[k];
                        }).sort().join(', ');
                    }

                    // fallback: string/number -> return as string
                    return String(roles);
                }

                function renderUsers(users) {
                    tbody.empty();
                    if (users.length === 0) {
                        tbody.append(`
                            <tr>
                                <td colspan="6" class="text-center text-muted py-4">
                                    <strong>No matching users found</strong>
                                </td>
                            </tr>
                        `);
                        return;
                    }

                    users.forEach(function(user) {
                        var rolesStr = normalizeRoles(user.roles);

                        // Use jQuery element creation and .text() for roles to avoid XSS issues
                        var $tr = $('<tr>');
                        $tr.append($('<td>').html('<strong>' + (user.id || '') + '</strong>'));
                        $tr.append($('<td>').html('<strong>' + (user.name || '') + '</strong><br>' +
                            (user.email || '')));
                        $tr.append($('<td>').text(user.username || '-'));
                        $tr.append($('<td>').text(rolesStr || '-'));

                        tbody.append($tr);
                    });
                }

                // initial render
                renderUsers(allUsers);

                // Role search filter (case-insensitive)
                $('#roleSearch').off('keyup').on('keyup', function() {
                    var searchVal = $(this).val().toLowerCase().trim();
                    if (searchVal === '') {
                        renderUsers(allUsers);
                        return;
                    }

                    var filtered = allUsers.filter(function(user) {
                        var rolesStr = normalizeRoles(user.roles).toLowerCase();
                        return rolesStr.indexOf(searchVal) !== -1;
                    });

                    renderUsers(filtered);
                });
            });


            var data_resp = "{{ $response['site']['url'] ?? '' }}";
            // Tab and Panel logic
            $(document).on('click', '.tabchnage', function() {
                let button = $(this);
                let targetPanel = button.data('id'); // e.g. "tab-plugins" -> "panel-features"
                // Detect which type of data
                loadTabData(targetPanel, button);
            });
        });


        // THIS FUNCTION USE FOR DYNAMIC DATA 
        function loadTabData(tabId, $button = null) {
            if (tabId === "tab-plugins") {
                let response = $button?.data('plugin-response');
                let data = typeof response === 'string' && response !== '' ? JSON.parse(response) : response;
                let tbody = $('#pluginTableBody').empty();

                if (!data || data.length === 0) {
                    tbody.append(`<tr><td colspan="6" class="text-center text-muted">No plugins found</td></tr>`);
                } else {
                    $.each(data.items, function(i, plugin) {
                        tbody.append(`
                    <tr>
                        <td>
                            <img src="${plugin.icon_url}" alt="${plugin.name}" width="40" height="40"
                                onerror="this.onerror=null;this.src='{{ asset('assets/images/wp-default-icon.png') }}';">
                        </td>
                        <td>
                            <strong>${plugin.name}</strong><br>
                            ${plugin.plugin_uri ? `<a href="${plugin.plugin_uri}" target="_blank">${plugin.plugin_uri}</a>` : ''}
                            <br/>
                            ${plugin.name !== 'DS Care' ? `
                                                                                                            ${plugin.is_active
                                                                                                            ? `<button class="badge bg-secondary updateBtn" data-type="plugin" data-action="deactivate" data-slug="${plugin.file_path}">Inactive</button>`
                                                                                                            : `<button class="badge bg-success updateBtn" data-type="plugin" data-action="activate" data-slug="${plugin.file_path}">Active</button>`}
                                                                                                            <button class="btn btn-danger btn-sm updateBtn" data-type="plugin" data-action="delete" data-slug="${plugin.file_path}">Delete</button>
                                                                                                        ` : ''}
                        </td>
                        <td>${plugin.version} ${plugin.update ? `<span class="text-muted">→</span> <strong>${plugin.update.new_version}</strong>` : ''}</td>
                        <td>${plugin.author || '-'}</td>
                        <td>${plugin.is_active ? '<span class="badge bg-success">Active</span>' : '<span class="badge bg-secondary">Inactive</span>'}</td>
                        <td>
                            ${plugin.update
                                ? `<button class="btn btn-primary updateBtn" data-type="plugin" data-action="update" data-slug="${plugin.file_path}">Update to ${plugin.update.new_version}</button>`
                                : '<span class="badge bg-info">Latest</span>'}
                        </td>
                    </tr>
                `);
                    });
                }
            } else if (tabId === "tab-themes") {
                let response = $button?.data('theme-response');
                let data = typeof response === 'string' && response !== '' ? JSON.parse(response) : response;
                let tbody = $('#themeTableBody').empty();

                if (!data || !data.items || data.items.length === 0) {
                    tbody.append(`<tr><td colspan="6" class="text-center text-muted">No themes found</td></tr>`);
                } else {
                    const themeRoundVersion = (v, decimals = 2) => v.split('.').map(p => {
                        if (/^\d+$/.test(p) && p.length > decimals) {
                            return p.substring(0, decimals);
                        }
                        return p;
                    }).join('.');

                    $.each(data.items, function(i, theme) {
                        tbody.append(`
                    <tr>
                        <td>
                            <a href="${theme.screenshot}" data-fancybox="theme-gallery" data-caption="${theme.name}">
                                <img src="${theme.screenshot}" width="40" height="40"
                                    onerror="this.onerror=null;this.src='{{ asset('assets/images/wp-default-icon.png') }}';">
                                    
                                
                            </a>
                        </td>
                        <td><strong>${theme.name}</strong>
                            
                             <br/>
                                    ${theme.is_active
                                    ? ``
                                    : `
                                                                                                            <button class="badge bg-success updateBtn" data-type="theme" data-action="activate" data-slug="${theme.slug}">Active</button>
                                                                                                            <button class="btn btn-danger btn-sm updateBtn" data-type="theme" data-action="delete" data-slug="${theme.slug}">Delete</button>
                                                                                                            `}
                                   
                        </td>
                        <td>${theme.slug || '-'}</td>
                        
                        <td>${themeRoundVersion(theme.version) || '-'}</td>
                        <td>${theme.author || '-'}</td>
                        <td>${theme.is_active
                            ? '<span class="badge bg-success">Active</span>'
                            : '<span class="badge bg-secondary">Inactive</span>'}</td>
                    </tr>
                `);
                    });
                }
            } else if (tabId === "tab-users") {
                let response = $button?.data('user-response');
                let data = typeof response === 'string' && response !== '' ? JSON.parse(response) : response;
                let tbody = $('#userTableBody').empty();

                if (!data || data.length === 0) {
                    tbody.append(`<tr><td colspan="3" class="text-center text-muted">No users found</td></tr>`);
                } else {
                    var allUsers = data.items;

                    function normalizeRoles(roles) {
                        if (!roles) return '';
                        if (Array.isArray(roles)) {
                            var arr = roles.map(function(r) {
                                if (typeof r === 'string') return r;
                                if (r && typeof r === 'object') {
                                    return r.name || r.role || r.roleName || '';
                                }
                                return String(r);
                            }).filter(Boolean);
                            return arr.sort(function(a, b) {
                                return a.localeCompare(b, undefined, {
                                    sensitivity: 'base'
                                });
                            }).join(', ');
                        }
                        if (typeof roles === 'object') {
                            return Object.keys(roles).filter(function(k) {
                                return roles[k];
                            }).sort().join(', ');
                        }
                        return String(roles);
                    }

                    function renderUsers(users) {
                        tbody.empty();
                        if (users.length === 0) {
                            tbody.append(`
                        <tr>
                            <td colspan="6" class="text-center text-muted py-4">
                                <strong>No matching users found</strong>
                            </td>
                        </tr>
                    `);
                            return;
                        }
                        users.forEach(function(user) {
                            var rolesStr = normalizeRoles(user.roles);
                            var $tr = $('<tr>');
                            $tr.append($('<td>').html('<strong>' + (user.name || '') + '</strong><br>' + (user
                                .email || '')));
                            $tr.append($('<td>').text(user.username || '-'));
                            $tr.append($('<td>').text(rolesStr || '-'));
                            tbody.append($tr);
                        });
                    }

                    renderUsers(allUsers);

                    // Attach search filter if element present
                    $('#roleSearch').off('keyup').on('keyup', function() {
                        var searchVal = $(this).val().toLowerCase().trim();
                        if (searchVal === '') {
                            renderUsers(allUsers);
                            return;
                        }
                        var filtered = allUsers.filter(function(user) {
                            var rolesStr = normalizeRoles(user.roles).toLowerCase();
                            return rolesStr.indexOf(searchVal) !== -1;
                        });
                        renderUsers(filtered);
                    });
                }
            } else if (tabId === "tab-backups") {
                // No dynamic data to load for backups currently
                return;

            }
        }



        jQuery(document).ready(function($) {
            $(document).on('click', '.updateBtn', function() {
                var type = $(this).data('type'); // "plugin"
                var slug = $(this).data('slug'); // plugin slug
                var action = $(this).data('action'); // plugin action
                var $btn = $(this);

                $btn.prop('disabled', true).text('Loading...');

                var wpStatusUrl = '{{ rtrim($result->url, '/') }}/wp-json/laravel-sso/v1/upgrade';

                var params = new URLSearchParams({
                    type: type,
                    slug: slug,
                    action: action
                });

                var urlWithParams = wpStatusUrl + '?' + params.toString();


                const requestOptions = {
                    method: "GET",
                    headers: getAuthHeaders(),
                    redirect: "follow"
                };

                // Perform fetch
                fetch(urlWithParams, requestOptions)
                    .then(function(resp) {
                        console.log('Direct fetch response:', resp);
                        if (!resp.ok) {
                            alert('WP fetch failed: ' + resp.status + ' ' + resp.statusText);
                            throw new Error('Network response not ok');
                        }
                        return resp.json();
                    })
                    .then(function(json) {
                        if (!json || !json.success) {
                            alert((json && json.message) ? json.message : 'Failed to fetch WP data.');
                            $btn.prop('disabled', false).text('Retry');
                            return;
                        }

                        // Success
                        alert('Operation successful. Updating data...');
                        $('#ajaxReloadBtn').trigger('click');
                        $btn.prop('disabled', false).text('Update');
                    })
                    .catch(function(err) {
                        console.log('Direct fetch error:', err);
                        $btn.prop('disabled', false).text('Retry');
                    });
            });
        });





        // Run Speed Test button AJAX (for new card)
        $(document).on('click', '#runSpeedBtn', function() {
            var $btn = $(this);
            $btn.prop('disabled', true).text('Running...');
            $.ajax({
                url: '/admin/website/' + {{ $result->id }} + '/check-speed',
                method: 'POST',
                data: {
                    _token: '{{ csrf_token() }}'
                },
                success: function(response) {
                    if (response.success) {
                        $btn.text('Done!').addClass('btn-success');
                        setTimeout(function() {
                            $btn.prop('disabled', false).text('Run Speed Test').removeClass(
                                'btn-success');
                            location.reload();
                        }, 1500);
                    } else {
                        $btn.text('Failed!').addClass('btn-danger');
                        setTimeout(function() {
                            $btn.prop('disabled', false).text('Run Speed Test').removeClass(
                                'btn-danger');
                        }, 2000);
                        alert(response.error || 'Speed test failed.');
                    }
                },
                error: function() {
                    $btn.text('Error!').addClass('btn-danger');
                    setTimeout(function() {
                        $btn.prop('disabled', false).text('Run Speed Test').removeClass(
                            'btn-danger');
                    }, 2000);
                    alert('Failed to run speed test.');
                }
            });
        });
    </script>




    <script>
        function updateUrlParam(key, value) {
            const url = new URL(window.location.href);
            url.searchParams.set(key, value);
            window.history.replaceState({}, '', url);
        }

        document.addEventListener("DOMContentLoaded", () => {
            const tabs = document.querySelectorAll(".tabchnage");
            const panels = document.querySelectorAll(".panel");

            function activateTabById(tabId) {
                tabs.forEach(t => {
                    const target = t.getAttribute("data-id");
                    const isActive = (target === tabId);
                    t.classList.toggle("active", isActive);
                    t.setAttribute("aria-selected", isActive.toString());
                });

                panels.forEach(p => {
                    const isActive = (p.getAttribute("aria-labelledby") === tabId);
                    p.classList.toggle("active", isActive);
                    p.setAttribute("data-active", isActive.toString());
                });
            }

            // 🔁 On click: activate tab and panel + update URL
            tabs.forEach(tab => {
                tab.addEventListener("click", () => {
                    const target = tab.getAttribute("data-id");
                    activateTabById(target);
                    updateUrlParam('tab', target);
                });
            });

            // 🔁 On load: read `tab` from URL and activate it
            const urlParams = new URLSearchParams(window.location.search);
            const defaultTab = tabs[0]?.getAttribute("data-id"); // fallback to first tab
            const tabFromUrl = urlParams.get('tab') || defaultTab;

            activateTabById(tabFromUrl);
        });
    </script>
    <script>
        // Loader overlay logic
        function showLoader() {
            if (!document.getElementById('pageLoader')) {
                const loader = document.createElement('div');
                loader.id = 'pageLoader';
                loader.style.position = 'fixed';
                loader.style.top = '0';
                loader.style.left = '0';
                loader.style.width = '100vw';
                loader.style.height = '100vh';
                loader.style.background = 'rgba(255,255,255,0.85)';
                loader.style.zIndex = '9999';
                loader.style.display = 'flex';
                loader.style.alignItems = 'center';
                loader.style.justifyContent = 'center';
                loader.innerHTML = `
                <div style="text-align:center;">
                <div class="spinner-border text-primary" style="width: 4rem; height: 4rem;" role="status"></div>
                <div style="margin-top:1rem; font-size:1.2rem; color:#2c437c;">Loading...</div>
                </div>
            `;
                document.body.appendChild(loader);
            }
        }

        function hideLoader() {
            const loader = document.getElementById('pageLoader');
            if (loader) loader.remove();
        }

        // Show loader on page load, hide when DOM is ready
        // showLoader();
        window.addEventListener('DOMContentLoaded', hideLoader);

        // Show loader on refresh button click
        document.getElementById('refreshPageBtn').addEventListener('click', function(e) {
            showLoader();
        });
    </script>
    <script>
        document.querySelectorAll('.go-tab-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const tabId = btn.getAttribute('data-tab');
                const tabButton = document.querySelector(`.tablist .tab[data-id='${tabId}']`);
                if (tabButton) {
                    tabButton.click();
                    tabButton.scrollIntoView({
                        behavior: 'smooth',
                        block: 'center'
                    });
                }
            });
        });
    </script>

    <script>
        // New flow: fetch WP JSON from server, then POST it back to save on server
        document.addEventListener('DOMContentLoaded', function() {
            const ajaxBtn = document.getElementById('ajaxReloadBtn');
            if (!ajaxBtn) return;

            ajaxBtn.addEventListener('click', function(e) {
                e.preventDefault();
                ajaxBtn.disabled = true;
                const span = document.getElementById('ajaxReloadBtnText');
                const original = span ? span.innerText : '';
                if (span) span.innerText = 'Fetching...';

                // Step 1: try direct browser fetch to WordPress status endpoint using iss & sig if available
                (function() {


                    var wpStatusUrl = '{{ rtrim($result->url, '/') }}' +
                        '/wp-json/laravel-sso/v1/status';


                    const requestOptions = {
                        method: "GET",
                        headers: getAuthHeaders(),
                        redirect: "follow"
                    };
                    // perform direct fetch to WP endpoint with iss & sig as query params
                    var urlWithParams = wpStatusUrl;

                    return fetch(urlWithParams, requestOptions)
                        .then(function(resp) {
                            console.log('Direct fetch raw response:', resp);
                            if (!resp.ok) {
                                // If WP blocks or returns non-200, fallback to server
                                alert(resp.message || ('WP fetch failed: ' + resp.status + ' ' +
                                    resp
                                    .statusText));
                            }
                            return resp.json();
                        })
                        .catch(function(err) {
                            // likely CORS or network error; fallback to server fetch
                            console.log('Direct fetch error:', err);
                        });
                })().then(function(json) {
                    console.log('Direct fetch response:', json);
                    if (!json || !json.success) {
                        alert((json && json.message) ? json.message : 'Failed to fetch WP data.');
                        ajaxBtn.disabled = false;
                        if (span) span.innerText = original;
                        return;
                    }

                    // Step 2: send fetched data to save endpoint
                    if (span) span.innerText = 'Saving...';
                    alert('Fetched data successfully. Now saving to server...');
                    console.log('Fetched data:', json.data);
                    fetch('{{ route('website.save.response', ['id' => $result->id]) }}', {
                            method: 'POST',
                            credentials: 'same-origin',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'X-Requested-With': 'XMLHttpRequest'
                            },
                            body: JSON.stringify(json.data)
                        }).then(function(resp2) {
                            return resp2.json();
                        })
                        .then(function(saveResp) {
                            if (saveResp && saveResp.success) {
                                if (span) span.innerText = 'Saved';
                                setTimeout(function() {
                                    location.reload();
                                }, 800);
                            } else {
                                alert((saveResp && saveResp.message) ? saveResp.message :
                                    'Save failed');
                                ajaxBtn.disabled = false;
                                if (span) span.innerText = original;
                            }
                        }).catch(function(err) {
                            alert('Save request failed: ' + err.message);
                            ajaxBtn.disabled = false;
                            if (span) span.innerText = original;
                        });

                }).catch(function(err) {
                    alert('Fetch request failed: ' + err.message);
                    ajaxBtn.disabled = false;
                    if (span) span.innerText = original;
                });
            });
        });
    </script>
@stop
