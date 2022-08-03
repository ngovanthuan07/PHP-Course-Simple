<div class="container">
    <h1 class="text-center">Login</h1>
    <form method="POST" action="/login">
        <!--       Email          -->
        <div class="form-group">
            <label>Email</label>
            <input type="text"
                   class="form-control <?php echo $model->hasError('email') ? 'is-invalid' : ''; ?>"
                   name="email"
                   value="<?php echo $model->email ?? ''; ?>"
            >
            <span class="<?php echo $model->hasError('email') ? 'text-danger' : ''; ?>">
                <?php echo $model->getFirstError('email') ?? '';  ?>
            </span>
        </div>
        <!--       Password          -->
        <div class="form-group">
            <label>Password</label>
            <input type="password"
                   class="form-control <?php echo $model->hasError('password') ? 'is-invalid' : ''; ?>"
                   name="password"
                   value="<?php echo $model->password ?? ''; ?>"
            >
            <span class="<?php echo $model->hasError('password') ? 'text-danger' : ''; ?>">
                <?php echo $model->getFirstError('password') ?? '';  ?>
            </span>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>