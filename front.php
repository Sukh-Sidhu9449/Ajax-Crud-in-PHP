<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <title>AJAX CRUD Operation</title>
</head>

<body>
    <div class="container">
        <h1 class="text-primary text-uppercase text-center">AJAX CRUD OPERATION</h1>
        <div class="d-flex justify-content-end">
            <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Add User
            </button>
        </div>
        <h2 class="text-danger">All Records</h2>
        <div id="records_contant">

        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">AJAX CRUD OPERATION</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="firstname">First Name:</label>
                            <input type="text" name="firstname" id="firstname" class="form-control" placeholder="First Name">
                        </div>
                        <div class="form-group">
                            <label for="lastname">Last Name:</label>
                            <input type="text" name="lastname" id="lastname" class="form-control" placeholder="Last Name">
                        </div>
                        <div class="form-group">
                            <label for="email">Email Id:</label>
                            <input type="text" name="email" id="email" class="form-control" placeholder="Email">
                        </div>
                        <div class="form-group">
                            <label for="mobile">Mobile:</label>
                            <input type="number" name="mobile" id="mobile" class="form-control" placeholder="Mobile Number">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-danger" onclick="addRecords()">Save</button>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- update modal -->


    <div class="modal fade" id="update_user_modal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">AJAX CRUD OPERATION</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="update_firstname">First Name:</label>
                        <input type="text" name="update_firstname" id="update_firstname" class="form-control" placeholder="First Name">
                    </div>
                    <div class="form-group">
                        <label for="update_lastname">Last Name:</label>
                        <input type="text" name="update_lastname" id="update_lastname" class="form-control" placeholder="Last Name">
                    </div>
                    <div class="form-group">
                        <label for="update_email">Email Id:</label>
                        <input type="text" name="update_email" id="update_email" class="form-control" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="update_mobile">Mobile:</label>
                        <input type="number" name="update_mobile" id="update_mobile" class="form-control" placeholder="Mobile Number">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-danger" onclick="updateuserdetail()">Update</button>
                    <input type="hidden" name="" id="hidden_user_id">
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>

    <script type="text/javascript">
        $(document).ready(function() {

            readRecords();

        });

        function readRecords() {

            var readrecord = "readrecord";
            $.ajax({
                url: "back.php",
                type: "post",
                data: {
                    readrecord: readrecord
                },
                success: function(data, status) {
                    $('#records_contant').html(data);
                }
            });
        }

        function addRecords() {
            

            var firstname = $('#firstname').val();
            var lastname = $('#lastname').val();
            var email = $('#email').val();
            var mobile = $('#mobile').val();

            $.ajax({
                url: "back.php",
                type: 'post',
                data: {
                    firstname: firstname,
                    lastname: lastname,
                    email: email,
                    mobile: mobile
                },
                success: function(data, status) {

                    readRecords();
                    $('#exampleModal div :input'). val(""); 
                    $('#exampleModal').modal("hide");
                }
            });

        }

        function DeleteUser(deleteid) {
            var conf = confirm("Are you sure?");
            if (conf == true) {
                $.ajax({
                    url: "back.php",
                    type: "post",
                    data: {
                        deleteid: deleteid
                    },
                    success: function(data, status) {
                        readRecords();

                    }

                });

            }
        }

        function GetUserDetails(id) {
            $('#hidden_user_id').val(id);

            $.post("back.php", {
                    id: id
                }, function(data, status) {
                    var user = JSON.parse(data);
                    $('#update_firstname').val(user.firstname);
                    $('#update_lastname').val(user.lastname);
                    $('#update_email').val(user.email);
                    $('#update_mobile').val(user.mobile);
                }

            );
            $('#update_user_modal').modal("show");
        }

        function updateuserdetail() {
            var firstnameupd = $('#update_firstname').val();
            var lastnameupd = $('#update_lastname').val();
            var emailupd = $('#update_email').val();
            var mobileupd = $('#update_mobile').val();

            var hidden_user_idupd = $('#hidden_user_id').val();
            $.post("back.php", {
                    hidden_user_idupd: hidden_user_idupd,
                    firstnameupd: firstnameupd,
                    lastnameupd: lastnameupd,
                    emailupd: emailupd,
                    mobileupd: mobileupd

                },
                function(data, status) {
                    $('#update_user_modal').modal("hide");
                    readRecords();
                }
            );
        }
    </script>
</body>

</html>