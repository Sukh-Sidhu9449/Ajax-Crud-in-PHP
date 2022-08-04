<?php 
$conn = mysqli_connect("localhost","root","King#123","crudop");
if(!$conn){
     "No connection";
}

extract($_POST);

if(isset($_POST['readrecord'])){
    $data='<table class="table table-bordered table-stripped">
    <tr>
        <th>NO.</th>
        <th>First name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Mobile No.</th>
        <th>Edit Action</th>
        <th>Delete Action</th>
    </tr>';
    $displayquery="SELECT * FROM curdajax";
    $result = mysqli_query($conn,$displayquery);

    if(mysqli_num_rows($result)>0){
        $number = 1;
        while($row=mysqli_fetch_assoc($result)){
            $data.='<tr>
            <td>'.$number.'</td>
            <td>'.$row['firstname'].'</td>
            <td>'.$row['lastname'].'</td>
            <td>'.$row['email'].'</td>
            <td>'.$row['mobile'].'</td>
            <td>
            <button onclick="GetUserDetails('.$row['id'].')" class= "btn btn-warning">Edit</button>
            </td>
            <td>
            <button onclick="DeleteUser('.$row['id'].')" class= "btn btn-danger">Delete</button>
            </td>
            </tr>';
            $number++;
        }
    }
    $data.='</table>';
    echo $data;

}


if(isset($_POST['firstname']) && isset($_POST['lastname']) && isset($_POST['email']) && isset($_POST['mobile'])){
    $query = "INSERT INTO curdajax(firstname, lastname, email, mobile) VALUES ('$firstname','$lastname','$email','$mobile')";
    mysqli_query($conn,$query);
}

if(isset($_POST['deleteid'])){
    $userid= $_POST['deleteid'];
    $deletequery= "DELETE FROM curdajax WHERE id ='$userid'";
    mysqli_query($conn,$deletequery);
}


//Update

if(isset($_POST['id']) && isset($_POST['id']) != ""){
    $user_id=$_POST['id'];
    $query="SELECT * FROM curdajax WHERE id='$user_id'";
    $res=mysqli_query($conn,$query);
    if(!$res){
        exit();
    }
    $response= array();

    if(mysqli_num_rows($res)>0){
        while($row=mysqli_fetch_assoc($res)){
            $response=$row;
        }
    }else{
        $response['status']=200;
        $response['message']= "Data not found";
    }
    echo json_encode($response);
}else{
    $response['status']=200;
    $response['message']= "Invalid Request";

}

// update table

if(isset($_POST['hidden_user_idupd'])){
    $hidden_user_idupd = $_POST['hidden_user_idupd'];
    $firstnameupd =$_POST['firstnameupd'];
    $lastnameupd =$_POST['lastnameupd'];
    $emailupd =$_POST['emailupd'];
    $mobileupd =$_POST['mobileupd'];

    $query= "UPDATE curdajax SET firstname='$firstnameupd',lastname='$lastnameupd',email='$emailupd',mobile='$mobileupd' WHERE id='$hidden_user_idupd'";

    mysqli_query($conn,$query);
}