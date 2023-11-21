<?php
include './../../../Config/Connection.php';

$bookingId = !empty($_GET['bookingId']) ? $_GET['bookingId'] : null;

$query = "
SELECT
   *
FROM
    booking
JOIN customer USING(customer_id)
LEFT JOIN payment USING(booking_id)
LEFT JOIN booking_room USING(booking_id)
LEFT JOIN(
    SELECT
        room_id AS id,
        branch_name,price,description,title
    FROM
        room
    JOIN branch USING(branch_id)
    UNION
SELECT
    villa_id AS id,
    branch_name,price,description,title
FROM
    villa
JOIN branch USING(branch_id)
) AS rooms_villas
ON
    booking.villa_id = rooms_villas.id OR booking_room.room_id = rooms_villas.id  WHERE booking.booking_id ='$bookingId'";

$result = mysqli_query($con, $query);

if (mysqli_num_rows($result) > 0) {
    $response = array();
    while ($row = mysqli_fetch_assoc($result)) {
        array_push($response, $row);
    }
    echo json_encode($response);
    die();
}

echo json_encode([]);
