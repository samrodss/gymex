<?php

session_start();

include_once "connection.php";
include_once "url.php";


$exercises = [];


$data = $_POST;

// ✅ First, check if $_POST is empty before accessing "type"
if (!empty($data) && isset($data["type"])) {

    if ($data["type"] === "create") {


        $name = $data["name"];
        $sets = $data["sets"];
        $reps = $data["reps"];
        $current_weight = $data["currentweight"];

        $query = "INSERT INTO exercises (name, sets, reps, currentweight) VALUES (:name, :sets, :reps, :currentweight)";
        $stmt = $conn->prepare($query);
        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":sets", $sets);
        $stmt->bindParam(":reps", $reps);
        $stmt->bindParam(":currentweight", $current_weight);

        try {
            $stmt->execute();
            $_SESSION["msg"] = "The exercise was successfully created!";
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }

        header("Location: " . $BASE_URL . "index.php");
        exit();

    } else if ($data["type"] === "delete") {
        if (isset($data["id"]) && is_numeric($data["id"])) {
            $id = $data["id"];

            $query = "DELETE FROM exercises WHERE id = :id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":id", $id, PDO::PARAM_INT);

            try {
                $stmt->execute();
                $_SESSION["msg"] = "The exercise was removed successfully!";
                header("Location:" . $BASE_URL . "index.php");
                exit(); // Important: Add exit() here
            } catch (PDOException $e) {
                // Log the error for debugging (e.g., error_log($e->getMessage());)
                $_SESSION["error"] = "An error occurred while deleting the exercise."; // User-friendly message
                header("Location:" . $BASE_URL . " index.php"); // Redirect even on error
                exit();
            }
        }

    } else if ($data["type"] === "edit") {
        $name = $data["name"];
        $sets = $data["sets"];
        $reps = $data["reps"];
        $current_weight = $data["currentweight"];
        $id = $data["id"];

        $query = "UPDATE exercises
        SET name = :name, sets = :sets, reps = :reps, currentweight = :currentweight
        WHERE id = :id ";

        $stmt = $conn->prepare($query);

        $stmt->bindParam(":name", $name);
        $stmt->bindParam(":sets", $sets);
        $stmt->bindParam(":reps", $reps);
        $stmt->bindParam(":currentweight", $current_weight);
        $stmt->bindParam(":id", $id);

        try {
            $stmt->execute();
            $_SESSION["msg"] = "The exercise was updated successfully!"; // Corrected message
            header("Location:" . $BASE_URL . "index.php");
            exit(); // Important: Add exit() here
        } catch (PDOException $e) {
            // Log the error for debugging
            $_SESSION["error"] = "An error occurred while updating the exercise."; // User-friendly message
            header("Location:" . $BASE_URL . "index.php"); // Redirect even on error
            exit();
        }
    }

} else {

    $query = "SELECT * FROM exercises";
    $stmt = $conn->prepare($query);
    $stmt->execute();
    $exercises = $stmt->fetchAll(PDO::FETCH_ASSOC);

}


