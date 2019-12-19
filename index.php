<?php include("db.php"); 

if(!isset($_SESSION['date_counter2'])) {
    $_SESSION['date_counter2'] = 0;
}


if(isset($_POST['datePrevious'])) { 

        $_SESSION['date_counter2'] += 1;   

    }


    if(isset($_POST['dateNext'])) { 
   
if ($_SESSION['date_counter2'] > 0) {

        $_SESSION['date_counter2'] -= 1;   

    }
}

$date = (new DateTime('now-' . $_SESSION['date_counter2'] . 'day'))->format('d-m-Y');
$dateCheck = strval($date);
$dateCode = (new DateTime('now-' . $_SESSION['date_counter2'] . 'day'))->format('d-m-Y');


$fname = "";
$fat =  "";
$carbs = "";
$protein = "";
$kcals = "";
$price = "";
$list = "";
$error_array = "";
if (isset($_POST['create_button'])) {
    $fname = strip_tags($_POST['reg_fname']);
    $_SESSION['reg_fname'] = $fname;
    $fat = strip_tags($_POST['reg_fat']);
    $_SESSION['reg_fat'] = $fat;
    $carbs = strip_tags($_POST['reg_carbs']);
    $_SESSION['reg_carbs'] = $carbs;
    $protein = strip_tags($_POST['reg_protein']);
    $_SESSION['reg_protein'] = $protein;
    $kcals = strip_tags($_POST['reg_kcals']);
    $_SESSION['reg_kcals'] = $kcals;
    $price = strip_tags($_POST['reg_price']);
    $_SESSION['reg_price'] = $price;
    $list =  $_POST['radio'];
    if ($list == 'grams') {
        $quantity = 100;
    }
    if ($list == 'piece') {
        $quantity = 1;
    }
    // Check if fname already exists
    $query = "SELECT count(*) as allcount FROM food_items WHERE fname='" . $fname . "'";
    $result = mysqli_query($con, $query);
    $row = mysqli_fetch_array($result);
    $allcount = $row['allcount'];
    // insert
    if (empty($error_array) && $allcount == 0) {
        $query = mysqli_query($con, "INSERT INTO food_items VALUES ('', '$fname', '$fat', '$carbs', '$protein', '$kcals', '$price', '$list', '$quantity')");
    }
}
?>


<!doctype html>

<html lang="en">

<head>

    <meta charset="utf-8">
    <title>Diet Tracker</title>

    
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
    
    <link href="https://fonts.googleapis.com/css?family=Open+Sans|Stylish&display=swap" rel="stylesheet">
    
    
        <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="styles.css">
        <script src="https://kit.fontawesome.com/ad07c4a8ed.js"></script>
        <link href="https://fonts.googleapis.com/icon?family=Material+Icons"
      rel="stylesheet">
      <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.8.0/Chart.min.js"></script>
      <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.14.1/moment.min.js"></script>
</head>

<body>

    <nav class="myNavbar">
        <img class="navbarImage" src="diet.png" width=23px height=23px>
        <div class="navbar-brand">Diet Tracker</div>
        <a href='' onclick="document.location.reload(true);"><i class="fas fa-redo-alt refresh"></i></a>
       
       <div class="navbar-minimize-maximize">
     
       <a href='javascript:void(0)' onclick="document.exitFullscreen();"><i class="far fa-window-minimize navbar-icon-right"></i></a>   
       <a href='javascript:void(0)'><i class="fas fa-window-maximize navbar-icon-right fullscreenOn"></i></a>
</div>

    </nav>


 
    <!-- modals -->

    <div id="modalOne" class="_modal hidden">
        <div class="modal_box_one">
        <div id="createFoodItem">
                <form id="foodForm" action="index.php" method="POST">
                    <div class="form-group">

                        <table style="width:100%">
                            <tr>
                                <td>name</td>
                                <td><input id="fname" name="reg_fname" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>fat</td>
                                <td><input id="fat" name="reg_fat" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td>grams</td>
                            </tr>
                            <tr>
                                <td>carbs</td>
                                <td><input id="carbs" name="reg_carbs" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td>grams</td>
                            </tr>
                            <tr>
                                <td>protein</td>
                                <td><input id="protein" name="reg_protein" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td>grams</td>
                            </tr>
                            <tr>
                                <td>kcals</td>
                                <td><input id="kcals" name="reg_kcals" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>price: €</td>
                                <td><input id="price" name="reg_price" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td></td>
                            </tr>

                        </table>

                        list per:<br>
                        100 grams <input type="radio" name="radio" value="grams"><br>
                        piece <input type="radio" name="radio" value="piece">
                    </div>
                    <button class="btn btn-secondary" onClick="cancel()">Cancel</button>
                    <button type="submit" name="create_button" value="Create" class="btn btn-secondary">Create</button>
                </form>
            </div>
        </div>
    </div>
    <div id="modalTwo" class="_modal hidden">
        <div class="modal_box_two">
            <p>Are you sure you want to delete this food item?</p>
            <button class="btn btn-secondary" onClick="cancel2()">Cancel</button>
            <button class="btn btn-secondary delete-this2">Delete</button>
