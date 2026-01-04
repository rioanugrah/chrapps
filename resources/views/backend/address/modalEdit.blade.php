<div class="modal fade" id="modalEdit" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Interfaces</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Enabled</label>
                        <select name="disabled" class="form-control" id="">
                            <option value="">-- Pilih --</option>
                            <option value="no">Yes</option>
                            <option value="yes">No</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="">Comment</label>
                        <input type="text" name="comment" class="form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Address</label>
                        <input type="text" name="address" class="form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Network</label>
                        <input type="text" name="network" class="form-control" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Interface</label>
                        <select name="interface" class="form-control" id="">
                            <option value="">-- Pilih --</option>
                            @foreach ($getInterfaces as $item)
                            <option value="{{ $item['name'] }}">{{ $item['name'] }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Update</button>
                </div>
            </form>
        </div>
    </div>
</div>
