<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Landing Page - Hotel UYU</title>
    <link rel="stylesheet" href="../css/style2.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f9f9f9;
            color: #333;
        }
        .logo {
            font-family: 'Arial Black', Arial, sans-serif;
            font-size: 4rem;
            text-align: center;
            color: #007BFF;
            margin: 20px 0;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.2);
        }
        .container {
            max-width: 900px;
            margin: 50px auto;
            padding: 20px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
            margin-top: 20px;
            font-size: 2.2rem;
            color: #007BFF;
        }
        h2 {
            font-size: 1.8rem;
            margin-top: 30px;
            color: #333;
        }
        p {
            font-size: 1.2rem;
            line-height: 1.8;
            margin: 20px 0;
            text-align: justify;
        }
        ul {
            text-align: left;
            margin: 20px auto;
            padding-left: 20px;
            line-height: 1.6;
        }
        ul li {
            font-size: 1.1rem;
        }
        .buttons {
            display: flex;
            justify-content: center;
            gap: 20px;
            margin-top: 30px;
        }
        .btn {
            text-decoration: none;
            padding: 12px 20px;
            font-size: 1rem;
            font-weight: bold;
            color: white;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn-primary {
            background-color: #007BFF;
        }
        .btn-primary:hover {
            background-color: #0056b3;
        }
        .btn-secondary {
            background-color: #28A745;
        }
        .btn-secondary:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>
    <div class="logo">UYU</div>
    <div class="container">
        <h1>Selamat Datang di Hotel UYU!</h1>
        <p>
            Selamat datang di Hotel UYU, tempat kenyamanan bertemu dengan kemewahan. Terletak di lokasi strategis, 
            Hotel UYU dirancang untuk memberikan pengalaman menginap yang tak terlupakan bagi Anda. Kami memahami pentingnya 
            liburan yang sempurna, dan itulah mengapa kami menyediakan berbagai fasilitas unggulan untuk memenuhi kebutuhan Anda.
        </p>

        <h2>Kenapa Memilih Hotel UYU?</h2>
        <ul>
            <li><strong>Kamar Mewah:</strong> Nikmati kenyamanan tidur di kamar yang dirancang dengan interior modern dan elegan, 
                dilengkapi dengan tempat tidur premium untuk istirahat yang maksimal.</li>
            <li><strong>Lokasi Strategis:</strong> Dekat dengan pusat kota, bandara, dan tempat wisata populer, menjadikan Hotel UYU 
                pilihan ideal bagi wisatawan maupun pelancong bisnis.</li>
            <li><strong>Fasilitas Lengkap:</strong> Dari kolam renang infinity yang menakjubkan hingga pusat kebugaran yang lengkap, 
                kami menyediakan segala yang Anda butuhkan selama menginap.</li>
            <li><strong>Layanan 24/7:</strong> Staf kami yang ramah selalu siap membantu Anda kapan saja.</li>
        </ul>

        <h2>Pesan Sekarang</h2>
        <p>
            Jangan lewatkan pengalaman menginap terbaik ini. Klik tombol di bawah untuk memulai proses pemesanan. 
            Kami menawarkan harga terbaik dengan kemudahan proses login dan pemesanan.
        </p>
        <div class="buttons">
            <a href="login.php" class="btn btn-primary">Book Now</a>
        </div>
    </div>
</body>
</html>
