<?php
function navbar_manager($active) {
    echo '
    <nav>
        <ul>
            <li><a href="index.php" ' . ($active == 'graphs' ? 'class="active"' : '') . '>Graphs</a></li>
            <li><a href="room_view.php" ' . ($active == 'rooms' ? 'class="active"' : '') . '>Rooms</a></li>
            <li><a href="bookings_view.php" ' . ($active == 'bookings' ? 'class="active"' : '') . '>Bookings</a></li>
            <li><a href="payments_view.php" ' . ($active == 'payments' ? 'class="active"' : '') . '>Payments</a></li>
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