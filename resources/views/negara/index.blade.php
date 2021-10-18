@extends('layouts')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Negara List</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addNegara()">Add</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="laravel_crud" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($negara as $rows)
                        <tr id="row_{{ $rows->id }}">
                            <td>{{ $rows->kd_negara }}</td>
                            <td>{{ $rows->nm_negara }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" onclick="editNegara(event.target)" class="btn btn-info">Edit</a>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" class="btn btn-danger" onclick="deleteNegara(event.target)">Delete</a>
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
                    <label class="col-sm-2">Kode</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="kd_negara" id="kd_negara">
                        <span id="kd_negaraError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Nama</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control" name="nm_negara" id="nm_negara">
                        <span id="nm_negaraError" class="alert-message"></span>
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
  
    function addNegara() {
        $("#idx").val('');
        $('#post-modal').modal('show');
    }
  
    function editNegara(event) {
        var id  = $(event).data("id");
        let _url = `/negara/${id}`;
        $('#nm_negaraError').text('');
        $("#kd_negaraError").text('');
        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    $("#idx").val(response.id);
                    $("#nm_negara").val(response.nm_negara);
                    $("#kd_negara").val(response.kd_negara);
                    $('#post-modal').modal('show');
                }
            }
        });
    }
  
    function createGenre() {
        var nm_negara = $('#nm_negara').val();
        var kd_negara = $('#kd_negara').val();
        var id = $('#idx').val();
  
        let _url     = `/negara`;
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: id,
                nm_negara: nm_negara,
                kd_negara: kd_negara,
                _token: _token
            },
            success: function(response) {
                if(response.code == 200) {
                    if(id != ""){
                        alert(response.message)
                        $("#row_"+id+" td:nth-child(1)").html(response.data.kd_negara);
                        $("#row_"+id+" td:nth-child(2)").html(response.data.nm_negara);
                    } else {
                        alert(response.message)
                        $('table tbody').prepend(
                            '<tr id="row_'+response.data.id+'">'+
                           '<td>'+response.data.kd_negara+'</td>'+
                           '<td>'+response.data.nm_negara+'</td>'+
                           '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editNegara(event.target)" class="btn btn-info">Edit</a>'+
                           '<a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deleteNegara(event.target)">Delete</a>'+
                           '</td></tr>');
                    }
                    $('#nm_negara').val('');
                    $('#post-modal').modal('hide');
                }
            },
            error: function(response) {
                $('#nm_negaraError').text(response.responseJSON.errors.description);
            }
        });
    }
  
    function deleteNegara(event) {
        var id  = $(event).data("id");
        let _url = `/negara/${id}`;
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