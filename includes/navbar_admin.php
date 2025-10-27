<?php
function navbar_admin($active) {
    echo '
    <nav>
        <ul>
            <li><a href="index.php" ' . ($active == 'graphs' ? 'class="active"' : '') . '>Graphs</a></li>
            <li><a href="rooms.php" ' . ($active == 'rooms' ? 'class="active"' : '') . '>Rooms</a></li>
            <li><a href="alter_data.php" ' . ($active == 'alter' ? 'class="active"' : '') . '>Bookings</a></li>
            <li><a href="users.php" ' . ($active == 'users' ? 'class="active"' : '') . '>Users</a></li>
            <li><a href="payments.php" ' . ($active == 'payments' ? 'class="active"' : '') . '>Payments</a></li>
            <li><a href="chatbot_view.php" ' . ($active == 'chatbot' ? 'class="active"' : '') . '>Chatbot</a></li>
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