</div>
</div>
<div id="modalThree" class="_modal hidden">
        <div class="modal_box_one">
        <div id="createFoodItem">
                <div id="foodForm">
                    <div class="form-group">
                        <table style="width:100%">
                            <tr>
                                <td>name</td>
                                <td><input id="editFname" name="reg_edit_fname" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>fat</td>
                                <td><input id="editFat" name="reg_edit_fat" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td>grams</td>
                            </tr>
                            <tr>
                                <td>carbs</td>
                                <td><input id="editCarbs" name="reg_edit_carbs" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td>grams</td>
                            </tr>
                            <tr>
                                <td>protein</td>
                                <td><input id="editProtein" name="reg_edit_protein" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td>grams</td>
                            </tr>
                            <tr>
                                <td>kcals</td>
                                <td><input id="editKcals" name="reg_edit_kcals" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td></td>
                            </tr>
                            <tr>
                                <td>price: €</td>
                                <td><input id="editPrice" name="reg_edit_price" type="text" class="form-control form-control-sm formFoodItem" required></td>
                                <td></td>
                            </tr>
                        </table>
                        list per:<br>
                        100 grams <input type="radio" name="radioEdit" value="grams" class="radioButtonEdit"><br>
                        piece <input type="radio" name="radioEdit" value="piece" class="radioButtonEdit">
                    </div>
                    <button class="btn btn-secondary" onClick="cancel3()">Cancel</button>
                    <button class="btn btn-secondary update-this">Update</button>
</div>
            </div>
        </div>
    </div>
    <!-- -->
    <div class="grid-container">
        <div class="grid-item grid-item-left">
            
            <h5 class="headerLeftRight">Food Items</h5>
            <hr>
            <table class="foodlist-table2" style='width:100%'>
            <tr>
    <th id="tableFood" style='width:33%'>Food</th>
    <th id="tableDrinks" style='width:33%'>Drinks</th>
    <th id="tableJunk" style='width:33%'>Junk</th>
  </tr>
