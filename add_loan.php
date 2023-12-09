<?php
include_once("navigation.php");
// echo date('Y-m-d H:i:s');
$query = "SELECT * FROM `borrower`";
$result = mysqli_query($conn, $query);
if (isset($_POST["submit"])) {
    if ($_FILES["image"]["error"] == 0) {
        $image_name = $_FILES["image"]["name"];
        $allowed_extensions = array("png", "jpg", "jpeg");
        $image_extension = explode(".", $image_name);
        $extension = end($image_extension);
        if (!in_array($extension, $allowed_extensions)) {
            echo "<script>alert('Please upload a valid image file');</script>";
        } else {
            if (($_FILES["image"]["size"]) <= 2097152) {
                $path = $_FILES["image"]["tmp_name"];
                $data = file_get_contents($path);
            } else {
                echo "<script>alert('Image file too big. Image can be of maximum 2 MB size.');</script>";
                // echo "<script>window.history.back(1);</script>";
                die("Image file too big.");
            }
        }
    }
    $borrower = $_POST["borrower"];
    $lender = $_POST["lender"];
    $amount = $_POST["amount"];
    $image = ['pic' => isset($data)?$data:'Null', 'borrower' => $borrower, 'lender' => $lender, 'amount'=> $amount, 'dated'=> (isset($_POST["date"]) && $_POST['date']!= '')?$_POST["date"]:'Null'];
    // echo $image['dated'];
    $sql = "INSERT INTO `loans` (`borrower_id`, `amount`, `image`, `lender_id`, `dated`) VALUES (:borrower, :amount, :pic, :lender, :dated)";
    $stmt = $pdo->prepare($sql);
    $stmt->bindValue(':borrower', $image['borrower']);
    $stmt->bindValue(':amount', $image['amount']);
    $stmt->bindValue(':pic', $image['pic']);
    $stmt->bindValue(':lender', $image['lender']);
    $stmt->bindValue(':dated', $image['dated']);//, is_null($image['dated']) ? PDO::PARAM_NULL : PDO::PARAM_STR);
    if ($stmt->execute($image)){
    // $pic = isset($data)?$data:'NULL';
    // $dated = (isset($_POST["date"]) && $_POST["date"] != '')?$_POST["date"]: date('Y-m-d H:i:s');
    // echo "<br>".$dated."<br>";
    // $query = "INSERT INTO `loans` (`borrower_id`, `amount`, `image`, `lender_id`, `dated`) VALUES ($borrower, $amount, $pic, $lender, '$dated')";
    // echo $query;
    // if (mysqli_query($conn, $query)) {
        echo "<script>alert('Record added successfully')</script>";
    }
    else{
        echo "<script>alert('There was an error adding the record')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LoanLy | Add New Loan Record</title>
    <link rel="stylesheet" type="text/css" href="resources\css\add loan.css">
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group"></div>    
        <label for="lender" class="form-label">Lender</label>
            <select class="form-select" id="lender" name="lender" required>
                <option selected value="">Select a Lender</option>
                <?php
                while ($row = mysqli_fetch_array($result)){
                    echo "<option value=".$row['id'].">".$row['name']."</option>";
                }
                ?>
            </select>
            <div class="form-group">
                <label for="borrower" class="form-label">Borrower</label>
                <select class="form-select" id="borrower" name="borrower" required>
                <option selected value="">Select a Borrower</option>
                    <?php
                    mysqli_data_seek($result, 0);
                    while ($row = mysqli_fetch_array($result)){
                        echo "<option value=".$row['id'].">".$row['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="amount" class="form-label">Amount</label>
                <input class="form-control" type="number" id="amount" name="amount" min="1" required>
            </div>
            <div class="form-group">
                <label for="attachment" class="form-label">Attachment</label>
                <input class="form-control" type="file" id="attachment" name="image" accept="image/png, image/jpeg">
            </div>
            <div class="form-group">
                <label for="date" class="form-label">Date</label>
                <input class="form-control" type="date" id="date" name="date" max="<?php echo date('Y-m-d'); ?>">
            </div>
            <input type="submit" value="Add Loan Record" name="submit">
        </form>
    </div>
</body>
</html>
