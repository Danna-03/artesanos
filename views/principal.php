<!-- Page Heading -->
<div class="d-sm-flex align-items-center justify-content-between mb-4">
    <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
</div>

<!-- Content Row -->
<div class="row">

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-primary shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Usuarios (Total)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalUsuarios">00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users-cog fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-success shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-success text-uppercase mb-1">
                            Clientes (Total)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalClientes">00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-users fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Earnings (Monthly) Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-info shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-info text-uppercase mb-1">
                            Productos (Total)</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalProductos">00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-th-list fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Pending Requests Card Example -->
    <div class="col-xl-3 col-md-6 mb-4">
        <div class="card border-left-warning shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-warning text-uppercase mb-1">
                            Ventas</div>
                        <div class="h5 mb-0 font-weight-bold text-gray-800" id="totalVentas">00</div>
                    </div>
                    <div class="col-auto">
                        <i class="fas fa-money-bill fa-2x text-gray-300"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xl-6 col-md-6 mb-4">
        <div class="card shadow h-100 py-2">
            <div class="card-body">
                <div class="row no-gutters align-items-center">
                    <div class="col mr-2">
                        <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                            Ultimos 7 diás</div>
                    </div>
                </div>
                <canvas id="ventas"></canvas>
            </div>
        </div>
    </div>


<!------------------------------------------------------------------------------------------------------>

<?php
// Tu conexión a la base de datos y consulta para obtener los datos del stock mínimo
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "venta";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT descripcion, existencia FROM producto WHERE status = 1 AND existencia < 15";
$result = $conn->query($sql);
?>

<div class="col-md-4 mb-4">
    <div class="card shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Stock Mínimo (Menos de 15 unidades)</div>
                </div>
            </div>
            <canvas id="stockMinimoProductos" width="400" height="500"></canvas>
        </div>
    </div>
</div>

<script src="<?php echo RUTA . 'assets/'; ?>js/chart.js"></script>

<script>
    // Obtén los datos de PHP y conviértelos a un formato legible para JavaScript
    var datosStockMinimo = <?php echo json_encode($result->fetch_all(MYSQLI_ASSOC)); ?>;

    // Obtén los nombres y valores del stock mínimo para el gráfico.
    var nombresProductos = datosStockMinimo.map(producto => producto.descripcion);
    var valoresStockMinimo = datosStockMinimo.map(producto => producto.existencia);

    // Configuración del gráfico
    var ctx = document.getElementById('stockMinimoProductos').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'doughnut', // Cambia 'line' a 'pie' para usar un gráfico de pastel
        data: {
            labels: nombresProductos,
            datasets: [{
                data: valoresStockMinimo,
                backgroundColor: [
                    'rgba(255, 99, 132, 0.2)',
                    'rgba(54, 162, 235, 0.2)',
                    'rgba(255, 206, 86, 0.2)',
                    'rgba(75, 192, 192, 0.2)',
                    'rgba(153, 102, 255, 0.2)',
                    'rgba(255, 159, 64, 0.2)'
                ],
                borderColor: [
                    'rgba(255, 99, 132, 1)',
                    'rgba(54, 162, 235, 1)',
                    'rgba(255, 206, 86, 1)',
                    'rgba(75, 192, 192, 1)',
                    'rgba(153, 102, 255, 1)',
                    'rgba(255, 159, 64, 1)'
                ],
                borderWidth: 1
            }]
        }
    });
</script>



<!------------------------------------------------------------------------------------------------------>

<script src="<?php echo RUTA . 'assets/'; ?>js/chart.js"></script>
<?php
// Obtén la cantidad de productos a mostrar del formulario o usa el valor predeterminado
$cantidadProductosMostrar = isset($_POST['cantidad']) ? intval($_POST['cantidad']) : 5;

// Consulta SQL para obtener los productos más vendidos
$sql = "SELECT p.descripcion, SUM(d.cantidad) as totalVentas
        FROM detalle_ventas d
        JOIN producto p ON d.id_producto = p.codproducto
        GROUP BY d.id_producto
        ORDER BY totalVentas DESC
        LIMIT $cantidadProductosMostrar";

$result = $conn->query($sql);
?>

