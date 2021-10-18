@extends('layouts')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Genre List</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addPost()">Add Genre</a>
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
                        @foreach ($genre as $rows)
                        <tr id="row_{{ $rows->id }}">
                            <td>{{ $rows->kd_genre }}</td>
                            <td>{{ $rows->nm_genre }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" onclick="editGenre(event.target)" class="btn btn-info">Edit</a>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" class="btn btn-danger" onclick="deleteGenre(event.target)">Delete</a>
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
                        <textarea class="form-control" id="nm_genre" name="nm_genre" placeholder="Enter Name" rows="4" cols="50"></textarea>
                        <span id="nm_genreError" class="alert-message"></span>
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
  
    function addPost() {
        $("#idx").val('');
        $('#post-modal').modal('show');
    }
  
    function editGenre(event) {
        var id  = $(event).data("id");
        let _url = `/genre/${id}`;
        $('#nm_genreError').text('');
        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    $("#idx").val(response.id);
                    $("#nm_genre").val(response.nm_genre);
                    $('#post-modal').modal('show');
                }
            }
        });
    }
  
    function createGenre() {
        var nm_genre = $('#nm_genre').val();
        var id = $('#idx').val();
  
        let _url     = `/genre`;
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: id,
                nm_genre: nm_genre,
                _token: _token
            },
            success: function(response) {
                if(response.code == 200) {
                    if(id != ""){
                        alert(response.message)
                        $("#row_"+id+" td:nth-child(2)").html(response.data.nm_genre);
                    } else {
                        alert(response.message)
                        $('table tbody').prepend('<tr id="row_'+response.data.id+'"><td>'+response.data.kd_genre+'</td><td>'+response.data.nm_genre+'</td><td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editGenre(event.target)" class="btn btn-info">Edit</a><a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deleteGenre(event.target)">Delete</a></td></tr>');
                    }
                    $('#nm_genre').val('');
                    $('#post-modal').modal('hide');
                }
            },
            error: function(response) {
                $('#nm_genreError').text(response.responseJSON.errors.description);
            }
        });
    }
  
    function deleteGenre(event) {
        var id  = $(event).data("id");
        let _url = `/genre/${id}`;
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