<?php
echo <<<TABLEHEAD
    <table cellspacing="2" cellpadding="2" width="40%" align="center" >
    <tr>
      <th colspan="4"><h1>Backup Reports</h1></th>
    </tr>
TABLEHEAD;

$path = ".";
$dir_iterator = new DirectoryIterator($path);

foreach ( $dir_iterator as $datei)
{
  $sorted_keys[$datei->getMTime()] = $datei->key();
}
krsort($sorted_keys);

$last_month = NULL;

foreach ($sorted_keys as $key) {
  $dir_iterator->seek($key);
  $datei = $dir_iterator->current();

  if(($datei != '*.php') && ($datei != '.') && ($datei != '..') && is_dir($path))
  {
    $current_month = date('M Y', $datei->getMTime());

    if ($current_month != $last_month) {
      echo '<tr><th colspan="4" align="center"><h2>' .$current_month. '</h2></th></tr>';
      echo '<tr>
        <th><h3>Name</h3></th>
        <th><h3>Time</h3></th>
        <th><h3>Date</h3></th>
        <th><h3>Size</h3></th>
      </tr>';
    }

    echo '<tr>';
    echo '<td align="center"><a href="' .$handle.$datei->getFilename(). '">Backup Report</a></td>';
    echo '<td align="center">' .date( 'H:i', $datei->getMTime() ). ' Uhr </td>';
    echo '<td align="center">' .date( 'd. M Y', $datei->getMTime() ). '</td>';
    echo '<td align="center">' .ceil( $datei->getSize()/1024 ). ' KB</td>';
    echo "</tr>\n";

    $last_month = $current_month;
  }
}
echo "</table>";
?>
