
<?php
$conn = oci_connect('autoservicio', 'autoservicio', 'autoservicio');
$query = 'SELECT * FROM EMP';
$Q = oci_parse($conn, $query);
oci_execute($Q, OCI_DEFAULT);
while ( $row = oci_fetch_array($id_sentencia, OCI_RETURN_NULLS) ) {
   print_r($row);
   echo '<br>';
}
oci_close($conn);
?>