<div class="container-fluid justify-content-cente">
    <div class="card col-12">
        <div class="card-header"><h1>Consulta de Depoimentos</h1></div>
        <div class="row mt-3">
            <div class="mb-3">
                <form id="" name="" method="POST" action="<?=BASE_HTTP?>/admin/depoimento">
                    <div class="form-group ">
                        <div class=" col-4">
                            <label class="visually-hidden" for="titulo">Titulo</label>
                            <input type="text" class="form-control" name="titulo" id="titulo" placeholder="Título">
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="col-4 ">
                            <span class="input-group-text">Depoimento</span>
                            <textarea class="form-control" aria-label="With textarea"></textarea>
                        </div>
                    </div>
                    <div class="form-group  ">
                        <div class="col-4 ">
                            <div class="float-end">
                                <button type="reset" class="btn btn-dark ">Limpar</button>
                                <button type="submit" class="btn btn-dark ">Pesquisar</button>
                            </div>
                        </div>
                    </div>

            </div>

            </form>

        </div>
    </div>

</div>