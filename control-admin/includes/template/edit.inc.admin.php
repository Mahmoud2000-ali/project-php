<div class='container custom-form'>
    <form method='POST' action='?namePage=update&id=<?php echo $_SESSION['test_id'];?>' enctype="multipart/form-data">
        <h2 class='h1 text-center'> Edit Information </h2>

        <div class="form-group row">
            <label for="inputUsername" class="col-sm-2 col-form-label">Username</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-user fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" id="inputText" placeholder="Username" name='username' required title="Enter Your Username" value='<?php echo $row["username"]; ?>' />
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="staticEmail" class="col-sm-2 col-form-label">Email</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-envelope fa-fw"></i></i></div>
                    <input type="email" class="form-control form-control-lg" id="inputEmail" placeholder="Email" name='email' required title="Enter Your Email" value='<?php echo $row["email"]; ?>'>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputPassword" class="col-sm-2 col-form-label">Password</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'> <i class="fas fa-lock fa-fw"></i></i></div>
                    <input type="password" class="form-control form-control-lg custom-password" id="inputPassword" required placeholder="Password" name='password' title="Enter Your Password" value="<?php echo $row["password"]; ?>" />
                    <div class='pass'> <i class="fas fa-eye fa-fw"></i></div>
                    <small id="passwordHelpBlock" class="form-text text-muted">
                        The Password, If You Are Not Enter New Then The Old Password Will Still.
                    </small>
                </div>
            </div>
        </div>

        <div class="form-group row">
            <label for="inputFullName" class="col-sm-2 col-form-label">Full Name</label>
            <div class="col-sm-10">
                <div class='input-con'>
                    <div class='i1'><i class="fas fa-user-friends fa-fw"></i></div>
                    <input type="text" class="form-control form-control-lg" id="inputFullName" placeholder="Full Name" name='fullname' required title="Enter Your Full Name" value='<?php echo $row["full_name"]; ?>'>
                </div>
            </div>
        </div>

        <div class="form-group row">
                <label for="inputFullName" class="col-sm-2 col-form-label">Choice Image</label>
                <div class="col-sm-10">
                    <div class='input-con'>
                        <input type="file" class="custom-file-input" id="validatedCustomFile" name = 'image'>
                        <label class="custom-file-label form-control" for="validatedCustomFile">Choose Image...</label>
                    </div>
                </div>
        </div>        

        <button type="submit" class="btn btn-primary btn-lg btn-block" style="margin-bottom:10px" value='Edit'> Edit </button>
    </form>
</div>