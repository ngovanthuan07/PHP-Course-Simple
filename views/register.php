<div class="container">
    <h1 class="text-center">Register</h1>
    <form method="POST" action="/register">
        <div class="row">
            <div class="col">
                <!--       Firstname          -->
                <div class="form-group">
                    <label>Firstname</label>
                    <input type="text"
                           class="form-control <?php echo $model->hasError('firstname') ? 'is-invalid' : ''; ?>"
                           name="firstname"
                           value="<?php echo $model->firstname ?? ''; ?>"
                    >
                    <span class="<?php echo $model->hasError('firstname') ? 'text-danger' : '';?>">
                        <?php echo $model->getFirstError('firstname') ?? '';  ?>
                    </span>
               </div>
            </div>
            <div class="col">
                <!--       Lastname          -->
                <div class="form-group">
                    <label>Lastname</label>
                    <input type="text"
                           class="form-control <?php echo $model->hasError('lastname') ? 'is-invalid' : ''; ?>"
                           name="lastname"
                           value="<?php echo $model->lastname ?? ''; ?>"
                    >
                    <span class="<?php echo $model->hasError('lastname') ? 'text-danger' : ''; ?>">
                        <?php echo $model->getFirstError('lastname') ?? '';  ?>
                    </span>
                </div>
            </div>
        </div>
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
        <!--       Confirm Password          -->
        <div class="form-group">
            <label>Confirm Password</label>
            <input type="password"
                   class="form-control <?php echo $model->hasError('confirmPassword') ? 'is-invalid' : ''; ?>"
                   name="confirmPassword"
                    value="<?php echo $model->confirmPassword ?? ''; ?>"
            >
            <span class="<?php echo $model->hasError('confirmPassword') ? 'text-danger' : ''; ?>">
                  <?php echo $model->getFirstError('confirmPassword') ?? '';  ?>
            </span>
        </div>
        <div class="d-flex justify-content-center">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>
</div>