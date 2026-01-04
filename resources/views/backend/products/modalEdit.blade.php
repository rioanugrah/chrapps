<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post">
                @csrf
                <input type="hidden" name="id" id="edit_id">
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Server</label>
                        <select name="server_id" class="form-control" id="edit_server">
                            <option value="">-- Pilih Server --</option>
                            @foreach ($servers as $item)
                            <option value="{{ $item->id }}">{{ $item->domain.' | '.$item->ip_public }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Product Name</label>
                        <input type="text" name="product_name" class="form-control" id="edit_product_name">
                    </div>
                    <div class="mb-3">
                        <label for="">Product Price</label>
                        <input type="text" name="product_price" class="form-control" id="edit_product_price">
                    </div>
                    <div class="mb-3">
                        <label for="">Rate Download</label>
                        <input type="text" name="rate_download" class="form-control" id="edit_rate_download">
                    </div>
                    <div class="mb-3">
                        <label for="">Rate Upload</label>
                        <input type="text" name="rate_upload" class="form-control" id="edit_rate_upload">
                    </div>
                    <div class="mb-3">
                        <label for="">Product Duration</label>
                        <select name="product_duration" class="form-control" id="edit_product_duration">
                            <option value="">-- Pilih Duration --</option>
                            @for ($i = 1; $i <= 30; $i++)
                            <option value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Status</label>
                        <select name="status" class="form-control" id="edit_status">
                            <option value="">-- Pilih --</option>
                            <option value="Active">Aktif</option>
                            <option value="InActive">Tidak Aktif</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </div>
            </form>
        </div>
    </div>
</div>
