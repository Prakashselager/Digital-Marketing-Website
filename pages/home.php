<?php
include("../includes/config.php");
include("../includes/navbar.php");
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>BrandEve Solutions - Home</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <link rel="icon" href="<?php echo BASE_URL; ?>assets/images/logos.png" type="image/png">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }

        html {
            scroll-behavior: smooth;
            overflow-x: hidden;
            overscroll-behavior: none;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #050510;
            min-height: 100vh;
            color: #ffffff;
            overflow-x: hidden;
            line-height: 1.6;
        }

        .page-bg {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background: #050510;
        }

        .page-bg::before {
            content: '';
            position: absolute;
            inset: 0;
            background:
                radial-gradient(ellipse at top left, rgba(124,58,237,0.35), transparent 55%),
                radial-gradient(ellipse at bottom right, rgba(6,182,212,0.25), transparent 55%),
                radial-gradient(ellipse at center, rgba(236,72,153,0.12), transparent 60%);
        }

        .page-bg::after {
            content: '';
            position: absolute;
            inset: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.035) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.035) 1px, transparent 1px);
            background-size: 70px 70px;
            mask-image: radial-gradient(ellipse at center, #000 20%, transparent 75%);
            -webkit-mask-image: radial-gradient(ellipse at center, #000 20%, transparent 75%);
        }

        .page-dots {
            position: fixed;
            inset: 0;
            z-index: -1;
            pointer-events: none;
            background-image: radial-gradient(rgba(255,255,255,0.08) 1px, transparent 1px);
            background-size: 20px 20px;
            opacity: 0.4;
        }

        /* ============ HERO ============ */
        .hero-section {
            min-height: 100vh;
            margin-top: -76px;
            padding: 76px 5% 80px;
            display: grid;
            grid-template-columns: 1.15fr 1fr;
            align-items: center;
            gap: 60px;
            position: relative;
            overflow: hidden;
        }

        .hero-left { position: relative; z-index: 3; }

        .hero-eyebrow {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            padding: 9px 22px;
            border-radius: 50px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(167,139,250,0.4);
            color: #c4b5fd;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2px;
            text-transform: uppercase;
            margin-bottom: 32px;
            backdrop-filter: blur(10px);
        }

        .hero-eyebrow::before {
            content: '';
            width: 8px;
            height: 8px;
            border-radius: 50%;
            background: #22d3ee;
            box-shadow: 0 0 15px #22d3ee;
            animation: dotPulse 2s ease-in-out infinite;
        }

        @keyframes dotPulse {
            0%, 100% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.4); opacity: 0.6; }
        }

        .hero-left h1 {
            font-size: clamp(42px, 5.5vw, 82px);
            font-weight: 900;
            line-height: 1.02;
            letter-spacing: -3px;
            margin-bottom: 30px;
        }

        .hero-left h1 .line { display: block; overflow: hidden; }

        .hero-left h1 .line-1 { animation: slideRevealUp 0.9s cubic-bezier(0.4,0,0.2,1) forwards; opacity: 0; animation-delay: 0.1s; }
        .hero-left h1 .line-2 { animation: slideRevealUp 0.9s cubic-bezier(0.4,0,0.2,1) forwards; opacity: 0; animation-delay: 0.25s; }
        .hero-left h1 .line-3 { animation: slideRevealUp 0.9s cubic-bezier(0.4,0,0.2,1) forwards; opacity: 0; animation-delay: 0.4s; }

        @keyframes slideRevealUp {
            from { opacity: 0; transform: translateY(100%); }
            to { opacity: 1; transform: translateY(0); }
        }

        .hero-left h1 .grad-1 {
            background: linear-gradient(120deg, #c4b5fd, #7c3aed, #a78bfa);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradMove 4s ease infinite;
        }

        .hero-left h1 .grad-2 {
            background: linear-gradient(120deg, #67e8f9, #06b6d4, #22d3ee);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradMove 4s ease infinite;
        }

        .hero-left h1 .grad-3 {
            background: linear-gradient(120deg, #fda4af, #ec4899, #f472b6);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradMove 4s ease infinite;
        }

        @keyframes gradMove {
            0%, 100% { background-position: 0% center; }
            50% { background-position: 100% center; }
        }

        .hero-left .hero-desc {
            max-width: 560px;
            color: #b8b8c8;
            font-size: 17px;
            line-height: 1.9;
            text-align: justify;
            margin-bottom: 40px;
            animation: fadeInSlide 1s ease forwards;
            opacity: 0;
            animation-delay: 0.6s;
        }

        .hero-left .hero-desc b { color: #a78bfa; font-weight: 700; }
        .hero-left .hero-desc i { color: #22d3ee; font-style: normal; font-weight: 700; }
        .hero-left .hero-desc u { color: #f472b6; text-decoration: none; font-weight: 700; }

        @keyframes fadeInSlide {
            from { opacity: 0; transform: translateX(-30px); }
            to { opacity: 1; transform: translateX(0); }
        }

        .hero-btns {
            display: flex;
            gap: 16px;
            flex-wrap: wrap;
            animation: fadeInSlide 1s ease forwards;
            opacity: 0;
            animation-delay: 0.8s;
        }

        .btn-glow {
            position: relative;
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 17px 40px;
            border-radius: 16px;
            background: linear-gradient(135deg, #7c3aed, #06b6d4);
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            overflow: hidden;
            box-shadow: 0 12px 40px rgba(124,58,237,0.4);
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            border: none;
        }

        .btn-glow::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 50%;
            width: 0;
            height: 0;
            border-radius: 50%;
            background: rgba(255,255,255,0.4);
            transform: translate(-50%, -50%);
            transition: width 0.6s ease, height 0.6s ease;
        }

        .btn-glow:hover::after {
            width: 400px;
            height: 400px;
        }

        .btn-glow span { position: relative; z-index: 2; display: inline-flex; align-items: center; gap: 10px; }

        .btn-glow:hover {
            transform: translateY(-4px) scale(1.02);
            box-shadow: 0 20px 60px rgba(6,182,212,0.5);
        }

        .btn-outline {
            display: inline-flex;
            align-items: center;
            gap: 12px;
            padding: 17px 40px;
            border-radius: 16px;
            background: transparent;
            border: 2px solid rgba(167,139,250,0.4);
            color: #ffffff;
            text-decoration: none;
            font-weight: 700;
            font-size: 15px;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            position: relative;
            overflow: hidden;
        }

        .btn-outline::before {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 0;
            background: linear-gradient(135deg, rgba(167,139,250,0.2), rgba(6,182,212,0.2));
            transition: height 0.4s ease;
        }

        .btn-outline:hover::before { height: 100%; }

        .btn-outline:hover {
            border-color: #a78bfa;
            color: #ffffff;
            transform: translateY(-4px);
        }

        .btn-outline span { position: relative; z-index: 2; display: inline-flex; align-items: center; gap: 10px; }

        .hero-right {
            position: relative;
            height: 500px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-orb-visual {
            position: relative;
            width: 100%;
            height: 100%;
        }

        .hero-float-card {
            position: absolute;
            padding: 18px 22px;
            border-radius: 18px;
            background: rgba(15,15,35,0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.1);
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            display: flex;
            align-items: center;
            gap: 14px;
            transition: all 0.4s ease;
            animation: cardFloat 6s ease-in-out infinite;
        }

        @keyframes cardFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-20px); }
        }

        .hero-float-card .hc-icon {
            width: 44px;
            height: 44px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .hero-float-card .hc-text strong {
            display: block;
            font-size: 14px;
            font-weight: 800;
            color: #ffffff;
        }

        .hero-float-card .hc-text span {
            font-size: 12px;
            color: #a8a8b8;
        }

        .hfc-1 { top: 40px; left: 10px; animation-delay: 0s; }
        .hfc-1 .hc-icon { background: rgba(124,58,237,0.25); color: #c4b5fd; }

        .hfc-2 { top: 50%; right: 20px; transform: translateY(-50%); animation-delay: 1.5s; }
        .hfc-2 .hc-icon { background: rgba(6,182,212,0.25); color: #67e8f9; }

        .hfc-3 { bottom: 60px; left: 40px; animation-delay: 3s; }
        .hfc-3 .hc-icon { background: rgba(236,72,153,0.25); color: #f9a8d4; }

        .hero-center-sphere {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 280px;
            height: 280px;
            border-radius: 50%;
            background: radial-gradient(circle at 30% 30%, rgba(167,139,250,0.4), rgba(6,182,212,0.2) 50%, transparent 70%);
            filter: blur(30px);
            animation: sphereRotate 12s linear infinite;
        }

        @keyframes sphereRotate {
            0% { transform: translate(-50%, -50%) rotate(0deg) scale(1); }
            50% { transform: translate(-50%, -50%) rotate(180deg) scale(1.15); }
            100% { transform: translate(-50%, -50%) rotate(360deg) scale(1); }
        }

        /* ============ TRUST BAR ============ */
        .trust-section {
            padding: 55px 0;
            background: rgba(73, 59, 113, 0.6);
            backdrop-filter: blur(8px);
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(245,158,11,0.15);
            border-bottom: 1px solid rgba(245,158,11,0.15);
        }

        .trust-label {
            text-align: center;
            margin-bottom: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 20px;
        }

        .trust-label .line {
            width: 60px;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(245,158,11,0.6), transparent);
        }

        .trust-label p {
            color: #fbbf24;
            font-size: 12px;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 800;
        }

        .trust-scroll {
            overflow: hidden;
            position: relative;
        }

        .trust-track {
            display: flex;
            gap: 40px;
            animation: trustMarquee 35s linear infinite;
            width: max-content;
            padding: 0 20px;
        }

        .trust-scroll:hover .trust-track { animation-play-state: paused; }

        @keyframes trustMarquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .trust-item {
            flex-shrink: 0;
            width: 140px;
            height: 90px;
            padding: 14px;
            border-radius: 20px;
            background: linear-gradient(135deg, #fff7ed, #ffffff);
            border: 1px solid rgba(251,191,36,0.2);
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.4s cubic-bezier(0.4,0,0.2,1);
            box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        }

        .trust-item:hover {
            transform: translateY(-8px) rotate(-3deg);
            box-shadow: 0 20px 40px rgba(245,158,11,0.4);
        }

        .trust-item img {
            width: 100%;
            height: 100%;
            object-fit: contain;
            display: block;
        }

        /* ============ SERVICES ============ */
        .services-section {
            padding: 120px 5%;
            position: relative;
            overflow: hidden;
        }

        .services-inner {
            max-width: 1300px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .services-head {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 40px;
            align-items: end;
            margin-bottom: 70px;
        }

        .services-head .label {
            display: inline-block;
            padding: 7px 20px;
            border-radius: 6px;
            background: rgba(20,184,166,0.15);
            border: 1px solid rgba(20,184,166,0.35);
            color: #5eead4;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 20px;
        }

        .services-head h2 {
            font-size: clamp(36px, 5vw, 62px);
            font-weight: 900;
            letter-spacing: -2px;
            line-height: 1.05;
        }

        .services-head h2 em {
            font-style: normal;
            background: linear-gradient(120deg, #5eead4, #22d3ee);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .services-head p {
            color: #ffffff;
            font-size: 16px;
            line-height: 1.9;
            text-align: justify;
        }

        .services-bento {
            display: grid;
            grid-template-columns: repeat(6, 1fr);
            grid-auto-rows: minmax(220px, auto);
            gap: 22px;
        }

        .service-tile {
            position: relative;
            border-radius: 26px;
            padding: 34px 30px;
            overflow: hidden;
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            color: #0a0a20;
        }

        .service-tile:hover {
            transform: translateY(-12px) rotate(-1deg);
        }

        .st-1 {
            grid-column: span 3;
            background: linear-gradient(135deg, #dbeafe, #bfdbfe);
            box-shadow: 0 15px 40px rgba(56,189,248,0.15);
        }
        .st-1:hover { box-shadow: 0 30px 70px rgba(56,189,248,0.5); }

        .st-2 {
            grid-column: span 3;
            background: linear-gradient(135deg, #d1fae5, #a7f3d0);
            box-shadow: 0 15px 40px rgba(52,211,153,0.15);
        }
        .st-2:hover { box-shadow: 0 30px 70px rgba(52,211,153,0.5); }

        .st-3 {
            grid-column: span 2;
            background: linear-gradient(135deg, #fce7f3, #fbcfe8);
            box-shadow: 0 15px 40px rgba(244,114,182,0.15);
        }
        .st-3:hover { box-shadow: 0 30px 70px rgba(244,114,182,0.5); }

        .st-4 {
            grid-column: span 2;
            background: linear-gradient(135deg, #fef3c7, #fde68a);
            box-shadow: 0 15px 40px rgba(251,191,36,0.15);
        }
        .st-4:hover { box-shadow: 0 30px 70px rgba(251,191,36,0.5); }

        .st-5 {
            grid-column: span 2;
            background: linear-gradient(135deg, #ede9fe, #ddd6fe);
            box-shadow: 0 15px 40px rgba(167,139,250,0.15);
        }
        .st-5:hover { box-shadow: 0 30px 70px rgba(167,139,250,0.5); }

        .st-6 {
            grid-column: span 6;
            background: linear-gradient(135deg, #cffafe, #a5f3fc);
            box-shadow: 0 15px 40px rgba(34,211,238,0.15);
            display: grid;
            grid-template-columns: auto 1fr auto;
            align-items: center;
            gap: 30px;
        }
        .st-6:hover { box-shadow: 0 30px 70px rgba(34,211,238,0.5); }

        .tile-icon {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            background: rgba(255,255,255,0.75);
            color: #0a0a20;
            transition: all 0.5s ease;
            position: relative;
            z-index: 2;
            box-shadow: 0 8px 20px rgba(0,0,0,0.08);
        }

        .service-tile:hover .tile-icon {
            transform: scale(1.15) rotate(-10deg);
            background: #ffffff;
        }

        .st-6 .tile-icon {
            width: 76px;
            height: 76px;
            font-size: 32px;
            grid-row: span 2;
        }

        .tile-body { position: relative; z-index: 2; }

        .tile-body h3 {
            font-size: 21px;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
            color: #0a0a20;
        }

        .tile-body p {
            color: rgba(10,10,32,0.75);
            font-size: 14px;
            line-height: 1.75;
            text-align: justify;
            font-weight: 500;
        }

        .tile-link {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 13px;
            font-weight: 800;
            color: #0a0a20;
            text-decoration: none;
            letter-spacing: 0.5px;
            margin-top: 20px;
            transition: all 0.3s ease;
            position: relative;
            z-index: 2;
            padding: 8px 18px;
            border-radius: 50px;
            background: rgba(235, 228, 3, 0.92);
            width: fit-content;
        }

        .tile-link i { transition: transform 0.3s ease; }

        .tile-link:hover {
            gap: 14px;
            background: #ffffff;
        }

        .tile-link:hover i { transform: translateX(6px); }

        .st-6 .tile-link { margin-top: 0; }

        /* ============ WHY ============ */
        .why-section {
            padding: 120px 5%;
            background: rgba(15, 12, 35, 0.5);
            backdrop-filter: blur(8px);
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(52,211,153,0.1);
            border-bottom: 1px solid rgba(52,211,153,0.1);
        }

        .why-inner {
            max-width: 1300px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .why-head {
            text-align: center;
            margin-bottom: 80px;
        }

        .why-head .label {
            display: inline-block;
            padding: 7px 22px;
            border-radius: 50px;
            background: rgba(16,185,129,0.15);
            border: 1px solid rgba(52,211,153,0.4);
            color: #6ee7b7;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 3px;
            text-transform: uppercase;
            margin-bottom: 22px;
        }

        .why-head h2 {
            font-size: clamp(36px, 5vw, 64px);
            font-weight: 900;
            letter-spacing: -2px;
            line-height: 1.05;
            margin-bottom: 20px;
        }

        .why-head h2 em {
            font-style: normal;
            background: linear-gradient(120deg, #34d399, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .why-head p {
            max-width: 620px;
            margin: 0 auto;
            color: #ffffffff;
            font-size: 16px;
            line-height: 1.85;
            text-align: justify;
            text-align-last: center;
        }

        .why-list {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 22px;
        }

        .why-item {
            position: relative;
            padding: 40px 28px;
            border-radius: 24px 24px 24px 4px;
            background: linear-gradient(135deg, #064e3b, #065f46);
            border: 1px solid rgba(52,211,153,0.3);
            transition: all 0.5s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
            color: #ffffff;
        }

        .why-item::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 60px;
            height: 60px;
            background: radial-gradient(circle at top left, rgba(110,231,183,0.5), transparent 70%);
            transition: all 0.5s ease;
        }

        .why-item:hover::before {
            width: 100%;
            height: 100%;
        }

        .why-item:hover {
            transform: translateY(-10px) scale(1.02);
            border-color: #6ee7b7;
            box-shadow: 0 25px 60px rgba(16,185,129,0.4);
        }

        .why-num {
            font-size: 48px;
            font-weight: 900;
            line-height: 1;
            background: linear-gradient(180deg, #6ee7b7, #10b981);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            margin-bottom: 16px;
            letter-spacing: -3px;
            position: relative;
            z-index: 2;
        }

        .why-item h4 {
            font-size: 18px;
            font-weight: 800;
            margin-bottom: 10px;
            position: relative;
            z-index: 2;
            letter-spacing: -0.3px;
            color: #ffffff;
        }

        .why-item p {
            color: rgba(255,255,255,0.85);
            font-size: 14px;
            line-height: 1.75;
            text-align: justify;
            position: relative;
            z-index: 2;
        }

        /* ============ PORTFOLIO ============ */
        .portfolio-section {
            padding: 120px 5%;
            position: relative;
            overflow: hidden;
        }

        .portfolio-inner {
            max-width: 1300px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .portfolio-head {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
            gap: 40px;
            margin-bottom: 70px;
            flex-wrap: wrap;
        }

        .portfolio-head-left .label {
            display: inline-block;
            padding: 7px 20px;
            border-radius: 6px;
            background: rgba(244,114,182,0.15);
            border: 1px solid rgba(244,114,182,0.4);
            color: #f9a8d4;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 22px;
        }

        .portfolio-head-left h2 {
            font-size: clamp(36px, 5vw, 62px);
            font-weight: 900;
            letter-spacing: -2px;
            line-height: 1.05;
        }

        .portfolio-head-left h2 em {
            font-style: normal;
            background: linear-gradient(120deg, #f472b6, #a78bfa);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .portfolio-head-right p {
            max-width: 400px;
            color: #ffffff;
            font-size: 15px;
            line-height: 1.85;
            text-align: justify;
        }

        .portfolio-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .pf-card {
            position: relative;
            border-radius: 28px;
            overflow: hidden;
            background: #1a0a20;
            border: 1px solid rgba(244,114,182,0.2);
            transition: all 0.6s cubic-bezier(0.34, 1.56, 0.64, 1);
            cursor: pointer;
            aspect-ratio: 4/5;
        }

        .pf-card:nth-child(1) { transform: rotate(-1.5deg); }
        .pf-card:nth-child(2) { transform: rotate(0.5deg); margin-top: 20px; }
        .pf-card:nth-child(3) { transform: rotate(1.5deg); }

        .pf-card:hover {
            transform: rotate(0deg) translateY(-15px) scale(1.03);
            z-index: 5;
            border-color: #f472b6;
            box-shadow: 0 40px 80px rgba(244,114,182,0.5);
        }

        .pf-image {
            position: absolute;
            inset: 0;
            overflow: hidden;
        }

        .pf-image img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.4,0,0.2,1);
        }

        .pf-card:hover .pf-image img {
            transform: scale(1.15);
        }

        .pf-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(180deg, transparent 40%, rgba(5,5,16,0.95) 100%);
            display: flex;
            flex-direction: column;
            justify-content: flex-end;
            padding: 32px 28px;
        }

        .pf-tag {
            display: inline-block;
            align-self: flex-start;
            padding: 6px 14px;
            border-radius: 50px;
            background: linear-gradient(135deg, #f472b6, #ec4899);
            color: #ffffff;
            font-size: 10px;
            font-weight: 800;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            margin-bottom: 16px;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.5s ease;
            transition-delay: 0.1s;
        }

        .pf-card:hover .pf-tag {
            transform: translateY(0);
            opacity: 1;
        }

        .pf-overlay h3 {
            font-size: 22px;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.4px;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.5s ease;
            transition-delay: 0.2s;
            color: #ffffff;
        }

        .pf-card:hover .pf-overlay h3 {
            transform: translateY(0);
            opacity: 1;
        }

        .pf-overlay p {
            color: #ffffff;
            font-size: 14px;
            line-height: 1.7;
            text-align: justify;
            transform: translateY(20px);
            opacity: 0;
            transition: all 0.5s ease;
            transition-delay: 0.3s;
        }

        .pf-card:hover .pf-overlay p {
            transform: translateY(0);
            opacity: 1;
        }

        .pf-arrow {
            position: absolute;
            top: 24px;
            right: 24px;
            width: 52px;
            height: 52px;
            border-radius: 50%;
            background: linear-gradient(135deg, #f472b6, #ec4899);
            border: none;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 18px;
            z-index: 3;
            transform: scale(0) rotate(-45deg);
            transition: all 0.5s cubic-bezier(0.34, 1.56, 0.64, 1);
            box-shadow: 0 10px 25px rgba(244,114,182,0.5);
        }

        .pf-card:hover .pf-arrow {
            transform: scale(1) rotate(0deg);
        }

        .portfolio-cta {
            text-align: center;
            margin-top: 60px;
        }

        /* ============ TESTIMONIALS ============ */
        .testimonials-section {
            padding: 120px 5%;
            background: rgba(10, 15, 40, 0.55);
            backdrop-filter: blur(8px);
            position: relative;
            overflow: hidden;
            border-top: 1px solid rgba(96,165,250,0.15);
            border-bottom: 1px solid rgba(96,165,250,0.15);
        }

        .testimonials-inner {
            max-width: 1300px;
            margin: 0 auto;
            position: relative;
            z-index: 2;
        }

        .testimonials-head {
            display: grid;
            grid-template-columns: auto 1fr;
            gap: 60px;
            align-items: center;
            margin-bottom: 70px;
        }

        .testimonials-head .head-left { max-width: 480px; }

        .testimonials-head .label {
            display: inline-block;
            padding: 7px 20px;
            border-radius: 6px;
            background: rgba(96,165,250,0.15);
            border: 1px solid rgba(96,165,250,0.4);
            color: #93c5fd;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 2.5px;
            text-transform: uppercase;
            margin-bottom: 22px;
        }

        .testimonials-head h2 {
            font-size: clamp(36px, 5vw, 62px);
            font-weight: 900;
            letter-spacing: -2px;
            line-height: 1.05;
            margin-bottom: 18px;
        }

        .testimonials-head h2 em {
            font-style: normal;
            background: linear-gradient(120deg, #60a5fa, #818cf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .testimonials-head .head-right p {
            color: #ffffff;
            font-size: 16px;
            line-height: 1.9;
            text-align: justify;
        }

        .tm-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 24px;
        }

        .tm-card {
            position: relative;
            padding: 40px 32px;
            border-radius: 24px;
            background: linear-gradient(135deg, #1e3a8a, #1e40af);
            border: 1px solid rgba(147,197,253,0.3);
            transition: all 0.5s cubic-bezier(0.4,0,0.2,1);
            overflow: hidden;
            color: #ffffff;
        }

        .tm-card::before {
            content: '';
            position: absolute;
            top: -2px;
            left: 20%;
            right: 20%;
            height: 3px;
            background: linear-gradient(90deg, transparent, #93c5fd, transparent);
            transition: all 0.5s ease;
        }

        .tm-card:hover::before {
            left: 0;
            right: 0;
        }

        .tm-card:hover {
            transform: translateY(-12px);
            border-color: #93c5fd;
            box-shadow: 0 30px 70px rgba(96,165,250,0.4);
        }

        .tm-quote {
            font-size: 60px;
            font-weight: 900;
            line-height: 0.7;
            color: rgba(147,197,253,0.4);
            margin-bottom: 20px;
            font-family: Georgia, serif;
            transition: all 0.5s ease;
        }

        .tm-card:hover .tm-quote {
            color: rgba(147,197,253,0.7);
        }

        .tm-stars {
            display: flex;
            gap: 4px;
            margin-bottom: 20px;
            color: #fbbf24;
            font-size: 14px;
        }

        .tm-card blockquote {
            color: #ffffff;
            font-size: 15px;
            line-height: 1.9;
            font-style: italic;
            margin-bottom: 26px;
            text-align: justify;
        }

        .tm-client {
            display: flex;
            align-items: center;
            gap: 14px;
            padding-top: 20px;
            border-top: 1px solid rgba(255,255,255,0.15);
        }

        .tm-avatar {
            width: 52px;
            height: 52px;
            border-radius: 16px;
            background: linear-gradient(135deg, #93c5fd, #60a5fa);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            font-weight: 800;
            color: #0a0a20;
            flex-shrink: 0;
            transition: all 0.5s ease;
        }

        .tm-card:hover .tm-avatar {
            transform: rotate(-8deg) scale(1.08);
        }

        .tm-info h5 {
            font-size: 15px;
            font-weight: 800;
            color: #ffffff;
            margin-bottom: 3px;
        }

        .tm-info span {
            font-size: 13px;
            color: rgba(255,255,255,0.7);
        }

        /* ============ CTA ============ */
        .cta-section {
            padding: 120px 5% 100px;
            position: relative;
            overflow: hidden;
        }

        .cta-marquee-wrap {
            position: relative;
            margin-bottom: 70px;
            overflow: hidden;
            mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent);
            -webkit-mask-image: linear-gradient(90deg, transparent, #000 10%, #000 90%, transparent);
        }

        .cta-marquee {
            display: flex;
            gap: 60px;
            animation: ctaMarquee 20s linear infinite;
            width: max-content;
        }

        @keyframes ctaMarquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }

        .cta-marquee span {
            font-size: clamp(60px, 9vw, 140px);
            font-weight: 900;
            letter-spacing: -5px;
            line-height: 1;
            white-space: nowrap;
            background: linear-gradient(120deg, rgba(244,114,182,0.35), rgba(167,139,250,0.35), rgba(34,211,238,0.35));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .cta-inner {
            max-width: 900px;
            margin: 0 auto;
            text-align: center;
            position: relative;
            z-index: 2;
        }

        .cta-inner h2 {
            font-size: clamp(34px, 4.5vw, 56px);
            font-weight: 900;
            letter-spacing: -2px;
            line-height: 1.1;
            margin-bottom: 24px;
        }

        .cta-inner h2 em {
            font-style: normal;
            background: linear-gradient(120deg, #f472b6, #a78bfa, #22d3ee);
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            animation: gradMove 5s ease infinite;
        }

        .cta-inner p {
            max-width: 620px;
            margin: 0 auto 40px;
            color: #c0c0d0;
            font-size: 17px;
            line-height: 1.85;
            text-align: justify;
            text-align-last: center;
        }

        .cta-inner .btn-glow {
            background: linear-gradient(135deg, #f472b6, #ec4899);
            box-shadow: 0 12px 40px rgba(244,114,182,0.4);
        }

        .cta-inner .btn-glow:hover {
            box-shadow: 0 20px 60px rgba(244,114,182,0.6);
        }

        /* ============ SCROLL REVEAL ============ */
        .reveal-left,
        .reveal-right,
        .reveal-up,
        .reveal-rotate {
            opacity: 0;
            transition: all 1s cubic-bezier(0.4,0,0.2,1);
        }

        .reveal-left { transform: translateX(-100px); }
        .reveal-right { transform: translateX(100px); }
        .reveal-up { transform: translateY(80px); }
        .reveal-rotate { transform: translateY(60px) rotate(-6deg) scale(0.9); }

        .reveal-left.active,
        .reveal-right.active,
        .reveal-up.active,
        .reveal-rotate.active {
            opacity: 1;
            transform: translate(0, 0) rotate(0) scale(1);
        }

        .d1 { transition-delay: 0.1s; }
        .d2 { transition-delay: 0.2s; }
        .d3 { transition-delay: 0.3s; }
        .d4 { transition-delay: 0.4s; }

        /* ============ RESPONSIVE ============ */
        @media (max-width: 1024px) {
            .hero-section {
                grid-template-columns: 1fr;
                gap: 40px;
                padding: 130px 5% 60px;
                margin-top: 0;
            }
            .hero-right { height: 350px; }
            .services-bento { grid-template-columns: repeat(4, 1fr); }
            .st-1, .st-2 { grid-column: span 4; }
            .st-3, .st-4, .st-5 { grid-column: span 2; }
            .st-6 { grid-column: span 4; }
            .why-list { grid-template-columns: repeat(2, 1fr); }
            .portfolio-grid, .tm-grid { grid-template-columns: repeat(2, 1fr); }
            .pf-card:nth-child(3) { display: none; }
        }

        @media (max-width: 768px) {
            .hero-section { padding: 120px 20px 60px; margin-top: 0; }
            .hero-left h1 { letter-spacing: -1.5px; }
            .hero-right { display: none; }
            .services-section,
            .why-section,
            .portfolio-section,
            .testimonials-section,
            .cta-section { padding: 80px 20px; }
            .services-head { grid-template-columns: 1fr; gap: 20px; margin-bottom: 50px; }
            .services-bento { grid-template-columns: 1fr; gap: 16px; }
            .st-1, .st-2, .st-3, .st-4, .st-5, .st-6 { grid-column: span 1; }
            .st-6 { grid-template-columns: 1fr; gap: 16px; }
            .why-list { grid-template-columns: 1fr; gap: 16px; }
            .portfolio-head { flex-direction: column; align-items: flex-start; gap: 20px; margin-bottom: 50px; }
            .portfolio-grid { grid-template-columns: 1fr; gap: 20px; }
            .pf-card:nth-child(1),
            .pf-card:nth-child(2),
            .pf-card:nth-child(3) { transform: rotate(0deg); margin-top: 0; display: block; }
            .testimonials-head { grid-template-columns: 1fr; gap: 20px; margin-bottom: 50px; }
            .tm-grid { grid-template-columns: 1fr; gap: 20px; }
            .cta-marquee span { font-size: 50px; letter-spacing: -2px; }
            .hero-btns { flex-direction: column; }
            .btn-glow, .btn-outline { width: 100%; justify-content: center; }
        }
    </style>
</head>
<body>

    <div class="page-bg"></div>
    <div class="page-dots"></div>

    <section class="hero-section">
        <div class="hero-left">
            <h1>
                <span class="line line-1"><span class="grad-1">We Build Brands</span></span>
                <span class="line line-2">That <span class="grad-2">Dominate</span></span>
                <span class="line line-3">The <span class="grad-3">Market</span></span>
            </h1>
            <p class="hero-desc">
                <b>Data-driven marketing</b>, <i>creative branding</i>, and high-performance websites designed to turn visitors into <u>loyal customers</u>.
            </p>
            <div class="hero-btns">
                <a href="<?php echo BASE_URL; ?>pages/contact.php" class="btn-glow">
                    <span><i class="fas fa-handshake"></i> Let's Work Together</span>
                </a>
                <a href="<?php echo BASE_URL; ?>pages/portfolio.php" class="btn-outline">
                    <span><i class="fas fa-eye"></i> View Our Work</span>
                </a>
            </div>
        </div>

        <div class="hero-right">
            <div class="hero-orb-visual">
                <div class="hero-center-sphere"></div>
                <div class="hero-float-card hfc-1">
                    <div class="hc-icon"><i class="fas fa-award"></i></div>
                    <div class="hc-text">
                        <strong>50+ Projects</strong>
                        <span>Delivered successfully</span>
                    </div>
                </div>
                <div class="hero-float-card hfc-2">
                    <div class="hc-icon"><i class="fas fa-rocket"></i></div>
                    <div class="hc-text">
                        <strong>Fast Delivery</strong>
                        <span>On-time execution</span>
                    </div>
                </div>
                <div class="hero-float-card hfc-3">
                    <div class="hc-icon"><i class="fas fa-heart"></i></div>
                    <div class="hc-text">
                        <strong>99% Happy Clients</strong>
                        <span>Real feedback</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="trust-section">
        <div class="trust-label">
            <div class="line"></div>
            <p>Trusted by leading brands</p>
            <div class="line"></div>
        </div>
        <div class="trust-scroll">
            <div class="trust-track">
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/bren.jpg" alt="Brand 1"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/jainheight.jpg" alt="Brand 2"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/kaynes.jpg" alt="Brand 3"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/knsinfra.jpg" alt="Brand 4"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/the resi.jpg" alt="Brand 5"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/toyoto.jpg" alt="Brand 6"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/zomato.jpg" alt="Brand 7"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/bren.jpg" alt="Brand 1"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/jainheight.jpg" alt="Brand 2"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/kaynes.jpg" alt="Brand 3"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/knsinfra.jpg" alt="Brand 4"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/the resi.jpg" alt="Brand 5"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/toyoto.jpg" alt="Brand 6"></div>
                <div class="trust-item"><img src="<?php echo BASE_URL; ?>assets/images/brands/zomato.jpg" alt="Brand 7"></div>
            </div>
        </div>
    </section>

    <section class="services-section">
        <div class="services-inner">
            <div class="services-head">
                <div>
                    <span class="label reveal-left">What We Do</span>
                    <h2 class="reveal-left d1">Our <em>Services</em></h2>
                </div>
                <p class="reveal-right d2">Comprehensive event and marketing solutions tailored to accelerate your business growth in the modern digital landscape.</p>
            </div>

            <div class="services-bento">
                <div class="service-tile st-1 reveal-left">
                    <div class="tile-icon"><i class="fas fa-users"></i></div>
                    <div class="tile-body">
                        <h3>Corporate Events</h3>
                        <p>Seminars, Meetings, Conferences, Team Building, Sports Events, Corporate Gifting</p>
                        <a href="<?php echo BASE_URL; ?>pages/services.php" class="tile-link">Explore <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="service-tile st-2 reveal-right">
                    <div class="tile-icon"><i class="fas fa-paint-brush"></i></div>
                    <div class="tile-body">
                        <h3>Branding & Promotions</h3>
                        <p>Brand Activation, Direction Boards, RWA Activities, Promo Table, Leaflet Printing</p>
                        <a href="<?php echo BASE_URL; ?>pages/services.php" class="tile-link">Explore <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="service-tile st-3 reveal-rotate">
                    <div class="tile-icon"><i class="fas fa-bullhorn"></i></div>
                    <div class="tile-body">
                        <h3>Marketing</h3>
                        <p>Digital Marketing, SEO, Newspaper Article Marketing, Trade Show Content Marketing</p>
                        <a href="<?php echo BASE_URL; ?>pages/services.php" class="tile-link">Explore <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="service-tile st-4 reveal-rotate d1">
                    <div class="tile-icon"><i class="fas fa-rocket"></i></div>
                    <div class="tile-body">
                        <h3>Launch & Exhibitions</h3>
                        <p>Product Launch, Ribbon Cutting, Inauguration, Trade Fair, Stall Design, Fabrications</p>
                        <a href="<?php echo BASE_URL; ?>pages/services.php" class="tile-link">Explore <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="service-tile st-5 reveal-rotate d2">
                    <div class="tile-icon"><i class="fas fa-music"></i></div>
                    <div class="tile-body">
                        <h3>Shows & Concerts</h3>
                        <p>Live Events, Music Shows, Concerts, Western & Classical Bands, Celebrity Shows</p>
                        <a href="<?php echo BASE_URL; ?>pages/services.php" class="tile-link">Explore <i class="fas fa-arrow-right"></i></a>
                    </div>
                </div>

                <div class="service-tile st-6 reveal-up">
                    <div class="tile-icon"><i class="fas fa-ring"></i></div>
                    <div class="tile-body">
                        <h3>Wedding & Ceremonial</h3>
                        <p>Wedding Themes, Destination Wedding, Theme Parties, Surprise Parties, Birthday Parties — creating unforgettable memories for life's biggest moments.</p>
                    </div>
                    <a href="<?php echo BASE_URL; ?>pages/services.php" class="tile-link">Explore <i class="fas fa-arrow-right"></i></a>
                </div>
            </div>
        </div>
    </section>

    <section class="why-section">
        <div class="why-inner">
            <div class="why-head">
                <span class="label reveal-up">Why Choose Us</span>
                <h2 class="reveal-up d1">What Makes Us <em>Different</em></h2>
                <p class="reveal-up d2">We combine creative thinking with strategic planning to deliver solutions that not only look great but also deliver measurable results.</p>
            </div>

            <div class="why-list">
                <div class="why-item reveal-left">
                    <div class="why-num">01</div>
                    <h4>Simple & Insightful</h4>
                    <p>We deliver simple, insightful, and creative events that leave a lasting impression.</p>
                </div>

                <div class="why-item reveal-up d1">
                    <div class="why-num">02</div>
                    <h4>End-to-End Solutions</h4>
                    <p>From conception to execution, we handle everything seamlessly under one roof.</p>
                </div>

                <div class="why-item reveal-up d2">
                    <div class="why-num">03</div>
                    <h4>Brand-Centric Approach</h4>
                    <p>We unite brands with people through meaningful and engaging experiences.</p>
                </div>

                <div class="why-item reveal-right d3">
                    <div class="why-num">04</div>
                    <h4>Proven Track Record</h4>
                    <p>500+ successful events and activations for leading brands across India.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="portfolio-section">
        <div class="portfolio-inner">
            <div class="portfolio-head">
                <div class="portfolio-head-left">
                    <span class="label reveal-left">Our Work</span>
                    <h2 class="reveal-left d1">Recent <em>Projects</em></h2>
                </div>
                <div class="portfolio-head-right">
                    <p class="reveal-right d2">Real projects with measurable results for brands across industries. Each campaign is crafted with strategy, creativity, and measurable outcomes.</p>
                </div>
            </div>

            <div class="portfolio-grid">
                <div class="pf-card reveal-left">
                    <div class="pf-image">
                        <img src="<?php echo BASE_URL; ?>assets/images/myglamm.jpg" alt="MyGlamm">
                    </div>
                    <div class="pf-arrow"><i class="fas fa-arrow-up-right-from-square"></i></div>
                    <div class="pf-overlay">
                        <span class="pf-tag">Brand Activation</span>
                        <h3>MyGlamm</h3>
                        <p>Successful residential welfare association activation for the beauty brand.</p>
                    </div>
                </div>

                <div class="pf-card reveal-up d1">
                    <div class="pf-image">
                        <img src="<?php echo BASE_URL; ?>assets/images/nature's basket.jpg" alt="Nature's Basket">
                    </div>
                    <div class="pf-arrow"><i class="fas fa-arrow-up-right-from-square"></i></div>
                    <div class="pf-overlay">
                        <span class="pf-tag">Brand Activation</span>
                        <h3>Nature's Basket</h3>
                        <p>Engaging community activation for the premium grocery brand.</p>
                    </div>
                </div>

                <div class="pf-card reveal-right d2">
                    <div class="pf-image">
                        <img src="<?php echo BASE_URL; ?>assets/images/zepto.jpg" alt="Zepto">
                    </div>
                    <div class="pf-arrow"><i class="fas fa-arrow-up-right-from-square"></i></div>
                    <div class="pf-overlay">
                        <span class="pf-tag">Brand Activation</span>
                        <h3>Zepto</h3>
                        <p>Quick commerce brand activation across residential communities.</p>
                    </div>
                </div>
            </div>

            <div class="portfolio-cta reveal-up">
                <a href="<?php echo BASE_URL; ?>pages/portfolio.php" class="btn-glow">
                    <span>View All Projects <i class="fas fa-arrow-right"></i></span>
                </a>
            </div>
        </div>
    </section>

    <section class="testimonials-section">
        <div class="testimonials-inner">
            <div class="testimonials-head">
                <div class="head-left">
                    <span class="label reveal-left">Testimonials</span>
                    <h2 class="reveal-left d1">What Our <em>Clients Say</em></h2>
                </div>
                <div class="head-right">
                    <p class="reveal-right d2">Real feedback from real clients who trusted us with their brands. Every project is a partnership built on trust, creativity, and results.</p>
                </div>
            </div>

            <div class="tm-grid">
                <div class="tm-card reveal-left">
                    <div class="tm-quote">"</div>
                    <div class="tm-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <blockquote>BrandEve delivered an exceptional activation that exceeded our expectations.</blockquote>
                    <div class="tm-client">
                        <div class="tm-avatar">AS</div>
                        <div class="tm-info">
                            <h5>Ananya Sharma</h5>
                            <span>Marketing Head, MyGlamm</span>
                        </div>
                    </div>
                </div>

                <div class="tm-card reveal-up d1">
                    <div class="tm-quote">"</div>
                    <div class="tm-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <blockquote>Their creative approach and seamless execution made our launch a huge success.</blockquote>
                    <div class="tm-client">
                        <div class="tm-avatar">RK</div>
                        <div class="tm-info">
                            <h5>Rahul Kumar</h5>
                            <span>CEO, Nature's Basket</span>
                        </div>
                    </div>
                </div>

                <div class="tm-card reveal-right d2">
                    <div class="tm-quote">"</div>
                    <div class="tm-stars">
                        <i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i><i class="fas fa-star"></i>
                    </div>
                    <blockquote>Professional, creative, and result-oriented. Highly recommend BrandEve.</blockquote>
                    <div class="tm-client">
                        <div class="tm-avatar">PM</div>
                        <div class="tm-info">
                            <h5>Priya Malhotra</h5>
                            <span>Brand Manager, Zepto</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="cta-section">
        <div class="cta-marquee-wrap">
            <div class="cta-marquee">
                <span>READY • TO • SCALE • YOUR • BRAND •</span>
                <span>READY • TO • SCALE • YOUR • BRAND •</span>
            </div>
        </div>

        <div class="cta-inner">
            <h2 class="reveal-up">Ready To <em>Unite Your Brand</em> With People?</h2>
            <p class="reveal-up d1">Let's create memorable experiences that connect your brand with your audience. Book a free consultation today.</p>
            <div class="reveal-up d2">
                <a href="<?php echo BASE_URL; ?>pages/contact.php" class="btn-glow">
                    <span><i class="fas fa-calendar-check"></i> Book A Free Call</span>
                </a>
            </div>
        </div>
    </section>

    <script>
        (function() {
            const reveals = document.querySelectorAll('.reveal-left, .reveal-right, .reveal-up, .reveal-rotate');
            const observer = new IntersectionObserver(function(entries) {
                entries.forEach(function(entry) {
                    if (entry.isIntersecting) {
                        entry.target.classList.add('active');
                    }
                });
            }, {
                threshold: 0.1,
                rootMargin: '0px 0px -80px 0px'
            });
            reveals.forEach(function(el) { observer.observe(el); });
        })();
    </script>

</body>
</html>

<?php include("../includes/footer.php"); ?>