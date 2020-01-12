<div class="container">
    <div class="row my-5">
        <div class="col-12 col-md-6 offset-md-3">
            <div class="card">
                <div class="card-header">
                    <h3>Upload File</h3>
                </div>
                <div class="card-body">
                    <form action="index.php" method="post" enctype="multipart/form-data" >
                        <input type="hidden" name="csrf_token" value="<?php echo \TgsCallsInfo\Services\Requests::createCSRF() ?>">
                        <input type="hidden" name="action" value="info">
                        <input type="hidden" name="method" value="upload">
                        <div class="form-group">
                            <label for="file_info">Choose file</label>
                            <input type="file" class="form-control-file" id="file_info" name="file_info"
                                   accept=".csv" required>
                        </div>

                        <div class="row mt-5">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn btn-success">
                                    Send
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>