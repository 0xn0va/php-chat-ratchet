<?php
include_once 'config.php';
if(isset($_POST['btn-upload']))
{

	$file = rand(100,10000)."-".$_FILES['file']['name'];
	$file_loc = $_FILES['file']['tmp_name'];
	$file_size = $_FILES['file']['size'];
	$file_type = $_FILES['file']['type'];
	$person_name = $_POST['pname'];
	$folder="uploads/";
	$new_size = $file_size/1024;
	$new_file_name = strtolower($file);
	$final_file=str_replace(' ','-',$new_file_name);

	if(move_uploaded_file($file_loc,$folder.$final_file))
	{
		?>
		<script>
		window.location.href='files.php';
		</script>
		<?php
	}
	else
	{
		?>
		<script>
		window.location.href='files.php';
		</script>
		<?php
	}
}
?>
