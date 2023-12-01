<div class="modal fade" id="editInvestor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="editInvestorTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editInvestorTitle">Edit Persentase Divisi</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form method="post" id="editForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="row">
                            <div class="col-md-4 mb-3">
                                <input type="hidden" name="komisaris_id" id="komisaris_id">
                                <label for="komisaris" class="form-label">Komisaris</label>
                                <input type="text" name="komisaris" id="komisaris" class="form-control" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <input type="hidden" name="divisi_id" id="divisi_id">
                                <label for="divisi" class="form-label">Divisi</label>
                                <input type="text" name="divisi" id="divisi" class="form-control" disabled>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label for="persen" class="form-label">Persentase</label>
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control @if ($errors->has('persen'))
                                is-invalid
                            @endif" name="persen" id="edit_persen" required>
                                    <span class="input-group-text" id="basic-addon1">%</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