</table>   
            
            <div id="test" class="foodList">
            <table class="foodlist-table" style='width:100%'>
                   
                    <?php
                    $sql = "SELECT id, fname from food_items";
                    $result = $con->query($sql);
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='food-list-tr'>";
                            echo "<td width:75% height=30 class='td-left' rel='".$row['id']."'>{$row['fname']}</td> ";
                            echo "<td style='width:10%' class='td-center' data-toggle='tooltip' data-placement='top' title='Delete'><a rel='".$row['id']."' class='delete-this icon-on-hover'  href='javascript:void(0)'><i class='material-icons'>delete_outline</i></a></td>";
                            echo "<td style='width:10%' class='td-center' data-toggle='tooltip' data-placement='top' title='Edit'><a rel='".$row['id']."' class='edit-this icon-on-hover' href='javascript:void(0)'><i class='material-icons'>edit</i></a></td>";
                            echo "<td style='width:5%' class='td-right' data-toggle='tooltip' data-placement='top' title='Add'><a rel='".$row['id']."' class='add-this' icon-on-hover  href='javascript:void(0)'><i class='material-icons addCircle'>add_circle_outline</i></a></td>";
                            echo "</tr>";
                            
                        }
                    }
                  
                  
                    ?>
            </table>
          
            </div>
            <button class="btn btn-secondary new-food-item" onClick="createFoodItem()">New Food Item</button>
        </div>
        <div class="grid-item">
        <div class="headerDate"><form action="index.php" method="post"><button type="submit" name="datePrevious" value="GO" class="btn buttonPreviousDate"><i class="fa fa-angle-left "></i></button></form><h5 id="date"><?php echo $date;?></h5><form action="index.php" method="post"><button type="submit" name="dateNext" value="GO" class="btn buttonNextDate"><i class="fa fa-angle-right "></i></button></form></div>    
            <hr>
            

            <div id="listToday"></div>
            <table id="mainTable" class="mainTable" style="width:100%">
  <tr>
    <th id="tableFoodItem" style='width:39%'>Food Item</th>
    <th id="tableFat" style='width:11%'>Fat</th>
    <th id="tableCarbs" style='width:11%'>Carbs</th>
    <th id="tableProtein" style='width:11%'>Protein</th>
    <th id="tableCosts" style='width:11%'>Costs</th>
    <th id="tableKcals" style='width:11%'>Kcals</th>
  </tr>
                </table>
                <table id="mainTable2"class="mainTable2">
  <?php
                    $sql = "SELECT id, fname, fat, carbs, protein, price, kcals, list, quantity from food_items_date WHERE thisdate = $dateCheck";
                    $result = $con->query($sql);
                    
                    if ($result->num_rows > 0) {
                        while ($row = $result->fetch_assoc()) {
                            echo "<tr class='mainTable2-tr'>";
                          
                        if ($row['list'] == 'grams') {
                            echo "<td style='width:39%' class='mainTableFirstColumn'>{$row['fname']}<input id='".$row['id']."' class='form-control form-control-sm inputQuantity' value='{$row['quantity']}' rel='".$row['id']."'>gr<a rel='".$row['id']."' 
                            class='remove-from-daily-list icon-on-hover remove-this'  href='javascript:void(0)'><i class='far fa-minus-square'></i></a></td>";
                          
                            $fatAdjusted = number_format($row['fat'] / 100 * $row['quantity'], 1, '.', '');
                            $carbsAdjusted = number_format($row['carbs'] / 100 * $row['quantity'], 1, '.', '');
                            $proteinAdjusted = number_format($row['protein'] / 100 * $row['quantity'], 1, '.', '');
                            $priceAdjusted = number_format($row['price'] / 100 * $row['quantity'], 2, '.', '');
                            $kcalsAdjusted = number_format($row['kcals'] / 100 * $row['quantity'], 0, '.', '');
    
                                echo "<td style='width:11%' class='mainTableColumns'>{$fatAdjusted}</td>";
                                echo "<td style='width:11%' class='mainTableColumns'>{$carbsAdjusted}</td>";
                                echo "<td style='width:11%' class='mainTableColumns'>{$proteinAdjusted}</td>";
                                echo "<td style='width:11%' class='mainTableColumns'>{$priceAdjusted}</td>";
                                echo "<td style='width:11%' class='mainTableColumnKcal'>{$kcalsAdjusted}</td>";
                                echo "</tr>";   
                        }
                        if ($row['list'] == 'piece') {
                            echo "<td style='width:39%' class='mainTableFirstColumn'>{$row['fname']}<input id='".$row['id']."' class='form-control form-control-sm inputQuantity piece' value='{$row['quantity']}' rel='".$row['id']."'>stuks<a rel='".$row['id']."' 
                            class='remove-from-daily-list icon-on-hover remove-this'  href='javascript:void(0)'><i class='far fa-minus-square'></i></a></td>";
                            
                          
                          
                        
                        $fatAdjusted = number_format($row['fat'] * $row['quantity'], 1, '.', '');
                        $carbsAdjusted = number_format($row['carbs'] * $row['quantity'], 1, '.', '');
                        $proteinAdjusted = number_format($row['protein'] * $row['quantity'], 1, '.', '');
                        $priceAdjusted = number_format($row['price'] * $row['quantity'], 2, '.', '');
                        $kcalsAdjusted = number_format($row['kcals'] * $row['quantity'], 0, '.', '');
                            echo "<td style='width:11%' class='mainTableColumns'>{$fatAdjusted}</td>";
                            echo "<td style='width:11%' class='mainTableColumns'>{$carbsAdjusted}</td>";
                            echo "<td style='width:11%' class='mainTableColumns'>{$proteinAdjusted}</td>";
                            echo "<td style='width:11%' class='mainTableColumns'>{$priceAdjusted}</td>";
                            echo "<td style='width:11%' class='mainTableColumnKcal'>{$kcalsAdjusted}</td>";
                            echo "</tr>";          
                        }
                    }
                    }
                    $con->close();
                  
                    ?>
</table>



