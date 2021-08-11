<?php
    $conn = mysqli_connect("localhost", "root", "", "drupal_767");

    $get_lib_id = "SELECT library_id FROM h5p_libraries WHERE machine_name = 'H5P.InteractiveVideo'";
    $id_result = mysqli_query($conn, $get_lib_id);
    $library_id = mysqli_fetch_assoc($id_result);

    $get_data = "SELECT json_content FROM h5p_nodes WHERE main_library_id = ".$library_id['library_id'];
    $results = mysqli_query($conn, $get_data);

    $row = mysqli_fetch_all($results);
    $decoded_values = [];
    foreach($row as $data) {
        array_push($decoded_values, json_decode($data[0]));
    }

    header('Content-Type: application/json');
    echo json_encode($decoded_values);
?>