@extends('app')
@section('content')
<form action="{{ route('obats.store') }}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>ID Obat:</strong>
                <input type="text" name="id_obat" class="form-control" placeholder="ID Obat">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Nama Obat:</strong>
                <input type="text" name="nama_obat" class="form-control" placeholder="Nama Obat">
                @error('nama_obat')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Golongan Obat:</strong>
                <select name="golongan_obat" id="golongan_obat" class="form-select" >
                        <option value="">Pilih</option>
                        @foreach($managers as $item)
                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                </select>
                @error('alias')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Khasiat :</strong>
                <input type="text" name="khasiat" class="form-control" placeholder="Khasiat">
                @error('name')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <div class="row col-xs-12 col-sm-12 col-md-12 mt-3">
            <div class="col-md-10 form-group">
                <input type="text" name="search" id="search" class="form-control" placeholder="Masukan Id Transaksi">
                @error('id_obat')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
            <div class="col-md-2 form-group text-center">
                <button class="btn btn-secondary" type="button" name="btnAdd" id="btnAdd"><i class="fa fa-plus"></i>Tambah</button>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 mt-3">
            <table id="example" class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                    <th scope="col">No</th>
                    <th scope="col">Id Transaksi</th>
                    <th scope="col">Nama Pembeli</th>
                    <th scope="col">Nama Obat</th>
                    <th scope="col">Harga Obat</th>
                
                    <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody id="detail">
                    
                </tbody>
            </table>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12">
            <div class="form-group">
                <strong>Jumlah Transaksi :</strong>
                <input type="text" name="jml" class="form-control" placeholder="Jumlah Transaksi">
                @error('nama_obat')
                <div class="alert alert-danger mt-1 mb-1">{{ $message }}</div>
                @enderror
            </div>
        </div>
        <button type="submit" class="btn btn-primary mt-3 ml-3">Submit</button>
    </div>
</form>
@endsection
@section('js')
<script type="text/javascript">
    var path = "{{ route('search.trn') }}";

    $("#search").autocomplete({
        source: function( request, response ) {
          $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            data: {
               search: request.term
            },
            success: function( data ) {
               response( data );
            }
          });
        },
        select: function (event, ui) {
            $('#search').val(ui.item.label);
           console.log($("input[nama=jml]").val());
            if($("input[nama=jml]").val() > 0){
                for (let i = 1; i <=  $("input[nama=jml]").val(); i++) {
                    id = $("input[nama=id_jadwal"+i+"]").val();
                    if(id==ui.item.id){
                        alert(ui.item.value+' sudah ada!');
                        break;
                    }else{
                        add(ui.item.id);
                    }
                }
            }else{
                add(ui.item.id);
            } 
           return false;
        }
      });

      function add(id){
        const path = "{{ route('trns.index') }}/" + id;
        var html = "";
        var no=0;
        if($('#detail tr').length > 0){
            var html = $('#detail').html();
            no = no+$('#detail tr').length;
        }
        $.ajax({
            url: path,
            type: 'GET',
            dataType: "json",
            success: function( data ) {
                console.log(data); 
                no++;
                html += '<tr>' +
                   '<td>'+no+'<input type="hidden" name="id_jadwal'+no+'" class="form-control" value="'+data.id+'"></td>' +
                    '<td><input type="text" name="name'+no+'" class="form-control" value="'+data.name+'"></td>' +
                    '<td><input type="text" name="nama_kamar'+no+'" class="form-control""></td>' +
                    '<td><input type="text" name="nomer_kamar'+no+'" class="form-control""></td>' +
                    '<td><a href="#" class="btn btn-sm btn-danger">Delete</a></td>' +
                '</tr>';
             $('#detail').html(html);
             $("input[name=jml]").val(no);
            }
        });
    }

    // function sumQty(no, q){
    //     var price = $("input[name=price"+no+"]").val();
    //     var subtotal = q*parseInt(price);
    //     $("input[name=sub_total"+no+"]").val(subtotal);
    //     console.log(q+"*"+price+"="+subtotal);
    // }

    // function sumTotal(){
    // var total = 0;
    //     for (let i = 1; i <= $("input[name=jml]").val(); i++) {
    //         var sub = $("input[name=sub_total]"+i+"]").val();
    //         total = total + parseInt(sub);
    //     }
    //     $("input[name=total]").val();
    // }

</script>
@endsection