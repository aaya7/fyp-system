<?= template_header('Seller Dashboard') ?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product Sales Chart</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>

<body>
    <?php
    $sellerID = $_SESSION['sellerID'];
    $sql = "SELECT productName, productSold FROM products WHERE sellerID = $sellerID";
    $result = $conn->query($sql);

    $productNames = [];
    $productSold = [];
    $selectedProduct = 'all';

    while ($row = $result->fetch_assoc()) {
        $productNames[] = $row['productName'];
        $productSold[] = $row['productSold'];
    }

    if (isset($_GET['product']) && in_array($_GET['product'], $productNames)) {
        $selectedProduct = $_GET['product'];
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

    $conn->close();
    ?>

    <div style="width: 80%; margin: auto; margin-top: 20px;">
        <table border="1" style="width:100%; border-collapse:collapse; margin-bottom:25px;">
            <tr>
                <td>
                    <!-- Filter Dropdown -->
                    <div style="width: 80%; margin: auto; margin-top: 10px;">
                        <label for="productFilter">Select Products:</label>
                        <select id="productFilter" onchange="updateChart()">
                            <option value="all">All Products</option>
                            <?php
                            foreach ($productNames as $productName) {
                                echo '<option value="' . $productName . '">' . $productName . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <!-- Bar Chart for Product Sales -->
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
                        var selectedProduct = '<?php echo $selectedProduct; ?>';

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

                        function updateChart() {
                            var selectedProduct = document.getElementById('productFilter').value;

                            // Filter products based on the selection
                            var filteredProductNames = [];
                            var filteredProductSold = [];

                            if (selectedProduct === 'all') {
                                filteredProductNames = <?php echo json_encode($productNames); ?>;
                                filteredProductSold = <?php echo json_encode($productSold); ?>;
                            } else {
                                var selectedIndex = productNames.indexOf(selectedProduct);
                                filteredProductNames.push(selectedProduct);
                                filteredProductSold.push(productSold[selectedIndex]);
                            }

                            productChart.data.labels = filteredProductNames;
                            productChart.data.datasets[0].data = filteredProductSold;
                            productChart.update();
                        }
                    </script>
                </td>
            </tr>
            <tr>
                <td>
                    <table border="1" style="width:100%; border-collapse:collapse;">
                        <tr>
                            <th>Product Name</th>
                            <th>Product Sold</th>
                        </tr>
                        <?php for ($i = 0; $i < count($productNames); $i++) { ?>
                            <tr>
                                <td><?php echo $productNames[$i]; ?></td>
                                <td><?php echo $productSold[$i]; ?></td>
                            </tr>
                        <?php } ?>
                        <tr>
                            <td><strong>Total Product Sold</strong></td>
                            <td><strong><?php echo $totalSales; ?></strong></td>
                        </tr>
                    </table>
                </td>
            </tr>
            <tr>
                <td>
                    <!-- Month Filter Dropdown -->
                    <div style="width: 80%; margin: auto; margin-top: 10px;">
                        <label for="monthFilter">Select Month:</label>
                        <select id="monthFilter" onchange="updateMonthlyProfitChart()">
                            <option value="all">All Months</option>
                            <?php
                            $months = ['', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'];
                            for ($i = 1; $i <= 12; $i++) {
                                echo '<option value="' . $i . '">' . $months[$i] . '</option>';
                            }
                            ?>
                        </select>
                    </div>

                    <!-- Line Chart for Monthly Profit -->
                    <div style="width: 80%; margin: auto; margin-top: 20px; background-color: rgba(216, 191, 216, 0.4); padding: 20px; border-radius: 10px; box-shadow: 0 0 10px rgba(0,0,0,0.1);">
                        <canvas id="monthlyProfitChart"></canvas>
                    </div>

                    <script>
                        var ctxProfit = document.getElementById('monthlyProfitChart').getContext('2d');
                        var monthlyProfitData = <?php echo json_encode(array_values($monthlyProfits)); ?>;
                        var months = <?php echo json_encode($months); ?>;

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
                                            text: 'Total Monthly Profit',
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

                        function updateMonthlyProfitChart() {
                            var selectedMonth = document.getElementById('monthFilter').value;

                            // Filter monthly profits based on the selection
                            var filteredMonthlyProfits = monthlyProfitData.slice(); 

                            if (selectedMonth !== 'all') {
                                for (var i = 1; i <= 12; i++) {
                                    if (i != selectedMonth) {
                                        filteredMonthlyProfits[i] = null;
                                    }
                                }
                            }
                            monthlyProfitChart.data.datasets[0].data = filteredMonthlyProfits;
                            monthlyProfitChart.update();
                        }
                    </script>
                </td>
            </tr>
        </table>
    </div>
</body>

</html>
<?= template_footer() ?>