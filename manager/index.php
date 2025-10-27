<?php
session_start();
if ($_SESSION['level'] !== 'manager') {
    header("Location: /login.php");
    exit;
}
include '../includes/navbar_manager.php';
include '../includes/db.php';

// Fetch total rooms
$totalRooms = $conn->query("SELECT COUNT(*) AS count FROM rooms")->fetch(PDO::FETCH_ASSOC)['count'];

// Fetch total pengguna users
$totalPengguna = $conn->query("SELECT COUNT(*) AS count FROM users WHERE level = 'pengguna'")->fetch(PDO::FETCH_ASSOC)['count'];

// Fetch total income
$totalIncome = $conn->query("SELECT SUM(amount_paid) AS total FROM payments")->fetch(PDO::FETCH_ASSOC)['total'] ?? 0;

// Graph 1: Room Availability
$availability = $conn->query("SELECT availability, COUNT(*) as count FROM rooms GROUP BY availability")->fetchAll(PDO::FETCH_ASSOC);

// Graph 2: Bookings Per Date
$bookings = $conn->query("SELECT check_in_date, COUNT(*) as count FROM bookings GROUP BY check_in_date")->fetchAll(PDO::FETCH_ASSOC);

// Graph 3: Room Booking Frequency (by room number)
$roomBookingFrequency = $conn->query("SELECT r.room_number, COUNT(*) as count
                                      FROM bookings b
                                      JOIN rooms r ON b.room_id = r.room_id
                                      GROUP BY r.room_number")->fetchAll(PDO::FETCH_ASSOC);

// Graph 4: User Booking Frequency (by user name)
$userBookingFrequency = $conn->query("SELECT u.name, COUNT(*) as count
                                      FROM bookings b
                                      JOIN users u ON b.user_id = u.user_id
                                      GROUP BY u.name")->fetchAll(PDO::FETCH_ASSOC);

// Graph 5: Monthly Income
$monthlyIncome = $conn->query("
    SELECT DATE_FORMAT(payment_date, '%Y-%m') AS month, SUM(amount_paid) AS total
    FROM payments
    GROUP BY DATE_FORMAT(payment_date, '%Y-%m')
    ORDER BY DATE_FORMAT(payment_date, '%Y-%m') ASC
")->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manager Dashboard</title>
    <link rel="stylesheet" href="../css/style2.css">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            background-color: #f7f7f7;
            color: #333;
            margin: 0;
            padding: 0;
        }
        h1 {
            text-align: center;
            margin: 20px 0;
            color: #007BFF;
        }
        .cards-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: space-around;
            padding: 20px;
        }
        .card {
            width: 30%;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            padding: 15px;
            text-align: center;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .card:hover {
            transform: scale(1.05);
        }
        .card h2 {
            font-size: 1.8rem;
            margin: 10px 0;
            color: #333;
        }
        .card p {
            font-size: 1.2rem;
            margin: 0;
            color: #555;
        }
        .chart-container {
            padding: 20px;
        }
        .chart-box {
            margin-bottom: 40px;
        }
        .chart-title {
            text-align: center;
            font-weight: bold;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php navbar_manager('graphs'); ?>
    <h1>Manager Dashboard</h1>

    <div class="cards-container">
        <!-- Card for Total Rooms -->
        <div class="card">
            <h2><?php echo $totalRooms; ?></h2>
            <p>Total Rooms</p>
        </div>

        <!-- Card for Total Pengguna Users -->
        <div class="card">
            <h2><?php echo $totalPengguna; ?></h2>
            <p>Pengguna</p>
        </div>

        <!-- Card for Total Income -->
        <div class="card">
            <h2>$<?php echo number_format($totalIncome, 2); ?></h2>
            <p>Total Income</p>
        </div>
    </div>

    <div class="chart-container">
        <!-- Room Availability Chart -->
        <div class="chart-box">
            <div class="chart-title">Room Availability</div>
            <canvas id="availabilityChart"></canvas>
        </div>

        <!-- Bookings Per Day Chart -->
        <div class="chart-box">
            <div class="chart-title">Bookings Per Day</div>
            <canvas id="bookingsChart"></canvas>
        </div>

        <!-- Room Booking Frequency Chart -->
        <div class="chart-box">
            <div class="chart-title">Room Booking Frequency</div>
            <canvas id="bookingFrequencyChart"></canvas>
        </div>

        <!-- User Booking Frequency Chart -->
        <div class="chart-box">
            <div class="chart-title">User Booking Frequency</div>
            <canvas id="userBookingFrequencyChart"></canvas>
        </div>

        <!-- New Monthly Income Chart -->
        <div class="chart-box">
            <div class="chart-title">Monthly Income</div>
            <canvas id="monthlyIncomeChart"></canvas>
        </div>
    </div>

    <script>
        // Room Availability Pie Chart
        const ctx1 = document.getElementById('availabilityChart').getContext('2d');
        const availabilityData = {
            labels: <?php echo json_encode(array_column($availability, 'availability')); ?>,
            datasets: [{
                label: 'Rooms',
                data: <?php echo json_encode(array_column($availability, 'count')); ?>,
                backgroundColor: ['#4CAF50', '#F44336'], // Green and Red
                borderWidth: 1
            }]
        };

        new Chart(ctx1, {
            type: 'pie',
            data: availabilityData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                }
            }
        });

        // Bookings Per Day Line Chart
        const ctx2 = document.getElementById('bookingsChart').getContext('2d');
        const bookingsData = {
            labels: <?php echo json_encode(array_column($bookings, 'check_in_date')); ?>,
            datasets: [{
                label: 'Bookings',
                data: <?php echo json_encode(array_column($bookings, 'count')); ?>,
                borderColor: '#3E95CD',
                backgroundColor: 'rgba(62, 149, 205, 0.2)',
                fill: true,
                tension: 0.3,
                borderWidth: 2
            }]
        };

        new Chart(ctx2, {
            type: 'line',
            data: bookingsData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Check-In Date'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Bookings'
                        }
                    }
                }
            }
        });

        // Room Booking Frequency Bar Chart
        const ctx3 = document.getElementById('bookingFrequencyChart').getContext('2d');
        const bookingFrequencyData = {
            labels: <?php echo json_encode(array_column($roomBookingFrequency, 'room_number')); ?>,
            datasets: [{
                label: 'Bookings Per Room',
                data: <?php echo json_encode(array_column($roomBookingFrequency, 'count')); ?>,
                backgroundColor: '#FFB74D',
                borderWidth: 1
            }]
        };

        new Chart(ctx3, {
            type: 'bar',
            data: bookingFrequencyData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Room Number'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Bookings'
                        }
                    }
                }
            }
        });

        // User Booking Frequency Bar Chart
        const ctx4 = document.getElementById('userBookingFrequencyChart').getContext('2d');
        const userBookingFrequencyData = {
            labels: <?php echo json_encode(array_column($userBookingFrequency, 'name')); ?>,
            datasets: [{
                label: 'Bookings Per User',
                data: <?php echo json_encode(array_column($userBookingFrequency, 'count')); ?>,
                backgroundColor: '#81C784',
                borderWidth: 1
            }]
        };

        new Chart(ctx4, {
            type: 'bar',
            data: userBookingFrequencyData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'User'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Bookings'
                        }
                    }
                }
            }
        });

        // Monthly Income Line Chart
        const ctx5 = document.getElementById('monthlyIncomeChart').getContext('2d');
        const monthlyIncomeData = {
            labels: <?php echo json_encode(array_column($monthlyIncome, 'month')); ?>,
            datasets: [{
                label: 'Income ($)',
                data: <?php echo json_encode(array_column($monthlyIncome, 'total')); ?>,
                borderColor: '#FF6384',
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                fill: true,
                tension: 0.3,
                borderWidth: 2
            }]
        };

        new Chart(ctx5, {
            type: 'line',
            data: monthlyIncomeData,
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    }
                },
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Month'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Income ($)'
                        }
                    }
                }
            }
        });
    </script>
</body>
</html>
