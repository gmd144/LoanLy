<?php
include_once("navigation.php");
if(isset($_SERVER['HTTP_REFERER']) && !isset($_POST["submit"])) {
    $previous_page = array_slice(explode('/', $_SERVER['HTTP_REFERER']), -1)[0];
    // echo "<script>alert('$previous_page')</script>";
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['edit_id'])) {
            $id = filter_var($_GET['edit_id'], FILTER_SANITIZE_STRING);
            $id = intval($id);
            $stmt = $pdo->prepare('SELECT * FROM loans WHERE id = :id');
            $stmt->execute(['id' => $id]);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $query = "SELECT * FROM borrower";
            $stmt = $pdo->prepare($query);
            $stmt->execute();
            $row = $stmt->fetchAll(PDO::FETCH_ASSOC);
            // echo "<pre>";
            // print_r($result);
            // foreach ($row as $key) {
            //     print_r($key);
            // }
            // echo "</pre>";
        } else {
            http_response_code(400);
            echo "No id provided";
        }
    }
} 
if (isset($_SERVER['HTTP_REFERER']) && isset($_POST["submit"])) {
    echo "<script>alert('into update')</script>";
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
    $id = $_POST["id"];
    $previous_page = $_POST["previous"];
    $date = isset($_POST["date"])?$_POST["date"]:'NULL';
    $image = ['pic' => isset($data)?$data:'Null', 'borrower' => $borrower, 'lender' => $lender, 'amount'=> $amount, 'dated'=> $date,  'id' => $id];
    echo $image;
    $sql = "UPDATE `loans` SET `borrower_id`=:borrower, `amount`=:amount, `image`=:pic, `lender_id`=:lender, `dated`=:dated WHERE loans.id=:id";
    $stmt = $pdo->prepare($sql);
    if ($stmt->execute($image)){
        echo "<script>alert('Record updated successfully')</script>";
        header("location:".$previous_page);
    }
    else{
        echo "<script>alert('There was an error adding the record')</script>";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>LoanLy | Edit a Loan Record</title>
    <link rel="stylesheet" type="text/css" href="resources\css\add loan.css">
</head>
<body>
    <div class="container">
        <form action="" method="post" enctype="multipart/form-data">
            <?php echo '<input type="text" name="id" value="'.$id.'" hidden>
            <input type="text" name="previous" value="'.$previous_page.'" hidden>'?>
        <div class="form-group"></div>    
        <label for="lender" class="form-label">Lender</label>
            <select class="form-select" id="lender" name="lender" required>
                <option value="">Select a Lender</option>
                <?php

                foreach ($row as $record){
                    $s = ($record['id']==$result[0]['lender_id'])?"selected":" ";
                    echo "<option ".$s." value=".$record['id'].">".$record['name']."</option>";
                }
                ?>
            </select>
            <div class="form-group">
                <label for="borrower" class="form-label">Borrower</label>
                <select class="form-select" id="borrower" name="borrower" required>
                <option value="">Select a Borrower</option>
                    <?php
                    foreach ($row as $record){
                        $s = ($record['id']==$result[0]['borrower_id'])?"selected":" ";
                        echo "<option ".$s." value=".$record['id'].">".$record['name']."</option>";
                    }
                    ?>
                </select>
            </div>
            <div class="form-group">
                <label for="amount" class="form-label">Amount</label>
                <input class="form-control" type="number" id="amount" name="amount" min="1" value="<?php echo $result[0]['amount']?>" required>
            </div>
            <div class="form-group picture">
                <label for="attachment" class="form-label">Attachment</label>
                <?php
                echo ($result[0]['image'] != NULL) ? "<img id='image' src='data:image/*;base64," . base64_encode($result[0]['image']) . "' onclick=document.getElementById('attachment').click() alt=''>" :'';
                ?>
                <input class="form-control" type="file" id="attachment" name="image" accept="image/png, image/jpeg" onchange="loadFile(event)">
            </div>
            <div class="form-group">
                <label for="date" class="form-label">Date</label>
                <input class="form-control" type="date" id="date" name="date" <?php echo "max=".date('Y-m-d'). " value=".$result[0]['dated']; ?>>
            </div>
            <input type="submit" value="Update Loan Record" name="submit">
        </form>
    </div>
    <script>
        var loadFile = function(event) {
            var image = document.getElementById('image');
            image.src = URL.createObjectURL(event.target.files[0]);
        };
    </script>
</body>
</html>
