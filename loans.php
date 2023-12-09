<?php
include_once("navigation.php");
$query = "SELECT* FROM loan_records";
$result = mysqli_query($conn, $query);
?>
<!DOCTYPE html>
<html>

<head>
    <title>LoanLy | Loan Records</title>
    <link rel="stylesheet" type="text/css" href="resources/css/loan_records.css">
</head>

<body>
    <div class="container">
        <table>
            <thead>
                <tr>
                    <th>Sr. #</th>
                    <th>Lender</th>
                    <th>Borrower</th>
                    <th>Amount</th>
                    <th>Image</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $i = 1;
                while ($row = mysqli_fetch_array($result)) {
                    $img = ($row['image'] != NULL) ? "<img class='modal-target' src='data:image/*;base64," . base64_encode($row['image']) . "' width='40px' height='50px' alt=''>" : NULL;
                    echo "<tr>
                            <td>" . $i . "</td>
                            <td>" . $row['lender'] . "</td>
                            <td>" . $row['borrower'] . "</td>
                            <td>" . $row['amount'] . "</td>
                            <td class='pic'>" . $img . "</td>
                            <td>" . $row['dated'] . "</td>
                            <td><span class='edit-button'><a href='edit_loan.php?edit_id=" . $row['loan_id'] . "'><i class='fa-solid fa-pen-to-square'></i> Edit</a></span> | <span class='delete-button' data-id=" . $row['loan_id'] . "><i class='fa-solid fa-trash'></i> Delete</span></td>
                    ";
                    $i++;
                }
                ?>
            </tbody>
        </table>
    </div>
    <div id="modal" class="modal">
        <span id="modal-close" class="modal-close">&times;</span>
        <img id="modal-content" class="modal-content">
        <!-- <div id="modal-caption" class="modal-caption"></div> -->
    </div>
    <script>
        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', function () {
                var row_id = this.getAttribute('data-id');

                // Send AJAX request
                var xhr = new XMLHttpRequest();
                xhr.open('POST', 'delete.php', true);
                xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
                xhr.send('id=' + encodeURIComponent(row_id));

                xhr.onload = function () {
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

        var modal = document.getElementById('modal');
        var modalClose = document.getElementById('modal-close');
        modalClose.addEventListener('click', function() { 
        modal.style.display = "none";
        });
        // global handler
        document.addEventListener('click', function (e) { 
        if (e.target.className.indexOf('modal-target') !== -1) {
            var img = e.target;
            var modalImg = document.getElementById("modal-content");
            var captionText = document.getElementById("modal-caption");
            modal.style.display = "block";
            modalImg.src = img.src;
            captionText.innerHTML = img.alt;
        }
        });
    </script>
</body>

</html>