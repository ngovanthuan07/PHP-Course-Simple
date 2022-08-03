<?php
/** @var  $this \app\core\View */


$this->title = 'Contact';
?>
<form method="POST" action="/contact">
    <div class="form-group">
        <label>Subject</label>
        <input type="text" class="form-control" name="subject" placeholder="Subject">
    </div>
    <div class="form-group">
        <label>Email address</label>
        <input type="email" class="form-control" name="email"  placeholder="Enter email">
    </div>
    <div class="form-group">
        <label>Password</label>
        <input type="password" class="form-control" name="password" placeholder="Password">
    </div>
    <div class="form-group">
        <label>Body</label>
        <input type="text" class="form-control" name="body"  placeholder="Body">
    </div>
    <button type="submit" class="btn btn-primary">Submit</button>
</form>