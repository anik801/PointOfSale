function logOut(){
	//alert("Hello");
	//$("#logOutButton").trigger('click');
	bootbox.confirm("Are you sure you want to log out?", function(result) {
		if(result){
			$("#logOutButton").trigger('click');
		}
	}); 
}

function deleteCategory(x){
	bootbox.confirm("Are you sure you want to delete this category?", function(result) {
		if(result){
			str="deleteCategory.php?x="+x;
			document.location.href=str;
		}
	});
}

function deleteType(y){
	//alert(name);
	bootbox.confirm("Are you sure you want to delete this type?", function(result) {
		if(result){
			str="deleteType.php?x="+y;
			document.location.href=str;
		}
	});
}

function deleteEmployee(z){
	bootbox.confirm("Are you sure you want to delete this employee?", function(result) {
		if(result){
			str="deleteEmployee.php?x="+z;
			document.location.href=str;
		}
	});
}

function isInt(n) {
   return n % 1 === 0;
}

function checkProductSell(quantity,currentQuantity,productId){
	//alert(quantity+" "+productId);
	if(!isInt(quantity) || quantity===""){
		alert("Plase enter a decimal number in sell quantity field.");
		x="#sq"+productId;
		$(x).val("");
	}else if(quantity>currentQuantity){
		alert("Selling quantity must be within the limits of available items.");
		x="#sq"+productId;
		$(x).val("");
	}else{
		addProduct(quantity,productId);
	}
}

function isNumeric(n) {
  return !isNaN(parseFloat(n)) && isFinite(n);
}

function checkCart(x){
	//$("#cartSubmit").trigger('click');
	var name=document.getElementById('name').value;
	var phone=document.getElementById('contact').value;
	var discount=document.getElementById('discount').value;
	var vat=document.getElementById('vat').value;
	var cash=document.getElementById('cash').value;

	x-=returnAmount;
	//alert(name);
	if(name==="" || phone===""){
		alert("Please enter a valid name and contact number.");
	}else if(!isNumeric(cash) || cash===""){
		alert("Plase enter valid number in the cash field.");
	}else if(cash<x){
		alert("Sorry, minimum amount for this bill is: "+x+" BDT.");
	}else if(!isNumeric(discount)||!isNumeric(vat)){
		alert("Plase enter valid number in discount and VAT fields.");
	}else if(discount<0 || discount>100){
		alert("Discount must be between 0 to 100.");
	}else if(vat<0 || vat>100){
		alert("VAT must be between 0 to 100.");
	}else{
		var returnId=$("#returnCashTemp").val();
		if(!isNumeric(returnId))
			returnId=0;
		url="showTempBill.php?x="+name+"&y="+phone+"&p="+discount+"&q="+vat+"&r="+cash+"&a="+returnId;
		window.location.href=url;
	}
	//alert(name);	
	/*
	var win = window.open(url, '_blank',width='600');
	win.focus();
	window.location.href="panel.php";
	*/
}
function finalizeCart(x,y,p,q,r,s,a){
	//alert(x+y);
	//printBill();
	//$("#cartSubmit").trigger('click');
	str="showTempBill.php?x="+x+"&y="+y+"&z=1&p="+p+"&q="+q+"&r="+r+"&s="+s+"&a="+a;
	window.location.href=str;
}


$(function() {
  $('#startingDate').datepicker({
    dateFormat: 'yy-mm-dd 00:00:00',
    altField: '#thealtdate',
    altFormat: 'yy-mm-dd'
    });
});

$(function() {
  $('#endingDate').datepicker({
    dateFormat: 'yy-mm-dd 23:59:59',
    altField: '#thealtdate',
    altFormat: 'yy-mm-dd'
    });
});

function checkReport(){
	//alert("Report Check Clicked");
	date1=$('#startingDate').val();
	date2=$('#endingDate').val();
	if(date1==="" || date2===""){
		alert("Please enter both dates.");
	}else if(date1>date2){
		alert("Error: Date out of range. Please check date inputs.");
	}else{
		$("#reportSubmit").trigger('click');
	}
}

function OpenInNewTab(x) {
	url="showBill.php?x="+x;
	var win = window.open(url, "_blank","top=10, left=10, width=800,height=600 scrollbars=1");
	win.focus();
}

function printBill(){
	$("#printButton").hide();
	window.print();
	$("#printButton").show();
}

function setTitle(x){
	//alert(x);
	document.getElementById("loginTitleDiv").innerHTML=x;
}

function setCategoryId(x){
	$("#categoryChangeId").val(x);
}

function setTypeId(x){
	$("#typeChangeId").val(x);
}

function checkEmployeeInput(){
	if($("#employeeName").val()==="" || $("#employeePhone").val()==="" || $("#employeeAddress").val()==="" || $("#employeeNationalId").val()==="" || $("#employeePassword").val()==="" || $("#employeeRePassword").val()===""){
		bootbox.alert("Please enter all fields correctly.", function() {		
		});
	}else if($("#employeePassword").val()!==$("#employeeRePassword").val()){
	    bootbox.alert("Passwords do not match!", function() {		
		});
	}else if($("#employeePassword").val()==="" && $("#employeeRePassword").val()===""){
	    $("#submit").trigger('click');
	}else{
	    var value = document.getElementById('employeePassword').value;
	    var len=value.length;	    	
	    if(len<8){
	    	bootbox.alert("Please enter a password of atleast 8 digits/letters", function() {		
			});
	    }else{
	    	$("#employeeSubmit").trigger('click');
	    }
	}

}

function checkEmployeeChangeInput(){
	$("#employeeChangeId").val(x);
	$("#employeeChangeSubmit").trigger('click');
}

function enableItem(x){
	alert('x');
}

function passwordEditCheck(){
	if($("#newPassword").val()!==$("#newRePassword").val()){
	    bootbox.alert("Passwords do not match!", function() {		
		});
	}else{
		var value = document.getElementById('newPassword').value;
	    var len=value.length;	    	
	    if(len<8){
	    	bootbox.alert("Password must be at least 8 digits/letters long.", function() {		
			});
	    }else{
	    	$("#passwordChangeSubmit").trigger('click');
	    }
	}
}


function deleteStock(x){
	bootbox.confirm("WARNING: This will delete this entire stock, not only this product. If you want to delete a rpoduct only, you can go to the <a href='products.php'>PRODUCTS</a> page.<br><br>Are you sure you want to delete this stock?", function(result) {
		if(result){
			str="deleteStock.php?x="+x;
			document.location.href=str;
		}
	});
}

function deleteProduct(x){
	bootbox.confirm("Are you sure you want to delete this product?", function(result) {
		if(result){
			str="deleteProduct.php?x="+x;
			document.location.href=str;
		}
	});
}

function checkReturn(invoiceId,productId){
	//alert("Check return called");
	x="#returnSelect"+productId;	
	var quantity= $(x).val();
	//alert(quantity);
	if(quantity==='0'){
		alert("Error: check quantity value.");
	}else if(confirm("Are you sure you want to return this product?")){
		str="returnSubmit.php?x="+invoiceId+"&y="+productId+"&z="+quantity;
		document.location.href=str;
	}

}

function returnSelect(x){
	//alert(x);
	if(x==='0'){
		$("#returnIdDiv").hide();
		returnAmount=document.getElementById('temp').value;
		document.getElementById('cash').placeholder="Enter the amount of cash given by the customer. Minimum: "+returnAmount;

	}else{
		$("#returnIdDiv").show();
	}
}

returnAmount=0;
function changeMinimum(){	
	var id = document.getElementById('returnId').value;
	showReturnCash(id);
}