<div class="inputWeight" style='width:100%'>
<div class="inputFields">
Morning: <input type="text" id="morningWeight" class="form-control form-control-sm inputFieldWeight" style='width:50px'> kg
&emsp;&emsp;Evening: <input type="text" id="eveningWeight" class="form-control form-control-sm inputFieldWeight" style='width:50px'> kg
                </div>
<button id="buttonLock" class="btn btn-secondary buttonSubmit">Submit Weight</button> 
<div id="lockStatusHtml" ></div>
<div class="btn btn-secondary buttonLockUnlock"><i id="buttonLockUnlock"class="fas fa-unlock"></i></div> 

                </div>
        </div>
        <div class="grid-item-right">
        <div class="grid-item-right-sub-one">
            <h5 class="headerLeftRight">Totals</h5>
            <hr>


            <table class="totalsTable" style='width:100%'>
            <tr>
    <th id="totalCosts" class="totalsHead" style='width:50%'></th>
    <th id="totalKcals" class="totalsHead" style='width:50%'></th>
  </tr>
</table> 


            <div id="chartWrapper">
                <canvas id="chart"></canvas>
                </div>
        </div>
                
                <div class="grid-item-right-sub-two">
                <h5 class="headerStatistics">Statistics<i class="fas fa-expand"></i></h5>
            <hr>
            <table class="foodlist-table2" style='width:100%'>
            <tr>
    <th id="tableKcalsGraph" style='width:33%'>Kcals</th>
    <th id="tableWeightGraph" style='width:33%'>Weight</th>
    <th id="tableCostsGraph" style='width:33%'>Costs</th>
  </tr>
</table>  
<div id="chartWrapperTwo" style="height: 195px">
<canvas id="chartTwo" class="hidden"></canvas>
<canvas id="chartThree" class="hidden"></canvas>
<canvas id="chartFour"></canvas>
                </div>
                </div>
                </div>
    </div>
    
 
    <script>



