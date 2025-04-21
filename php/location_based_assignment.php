<?php
require_once 'connection.php';

function assignByLocation() {
    global $pdo;

    // Get all pending packages (delivery_status_id = 1)
    $pendingPackagesSql = "
        SELECT pd.*, ad.address AS pickup_address
        FROM package_details pd
        JOIN address_details ad ON pd.order_code = ad.order_code
        WHERE pd.delivery_status_id = 1 AND ad.address_type_id = 1";
    $pendingStmt = $pdo->query($pendingPackagesSql);
    $pendingPackages = $pendingStmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($pendingPackages)) {
        return "No pending packages to assign.";
    }

    // Get all available riders
    $availableRidersSql = "
        SELECT ad.account_id, ad.name, ad.default_location
        FROM account_details ad
        LEFT JOIN package_details pd ON ad.account_id = pd.delivery_rider_id 
            AND pd.delivery_status_id IN (2, 3) -- In transit or waiting for pickup
        WHERE ad.type_id = 3 
        GROUP BY ad.account_id
        HAVING COUNT(pd.order_code) = 0"; // Only riders with no active assignments
    $ridersStmt = $pdo->query($availableRidersSql);
    $availableRiders = $ridersStmt->fetchAll(PDO::FETCH_ASSOC);

    if (empty($availableRiders)) {
        return "No available riders.";
    }

    $assignmentsMade = 0;

    foreach ($pendingPackages as $package) {
        $nearestRider = findNearestRider($package['pickup_address'], $availableRiders);

        if ($nearestRider) {
            // Assign package to nearest rider
            $assignSql = "
                UPDATE package_details
                SET delivery_rider_id = :rider_id, delivery_status_id = 2, date_assigned = NOW()
                WHERE order_code = :order_code";
            $stmt = $pdo->prepare($assignSql);
            $stmt->bindParam(':rider_id', $nearestRider['account_id'], PDO::PARAM_INT);
            $stmt->bindParam(':order_code', $package['order_code'], PDO::PARAM_INT);
            $stmt->execute();

            // Remove the assigned rider from the available riders list
            $availableRiders = array_filter($availableRiders, function($rider) use ($nearestRider) {
                return $rider['account_id'] != $nearestRider['account_id'];
            });

            $assignmentsMade++;
        }

        if (empty($availableRiders)) {
            break; // No more available riders
        }
    }

    return "Location-based assignment completed. Assigned $assignmentsMade packages.";
}

function findNearestRider($pickupAddress, $riders) {
    // In a real-world scenario, you would use a geocoding service here
    // to convert addresses to coordinates and then calculate distances.
    // For this example, we'll use a simple string comparison as a placeholder.

    $nearestRider = null;
    $shortestDistance = PHP_INT_MAX;

    foreach ($riders as $rider) {
        $distance = levenshtein($pickupAddress, $rider['default_location']);

        if ($distance < $shortestDistance) {
            $shortestDistance = $distance;
            $nearestRider = $rider;
        }
    }

    return $nearestRider;
}

// This function can be called by other scripts
function runAutoAssignment() {
    $result = assignByLocation();
    error_log($result); // Log the result
    return $result;
}