<?php
try {
    $db = new PDO("pgsql:host=db.gfvkcocmhfotqnjkcnfc.supabase.co;port=5432;dbname=postgres;sslmode=prefer", "postgres", "Daen121209@@");
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>