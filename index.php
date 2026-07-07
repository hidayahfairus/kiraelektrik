<?php
$voltage = '';
$current = '';
$rate = '';
$power = 0;
$rate_rm = 0;
$results = [];
$error = '';

function calculate_electricity($v, $c, $r) {
    $powerKW = ($v * $c) / 1000;
    $rateRM = $r / 100;
    $res = [];
    for ($hour = 1; $hour <= 24; $hour++) {
        $energy = $powerKW * $hour;
        $total = $energy * $rateRM;
        $res[] = [
            'hour' => $hour,
            'energy' => $energy,
            'total' => $total
        ];
    }
    return [
        'power' => $powerKW,
        'rate_rm' => $rateRM,
        'table' => $res
    ];
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $voltage = $_POST['voltage'];
    $current = $_POST['current'];
    $rate = $_POST['rate'];

    if (
        is_numeric($voltage) &&
        is_numeric($current) &&
        is_numeric($rate) &&
        $voltage > 0 &&
        $current > 0 &&
        $rate > 0
    ) {
        $data = calculate_electricity($voltage, $current, $rate);
        $power = $data['power'];
        $rate_rm = $data['rate_rm'];
        $results = $data['table'];
    } else {
        $error = 'Please enter valid numeric values greater than 0.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Calculate</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body class="bg-white">
    <div class="container py-5" style="max-width: 600px;">
        <h1 class="mb-4">Calculate</h1>
        
        <?php if (!empty($error)): ?>
            <div class="alert alert-danger" role="alert">
                <?php echo htmlspecialchars($error); ?>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label for="voltage">Voltage</label>
                <input type="number" step="any" class="form-control" id="voltage" name="voltage" value="<?php echo htmlspecialchars($voltage); ?>" placeholder="e.g. 19" required>
                <small class="form-text text-muted">Voltage (V)</small>
            </div>
            
            <div class="form-group">
                <label for="current">Current</label>
                <input type="number" step="any" class="form-control" id="current" name="current" value="<?php echo htmlspecialchars($current); ?>" placeholder="e.g. 3.24" required>
                <small class="form-text text-muted">Ampere (A)</small>
            </div>
            
            <div class="form-group">
                <label for="rate">CURRENT RATE</label>
                <input type="number" step="any" class="form-control" id="rate" name="rate" value="<?php echo htmlspecialchars($rate); ?>" placeholder="e.g. 21.80" required>
                <small class="form-text text-muted">sen/kWh</small>
            </div>
            
            <div class="text-center my-4">
                <button type="submit" class="btn btn-outline-primary px-4 py-2">calculate</button>
            </div>
        </form>

        <?php if (!empty($results)): ?>
            <div class="border rounded p-4 mb-4" style="border-color: #b8daff !important; background-color: #f8fafd;">
                <h5 class="font-weight-bold" style="color: #004085; font-size: 1.1rem; letter-spacing: 0.5px;">POWER : <?php echo number_format($power, 5); ?>kw</h5>
                <h5 class="font-weight-bold mb-0" style="color: #004085; font-size: 1.1rem; letter-spacing: 0.5px;">RATE : <?php echo number_format($rate_rm, 3); ?>RM</h5>
            </div>

            <table class="table table-striped mt-4">
                <thead>
                    <tr>
                        <th style="border-top: none; border-bottom: 2px solid #333;">#</th>
                        <th style="border-top: none; border-bottom: 2px solid #333;">Hour</th>
                        <th style="border-top: none; border-bottom: 2px solid #333;">Energy (kWh)</th>
                        <th style="border-top: none; border-bottom: 2px solid #333;">TOTAL (RM)</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($results as $row): ?>
                        <tr>
                            <th scope="row" class="font-weight-bold"><?php echo $row['hour']; ?></th>
                            <td><?php echo $row['hour']; ?></td>
                            <td><?php echo number_format($row['energy'], 5); ?></td>
                            <td><?php echo number_format($row['total'], 2); ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        <?php endif; ?>
    </div>
</body>
</html>
