<div class="modal fade" id="createInvestor" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
    role="dialog" aria-labelledby="investorTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="investorTitle">Tambah Komisaris</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{route('persen-divisi.store')}}" method="post" id="createForm">
                @csrf
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="komisaris_id" class="form-label">Komisaris</label>
                            <select class="form-select" name="komisaris_id" id="komisaris_id" required>
                                <option value="">-- Pilih Komisaris --</option>
                                @foreach ($komisaris as $k)
                                <option value="{{$k->id}}">{{$k->nama}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-4 mb-3">
                            <label for="divisi_id" class="form-label">Divisi</label>
                            <select class="form-select" name="divisi_id" required>
                                <option value="">-- Pilih Divisi --</option>
                                @foreach ($divisi as $k)
                                <option value="{{$k->id}}">{{$k->nama}}</option>
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 mb-3">
                            <label for="persen" class="form-label">Persentase</label>
                            <div class="input-group mb-3">
                                <input type="text" class="form-control @if ($errors->has('persen'))
                            is-invalid
                        @endif" name="persen" id="persen" required>
                                <span class="input-group-text" id="basic-addon1">%</span>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
