<?= template_header('Seller Dashboard') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>

    <?php
    $sellerID = $_SESSION['sellerID'];
    $sql = "SELECT productSold FROM products where sellerID = $sellerID";
    $result = $conn->query($sql);
    $productSold = [];

    while ($row = $result->fetch_assoc()) {
        $productSold[] = $row['productSold'];
    }

    $totalSales = array_sum($productSold);

    $sql2 = "SELECT oi.itemPrice, o.customerID, o.order_date, oi.statusStatement 
    FROM orders o JOIN order_items oi ON o.orderID = oi.orderID JOIN products p 
    ON oi.productID = p.productID WHERE sellerID = $sellerID";
    $result2 = $conn->query($sql2);

    $uniqueCustomers = array();
    $completedSales = [];

    while ($row = $result2->fetch_assoc()) {
        $customerID = $row['customerID'];
        $allSales[] = $row['itemPrice'];

        if (!in_array($customerID, $uniqueCustomers)) {
            $uniqueCustomers[] = $customerID;
        }

        $status = $row['statusStatement'];
        if ($status == 'Order Completed.') {
            $completedSales[] = $row['itemPrice'];
        }
    }

    // Calculate total sales profit
    $salesProfit = array_sum($completedSales);
    $totalUniqueCustomers = count($uniqueCustomers);

    $sql = "SELECT productName, productSold FROM products WHERE sellerID = $sellerID";
    $result = $conn->query($sql);

    $productNames = [];
    $productSold = [];

    while ($row = $result->fetch_assoc()) {
        $productNames[] = $row['productName'];
        $productSold[] = $row['productSold'];
    }
    $totalSales = array_sum($productSold);

    $stmt = $conn->prepare('SELECT oi.itemPrice, o.order_date, oi.statusStatement 
    FROM orders o JOIN order_items oi ON o.orderID = oi.orderID JOIN products p 
    ON oi.productID = p.productID WHERE sellerID = ?');
    $stmt->bind_param('i', $sellerID);
    $stmt->execute();
    $profit = $stmt->get_result();

    if ($profit->num_rows > 0) {
        $monthlyProfits = array_fill(1, 12, 0);

        while ($orders = $profit->fetch_assoc()) {
            $status = $orders['statusStatement'];

            if ($status == 'Order Completed.') {
                $orderMonth = date('n', strtotime($orders['order_date']));
                $monthlyProfits[$orderMonth] += $orders['itemPrice'];
            }
        }
    }

    $pieChart = "SELECT COUNT(DISTINCT c.customerID) as studentCount, c.customerFaculty
    FROM orders o 
    JOIN order_items oi ON o.orderID = oi.orderID 
    JOIN products p ON oi.productID = p.productID 
    JOIN customers c ON o.customerID = c.customerID
    WHERE sellerID = $sellerID
    GROUP BY c.customerFaculty";
    $resultPie = $conn->query($pieChart);

    $facultyNames = [];
    $studentCount = [];

    while ($row = $resultPie->fetch_assoc()) {
        $facultyNames[] = $row['customerFaculty'];
        $studentCount[] = $row['studentCount'];
    }

    $conn->close();
    ?>

    <div style="width: 80%; margin: auto; margin-top: 20px;">
        <table style="width:100%; border-radius:20px 50px; border-collapse:collapse; background-color: rgba(216, 191, 216, 0.4); margin-bottom:20px;">
            <tr>
                <td>
                    <h3>Total Product Sold</h3>
                    <h1><?php echo $totalSales; ?></h1>
                </td>
                <td>
                    <h3>Overall Sales Profit</h3>
                    <h1>RM<?php echo $salesProfit; ?></h1>
                </td>
                <td>
                    <h3>Total Customer</h3>
                    <h1><?php echo $totalUniqueCustomers; ?></h1>
                </td>
            </tr>
        </table>
        <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
            <tr>
                <td style="width:50%;">
                    <!-- Line Chart for Monthly Profit -->
                    <h3>Total Profit Monthly (2024)</h3>
                    <div style="width: 95%; margin: auto; margin-top: 20px; background-color: rgba(216, 191, 216, 0.4); padding: 10px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        <canvas id="monthlyProfitChart" style="min-height: 250px;"></canvas>
                    </div>
                    <script>
                        var ctxProfit = document.getElementById('monthlyProfitChart').getContext('2d');
                        var monthlyProfitData = <?php echo json_encode(array_values($monthlyProfits)); ?>;

                        monthlyProfitData.unshift(null);

                        var monthlyProfitChart = new Chart(ctxProfit, {
                            type: 'line',
                            data: {
                                labels: ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
                                datasets: [{
                                    label: 'Monthly Profit',
                                    data: monthlyProfitData,
                                    borderColor: 'rgb(169, 92, 104)',
                                    borderWidth: 2,
                                    pointRadius: 3,
                                    pointHoverRadius: 8,
                                    fill: false,
                                    pointBackgroundColor: 'rgb(194, 30, 86)',
                                    pointBorderColor: 'rgb(48, 25, 52)',
                                    pointBorderWidth: 2
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Total Profit',
                                            font: {
                                                size: 12, 
                                                weight: 'bold'
                                            },
                                            color: 'rgb(48, 25, 52)' 
                                        },
                                        ticks: {
                                            callback: function(value, index, values) {
                                                return 'RM' + value;
                                            },
                                            color: 'rgb(48, 25, 52)'
                                        }
                                    },
                                    x: {
                                        title: {
                                            display: true,
                                            text: 'Month',
                                            font: {
                                                size: 12, 
                                                weight: 'bold' 
                                            },
                                            maxRotation: 0, 
                                            minRotation: 0,
                                            color: 'rgb(48, 25, 52)'
                                        },
                                        ticks: {
                                            color: 'rgb(48, 25, 52)' 
                                        }
                                    }
                                },
                                elements: {
                                    line: {
                                        tension: 0.2 
                                    }
                                },
                                plugins: {
                                    tooltip: {
                                        backgroundColor: '#555555', 
                                        titleColor: '#FFFFFF',
                                        bodyColor: '#FFFFFF', 
                                        footerColor: '#FFFFFF' 
                                    }
                                }
                            }
                        });
                    </script>
                </td>
                <td style="width:50%;">
                    <!-- Pie Chart for Student Percentage by Faculty -->
                    <h3>Number of Customer Based on Each Faculty</h3>
                    <div style="width: 80%; margin: auto; margin-top: 20px; background-color: rgba(216, 191, 216, 0.4); padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        <canvas id="studentPieChart"></canvas>
                    </div>
                    <script>
                        var facultyNames = <?php echo json_encode($facultyNames); ?>;
                        var studentCount = <?php echo json_encode($studentCount); ?>;

                        var ctxPie = document.getElementById('studentPieChart').getContext('2d');
                        var studentPieChart = new Chart(ctxPie, {
                            type: 'pie',
                            data: {
                                labels: facultyNames,
                                datasets: [{
                                    data: studentCount,
                                    borderWidth: 1,
                                    backgroundColor: [
                                        'rgb(60, 7, 83)',
                                        'rgb(108, 34, 166)',
                                        'rgb(145, 10, 103)' 
                                    ],
                                }]
                            },
                            options: {
                                responsive: true,
                                maintainAspectRatio: false,
                                cutoutPercentage: 50,
                                legend: {
                                    position: 'right',
                                    labels: {
                                        fontSize: 12
                                    }
                                },
                                title: {
                                    display: true,
                                    text: 'Customer Percentage by Faculty',
                                    font: {
                                        size: 12,
                                        weight: 'bold'
                                    },
                                    color: 'rgb(48, 25, 52)'
                                },
                            }
                        });
                    </script>
                </td>
            </tr>
        </table>
        <table style="width:100%; border-collapse:collapse; margin-bottom:20px;">
            <tr>
                <td>
                    <!-- Bar Chart for Product Sales -->
                    <h3>Total Number of Sold Product</h3>
                    <div style="width: 80%; margin: auto; margin-top: 20px; background-color: rgba(216, 191, 216, 0.4); padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        <canvas id="productChart"></canvas>
                    </div>
                    <script>
                        var barColors = [
                            'rgb(242, 175, 239)',
                            'rgb(196, 153, 243)',
                            'rgb(115, 96, 223)',
                            'rgb(51, 24, 107)',
                            'rgb(114, 4, 85)',
                            'rgb(60, 7, 83)',
                            'rgb(145, 10, 103)',
                            'rgb(255, 128, 128)',
                            'rgb(255, 207, 150)',
                            'rgb(246, 253, 195)',
                            'rgb(205, 250, 213)',
                            'rgb(190, 109, 183)',
                            'rgb(253, 211, 106)',
                            'rgb(220, 132, 73)',
                            'rgb(192, 74, 130)'
                        ];

                        var productNames = <?php echo json_encode($productNames); ?>;
                        var productSold = <?php echo json_encode($productSold); ?>;

                        // Create a bar chart
                        var ctx = document.getElementById('productChart').getContext('2d');
                        var productChart = new Chart(ctx, {
                            type: 'bar',
                            data: {
                                labels: productNames,
                                datasets: [{
                                    data: productSold,
                                    backgroundColor: barColors,
                                    borderColor: 'rgb(48, 25, 52)',
                                    borderWidth: 1
                                }]
                            },
                            options: {
                                scales: {
                                    y: {
                                        beginAtZero: true,
                                        title: {
                                            display: true,
                                            text: 'Product Quantity',
                                            font: {
                                                size: 12,
                                                weight: 'bold'
                                            },
                                            color: 'rgb(48, 25, 52)'
                                        },
                                        ticks: {
                                            beginAtZero: true,
                                            stepSize: 1, 
                                            color: 'rgb(48, 25, 52)'
                                        }
                                    },
                                    x: {
                                        display: false,
                                    }
                                },
                                plugins: {
                                    legend: {
                                        display: true,
                                        maxHeight: 100, 
                                        maxItems: 5, 
                                        labels: {
                                            generateLabels: function(chart) {
                                                var data = chart.data;
                                                if (data.labels.length && data.datasets.length) {
                                                    return data.labels.map(function(label, i) {
                                                        var dataset = data.datasets[0];
                                                        var backgroundColor = dataset.backgroundColor[i];
                                                        return {
                                                            text: label,
                                                            fillStyle: backgroundColor
                                                        };
                                                    });
                                                }
                                                return [];
                                            }
                                        }
                                    }
                                }
                            }
                        });
                    </script>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
<?= template_footer() ?>