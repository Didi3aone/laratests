@extends('layouts')
@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Film List</h1>
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
                            <th>Genre</th>
                            <th>Artis</th>
                            <th>Produser</th>
                            <th>Pendapatan</th>
                            <th>Nominasi</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($film as $rows)
                        <tr id="row_{{ $rows->id }}">
                            <td>{{ $rows->kd_film }}</td>
                            <td>{{ $rows->nm_film }}</td>
                            <td>{{ $rows->getGenre['nm_genre'] }}</td>
                            <td>{{ $rows->getArtis['nm_artis'] }}</td>
                            <td>{{ $rows->getProduser['nm_produser'] }}</td>
                            <td>{{ $rows->pendapatan }}</td>
                            <td>{{ $rows->nominasi }}</td>
                            <td>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" onclick="editFilm(event.target)" class="btn btn-info">Edit</a>
                                <a href="javascript:void(0)" data-id="{{ $rows->id }}" class="btn btn-danger" onclick="deleteFilm(event.target)">Delete</a>
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
                        <input class="form-control" id="nm_film" name="nm_film" placeholder="Enter Name">
                        <span id="nm_filmError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Produser</label>
                    <div class="col-sm-12">
                        <select name="produser" id="produser" class="form-control">
                            @foreach ($produser as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <span id="produserError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Artis</label>
                    <div class="col-sm-12">
                        <select name="artis" id="artis" class="form-control">
                            @foreach ($artis as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <span id="artisError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Genre</label>
                    <div class="col-sm-12">
                        <select name="genre" id="genre" class="form-control">
                            @foreach ($genre as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                        <span id="genreError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Nominasi</label>
                    <div class="col-sm-12">
                        <input class="form-control" id="nominasi" name="nominasi" placeholder="Enter Name">
                        <span id="nominasiError" class="alert-message"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="col-sm-2">Pendapatan</label>
                    <div class="col-sm-12">
                        <input class="form-control" id="pendapatan" name="pendapatan" placeholder="Enter Name">
                        <span id="pendapatanError" class="alert-message"></span>
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
  
    function editFilm(event) {
        var id  = $(event).data("id");
        let _url = `/film/${id}`;
        $('#nm_genreError').text('');
        $.ajax({
            url: _url,
            type: "GET",
            success: function(response) {
                if(response) {
                    $("#idx").val(response.id);
                    $("#nm_film").val(response.nm_film);
                    $("#pendapatan").val(response.pendapatan);
                    $("#nominasi").val(response.nominasi);
                    $("#artis").val(response.artis).trigger('change');
                    $("#produser").val(response.produser).trigger('change');
                    $("#genre").val(response.genre).trigger('change');
                    $('#post-modal').modal('show');
                }
            }
        });
    }
  
    function create() {
        var nm_film = $('#nm_film').val();
        var produser = $('#produser').val();
        var artis = $('#artis').val();
        var genre = $('#genre').val();
        var nominasi = $('#nominasi').val();
        var pendapatan = $('#pendapatan').val();
        var id      = $('#idx').val();
  
        let _url     = `/film`;
        let _token   = $('meta[name="csrf-token"]').attr('content');
        $.ajax({
            url: _url,
            type: "POST",
            data: {
                id: id,
                nm_film: nm_film,
                produser: produser,
                artis: artis,
                genre: genre,
                nominasi: nominasi,
                pendapatan: pendapatan,
                _token: _token
            },
            success: function(response) {
                if(response.code == 200) {
                    if(id != ""){
                        alert(response.message)
                        $("#row_"+id+" td:nth-child(1)").html(response.data.kd_film);
                        $("#row_"+id+" td:nth-child(2)").html(response.data.nm_film);
                        $("#row_"+id+" td:nth-child(3)").html(response.data.genre);
                        $("#row_"+id+" td:nth-child(4)").html(response.data.artis);
                        $("#row_"+id+" td:nth-child(5)").html(response.data.produser);
                        $("#row_"+id+" td:nth-child(6)").html(response.data.pendapatan);
                        $("#row_"+id+" td:nth-child(6)").html(response.data.nominasi);
                    } else {
                        console.log(response.data.get_genre)
                        console.log(response.data.getgenre)
                        alert(response.message)
                        $('table tbody').prepend(
                            '<tr id="row_'+response.data.id+'">'+
                            '<td>'+response.data.kd_film+'</td>'+
                            '<td>'+response.data.nm_film+'</td>'+
                            '<td>'+response.data.genre+'</td>'+
                            '<td>'+response.data.artis+'</td>'+
                            '<td>'+response.data.produser+'</td>'+
                            '<td>'+response.data.pendapatan+'</td>'+
                            '<td>'+response.data.nominasi+'</td>'+
                            '<td><a href="javascript:void(0)" data-id="'+response.data.id+'" onclick="editFilm(event.target)" class="btn btn-info">Edit</a>'+
                            '<a href="javascript:void(0)" data-id="'+response.data.id+'" class="btn btn-danger" onclick="deleteFilm(event.target)">Delete</a>'+
                            '</td></tr>');
                    }
                    $('#nm_artis').val('');
                    $('#bayaran').val('');
                    $('#post-modal').modal('hide');
                }
            },
            error: function(response) {
                $('#nm_filmError').text(response.responseJSON.errors.nm_film);
                $('#pendapatanError').text(response.responseJSON.errors.pendapatan);
                $('#nominasiError').text(response.responseJSON.errors.nominasi);
                $('#negaraError').text(response.responseJSON.errors.negara);
                $('#awardError').text(response.responseJSON.errors.award);
            }
        });
    }
  
    function deleteFilm(event) {
        var id  = $(event).data("id");
        let _url = `/film/${id}`;
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