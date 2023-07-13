<?php
// Get the duration from the request body
$data = json_decode(file_get_contents('php://input'), true);
$duration = $data['duration'];
$newValue = $data['value'];

// Define an array of valid durations and their corresponding file names
$validDurations = [
  '1day.csv',
  '3days.csv',
  '1week.csv',
  '1month.csv'
];

// Check if the provided duration is valid
if (in_array($duration, $validDurations)) {
  $file = $duration;

  // Read the file into an array of lines
  $lines = file($file);

  // Check if the row index is valid
  $row = $data['row'];
  if ($row >= 0 && $row < count($lines)) {
    // Split the line into columns
    $columns = explode(',', $lines[$row]);

    // Update the value in the fourth column (index 3) to the new value
    $columns[3] = $newValue;

    // Join the columns back into a line
    $updatedLine = implode(',', $columns);

    // Replace the line with the updated line in the array
    $lines[$row] = $updatedLine;

    // Write the updated lines back to the file
    file_put_contents($file, implode('', $lines));

    // Response message
    echo 'Value updated successfully.';
  } else {
    // Invalid row index
    echo 'Invalid row index.';
  }
} else {
  // Invalid duration
  echo 'Invalid duration.';
}
?>
