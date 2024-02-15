<?= template_header('Dashboard') ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.1.3/Chart.bundle.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
</head>
<style>
    li:hover {
        background-color: rgba(48, 25, 52, 0.1);
    }
</style>

<body>

    <div style="width: 80%; margin: auto; margin-top: 20px;">
        <?php
        $countSeller = "SELECT COUNT(DISTINCT sellerID) as sellerCount FROM sellers";
        $resultSeller = $conn->query($countSeller);
        $sellerCount = 0;

        if ($resultSeller->num_rows > 0) {
            $row = $resultSeller->fetch_assoc();
            $sellerCount = $row['sellerCount'];
        } else {
            echo ("<script>alert('No Shop Found!')</script>");
        }

        $countCust = "SELECT COUNT(DISTINCT customerID) as customerCount FROM customers";
        $resultCust = $conn->query($countCust);
        $customerCount = 0;

        if ($resultCust->num_rows > 0) {
            $row = $resultCust->fetch_assoc();
            $customerCount = $row['customerCount'];
        } else {
            echo ("<script>alert('No Customer Found!')</script>");
        }

        $countProducts = "SELECT COUNT(DISTINCT productID) as productCount FROM products";
        $resultProducts = $conn->query($countProducts);
        $productCount = 0;

        if ($resultProducts->num_rows > 0) {
            $row = $resultProducts->fetch_assoc();
            $productCount = $row['productCount'];
        } else {
            echo ("<script>alert('No Product Found!')</script>");
        }
        ?>

        <table style="width:100%; border-radius:20px 50px; border-collapse:collapse; background-color: rgba(216, 191, 216, 0.4); margin-bottom:20px;">
            <tr>
                <td>
                    <h3>Number of Shop</h3>
                    <h1><i class="fa-solid fa-shop"></i> <?php echo $sellerCount; ?></h1>
                </td>
                <td>
                    <h3>Total Products</h3>
                    <h1><i class="fa-brands fa-shopify"></i> <?php echo $productCount; ?></h1>
                </td>
                <td>
                    <h3>Number of Customers</h3>
                    <h1><i class="fa-solid fa-person"></i> <?php echo $customerCount; ?></h1>
                </td>
            </tr>
        </table>
        <?php
        $trendingProducts = "SELECT productName, productSold
            FROM products
            ORDER BY productSold DESC
            LIMIT 7";
        $famousProducts = $conn->query($trendingProducts);
        ?>
        <table style="width:100%; border-radius:20px 50px; border-collapse:collapse; background-color: rgba(216, 191, 216, 0.4); margin-bottom:20px;">
            <tr>
                <td style="width:40%;">
                    <h2 style="margin-top: 0;">Top 7 Trending Products</h2>
                    <ul style="list-style-type: none; padding: 0; margin: 0; font-size: 16px;">
                        <?php
                        while ($row = $famousProducts->fetch_assoc()) {
                            echo '<li style="padding: 10px; border-bottom: 1px solid rgba(48, 25, 52, 0.2);
                            transition: background-color 0.3s;
                            text-align: center;">' . $row['productName'] . '</li>';
                        }
                        ?>
                    </ul>
                </td>
                <td style="width: 100%;">
                    <h3>Percentage of Customers Based on Each Faculty</h3>
                    <canvas id="chart-area-doughnut"></canvas>
                </td>
            </tr>
        </table>
    </div>
    <center>
        <table style="width: 80%; padding-top:50px;">
            <tr>
                <td>
                    <h3>Products Available by Shop Category</h3>
                    <canvas id="chart-area-bar"></canvas>
                </td>
            </tr>
        </table>
    </center>

    <script>
        <?php
        // Bar Chart Data
        $queryProduct = "SELECT s.shopCategory, COUNT(p.productID) AS productCount
        FROM sellers s
        JOIN products p ON s.sellerID = p.sellerID
        GROUP BY s.shopCategory";

        $result = $conn->query($queryProduct);
        $productCategory = array();
        while ($row = $result->fetch_assoc()) {
            $productCategory[] = $row;
        }
        $shopCategories = array_column($productCategory, 'shopCategory');
        $productQuantities = array_column($productCategory, 'productCount');
        ?>

        var shopCategoriesBar = <?php echo json_encode($shopCategories); ?>;
        var productQuantitiesBar = <?php echo json_encode($productQuantities); ?>;
        var ctxBar = document.getElementById("chart-area-bar").getContext("2d");

        var barColors = [
            'rgba(241, 194, 50, 0.5)',
            'rgba(120, 191, 74, 0.5)',
            'rgba(36, 123, 160, 0.5)',
            'rgba(190, 127, 240, 0.5)',
            'rgba(169, 92, 104, 0.5)',
            'rgba(116, 81, 24, 0.5)',
            'rgb(242, 175, 239, 0.5)',
            'rgb(196, 153, 243, 0.5)',
            'rgb(115, 96, 223, 0.5)',
            'rgb(51, 24, 107, 0.5)'
        ];

        var configBar = {
            type: 'bar',
            data: {
                labels: shopCategoriesBar,
                datasets: [{
                    label: 'Product Count',
                    data: productQuantitiesBar,
                    backgroundColor: barColors,
                    borderColor: 'rgb(108, 34, 166)',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                legend: {
                    display: false
                },
                title: {
                    display: false,
                    text: 'Product Count by Shop Category'
                },
                scales: {
                    xAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Shop Category'
                        },
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: false
                        }
                    }],
                    yAxes: [{
                        scaleLabel: {
                            display: true,
                            labelString: 'Product Count'
                        },
                        ticks: {
                            beginAtZero: true
                        },
                        gridLines: {
                            display: false
                        }
                    }]
                }
            }
        };

        window.myBarChart = new Chart(ctxBar, configBar);

        <?php
        $pieChart = "SELECT COUNT(DISTINCT customerID) as customerCount, customerFaculty
        FROM customers GROUP BY customerFaculty";
        $resultPie = $conn->query($pieChart);

        $facultyNames = [];
        $custCount = [];
        $totalCustomers = 0;

        while ($row = $resultPie->fetch_assoc()) {
            $totalCustomers += $row['customerCount'];
            $facultyNames[] = $row['customerFaculty'];
            $custCount[] = $row['customerCount'];
        }
        ?>

        // Doughnut Chart
        var facultyNamesDoughnut = <?php echo json_encode($facultyNames); ?>;
        var custCountDoughnut = <?php echo json_encode($custCount); ?>;
        var totalCustomersDoughnut = <?php echo $totalCustomers; ?>;
        var percentageDoughnut = custCountDoughnut.map(function(count) {
            return (count / totalCustomersDoughnut) * 100;
        });

        var ctxDoughnut = document.getElementById("chart-area-doughnut").getContext("2d");
        var configDoughnut = {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: percentageDoughnut,
                    backgroundColor: [
                        'rgb(60, 7, 83)',
                        'rgb(108, 34, 166)',
                        'rgb(145, 10, 103)'
                    ],
                    label: 'Customer Count'
                }],
                labels: facultyNamesDoughnut
            },
            options: {
                responsive: true,
                legend: {
                    position: 'bottom',
                },
                title: {
                    display: false,
                    text: 'Customer Percentage by Faculty'
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                tooltips: {
                    callbacks: {
                        label: function(tooltipItem, data) {
                            var dataset = data.datasets[tooltipItem.datasetIndex];
                            var total = dataset.data.reduce(function(previousValue, currentValue, currentIndex, array) {
                                return previousValue + currentValue;
                            });
                            var currentValue = dataset.data[tooltipItem.index];
                            var percentage = Math.floor(((currentValue / total) * 100) + 0.5);
                            return percentage + "%";
                        }
                    }
                }
            }
        };

        window.myDoughnut = new Chart(ctxDoughnut, configDoughnut);
    </script>
</body>

</html>
<?= template_footer() ?>