<?php
function navbar_pengguna($active) {
    echo '
    <nav>
        <ul>
            <li><a href="home.php" ' . ($active == 'home' ? 'class="active"' : '') . '>Home</a></li>
            <li><a href="index.php" ' . ($active == 'booking' ? 'class="active"' : '') . '>Booking</a></li>
            <li><a href="transaksi_pengguna.php" ' . ($active == 'transaksi' ? 'class="active"' : '') . '>Transaksi</a></li>
            <li><a href="how.php" ' . ($active == 'how' ? 'class="active"' : '') . '>Informasi</a></li>
            <li><a href="chatbot.php" ' . ($active == 'chatbot' ? 'class="active"' : '') . '>Chatbot</a></li>
            <li><a href="#" onclick="confirmLogout()">Logout</a></li>
        </ul>
    </nav>

    <script>
        function confirmLogout() {
            if (confirm("Are you sure you want to log out?")) {
                window.location.href = "../logout.php";
            }
        }
    </script>
    ';
}
?>