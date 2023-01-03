<div class="d-flex flex-column justify-content-center align-items-center">
    <div class="card mt-3 text-dark text-center" style="width: 500px;">
        <div class="card-header">
            <h1>Login</h1>
        </div>
        <div class="card-body">
            <form action="" method="post">
                <div class="form-group">
                    <label class="float-start" for="email">E-mail</label>
                    <input class="form-control" value="<?=$_REQUEST['email']?>" type="text" name="email" id="email" autofocus required />
                </div>

                <div class="form-group my-3">
                    <label class="float-start" for="senha">Senha</label>
                    <input class="form-control" value="<?=$_REQUEST['senha']?>" type="password" name="senha" id="senha" required  />
                </div>

                <button type="submit" class="btn btn-lg btn-danger">Entrar</button>
            </form>
        </div>
    </div>
</div>