@extends('layouts')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Produser List</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addProduser()">Add</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="laravel_crud" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>International</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($produser as $rows)
                        <tr id="row_{{ $rows->id }}">
                            <td>{{ $rows->kd_produser }}</td>
                            <td>{{ $rows->nm_produser }}</td>
                            <td>{{ $rows->international }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" onclick="editProduser(event.target)" class="btn btn-info">Edit</a>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" class="btn btn-danger" onclick="deleteProduser(event.target)">Delete</a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
<div class="modal fade" id="post-modal" aria-hidden="true">
    <div class="modal-dialog">
      <div class="modal-content">
          <div class="modal-header">
              <h4 class="modal-title"></h4>
          </div>
          <div class="modal-body">
            <form name="userForm" class="form-horizontal">
                <input type="hidden" name="idx" id="idx">
                <div class="form-group">
                    <label class="col-sm-2">Nama</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="nm_produser" id="nm_produser">
                        <span id="nm_produserError" class="alert-message"></span>
                    </div>
                    <div class="col-sm-12">
                        <label class="col-sm-2">International</label>
                        <select name="international" id="international" class="form-control">
                            <option value="YA"> YA</option>
                            <option value="TIDAK"> Tidak</option>
                        </select>
                        <span id="internationalError" class="alert-message"></span>
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="createGenre()">Save</button>
          </div>
      </div>
    </div>
  </div>
@endsection
@section('scripts')
<script>
    $('#laravel_crud').DataTable();
  
    function addProduser() {
        $("#idx").val('');
        $('#post-modal').modal('show');
    }
  
    function editProduser(event) {
        var id  = $(event).data("id");
        let _url = `/produser/${id}`;
        $('#nm_produserError').text('');
        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    $("#idx").val(response.id);
                    $("#nm_genre").val(response.nm_genre);
                    $("#nm_produser").val(response.nm_produser);
                    $("#international").val(response.international).trigger('change');
                    $('#post-modal').modal('show');
                }
            }
        });
    }
  
    function createGenre() {
        var nm_produser = $('#nm_produser').val();
        var international = $("#international").val()
        var id = $('#idx').val();
  
        let _url     = `/produser`;
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: id,
                nm_produser: nm_produser,
                international : international,
                _token: _token
            },
            success: function(response) {
                if(response.code == 200) {
                    if(id != ""){
                        alert(response.message)
                        $("#row_"+id+" td:nth-child(2)").html(response.data.nm_produser);
                        $("#row_"+id+" td:nth-child(3)").html(response.data.international);
                    } else {
                        alert(response.message)
                        $('table tbody').prepend(
                            '<tr id="row_'+response.data.id+'">'+
                           '<td>'+response.data.kd_produser+'</td>'+
                           '<td>'+response.data.nm_produser+'</td>'+
                           '<td>'+response.data.international+'</td>'+
                           '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editProduser(event.target)" class="btn btn-info">Edit</a>'+
                           '<a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deleteProduser(event.target)">Delete</a>'+
                           '</td></tr>');
                    }
                    $('#nm_produser').val('');
                    $('#post-modal').modal('hide');
                }
            },
            error: function(response) {
                $('#nm_produserError').text(response.responseJSON.errors.description);
            }
        });
    }
  
    function deleteProduser(event) {
        var id  = $(event).data("id");
        let _url = `/produser/${id}`;
        let _token   = $('meta[name="csrf-token"]').attr('content');
        var conf = confirm('Are you sure ? ') 

        if( conf ) {
            $.ajax({
                url: _url,
                type: 'DELETE',
                data: {
                    _token: _token
                },
                success: function(response) {
                    $("#row_"+id).remove();
                }
            });
        }
    }
  
  </script>
@endsection