<div class="col-md-2"></div>
    <div class="col-md-8">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="panel-title">
                    Import Movie                </div>
            </div>
            <div class="panel-body">
				<form action = "http://localhost/Cineverse/index.php?admin/movie_import/" method="POST" enctype="multipart/form-data">
	                <div class="form-group mb-2">
                        <!-- <label for="save_excel_data">Import an Excel file</label>
                        <div class="form-group">
                            <input type="file" name="save_excel_data" class="form-control" id="save_excel_data">
                        </div> -->
						<input type="file" name="import_file" class="form-control" />
						<br>
                        <button type="submit" name="save_excel_data" class="btn btn-primary mt-3">Import
                            data</button>
                    </div>

					<!-- <div class="form-group">
						<input type="submit" class="btn btn-success" value="Submit">
						<a href="http://localhost/Netflix/index.php?admin/movie_list/" class="btn btn-black">Go back</a>
					</div> -->
				</form>
            </div>
			<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
        </div>
    </div>

<script>

</script>

<?php
$host = "localhost";
$username = "root";
$password = "";
$database = "cineversedb";

// Create DB Connection
$conn = mysqli_connect($host, $username, $password, $database);

// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
} 
require 'application\vendor\autoload.php';
// echo $_POST['save_excel_data'];
if (isset($_POST['save_excel_data'])) {
    // echo "Import file successfully";
    $fileName = $_FILES['import_file']['name'];
    $file_ext = pathinfo($fileName, PATHINFO_EXTENSION);

    $allowed_ext = ['xls', 'csv', 'xlsx'];

    if (in_array($file_ext, $allowed_ext)) {
        // echo "Check file type sucessfully";
        $inputFileNamePath = $_FILES['import_file']['tmp_name'];
        $spreadsheet = \PhpOffice\PhpSpreadsheet\IOFactory::load($inputFileNamePath);
        $data = $spreadsheet->getActiveSheet()->toArray();

        // echo $inputFileNamePath;

        $count = "0";
        foreach ($data as $row) {
            if ($count > 0) {
                $title = $row['0'];
                $description_short = $row['1'];
                $description_long = $row['2'];
                $year = $row['3'];
                $country_id = $row['4'];
                $rating = $row['5'];
                $genre_id = $row['6'];

                $actorsData = $row['7'];
                $actorsList = explode(",", $actorsData);
                $actorsArray = json_encode($actorsList);

                $director = $row['8'];
                $featured = $row['9'];
                $kids_restriction = $row['10'];
                $url = $row['11'];
                $trailer_url = $row['12'];
                $duration = $row['13'];

                $moviesQuery = "INSERT INTO movie (title,description_short,description_long,year,country_id,rating,genre_id,actors,director,featured,kids_restriction,url,trailer_url,duration) 
                                VALUES ('$title','$description_short','$description_long','$year','$country_id','$rating','$genre_id','$actorsArray','$director','$featured','$kids_restriction','$url','$trailer_url','$duration')";
                $result = mysqli_query($conn, $moviesQuery);

                $movie_id = mysqli_insert_id($conn);


                $thumbnailData = $row['14'];
                $imageData = file_get_contents($thumbnailData);
                file_put_contents('C:/xampp/htdocs/cineverse/assets/global/movie_thumb/' . $movie_id . '.jpg', $imageData);

                $posterData = $row['15'];
                $imageData = file_get_contents($posterData);
                file_put_contents('C:/xampp/htdocs/cineverse/assets/global/movie_poster/' . $movie_id . '.jpg', $imageData);
                $msg = true;

            } else {
                $count = "1";
            }
        }

        // if (isset($msg)) {
        //     $_SESSION['message'] = "Successfully Imported";
        //     header('Location: index.php');
        //     exit(0);
        // } else {
        //     $_SESSION['message'] = "Not Imported";
        //     header('Location: index.php');
        //     exit(0);
        // }
    }
    // else {
//     $_SESSION['message'] = "Invalid File";
//     header('Location: index.php');
//     exit(0);
}


?>