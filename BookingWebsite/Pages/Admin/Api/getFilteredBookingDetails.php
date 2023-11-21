<?php
include "./../../../Config/Connection.php";
include "./../../../Services/BookingStatus.php";

$branchName = $_GET['brName'];

$query = "
SELECT
      bk.*,
    cus.customer_name,
    bk_room.room_id
FROM
    booking AS bk
JOIN customer AS cus USING(customer_id)
LEFT JOIN booking_room AS bk_room USING(booking_id)
LEFT JOIN (
    SELECT
        room_id AS id,
        branch_id
    FROM
        room
    UNION
SELECT
    villa_id AS id,
    branch_id
FROM
    villa
) AS room_villas ON bk_room.room_id=room_villas.id OR bk.villa_id=room_villas.id
JOIN branch USING (branch_id) WHERE bk.booking_status='" . bookingStatus::CHECKED_IN->value . "' AND branch_name LIKE CONCAT ('$branchName','%') ORDER BY booking_id ASC";

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