$(document).ready(function(){
    
    updateChart();
    
    $(function () {
  $('[data-toggle="tooltip"]').tooltip()
})
var id;
var deletethis = 'delete';
var editthis = 'edit';
var updatethis = 'update';
var addthis = 'add';
var setthisquantity = 'setthisquantity';
var removethis = 'removethis';
var weightthis = 'weightthis';

$(".delete-this").on('click', function(){
document.getElementById("modalTwo").classList.remove('hidden');
id = $(this).attr('rel');
});
$(".delete-this2").on('click', function(){
    document.getElementById("modalTwo").classList.add('hidden');
    $.post("delete.php", {id: id, deletethis: deletethis}, function(data){
    
});
$("a[rel=" + id + "]").parents('tr').remove();
});  
$(".edit-this").on('click', function(){
    document.getElementById("modalThree").classList.remove('hidden');
    id = $(this).attr('rel');
   
    $.post("edit.php", {id: id, editthis: editthis}, function(data){
        
        var formData = JSON.parse(data);
        
        document.getElementById('editFname').value = formData.fname;
        document.getElementById('editFat').value = formData.fat;
        document.getElementById('editCarbs').value = formData.carbs;
        document.getElementById('editProtein').value = formData.protein;
        document.getElementById('editKcals').value = formData.kcals;
        document.getElementById('editPrice').value = formData.price;
       
        
        if (formData.list == 'grams') {
            $('.radioButtonEdit:first').attr('checked', true);
        }
        if (formData.list == 'piece') {
            $('.radioButtonEdit:last').attr('checked', true);
        }
      
});
});
   
$(".update-this").on('click', function(){
    document.getElementById("modalThree").classList.add('hidden');
    
var edit_fname = document.getElementById('editFname').value; 
var edit_fat = document.getElementById('editFat').value;
var edit_carbs = document.getElementById('editCarbs').value;
var edit_protein = document.getElementById('editProtein').value;
var edit_kcals = document.getElementById('editKcals').value;
var edit_price = document.getElementById('editPrice').value;
if  ($('.radioButtonEdit:first').is(":checked")) {
    var edit_list = 'grams';
    var edit_quantity = 100;
}
else  {
    var edit_list = 'piece';
    var edit_quantity = 1;
};
    $.post("update.php", {id: id, edit_fname: edit_fname, edit_fat: edit_fat, edit_carbs: edit_carbs, edit_protein: edit_protein, edit_kcals: edit_kcals, edit_price: edit_price, edit_list: edit_list, edit_quantity: edit_quantity, updatethis: updatethis}, function(data){
    });
    $(".td-left[rel=" + id + "]").html(edit_fname);
});
$(".add-this").on('click', function(){
    
    id = $(this).attr('rel');
    var dateOne = document.getElementById('date').textContent;
    var date =  dateOne;
   
    $.post("add.php", {id: id, date: date, addthis: addthis}, function(data){
        
    var returnData = JSON.parse(data);
    
    var fat = parseFloat(returnData.fat).toFixed(1);
    var carbs = parseFloat(returnData.carbs).toFixed(1);
    var protein = parseFloat(returnData.protein).toFixed(1);
    var price = parseFloat(returnData.price).toFixed(2);
    var kcals = parseFloat(returnData.kcals).toFixed(0);
    
                                          
if (returnData.list == 'grams') {
        $(".mainTable2").append( "<tr><td style='width:39%' class='mainTableFirstColumn'>" + returnData.fname + "<input id='" + returnData.id + "' class='form-control form-control-sm inputQuantity' value='" + returnData.quantity + "' rel='" +  returnData.id + "'>gr<a rel='" +  returnData.id + "'class='remove-from-daily-list icon-on-hover remove-this'  href='javascript:void(0)'><i class='far fa-minus-square'></i></a></td><td style='width:11%' class='mainTableColumns'>" + fat + "</td><td style='width:11%' class='mainTableColumns'>" + carbs + "</td><td style='width:11%' class='mainTableColumns'>" + protein + "</td><td style='width:11%' class='mainTableColumns'>" + price + "</td><td style='width:11%' class='mainTableColumnKcal'>" + kcals + "</td></tr>" );
}
else {
    
         $(".mainTable2").append( "<tr><td style='width:39%' class='mainTableFirstColumn'>" + returnData.fname + "<input id='" + returnData.id + "' class='form-control form-control-sm inputQuantity piece' value='" + returnData.quantity + "' rel='" +  returnData.id + "'>stuks<a rel='" +  returnData.id + "'class='remove-from-daily-list icon-on-hover remove-this'  href='javascript:void(0)'><i class='far fa-minus-square'></i></a></td><td style='width:11%' class='mainTableColumns'>" + fat + "</td><td style='width:11%' class='mainTableColumns'>" + carbs + "</td><td style='width:11%' class='mainTableColumns'>" + protein + "</td><td style='width:11%' class='mainTableColumns'>" + price + "</td><td style='width:11%' class='mainTableColumnKcal'>" + kcals + "</td></tr>" );
}
        for (var i = 1; i < table.rows.length; i++) {
    totalFat = totalFat + parseInt(table.rows[i].cells[1].innerHTML);
    totalCarbs = totalCarbs + parseInt(table.rows[i].cells[2].innerHTML);
    totalProtein = totalProtein + parseInt(table.rows[i].cells[3].innerHTML);
    totalCosts = totalCosts + parseInt(table.rows[i].cells[4].innerHTML);
    totalKcals = totalKcals + parseInt(table.rows[i].cells[5].innerHTML);
}
     updateChart();
});
});
$("body").on('keyup', '.inputQuantity', function(){
  
    id = $(this).attr('rel');    
    var edit_quantity = document.getElementById(id).value; 
    $.post("setquantity.php", {id: id, edit_quantity: edit_quantity, setthisquantity: setthisquantity}, function(data){
        var returnData = JSON.parse(data);
     
if (returnData.list == 'grams') {
var fat = returnData.fat / 100 * returnData.quantity;
var carbs = returnData.carbs / 100 * returnData.quantity;
var protein = returnData.protein / 100 * returnData.quantity;
var price = returnData.price / 100 * returnData.quantity;
var kcals = returnData.kcals / 100 * returnData.quantity;
    var newTableRow =  "<tr><td style='width:39%' class='mainTableFirstColumn'>" + returnData.fname + "<input id='" + returnData.id + "' class='form-control form-control-sm inputQuantity' value='" + returnData.quantity + "' rel='" +  returnData.id + "'>gr<a rel='" +  returnData.id + "'class='remove-from-daily-list icon-on-hover remove-this'  href='javascript:void(0)'><i class='far fa-minus-square'></i></a></td><td style='width:12%'  class='mainTableColumns'>" + fat.toFixed(1) + "</td><td style='width:11%'  class='mainTableColumns'>" + carbs.toFixed(1) + "</td><td style='width:11%'  class='mainTableColumns'>" + protein.toFixed(1) + "</td><td style='width:11%'  class='mainTableColumns'>" + price.toFixed(2) + "</td><td style='width:11%' class='mainTableColumnKcal'>" + kcals.toFixed(0) + "</td></tr>";
    $('#'+ id).parent().parent().replaceWith(newTableRow);
}
else {
var fat = returnData.fat * returnData.quantity;
var carbs = returnData.carbs * returnData.quantity;
var protein = returnData.protein * returnData.quantity;
var price = returnData.price  * returnData.quantity;
var kcals = returnData.kcals * returnData.quantity;
    var newTableRow =  "<tr><td style='width:39%' class='mainTableFirstColumn'>" + returnData.fname + "<input id='" + returnData.id + "' class='form-control form-control-sm inputQuantity piece' value='" + returnData.quantity + "' rel='" +  returnData.id + "'>stuks<a rel='" +  returnData.id + "'class='remove-from-daily-list icon-on-hover remove-this'  href='javascript:void(0)'><i class='far fa-minus-square'></i></a></td><td style='width:12%'  class='mainTableColumns'>" + fat.toFixed(1) + "</td><td style='width:11%'  class='mainTableColumns'>" + carbs.toFixed(1) + "</td><td style='width:11%'  class='mainTableColumns'>" + protein.toFixed(1) + "</td><td style='width:11%'  class='mainTableColumns'>" + price.toFixed(2) + "</td><td style='width:11%' class='mainTableColumnKcal'>" + kcals.toFixed(0) + "</td></tr>";
    $('#'+ id).parent().parent().replaceWith(newTableRow);
}
for (var i = 1; i < table.rows.length; i++) {
    totalFat = totalFat + parseInt(table.rows[i].cells[1].innerHTML);
    totalCarbs = totalCarbs + parseInt(table.rows[i].cells[2].innerHTML);
    totalProtein = totalProtein + parseInt(table.rows[i].cells[3].innerHTML);
    totalCosts = totalCosts + parseInt(table.rows[i].cells[4].innerHTML);
    totalKcals = totalKcals + parseInt(table.rows[i].cells[5].innerHTML);
}
        updateChart();
});
});
$("body").on('click', '.remove-this', function(){
    id = $(this).attr('rel');
    $.post("remove.php", {id: id, removethis: removethis}, function(data){
    
});
$("a[rel=" + id + "]").parents('tr').remove();
        updateChart();
});  
$(".fullscreenOn").on('click', function() {
var el = document.documentElement,
    rfs = // for newer Webkit and Firefox
    el.requestFullScreen ||
    el.webkitRequestFullScreen ||
    el.mozRequestFullScreen ||
    el.msRequestFullScreen;
if (typeof rfs != "undefined" && rfs) {
    rfs.call(el);
} else if (typeof window.ActiveXObject != "undefined") {
    // for Internet Explorer
    var wscript = new ActiveXObject("WScript.Shell");
    if (wscript != null) {
        wscript.SendKeys("{F11}");
    }
}
    updateChart();
});





var dateCounterJs = "<?php echo $_SESSION['date_counter2']; ?>";
var dateCode = "<?php echo $dateCode ?>";
console.log(dateCounterJs);

    $(document).ready(function() { 

        if (dateCounterJs != 0) {

    $(".buttonLockUnlock").css({'background-color': '#F06268',});
    document.getElementById("buttonLock").disabled = true;
    $(".td-right").tooltip('disable');
    $(".addCircle").hide();
    $(".remove-this").hide();
    $("#buttonLockUnlock").removeClass('fas fa-unlock').addClass('fas fa-lock');
        } 
         
});



$(".buttonLockUnlock").on('click', function(){
  

    $(".buttonLockUnlock").css({'background-color': '#14DB4D',});
    document.getElementById("buttonLock").disabled = false;
    $(".td-right").tooltip('enable');
    
    $(".addCircle").show();
    $(".remove-this").show();

    $(this).find('i').removeClass('fas fa-lock').addClass('fas fa-unlock');

});



$("#buttonLock").on('click', function(){
     
    var dateOne = document.getElementById('date').textContent;
    var date =  dateOne;

    var morningWeight = document.getElementById('morningWeight').value;
    var eveningWeight = document.getElementById('eveningWeight').value;

    console.log(date);
    console.log(morningWeight);
    console.log(eveningWeight);
   
   
   $.post("weight.php", {date: date, morningWeight: morningWeight, eveningWeight: eveningWeight, weightthis: weightthis}, function(){
           
});
});

});

</script>

<script type="text/javascript" src="javascript.js"></script>

</body>

</html>