<div class="col-xl-6 col-md-6 mb-4">
    <div class="card shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Productos Más Vendidos</div>
                </div>
            </div>
            
            <!-- Agrega el formulario para seleccionar la cantidad de productos a mostrar -->
            <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                <label for="cantidadProductos">Mostrar:</label>
                <select name="cantidad" id="cantidadProductos">
                    <option value="5" <?php echo ($cantidadProductosMostrar == 5) ? 'selected' : ''; ?>>5</option>
                    <option value="10" <?php echo ($cantidadProductosMostrar == 10) ? 'selected' : ''; ?>>10</option>
                    <option value="15" <?php echo ($cantidadProductosMostrar == 15) ? 'selected' : ''; ?>>15</option>
                </select>
                <input type="submit" value="Actualizar">
            </form>

            <canvas id="productosMasVendidos"></canvas>
        </div>
    </div>
</div>

<script>
    // Obtén los datos de PHP y conviértelos a un formato legible para JavaScript
    var datosProductosMasVendidos = <?php echo json_encode($result->fetch_all(MYSQLI_ASSOC)); ?>;

    // Obtén los nombres y valores de los productos más vendidos para el gráfico.
    var nombresProductosMasVendidos = datosProductosMasVendidos.map(producto => producto.descripcion);
    var valoresProductosMasVendidos = datosProductosMasVendidos.map(producto => producto.totalVentas);

    // Configuración del gráfico
    var ctx = document.getElementById('productosMasVendidos').getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: nombresProductosMasVendidos,
            datasets: [{
                label: 'Total Ventas',
                data: valoresProductosMasVendidos,
                backgroundColor: 'rgba(255, 99, 132, 0.2)',
                borderColor: 'rgba(255, 99, 132, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                y: {
                    beginAtZero: true
                }
            }
        }
    });
</script>

<!------------------------------------------------------------------------------------------------------>
<head>
    <!-- ... tus otros elementos head ... -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
</head>

<?php

// Obtener años únicos de la base de datos
$sqlYears = "SELECT DISTINCT YEAR(fecha) as year FROM ventas ORDER BY year DESC";
$resultYears = $conn->query($sqlYears);
$years = [];
while ($rowYear = $resultYears->fetch_assoc()) {
    $years[] = $rowYear['year'];
}

// Obtener el año actual
$selectedYear = date("Y");
if (isset($_POST['selectedYear'])) {
    $selectedYear = intval($_POST['selectedYear']);
}

$sql = "SELECT MONTH(fecha) as mes, SUM(total) as totalVentas
        FROM ventas
        WHERE YEAR(fecha) = $selectedYear
        GROUP BY MONTH(fecha)
        ORDER BY mes";

$result = $conn->query($sql);

$labels = [];
$data = [];

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $labels[] = obtenerNombreMes($row['mes']);
        $data[] = $row['totalVentas'];
    }
}

$conn->close();

function obtenerNombreMes($numeroMes) {
    $nombreMeses = ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'];
    return $nombreMeses[$numeroMes - 1];
}
?>

<script src="<?php echo RUTA . 'assets/'; ?>js/chart.js"></script>

<div class="col-xl-6 col-md-6 mb-4">
    <div class="card shadow h-100 py-2">
        <div class="card-body">
            <div class="row no-gutters align-items-center">
                <div class="col mr-2">
                    <div class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                        Ventas por Mes</div>
                    <form method="post" action="<?php echo $_SERVER['PHP_SELF']; ?>">
                        <label for="selectYear">Seleccionar Año:</label>
                        <select name="selectedYear" id="selectYear">
                            <?php
                            foreach ($years as $year) {
                                echo "<option value=\"$year\"";
                                if ($selectedYear == $year) {
                                    echo " selected";
                                }
                                echo ">$year</option>";
                            }
                            ?>
                        </select>
                        <input type="submit" value="Actualizar">
                    </form>
                </div>
            </div>
            <canvas id="ventasPorMes"></canvas>
        </div>
    </div>
</div>

<script>
var ctx = document.getElementById('ventasPorMes').getContext('2d');
var coloresPorMes = obtenerColoresPorMes();
var myChart = new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: 'Ventas',
            data: <?php echo json_encode($data); ?>,
            backgroundColor: coloresPorMes,
            borderColor: coloresPorMes,
            borderWidth: 1
        }]
    },
    options: {
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

function obtenerColoresPorMes() {
    var colores = [];
    for (var i = 0; i < <?php echo count($labels); ?>; i++) {
        // Genera colores aleatorios para cada mes
        var color = 'rgba(' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ',' + Math.floor(Math.random() * 256) + ', 0.7)';
        colores.push(color);
    }
    return colores;
}
</script>



</div>