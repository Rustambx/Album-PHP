<?php require_once $_SERVER['DOCUMENT_ROOT']. '/includes/header.php';?>
<div class="test" style="margin: 50px 50px">
    <form method="post" enctype="multipart/form-data">
        <div class="form-group" id="name-field">
            <label for="name">Name</label>
            <input type="text" id="name" name="name" class="form-control">
            <span class="error"></span>
        </div>
        <div class="form-group" id="email-field">
            <label for="email">Email address</label>
            <input type="email" id="email" name="email" class="form-control" aria-describedby="emailHelp">
            <span class="error"></span>
        </div>
        <div class="form-group" id="phone-field">
            <label for="phone">Phone</label>
            <input type="text" id="phone" name="phone" class="form-control">
            <span class="error"></span>
        </div>
        <div class="form-group" id="date-field">
            <label for="phone">Date of birth</label>
            <input type="date" name="date">
            <span class="error"></span>
        </div>
        <div class="form-group" id="image-field">
            <label for="exampleFormControlFile1">Image (Max size 1 MB)</label>
            <input type="file" class="form-control-file" multiple id="image" name="image[]">
            <span class="error"></span>
        </div>
        <button type="submit" id="submit" class="btn btn-primary">Submit</button>
    </form>
</div>
<?php require_once $_SERVER['DOCUMENT_ROOT']. '/includes/footer.php'?>
