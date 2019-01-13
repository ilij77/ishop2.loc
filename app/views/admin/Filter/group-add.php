<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Новая группа фильтров
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?=ADMIN?>/filter/attribute-group">группы фильтров</a></li>
        <li class="active">Новая группа фильтров</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <form action="<?=ADMIN?>/filter/group-add" method="post" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование группы</label>
                            <input type="text" name="title" class="form-control" id="title"placeholder="Наименование группы" required>
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

                        </div>




                        <div class="box-footer">
                            <button type="submit" class="btn btn-success">Добавить</button>
                        </div>
                    </div>
                </form>








            </div>


        </div>

</section>
<!-- /.content -->