@extends('layouts')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Artis List</h1>
    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <a href="javascript:void(0)" class="btn btn-success mb-3" id="create-new-post" onclick="addPost()">Add</a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="laravel_crud" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Kode</th>
                            <th>Nama</th>
                            <th>Jenis Kelamin</th>
                            <th>Bayaran</th>
                            <th>Negara</th>
                            <th>Award</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($artis as $rows)
                        <tr id="row_{{ $rows->id }}">
                            <td>{{ $rows->kd_artis }}</td>
                            <td>{{ $rows->nm_artis }}</td>
                            <td>{{ $rows->jk }}</td>
                            <td>{{ $rows->bayaran }}</td>
                            <td>{{ $rows->negara }}</td>
                            <td>{{ $rows->award }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" onclick="editArtis(event.target)" class="btn btn-info">Edit</a>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" class="btn btn-danger" onclick="deleteArtis(event.target)">Delete</a>
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
                        <input class="form-control" id="nm_artis" name="nm_artis" placeholder="Enter Name">
                        <span id="nm_artisError" class="alert-message"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Bayaran</label>
                    <div class="col-sm-12">
                        <input class="form-control" id="bayaran" name="bayaran" placeholder="Enter Name">
                        <span id="bayaranError" class="alert-message"></span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-sm-2">Jenis Kelamin</label>
                    <div class="col-sm-12">
                        <select name="jk" id="jk" class="form-control">
                            <option value="PRIA">PRIA</option>
                            <option value="WANITA">WANITA</option>
                        </select>
                        <span id="jkError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Negara</label>
                    <div class="col-sm-12">
                        <select name="negara" id="negara" class="form-control">
                            @foreach ($negara as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <span id="negaraError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Award</label>
                    <div class="col-sm-12">
                        <input class="form-control" id="award" name="award" placeholder="Enter Name">
                        <span id="awardError" class="alert-message"></span>
                    </div>
                </div>
            </form>
          </div>
          <div class="modal-footer">
              <button type="button" class="btn btn-primary" onclick="create()">Save</button>
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
  
    function editArtis(event) {
        var id  = $(event).data("id");
        let _url = `/artis/${id}`;
        $('#nm_genreError').text('');
        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    $("#idx").val(response.id);
                    $("#nm_artis").val(response.nm_artis);
                    $("#bayaran").val(response.bayaran);
                    $("#award").val(response.award);
                    $("#negara").val(response.negara).trigger('change');
                    $("#jk").val(response.jk).trigger('change');
                    $('#post-modal').modal('show');
                }
            }
        });
    }
  
    function create() {
        var nm_artis = $('#nm_artis').val();
        var jk = $('#jk').val();
        var bayaran = $('#bayaran').val();
        var negara = $('#negara').val();
        var award = $('#award').val();
        var id      = $('#idx').val();
  
        let _url     = `/artis`;
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: id,
                nm_artis: nm_artis,
                jk: jk,
                bayaran: bayaran,
                negara: negara,
                award: award,
                _token: _token
            },
            success: function(response) {
                if(response.code == 200) {
                    if(id != ""){
                        alert(response.message)
                        $("#row_"+id+" td:nth-child(1)").html(response.data.kd_artis);
                        $("#row_"+id+" td:nth-child(2)").html(response.data.nm_artis);
                        $("#row_"+id+" td:nth-child(3)").html(response.data.jk);
                        $("#row_"+id+" td:nth-child(4)").html(response.data.bayaran);
                        $("#row_"+id+" td:nth-child(5)").html(response.data.negara);
                        $("#row_"+id+" td:nth-child(6)").html(response.data.award);
                    } else {
                        alert(response.message)
                        $('table tbody').prepend(
                            '<tr id="row_'+response.data.id+'">'+
                            '<td>'+response.data.kd_artis+'</td>'+
                            '<td>'+response.data.nm_artis+'</td>'+
                            '<td>'+response.data.jk+'</td>'+
                            '<td>'+response.data.bayaran+'</td>'+
                            '<td>'+response.data.negara+'</td>'+
                            '<td>'+response.data.award+'</td>'+
                            '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editArtis(event.target)" class="btn btn-info">Edit</a>'+
                            '<a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deleteArtis(event.target)">Delete</a>'+
                            '</td></tr>');
                    }
                    $('#nm_artis').val('');
                    $('#bayaran').val('');
                    $('#post-modal').modal('hide');
                }
            },
            error: function(response) {
                $('#nm_artisError').text(response.responseJSON.errors.nm_artis);
                $('#bayaranError').text(response.responseJSON.errors.bayaran);
                $('#jkError').text(response.responseJSON.errors.jk);
                $('#negaraError').text(response.responseJSON.errors.negara);
                $('#awardError').text(response.responseJSON.errors.award);
            }
        });
    }
  
    function deleteArtis(event) {
        var id  = $(event).data("id");
        let _url = `/artis/${id}`;
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