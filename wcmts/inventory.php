<?php include 'inc/header.php'; ?>

<?php // Ideally, use OOP to create special classes & objects to fetch from db e.g. Create a "Vheicle" class and use a method such as getVehicle() or vehicle->get() to get the data

  $vehicles_hard_coded_example = array(
    array(
      'id' => '1',
      'make' => 'Audi',
      'model' => 'A6',
      'year' => '2005',
      'price' => '8100.00',
      'mileage' => '48000',
      'vin' => '1WH63KS8DH7Y23781',
      'engine_type' => 'V6',
      'engine_size' => '3.2L',
      'transmission' => '6-Speed Automatic',
      'fuel_spec' => 'Gasoline',
      'exterior_color' => 'Gray',
      'interior_color' => 'Gray',
      'body_style' => 'Sedan',
      'body_doors' => '4',
      'seats' => '5',
      'image_path' => 'images/audi-a6-2005-23781/',
      'image_count' => '17',
      'vehicle_info_color' => 'Gray',
      'vehicle_info_transmission' => '6-Speed Automatic',
      'vehicle_info_mileage' => '48,000 mi',
      'maintenance_service' => 'Engine oil & oil filter replacement,Transmission Fluid replacement,Multi-point inspection'
    ),
    array(
      'id' => '4',
      'make' => 'Chevrolet',
      'model' => 'Corvette ZR-1',
      'year' => '1991','price' => '49995.00',
      'mileage' => '1900',
      'vin' => '6SG73JUD8YBQ34719',
      'engine_type' => 'v8',
      'engine_size' => '5.7L',
      'transmission' => '6-Speed Manual',
      'fuel_spec' => 'Gas','exterior_color' => 'Red',
      'interior_color' => 'Red',
      'body_style' => 'Coupe',
      'body_doors' => '2',
      'seats' => '2',
      'image_path' => 'images/chevrolet-corvette-zr1-1991-34719',
      'image_count' => '20',
      'vehicle_info_color' => 'Red',
      'vehicle_info_transmission' => '6-Speed Manual',
      'vehicle_info_mileage' => '1900',
      'maintenance_service' => 'Fresh fluids to keep this collector-car worthy!'
    ),
  );

  $sql = 'SELECT * FROM vehicles';
  $result = mysqli_query($conn, $sql);
  $vehicles = mysqli_fetch_all($result, MYSQLI_ASSOC)
?>
   
    <h2>Inventory</h2>

    <?php if(empty($vehicles)): ?>
      <p class="lead mt3">There are no vehicles</p>
    <?php endif; ?>

    <?php foreach($vehicles as $vehicle): ?>
    <div class="card my-3 w-75">
      <div class="card-body text-center">
        <?php echo $vehicle['seats'] ?>
        <div class="text-secondary mt-2">
          By <?php echo $vehicle['make']; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>

<?php include 'inc/footer.php'; ?>