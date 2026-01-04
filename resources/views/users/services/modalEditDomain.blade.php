<div class="modal fade" id="modalEditDomain" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat Domain</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-update-domain" method="post">
                @csrf
                <input type="hidden" name="id" id="edit_domain_id">
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="mb-3">
                                <label for="">Domain</label>
                                <input type="text" name="domain" class="form-control" id="edit_domain">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="">Port</label>
                                <input type="text" name="port" class="form-control" id="edit_domain_port">
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="mb-3">
                                <label for="">Status</label>
                                <select name="status" class="form-control" id="edit_domain_status">
                                    <option value="">-- Pilih --</option>
                                    <option value="Active">Aktif</option>
                                    <option value="InActive">Tidak Aktif</option>
                                </select>
                            </div>
                        </div>
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
