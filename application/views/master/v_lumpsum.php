<?php

?>
<div class="container" data-role="main" class="ui-content">
    <h3>Master Data Lump Sum</h3>
    <div class="row col-md-5">
        <button class="btn btn-primary" onclick="add()"> <span>Tambah Data</span></button>
        <button class="btn btn-info" onclick="reload_table()"> <span>Refresh Halaman</span></button><br><br> 
    </div>
</div>

<!-- Bootstrap modal For Datatable-->
<div class="modal fade" id="md-form" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h3 class="modal-title">Data Agent</h3>
            </div>
            <div class="modal-body form">
                <div class="form-group">
                    <form id="frm-modal" action="#" enctype="multipart/form-data">
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">No Perjanjian</label>
                                    <input hidden id="idm" name="idm">
                                    <input class="form-control" type="text" name="no_perjanjian" id="no_perjanjian" required>                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Perihal</label>
                                    <input class="form-control" type="text" name="nama_perjanjian" id="nama_perjanjian" required>                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Nama Tenant</label>
                                    <select class="form-control" name="tenant" id="tenant" onchange="showTenant(this.value)">
                                        <option value="">-----</option>
                                    </select>
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Penanggung Jawab</label>
                                    <input class="form-control" disabled type="text" name="penanggung_jawab" id="penanggung_jawab">                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Lokasi Tenant</label>
                                    <input class="form-control" disabled type="text" name="lokasi" id="lokasi">                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Waktu Kadaluarsa</label>
                                    <div class='input-group date' id='datetimepicker2'>
                                        <input type='text' class="form-control" name="waktu_kadaluarsa" id="waktu_kadaluarsa"/>
                                        <span class="input-group-addon">
                                                <span class="glyphicon glyphicon-calendar"></span>
                                        </span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="agent_name" class="form-label">Nominal</label>
                                    <input class="form-control" type="text" name="nominal" id="nominal">                                    
                                    <span class="help-block"></span>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="modal-footer bg-warning" >
                <div class="row">
                    <div class="col-md-12">
                        <button onclick='save()' id='btnSave' type='button' class='btn btn-primary' >Save</button>
                        <button onclick='batal()' type='button' class='btn btn-danger' >Cancel</button>
                    </div>
                </div>
			</div>				
        </div>
    </div><!-- /.modal-content -->
</div><!-- /.modal-dialog -->
<!-- End Bootstrap modal -->

<div class="container">
    <div class="row col-md-12">
        <table id="table" class="table table-striped table-bordered" cellspacing="0" width="70%">
            <thead>
            <tr>
                <th>
                    <center>No
                </th>
                <th>
                    <center>No Perjanjian
                </th>
                <th>
                    <center>Perihal
                </th>
                <th>
                    <center>Waktu Kadaluarsa
                </th>
                <th>
                    <center>Nominal
                </th>
                <th>
                    <center>Nama Tenant
                </th>
                <th>
                    <center>Aksi
                </th>
            </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
            <tr>
                <th>
                    <center>No
                </th>
                <th>
                    <center>No Perjanjian
                </th>
                <th>
                    <center>Perihal
                </th>
                <th>
                    <center>Waktu Kadaluarsa
                </th>
                <th>
                    <center>Nominal
                </th>
                <th>
                    <center>Nama Tenant
                </th>
                <th>
                    <center>Aksi
                </th>
            </tr>
            </tfoot>
        </table>
    </div>
</div>

