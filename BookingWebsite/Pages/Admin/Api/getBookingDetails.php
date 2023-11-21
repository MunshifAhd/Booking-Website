<?php
include './../../../Config/Connection.php';

$bookingId = !empty($_POST['bookingId']) ? $_POST['bookingId'] : null;

$query = "
SELECT
    booking.booking_id,
    booking.check_in,
    booking.check_out,
    booking.no_of_occupants,
    booking.villa_id,
    booking_room.room_id,
    customer.customer_name,
    customer.customer_id,
    customer.customer_email,
    customer.customer_nic,
    customer.customer_address,
    customer.customer_phone_number,
    customer.customer_type,
    payment.payment_id,
    payment.creditcard_number,
    payment.expiry,
    payment.cvn,
    rooms_villas.*
FROM
    booking
JOIN customer USING(customer_id)
LEFT JOIN payment USING(booking_id)
LEFT JOIN booking_room USING(booking_id)
LEFT JOIN(
    SELECT
        room_id AS id,
        branch_name,price
    FROM
        room
    JOIN branch USING(branch_id)
    UNION
SELECT
    villa_id AS id,
    branch_name,price
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
