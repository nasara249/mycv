
<html>

<head>
    <title>XML Upload</title>
    <meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1">
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="font-awesome/css/font-awesome.css" rel="stylesheet">

</head>

<body style="background:url('bg.jpg') no-repeat fixed;background-size: cover;">
    <div class="container" style="margin: 40px auto;">
        <div class="jumbotron" style="opacity:0.5">
            <h3>XML FILE MANIPULATION</h3>
            <h5>Using Simple Core PHP, Bootstrap Theme and Ajax</h5>
        </div>
    <div class="row">
        <div class="col-lg-6 col-sm-12 col-md-12 p-lg">
            <form class="form" name="frm" role="form" id="frm" method="post">
                <div class="form-group">
                    <input type="text" name="name" id="name" class="form-control" placeholder="Name" autofocus>
                </div><div class="form-group">
                    <input type="text" name="mob" id="mob" class="form-control" placeholder="Mobile">
                </div><div class="form-group">
                    <input type="text" name="dept" id="dept" class="form-control" placeholder="Department">
                </div><div class="form-group">
                    <input type="text" name="mail" id="mail" class="form-control" placeholder="E-Mail">
                </div>
                <input type="submit" name="valid" id="submit" class="btn btn-info pull-right" value="Add to XML File">
            </form>
            <div class="clearfix"></div>
            <form class="form" name="update_frm" role="form" id="update_frm" method="post">
                <div class="form-group">
                    <input type="text" name="name2" id="name2" class="form-control" placeholder="Name" autofocus>
                </div><div class="form-group">
                    <input type="text" name="dept2" id="dept2" class="form-control" placeholder="Department">
                </div><div class="form-group">
                    <input type="text" name="mail2" id="mail2" class="form-control" placeholder="E-Mail">
                </div>
                <input type="submit" name="update" id="update" data-val='' class="btn btn-info pull-right" value="Update Data">
            </form>
            <div class="clearfix"></div>

        </div>
        <div class="col-lg-6 col-sm-12 col-md-12">
            <div class="row" id="show_data">

            </div>

        </div>
    </div>
    </div>
        
    <script src="js/jquery-3.1.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/jquery.validate.min.js" type="text/javascript"></script>
    <script>
        $(document).ready(function(){
            $('#update_frm').hide();
            $.validator.setDefaults({
                debug:true,
                success:"valid"
            });
            $('#submit').click(function(){
                $('#frm').validate({
                    success:"valid",
                    errorElement:"h5",
                    errorClass:"text-danger",
                    highlight:function(element,errorClass,validClass){
                        $(element).parent('div.form-group').addClass('has-error');
                        $(element.form).find("h5[for="+element.id+"]").addClass(errorClass);
                    },
                    unhighlight:function(element,errorClass,validClass){
                        $(element).parent('div.form-group').removeClass('has-error');
                        $(element.form).find("h5[for="+element.id+"]").removeClass(errorClass);
                    },
                    submitHandler:function(form){
                        $(form).ajaxSubmit;
                        var data = $(form).serialize();
                        $.ajax({
                            type:'post',
                            url:'add.php',
                            data:data,
                            success:function(res){
                                if(res == "already"){
                                    alert("Content Already Exsist !");
                                }else{
                                    load_xml();
                                    $('.form-control').val('');
                                }
                            },
                            error:function(){
                                alert('Error Occured !');
                            }
                        });
                    },
                    rules:{
                        name:{
                            required:true
                        },
                        mob:{
                            required:true,
                            maxlength:10,
                            minlength:10,
                            digits:true
                        },
                        mail:{
                            required:true,
                            email:true
                        },
                        dept:{
                            required:true
                        }
                        
                    }
                });
            });
            load_xml();
            function load_xml(){
                $.ajax({
                    type:'post',
                    url:"load.php",
                    dataType:'json',
                    success:function(res){
                        var out='';
                        var i;
                        for(i=1;i<res.length;i++){
                            out += "<div class='col-sm-4 text-center m-b-md' style='border-radius:10px;box-shadow: 0px 0px 10px gray;padding:5px;'>";
                            out += "<h4 class='text-danger'>"+res[i]['name'][0]+"</h4>";
                            out += "<h5 class='text-info'>"+res[i]['mobile'][0]+"</h5>";
                            out += "<span class='badge'>"+res[i]['email'][0]+"</span>";
                            out += "<h6>"+res[i]['dept'][0]+"</h6><h6>Posted@ - "+res[i]['posted'][0]+"</h6>";
                            out += "<button class='btn btn-circle btn-info edit-btn' id='"+res[i]['mobile'][0]+"'><i class='fa fa-pencil'></i></button>";
                            out += " <button class='btn btn-circle btn-danger delete-btn' id='"+res[i]['mobile'][0]+"'><i class='fa fa-trash-o'></i></button>";
                            out += "</div>";
                        }
                        $('#show_data').html(out);
                    },
                    error:function(){
                        $('#show_data').html("<h5>No Data Found !</h5>");
                    }
                });
            }
            
            $('#show_data').on('click','.edit-btn',function(){
                $.ajax({
                    type:'post',
                    url:'get_data.php?id='+$(this).attr('id'),
                    dataType:'json',
                    success:function(res){
                        $('#name2').val(res[0]['name'][0]);
                        $('#mail2').val(res[0]['email'][0]);
                        $('#dept2').val(res[0]['dept'][0]);
                        $('#update').attr('data-val',res[0]['mobile'][0]);
                        $('#frm').hide();
                        $('#update_frm').show();
                    },
                    error:function(){
                        alert("Can't reach the function");
                    }
                });
            });
            
            $('#show_data').on('click','.delete-btn',function(){
                if(confirm("Are you sure about delete this ?")){
                    $.ajax({
                        type:"post",
                        url:"delete.php",
                        data:{id:$(this).attr('id')},
                        success:function(res){
                            load_xml();
                        },error:function(){
                            alert("Some problem on finding the xml file !");
                        }
                    });
                }else{
                 alert("Data is Safe, Now !");
                }
            });
            
            $('#update').click(function(){
                $('#update_frm').validate({
                    success:"valid",
                    errorElement:"h5",
                    errorClass:"text-danger",
                    highlight:function(element,errorClass,validClass){
                        $(element).parent('div.form-group').addClass('has-error');
                        $(element.form).find("h5[for="+element.id+"]").addClass(errorClass);
                    },
                    unhighlight:function(element,errorClass,validClass){
                        $(element).parent('div.form-group').removeClass('has-error');
                        $(element.form).find("h5[for="+element.id+"]").removeClass(errorClass);
                    },
                    submitHandler:function(form){
                        $(form).ajaxSubmit;
                        var data = $(form).serialize();
                        $.ajax({
                            type:'post',
                            url:"update.php?id="+$('#update').attr('data-val'),
                            data:data,
                            success:function(res){
                                $('#name').val('').focus();
                                $('#mail').val('');
                                $('#dept').val('');
                                $('#update').attr('data-val','');
                                $('#update_frm').hide();
                                $('#frm').show();
                                load_xml();
                            },
                            error:function(){
                                alert('not worked');
                            }
                        });
                    },
                    rules:{
                        name2:{
                            required:true
                        },
                        mail2:{
                            required:true,
                            email:true
                        },
                        dept2:{
                            required:true
                        }
                        
                    }
                });
            });
            
        });
    </script>
</body>
</html>
