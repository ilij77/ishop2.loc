<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        Редактирование  <?=$group->title?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?=ADMIN;?>"><i class="fa fa-dashboard"></i> Главная</a></li>
        <li><a href="<?=ADMIN?>/filter/attribute-group">группы фильтров</a></li>
        <li class="active">Редактирование группа фильтров</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-md-12">
            <div class="box">

                <form action="<?=ADMIN?>/filter/group-edit" method="post" data-toggle="validator">
                    <div class="box-body">
                        <div class="form-group has-feedback">
                            <label for="title">Наименование группы</label>
                            <input type="text" name="title" class="form-control" id="title"placeholder="Наименование группы"
                                   required value="<?=$group->title?>">
                            <span class="glyphicon form-control-feedback" aria-hidden="true"></span>

                        </div>




                        <div class="box-footer">
                            <input type="hidden" name="id" value="<?=$group->id?>">
                            <button type="submit" class="btn btn-success">Сохранить</button>
                        </div>
                    </div>
                </form>








            </div>


        </div>

</section>
<!-- /.content -->