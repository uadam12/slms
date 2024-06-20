<form method="post" class="card shadow my-3">
    <div class="card-header text-center">
        <h3 class="card-title text-primary">Loan Form</h3>
    </div>

    <div class="card-body">
        <!-- Loan purpose -->
        <div class="input-group mb-2">
            <label for="purpose" class="input-group-text">Loan Purpose</label>
            <input value="<?=$purpose??''?>" type="text" id="purpose" name="purpose" class="form-control" placeholder="Purpose of the loan. eg Paying school fees.">
        </div>

        <!-- Loan amount -->
        <div class="input-group mb-2">
            <label for="amount" class="input-group-text">
                <span class="text-danger">*</span>Loan Amount
            </label>
            <input value="<?=$amount??''?>" step='.05' type="number" id="amount" name="amount" class="form-control" placeholder="Please enter loan amount (in ₦)" required>
        </div>

        <!-- Loan starting date -->
        <div class="input-group mb-2">
            <label for="start" class="input-group-text">
                <span class="text-danger">*</span>Loan From
            </label>
            <input value="<?= $start??'' ?>" type="datetime-local" name="start" id="start" class="form-control" required>
        </div>

        <!-- Loan ending date -->
        <div class="input-group">
            <label for="end" class="input-group-text">
                <span class="text-danger">*</span>Loan End
            </label>
            <input type="datetime-local" name="end" id="end" class="form-control" required>
        </div>
    </div>

    <div class="card-footer text-end">
        <button class="btn btn-success">
            <i class="fa fa-paper-plane"></i>Submit
        </button>
    </div>
</form>