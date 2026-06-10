<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'SPK Pemilihan Influencer UMKM')</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        :root{
            --primary:#10B981;
            --primary-dark:#059669;
            --primary-emerald:#10B981;
            --secondary:#0F172A;
            --secondary-light:#1E293B;
            --gold:#F59E0B;
            --warm-ochre:#F59E0B;
        }

        *{
            font-family:'Poppins',sans-serif;
        }

        body{
            background:linear-gradient(135deg,#f8fafc,#eef2ff);
            margin:0;
        }

        .sidebar{
            position:fixed;
            left:0;
            top:0;
            width:270px;
            height:100vh;
            background:linear-gradient(180deg,#0F172A,#1E293B);
            color:white;
            padding:25px 0;
            z-index:1000;
        }

        .sidebar-brand{
            text-align:center;
            padding:25px;
            border-bottom:1px solid rgba(255,255,255,.1);
        }

        .sidebar-menu{
            list-style:none;
            padding:20px 15px;
        }

        .sidebar-menu a{
            display:flex;
            gap:12px;
            align-items:center;
            color:#cbd5e1;
            text-decoration:none;
            padding:14px 18px;
            border-radius:12px;
            margin-bottom:8px;
        }

        .sidebar-menu a:hover,
        .sidebar-menu a.active{
            background:linear-gradient(135deg,var(--primary),var(--primary-dark));
            color:white;
        }

        .main-content{
            margin-left:270px;
            padding:35px;
        }

        .card{
            border:none;
            border-radius:20px;
            box-shadow:0 10px 30px rgba(0,0,0,.06);
        }

        .card-header{
            background:linear-gradient(135deg,var(--primary),var(--primary-dark)) !important;
            color:white;
            border:none;
        }

        .btn-primary{
            background:var(--primary);
            border-color:var(--primary);
        }

        @media(max-width:768px){
            .sidebar{
                position:relative;
                width:100%;
                height:auto;
            }

            .main-content{
                margin-left:0;
                padding:20px;
            }
        }
    </style>

    @yield('extra-css')
</head>
<body>

<div class="sidebar">
    <div class="sidebar-brand">
        <h4><i class="bi bi-stars"></i> SPK Influencer</h4>
        <small>Simple Additive Weighting</small>
    </div>

    <ul class="sidebar-menu">
        <li><a href="{{ route('spk.index') }}" class="@if(Route::currentRouteName() === 'spk.index') active @endif"><i class="bi bi-grid-fill"></i> Dashboard</a></li>
        <li><a href="{{ route('campaign.index') }}" class="@if(Route::currentRouteName() === 'campaign.index') active @endif"><i class="bi bi-folder-fill"></i> Kampanye</a></li>
        <li><a href="{{ route('campaign.create') }}" class="@if(Route::currentRouteName() === 'campaign.create') active @endif"><i class="bi bi-plus-circle-fill"></i> Buat Campaign</a></li>
        <li><a href="{{ route('influencer.manage') }}" class="@if(Route::currentRouteName() === 'influencer.manage') active @endif"><i class="bi bi-people-fill"></i> Influencer</a></li>
        <li><a href="{{ route('spk.result') }}" class="@if(Route::currentRouteName() === 'spk.result') active @endif"><i class="bi bi-bar-chart-fill"></i> Hasil Analisis</a></li>
    </ul>
</div>

<div class="main-content">

    @if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
    @endif

    @yield('content')

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
@yield('extra-js')

</body>
</html>
