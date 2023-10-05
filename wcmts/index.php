<?php include 'inc/header.php'; ?>

<?php 
    $year = '';
    $make = '';
    $model = '';
    $price = '';
    $mileage = '';
    $vin = '';
    $engine_type = '';
    $engine_size = '';
    $transmission = '';
    $fuel_spec = '';
    $exterior_color = '';
    $interior_color = '';
    $body_style = '';
    $body_doors = '';
    $seats = '';
    $maintenance_service = '';
    $image_path = '';
    $image_count = '';
    
    $yearErr = '';
    $makeErr = ''; 
    $modelErr = '';
    $modelErr = '';
    $priceErr = '';
    $mileageErr = '';
    $vinErr = '';
    $engine_typeErr = '';
    $engine_sizeErr = '';
    $transmissionErr = '';
    $fuel_specErr = '';
    $exterior_colorErr = '';
    $interior_colorErr = '';
    $body_styleErr = ''; 
    $body_doorsErr = '';
    $seatsErr = '';
    $maintenance_serviceErr = '';
    $image_pathErr = '';
    $image_countErr = '';

    // Form submit
    if(isset($_POST['submit'])) {
        // Variable year
        if(empty($_POST['year'])) {
            $yearErr = 'Year is required';
        } else {
            $year = filter_input(INPUT_POST, 'year', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable make
        if(empty($_POST['make'])) {
            $makeErr = 'Make is required';
        } else {
            $make = filter_input(INPUT_POST, 'make', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable model
        if(empty($_POST['model'])) {
            $modelErr = 'Model is required';
        } else {
            $model = filter_input(INPUT_POST, 'model', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Price
        if(empty($_POST['price'])) {
            $priceErr = 'Price is required';
        } else {
            $price = filter_input(INPUT_POST, 'price', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Mileage
        if(empty($_POST['mileage'])) {
            $mileageErr = 'Mileage is required';
        } else {
            $mileage = filter_input(INPUT_POST, 'mileage', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable VIN
        if(empty($_POST['vin'])) {
            $vinErr = 'VIN is required';
        } else {
            $vin = filter_input(INPUT_POST, 'vin', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Engine Type
        if(empty($_POST['engine_type'])) {
            $engine_typeErr = 'Engine type is required';
        } else {
            $engine_type = filter_input(INPUT_POST, 'engine_type', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Engine Size
        if(empty($_POST['engine_size'])) {
            $engine_sizeErr = 'Engine size is required';
        } else {
            $engine_size = filter_input(INPUT_POST, 'engine_size', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Transmission
        if(empty($_POST['transmission'])) {
            $transmissionErr = 'Transmission is required';
        } else {
            $transmission = filter_input(INPUT_POST, 'transmission', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Fuel Spec
        if(empty($_POST['fuel_spec'])) {
            $fuel_specErr = 'Fuel spec is required';
        } else {
            $fuel_spec = filter_input(INPUT_POST, 'fuel_spec', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Exterior Color
        if(empty($_POST['exterior_color'])) {
            $exterior_colorErr = 'Exterior color is required';
        } else {
            $exterior_color = filter_input(INPUT_POST, 'exterior_color', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Interior Color
        if(empty($_POST['interior_color'])) {
            $interior_colorErr = 'Interior color is required';
        } else {
            $interior_color = filter_input(INPUT_POST, 'interior_color', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Body Style
        if(empty($_POST['body_style'])) {
            $body_styleErr = 'Body style is required';
        } else {
            $body_style = filter_input(INPUT_POST, 'body_style', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Body Doors
        if(empty($_POST['body_doors'])) {
            $body_doorsErr = 'Body doors is required';
        } else {
            $body_doors = filter_input(INPUT_POST, 'body_doors', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Seats
        if(empty($_POST['seats'])) {
            $seatsErr = 'Seats is required';
        } else {
            $seats = filter_input(INPUT_POST, 'seats', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Maintenance and Service
        if(empty($_POST['maintenance_service'])) {
            $maintenance_serviceErr = 'Maintenance and service is required';
        } else {
            $maintenance_service = filter_input(INPUT_POST, 'maintenance_service', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Image Path
        if(empty($_POST['image_path'])) {
            $image_pathErr = 'Image path is required';
        } else {
            $image_path = filter_input(INPUT_POST, 'image_path', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Image Count
        if(empty($_POST['image_count'])) {
            $image_countErr = 'Image count is required';
        } else {
            $image_count = filter_input(INPUT_POST, 'image_count', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        /* The following three are for db only. The json will read these and display on another page */
        // Variable Vehicle Info Color
        if(empty($_POST['exterior_color'])) {
            $vehicle_info_colorErr = 'Color is required';
        } else {
            $vehicle_info_color = filter_input(INPUT_POST, 'exterior_color', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Vehicle Info Transmission
        if(empty($_POST['image_count'])) {
            $vehicle_info_transmissionErr = 'Transmission is required';
        } else {
            $vehicle_info_transmission = filter_input(INPUT_POST, 'transmission', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        // Variable Vehicle Info Mileage
        if(empty($_POST['image_count'])) {
            $vehicle_info_mileageErr = 'Mileage is required';
        } else {
            $vehicle_info_mileage = filter_input(INPUT_POST, 'mileage', FILTER_SANITIZE_SPECIAL_CHARS);
        }

        if(empty($yearErr) && empty($makeErr) && empty($modelErr) && empty($priceErr) && 
            empty($mileageErr) && empty($vinErr) && empty($engine_typeErr) && empty($engine_sizeErr) && empty($transmissionErr) && 
            empty($fuel_specErr) && empty($exterior_colorErr) && empty($interior_colorErr) && 
            empty($body_styleErr) && empty($body_doorsErr) && empty($seatsErr) && empty($maintenance_serviceErr) && 
            empty($image_pathErr) && empty($image_countErr)) {
                $sql = "INSERT INTO vehicles (
                    make, model, year, price, mileage, vin, engine_type, engine_size, transmission,
                    fuel_spec, exterior_color, interior_color, body_style, body_doors, seats, image_path,
                    image_count, vehicle_info_color, vehicle_info_transmission, vehicle_info_mileage, maintenance_service
                ) VALUES (
                    '$make', '$model', '$year', '$price', '$mileage', '$vin', '$engine_type', '$engine_size', '$transmission',
                    '$fuel_spec', '$exterior_color', '$interior_color', '$body_style', '$body_doors', '$seats', '$image_path',
                    '$image_count', '$vehicle_info_color', '$vehicle_info_transmission', '$vehicle_info_mileage', '$maintenance_service'
                )";

                // Add to database
                // $sql = "INSERT INTO `vehicles` (
                //     `make`, `model`, `year`, `price`, `mileage`, `vin`, `engine_type`, `engine_size`, `transmission`, `fuel_spec`, `exterior_color`, `interior_color`, `body_style`, `body_doors`, `seats`, `image_path`, `image_count`, `vehicle_info_color`, `vehicle_info_transmission`, `vehicle_info_mileage`, `maintenance_service`
                // ) VALUES (
                //     '$make', '$model', '$year', $price, $mileage, '$vin', '$engine_type', '$engine_size', '$transmission', '$fuel_spec', '$exterior_color', '$interior_color', '$body_style', $body_doors, $seats, '$image_path', $image_count, 'Gray', '6-Speed Automatic', '48,000 mi', '$maintenance_service')";

                if(mysqli_query($conn, $sql)) {
                    // Success
                    header('Location: inventory.php');
                } else {
                    // Error
                    echo 'Error: ' . mysqli_error($conn);
                }
        }
    }

    echo $yearErr;                  echo $year;
    echo $makeErr;                  echo $make;
    echo $modelErr;                 echo $model;
    echo $priceErr;                 echo $price;
    echo $mileageErr;               echo $mileage;
    echo $vinErr;                   echo $vin;
    echo $engine_typeErr;           echo $engine_type;
    echo $engine_sizeErr;           echo $engine_size;
    echo $transmissionErr;          echo $transmission;
    echo $fuel_specErr;             echo $fuel_spec;
    echo $exterior_colorErr;        echo $exterior_color;
    echo $interior_colorErr;        echo $interior_color;
    echo $body_styleErr;            echo $body_style;
    echo $body_doorsErr;            echo $body_doors;
    echo $seatsErr;                 echo $seats;
    echo $maintenance_serviceErr;   echo $maintenance_service;
    echo $image_pathErr;            echo $image_path;
    echo $image_countErr;           echo $image_count;

?>

    <img src="logo.png" class="rounded-circle w-25 mb-3" alt="">
    <h2>Vehicle Info</h2>
    <p class="lead text-center">Add Vehicle</p>
    <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" class="mt-4 w-75">
        <div class="mb-3">
            <label for="year" class="form-label">Year:</label>
            <input type="number" class="form-control <?php echo $yearErr ? 'is-invalid' : null; // Can also use: !$yearErr ?: 'is-invalid' ?>" name="year" value="<?php echo isset($_POST['year']) ? $year : ''; ?>" placeholder="Enter vehicle year" id="year">
            <div class="invalid-feedback"><?php echo $year; ?></div>
        </div>
        <div class="mb-3">
            <label for="make" class="form-label">Make:</label>
            <input type="text" class="form-control <?php echo $makeErr ? 'is-invalid' : null; ?>" name="make" value="<?php echo isset($_POST['make']) ? $make : ''; ?>" placeholder="Enter vehicle make" id="make">
            <div class="invalid-feedback"><?php echo $make; ?></div>
        </div>
        <div class="mb-3">
            <label for="model" class="form-label">Model:</label>
            <input type="text" class="form-control <?php echo $modelErr ? 'is-invalid' : null; ?>" name="model" value="<?php echo isset($_POST['model']) ? $model : ''; ?>" placeholder="Enter vehicle model" id="model">
            <div class="invalid-feedback"><?php echo $model; ?></div>
        </div>
        <div class="mb-3">
            <label for="price" class="form-label">Price:</label>
            <input type="number" class="form-control <?php echo $priceErr ? 'is-invalid' : null; ?>" name="price" value="<?php echo isset($_POST['price']) ? $price : ''; ?>" placeholder="Enter vehicle price" id="price">
            <div class="invalid-feedback"><?php echo $price; ?></div>
        </div>
        <div class="mb-3">
            <label for="mileage" class="form-label">Mileage:</label>
            <input type="number" class="form-control <?php echo $mileageErr ? 'is-invalid' : null; ?>" name="mileage" value="<?php echo isset($_POST['mileage']) ? $mileage : ''; ?>" placeholder="Enter vehicle mileage e.g. 35000 mi" id="mileage">
            <div class="invalid-feedback"><?php echo $mileage; ?></div>
        </div>
        <div class="mb-3">
            <label for="vin" class="form-label">VIN:</label>
            <input type="text" class="form-control <?php echo $vinErr ? 'is-invalid' : null; ?>" name="vin" value="<?php echo isset($_POST['vin']) ? $vin : ''; ?>" placeholder="Enter 17-digit vehicle vin" id="vin">
            <div class="invalid-feedback"><?php echo $vin; ?></div>
        </div>
        <div class="mb-3">
            <label for="engine_type" class="form-label">Engine Type:</label>
            <input type="text" class="form-control <?php echo $engine_typeErr ? 'is-invalid' : null; ?>" name="engine_type" value="<?php echo isset($_POST['engine_type']) ? $engine_type : ''; ?>" placeholder="e.g. V6" id="engine_type">
            <div class="invalid-feedback"><?php echo $engine_type; ?></div>
        </div>
        <div class="mb-3">
            <label for="engine_size" class="form-label">Engine Size:</label>
            <input type="text" class="form-control <?php echo $engine_sizeErr ? 'is-invalid' : null; ?>" name="engine_size" value="<?php echo isset($_POST['engine_size']) ? $engine_size : ''; ?>" placeholder="e.g. 3.5L" id="engine_size">
            <div class="invalid-feedback"><?php echo $engine_size; ?></div>
        </div>
        <div class="mb-3">
            <label for="transmission" class="form-label">Transmission:</label>
            <input type="text" class="form-control <?php echo $transmissionErr ? 'is-invalid' : null; ?>" name="transmission" value="<?php echo isset($_POST['transmission']) ? $transmission : ''; ?>" placeholder="e.g. 6-Speed Manual" id="transmission">
            <div class="invalid-feedback"><?php echo $transmission; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Fuel Spec:</label>
            <input type="text" class="form-control <?php echo $fuel_specErr ? 'is-invalid' : null; ?>" name="fuel_spec" value="<?php echo isset($_POST['fuel_spec']) ? $fuel_spec : ''; ?>" placeholder="e.g. Gasoline" id="fuel_spec">
            <div class="invalid-feedback"><?php echo $fuel_spec; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Exterior Color:</label>
            <input type="text" class="form-control <?php echo $exterior_colorErr ? 'is-invalid' : null; ?>" name="exterior_color" value="<?php echo isset($_POST['exterior_color']) ? $exterior_color : ''; ?>" placeholder="e.g. Red" id="exterior_color">
            <div class="invalid-feedback"><?php echo $exterior_color; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Interior Color:</label>
            <input type="text" class="form-control <?php echo $interior_colorErr ? 'is-invalid' : null; ?>" name="interior_color" value="<?php echo isset($_POST['interior_color']) ? $interior_color : ''; ?>" placeholder="e.g. Black" id="interior_color">
            <div class="invalid-feedback"><?php echo $interior_color; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Body Style:</label>
            <input type="text" class="form-control <?php echo $body_styleErr ? 'is-invalid' : null; ?>" name="body_style" value="<?php echo isset($_POST['body_style']) ? $body_style : ''; ?>" placeholder="e.g. Sedan" id="body_style">
            <div class="invalid-feedback"><?php echo $body_style; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Body Doors:</label>
            <input type="number" class="form-control <?php echo $body_doorsErr ? 'is-invalid' : null; ?>" name="body_doors" value="<?php echo isset($_POST['body_doors']) ? $body_doors : ''; ?>" placeholder="e.g. 4" id="body_doors">
            <div class="invalid-feedback"><?php echo $body_doors; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Seats:</label>
            <input type="number" class="form-control <?php echo $seatsErr ? 'is-invalid' : null; ?>" name="seats" value="<?php echo isset($_POST['seats']) ? $seats : ''; ?>" placeholder="e.g. 5" id="seats">
            <div class="invalid-feedback"><?php echo $seats; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Maintenance and Service:</label>
            <textarea class="form-control <?php echo $maintenance_serviceErr ? 'is-invalid' : null; ?>" name="maintenance_service" value="<?php echo isset($_POST['maintenance_service']) ? $maintenance_service : ''; ?>"  placeholder="Enter details separated by commas e.g., Tune up, New tires, etc." style="height:100px" id="maintenance_service"></textarea>
            <div class="invalid-feedback"><?php echo $maintenance_service; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Image Path:</label>
            <input type="text" class="form-control <?php echo $image_pathErr ? 'is-invalid' : null; ?>" name="image_path" value="<?php echo isset($_POST['image_path']) ? $image_path : ''; ?>" placeholder="Enter path to folder e.g. /images/toyota-corolla-04721/" id="image_path">
            <div class="invalid-feedback"><?php echo $image_path; ?></div>
        </div>
        <div class="mb-3">
            <label for="" class="form-label">Image Count:</label>
            <input type="number" class="form-control <?php echo $image_countErr ? 'is-invalid' : null; ?>" name="image_count" value="<?php echo isset($_POST['image_count']) ? $image_count : ''; ?>" placeholder="Enter number of images in folder e.g. 21" id="image_count">
            <div class="invalid-feedback"><?php echo $image_count; ?></div>
        </div>
        <div class="mb-3">
            <input type="submit" name="submit" value="Add Vehicle" class="btn btn-dark w-100">
        </div>
    </form>
<?php include 'inc/footer.php'; ?>