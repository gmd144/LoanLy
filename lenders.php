<?php
include_once("navigation.php");
if (isset($_POST["submit"])) {
    $name = htmlspecialchars($_POST["lenderName"]);
    $query = "INSERT INTO `borrower` (`name`) VALUES ('$name')";
    $result = mysqli_query($conn, $query);
    if ($result){
        header("location: lenders.php");
    }
}
elseif (isset($_POST["update"])) {
    $name = htmlspecialchars($_POST["new_name"]);
    $id = filter_var($_POST['id'], FILTER_SANITIZE_STRING);
    $id = intval($id);
    $query = 'UPDATE `borrower` SET `name` = "'.$name.'" WHERE id = '.$id;
    // echo $query;
    $result = mysqli_query($conn, $query);
    if ($result){
        header("location: lenders.php");
    }
}
else{
    $query = "SELECT * FROM `borrower`";
    $result = mysqli_query($conn, $query);
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>LoanLy | Manage Lenders</title>
    <link rel="stylesheet" type="text/css" href="resources\css\lenders.css">
</head>

<body>
    <div class="container">
        <form action="" method="post">
            <div class="row">
                <div class="input-group">
                    <span class="input-group-text"><label for="lenderName">Lender Name</label></span>
                    <input class="form-control" type="text" id="lenderName" name="lenderName" required>
                </div>
                <input type="submit" name="submit" value="Add Lender">
            </div>
        </form>
        <table>
            <thead>
                <tr>
                    <th>Sr #</th>
                    <th>Lender Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_array($result)){
                    echo "<tr>
                             <td>".$i."</td>
                             <td>".$row['name']."</td>
                             <td><span class='edit-button' data-id=".$row['id']."><i class='fa-solid fa-pen-to-square'></i> Edit</span> | <span class='delete-button' data-id=".$row['id']."><i class='fa-solid fa-trash'></i> Delete</span></td>
                          </tr>";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>

    <div id="form_container">
        <form id="my_form" method="post">
            <div class="input-group m-1">
                <span class="input-group-text"><label for="my_input">Name</label></span>
                <input type="text" id="my_input" name="new_name" class="form-control" required>
            </div>
            <input type="number" id="edit-id" name="id" hidden>
            <input type="submit" name="update" value="Submit">
        </form>
    </div>
    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
        button.addEventListener('click', function() {
            var row_id = this.getAttribute('data-id');

            // Send AJAX request
            var xhr = new XMLHttpRequest();
            xhr.open('POST', 'delete.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.send('id=' + encodeURIComponent(row_id));

            xhr.onload = function() {
                if (xhr.status == 200) {
                    alert('Record Deleted successfully');
                    location.reload()
                    // console.log(xhr.responseText);
                } else {
                    alert('An error occurred');
                    console.log(xhr.responseText);
                }
            };
        });
        });
        document.querySelectorAll('.edit-button').forEach(button => {
        button.addEventListener('click', function() {
                var row_id = this.getAttribute('data-id');
                document.getElementById("edit-id").value = row_id;
                document.getElementById("form_container").style.display = "block";
            });
        });

        // document.getElementById("my_form").addEventListener("submit", function(e) {
        //     e.preventDefault();
        //     document.getElementById("form_container").style.display = "none";
        //     this.submit();
        // });
    </script>
</body>

</html>