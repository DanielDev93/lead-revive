<div class="box box-primary">
    <div class="box-header with-border">
        <!-- START: Filter -->
        <div class="well">
            <form name="form_filter" method="get" style="margin:0px;">
                <div class="row">
                    <div class="col-sm-1">
                        Filter:
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <label class="sr-only">Status</label>
                            <select id="filter_status" name="filter_status" class="form-control" onchange="form_filter.submit();">
                                <option value="">- Status -</option>
                                <?php $selected = ($filterStatus != 'Draft') ? '' : ' selected="selected"'; ?>
                                <option value="Draft" <?php echo $selected; ?>>Draft</option>
                                <?php $selected = ($filterStatus != 'Published') ? '' : ' selected="selected"'; ?>
                                <option value="Published" <?php echo $selected; ?>>Published</option>
                                <?php $selected = ($filterStatus != 'Unpublished') ? '' : ' selected="selected"'; ?>
                                <option value="Unpublished" <?php echo $selected; ?>>Unpublished</option>
                            </select>
                        </div>  
                    </div>
                    <div class="col-sm-2">
                        <div class="form-group">
                            <input id="filter_search" name="filter_search" class="form-control" value="{{$filterSearch}}" placeholder="Search" />
                        </div>
                    </div>
                    <div class="col">
                        <button class="btn btn-primary" title="Filter">
                            @include("cms::shared.icons.bootstrap.bi-filter")
                        </button>

                        <button type="button" class="btn btn-primary float-end" onclick="showPageCreateModal();">
                            @include("cms::shared.icons.bootstrap.bi-plus-circle")
                            Add Page
                        </button>  
                    </div>
                </div>
            </form>
        </div>
        <!-- END: Filter -->

    </div>

    <div class="box-body">
        <ul class="nav nav-tabs" style="margin-bottom: 3px;">
            <li class="nav-item">
                <a class="nav-link <?php if ($view == '' || $view == 'all' ) { ?>active<?php } ?>"  href="?view=all">
                    @include("cms::shared/icons/bootstrap/bi-list")
                    Live
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link <?php if ($view == 'trash') { ?>active<?php } ?>" href="?&view=trash">
                    @include("cms::shared/icons/bootstrap/bi-trash")
                    Trash
                </a>
            </li>
        </ul>

        <!--START: Categories -->
        <style scoped="scoped">
            .table-striped > tbody > tr:nth-child(2n+1) > td{
                background-color: transparent !important;
            }
            .table-striped > tbody > tr:nth-child(2n+1){
                background-color: #F9F9F9 !important;
            }
            #table_pages tr:hover {
                background-color: #FEFF8F !important;
            }
        </style>
        <table id="table_pages" class="table table-striped">
            <tr>
                <th style="text-align:center;">
                    <a href="?cmd=pages-manager&amp;by=Title&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Title&nbsp;<?php
                        if ($orderby === 'Title') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>,
                    <a href="?cmd=pages-manager&amp;by=Alias&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Alias&nbsp;<?php
                        if ($orderby === 'Alias') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>,
                    <a href="?cmd=pages-manager&amp;by=id&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        ID&nbsp;<?php
                        if ($orderby === 'Id') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>
                </th>
                <th style="text-align:center;width:100px;">
                    <a href="?cmd=pages-manager&amp;by=Status&amp;sort=<?php if ($sort == 'asc') { ?>desc<?php } else { ?>asc<?php } ?>">
                        Status&nbsp;<?php
                        if ($orderby === 'Status') {
                            if ($sort == 'asc') {
                                ?>&#8595;<?php } else { ?>&#8593;<?php
                            }
                        }
                        ?>
                    </a>
                </th>
                <th style="text-align:center;width:230px;">
                    Action
                </th>
            </tr>

            <?php foreach ($pages as $page) { ?>
                <tr>
                    <td>
                        <div style="color:#333;font-size: 14px;font-weight:bold;">
                            <?php echo $page->Title; ?>
                        </div>                        
                        <div style="color:#333;font-size: 12px;font-style:italic;">
                            <?php echo $page->Alias; ?>
                        </div>
                        <div style="color:#999;font-size: 10px;">
                            ref. <?php echo $page->Id; ?>
                        </div>
                    <td style="text-align:center;vertical-align: middle;">
                        <?php echo $page['Status']; ?><br>
                    </td>
                    <td style="text-align:center;vertical-align: middle;">
                        <a href="<?php echo $page->url(); ?>" class="btn btn-sm btn-success" target="_blank">
                            @include("cms::shared/icons/bootstrap/bi-eye")
                            View
                        </a>
                        <a href="<?php echo \Sinevia\Cms\Helpers\Links::adminPageUpdate(['PageId' => $page['Id']]); ?>" class="btn btn-sm btn-warning">
                            @include("cms::shared/icons/bootstrap/bi-pencil-square")
                            Edit
                        </a>

                        <?php if ($page->Status == 'Deleted') { ?>
                            <button class="btn btn-sm btn-danger" onclick="confirmPageDelete('<?php echo $page->Id; ?>');">
                                @include("cms::shared/icons/bootstrap/bi-x-circle")
                                Delete
                            </button>
                        <?php } ?>

                        <?php if ($page->Status != 'Deleted') { ?>
                            <button class="btn btn-sm btn-danger" onclick="confirmPageMoveToTrash('<?php echo $page->Id; ?>');">
                                @include("cms::shared/icons/bootstrap/bi-trash")
                                Trash
                            </button>
                        <?php } ?>
                    </td>
                </tr>
            <?php } ?>
        </table>
        <!-- END: Categories -->

        <!-- START: Pagination -->    
        {!! $pages->render("cms::shared/bootstrap-5/pagination") !!}
        <!-- END: Pagination -->
    </div>

</div>


@include('cms::admin/page-manager/bootstrap-5/page-create-modal')
@include('cms::admin/page-manager/bootstrap-5/page-delete-modal')
@include('cms::admin/page-manager/bootstrap-5/page-move-trash-modal')
