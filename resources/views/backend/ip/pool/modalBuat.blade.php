<div class="modal fade modalBuat" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Buat IP Pool</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="form-simpan" method="post">
                @csrf
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="">Comment</label>
                        <input type="text" name="comment" class="form-control" placeholder="Comment" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Name</label>
                        <input type="text" name="name" class="form-control" placeholder="Name" id="">
                    </div>
                    <div class="mb-3">
                        <label for="">Ranges</label>
                        <input type="text" name="ranges" class="form-control" placeholder="Address" id="">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Save</button>
                </div>
            </form>
        </div>
    </div>
</div>