<script type="text/javascript">
    var table;

    $(function () {
        $('#datetimepicker2').datepicker({
            format: "yyyy-mm-dd",
            autoclose: true,
            todayHighlight: true
        });
    });

    $(document).ready(function() {
        //datatables
        table = $('#table').DataTable({
            "processing": true, //Feature control the processing indicator.
            "serverSide": true, //Feature control DataTables' server-side processing mode.
            "order": [], //Initial no order.

            // Load data for the table's content from an Ajax source
            "ajax": {
                "url": "<?php echo site_url('master/ajax_data_lumpsum')?>",
                "type": "POST"
            },

            //Set column definition initialisation properties.
            "columnDefs": [
                {
                    "targets": [ 0 ], //first column / numbering column
                    "orderable": false, //set not orderable
                },
            ],
        });

        $.ajax({
            url:'<?php echo site_url('master/populateLumpsum')?>',
            type:'POST',
            dataType: 'json',
            success: function( json ) {
                $.each(json, function(i, value) {
                    $('#tenant').append($('<option>').text(value.nama_tenant).attr('value', value.id_tenant));
                });
            }
        });        
    });

    function reload_table() {
        table.ajax.reload(null,false);
    }

    function edit(id){
        save_method = 'update';
        $('#frm-modal')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#btnSave').text('Update');
        $('.select2').select2({
        });

        //Ajax Load data from ajax
        $.ajax({
            url : "<?php echo site_url('master/editLumpsum/')?>" + id,
            type: "GET",
            dataType: "JSON",
            success: function(data)
            {		
                $('#md-form').modal('show'); // show bootstrap modal when complete loaded
                $('.modal-title').text('Edit Data Lumpsum'); // Set title to Bootstrap modal title

                $('#idm').val(data.id_lumpsum);
                $('#no_perjanjian').val(data.no_perjanjian);
                $('#nama_perjanjian').val(data.perihal);
                $('#tenant').val(data.id_tenant).change();
                $('#waktu_kadaluarsa').val(data.waktu_kadaluarsa);
                $('#nominal').val(data.nominal);
            },
            error: function (jqXHR, textStatus, errorThrown)
            {
                alert('Error get data from ajax');
            }
        });
    }

    function save(){    
        var url;

        if(save_method == 'add') {
            $('#btnSave').text('Saving...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable
            url = "<?php echo site_url('master/input_data_lumpsum');?>"; 
        } else {
            $('#btnSave').text('Updating...'); //change button text
            $('#btnSave').attr('disabled',true); //set button disable 
            url = "<?php echo site_url('master/edit_lumpsum');?>"; 
        }

        formData = new FormData($('#frm-modal')[0]);
        formData.append( 'save_method', save_method );

        // ajax adding data to database
        $.ajax({
            url : url,
            type: "POST",
            data: formData,
            async: false,
            contentType: false,
            processData: false,
            dataType: "JSON",
            success: function(data){
                //if success close modal and reload ajax table
                if(data.status){
                    reload_table();
                    $('#frm-modal')[0].reset();
                }
                else{
                    for (var i = 0; i < data.inputerror.length; i++) {
                        $('[name="'+data.inputerror[i]+'"]').parent().parent().addClass('has-error'); //select parent twice to select div form-group class and add has-error class
                        $('[name="'+data.inputerror[i]+'"]').next().text(data.error_string[i]); //select span help-block class set text error string
                    }
                    $('#btnSave').attr('disabled',false); //set button enable 
                }

                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
                $('#md-form').modal('hide');
            },
            error: function (jqXHR, textStatus, errorThrown){
                alert('Error adding data');
                $('#btnSave').text('Save'); //change button text
                $('#btnSave').attr('disabled',false); //set button enable 
            }
        });
    }

    function add(){
        save_method = 'add';
        $('#frm-modal')[0].reset(); // reset form on modals
        $('.form-group').removeClass('has-error'); // clear error class
        $('.help-block').empty(); // clear error string
        $('#btnSave').text('Save');
        $('.select2').select2({
        });
        $('#md-form').modal('show'); // show bootstrap modal when complete loaded
        $('.modal-title').text('Tambah Data Lumpsum'); // Set title to Bootstrap modal title
    }

    function batal(){
        $('#frm-modal')[0].reset();
        $('#btnSave').text('Save'); //change button text
        $('#btnSave').attr('class','btn btn-primary'); //set button disable 
        $('#md-form').modal('hide');
    }

    $('.modal').on('hidden.bs.modal', function () {
        reload_table();
    });

    function showTenant(str) {
        if (str=="") {
            document.getElementById("penanggung_jawab").innerHTML="";
            document.getElementById("lokasi").innerHTML="";
            return;
        }
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp=new XMLHttpRequest();
        } else { // code for IE6, IE5
            xmlhttp=new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange=function() {
            if (this.readyState==4 && this.status==200) {
                var data = JSON.parse(this.responseText);
                document.getElementById("penanggung_jawab").value= data.penanggung_jawab;
                document.getElementById("lokasi").value=data.lokasi;
            }
        }
        xmlhttp.open("GET","<?php echo base_url('master/cari_tenant/')?>"+str,true);
        xmlhttp.send();
    }

</script>